<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Date filtering
            $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
            $endDate = $request->input('end_date', now()->format('Y-m-d'));
    
            // Calculate sales data grouped by date
            $salesData = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(total_price) as total_sales')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->pluck('total_sales', 'date')
                ->toArray();
    
            // Get top products with sales data
            $topProducts = Product::with(['category'])
                ->withCount(['transactions as sold' => function($query) use ($startDate, $endDate) {
                    $query->whereBetween('transactions.created_at', [$startDate, $endDate]);
                }])
                ->withSum(['transactions as total_sales' => function($query) use ($startDate, $endDate) {
                    $query->whereBetween('transactions.created_at', [$startDate, $endDate])
                          ->select(DB::raw('SUM(transactions.total_price)'));
                }])
                ->orderBy('total_sales', 'desc')
                ->limit(5)
                ->get();
    
            // Get product sales for pie chart
            $productSales = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->with('product')
                ->select(
                    'product_id',
                    DB::raw('SUM(total_price) as total_sales')
                )
                ->groupBy('product_id')
                ->orderBy('total_sales', 'desc')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'name' => $item->product->name,
                        'total_sales' => $item->total_sales
                    ];
                });
    
            // Get recent orders
            $recentOrders = Transaction::with(['user', 'product'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
    
            return view('admin.dashboard', compact(
                'salesData',
                'productSales',
                'topProducts',
                'recentOrders',
                'startDate',
                'endDate'
            ));
    
        } catch (\Exception $e) {
            \Log::error('Dashboard error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to load dashboard data: ' . $e->getMessage()]);
        }
    }

    public function data(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
    
        // Get sales data
        $sales = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
        // Get product distribution data
        $products = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->with('product')
            ->selectRaw('product_id, SUM(total_price) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    
        // Get top products
        $topProducts = Product::with(['category'])
            ->withCount(['transactions as sold' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withSum(['transactions as total_sales' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => optional($product->category)->name,
                    'price' => $product->price,
                    'sold' => $product->sold,
                    'stock' => $product->stock
                ];
            });
    
        // Get recent orders
        $recentOrders = Transaction::with(['user', 'product'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->id,
                    'user' => optional($order->user)->name,
                    'quantity' => $order->quantity,
                    'status' => $order->status,
                    'date' => $order->created_at->format('Y-m-d H:i:s')
                ];
            });
    
        return response()->json([
            'sales' => [
                'dates' => $sales->pluck('date'),
                'values' => $sales->pluck('total')
            ],
            'products' => [
                'labels' => $products->pluck('product.name'),
                'values' => $products->pluck('total')
            ],
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders
        ]);
    }
}