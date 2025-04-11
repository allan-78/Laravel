<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderDataController extends Controller
{
    public function __invoke(Request $request)
    {
        $transactions = Transaction::with(['user', 'product']);

        return DataTables::of($transactions)
            ->addColumn('customer', function ($transaction) {
                return $transaction->user->name;
            })
            ->addColumn('date', function ($transaction) {
                return $transaction->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('total', function ($transaction) {
                return '$' . number_format($transaction->total_price, 2);
            })
            ->addColumn('actions', function ($transaction) {
                return '<button onclick="openStatusModal(' . $transaction->id . ', \'' . $transaction->status . '\')" class="btn btn-sm btn-primary">Update Status</button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}