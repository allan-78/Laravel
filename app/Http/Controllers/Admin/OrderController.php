<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Mail\TransactionReceipt;
use App\Services\PdfGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    protected $pdfGenerator;

    public function __construct(PdfGenerator $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function index()
    {
        return view('admin.orders.index');
    }

    public function data()
    {
        $orders = Order::with(['user', 'products'])->select('orders.*');

        return DataTables::of($orders)
            ->addColumn('customer', function ($order) {
                return $order->user->name;
            })
            ->addColumn('product', function ($order) {
                return $order->products->pluck('name')->implode(', ');
            })
            ->addColumn('quantity', function ($order) {
                return $order->products->sum('pivot.quantity');
            })
            ->addColumn('date', function ($order) {
                return $order->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('total', function ($order) {
                return '$' . number_format($order->total, 2);
            })
            ->addColumn('actions', function ($order) {
                return '<button class="btn btn-sm btn-primary" onclick="openStatusModal(' . $order->id . ', \'' . $order->status . '\')">
                            Update Status
                        </button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:completed,failed,refunded'
            ]);

            $order->status = $request->status;
            $order->save();

            // Generate PDF
            $pdf = $this->pdfGenerator->generateTransactionReceipt($order);

            // Send email with PDF attachment
            Mail::to($order->user->email)
                ->send(new TransactionReceipt($order, $pdf));

            return response()->json([
                'message' => 'Order status updated successfully',
                'status' => $order->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating order status: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index');
    }
}