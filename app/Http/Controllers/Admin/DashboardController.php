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
            $salesData = Transaction::whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COALESCE(SUM(total_amount), 0) as total_sales')
                )
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->date => (float)$item->total_sales];
                })
                ->toArray();

            // Get top products with sales data
            $topProducts = Product::select(
                'products.*',
                DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as sold'),
                DB::raw('COALESCE(SUM(transaction_items.quantity * transaction_items.price), 0) as total_sales')
            )
            ->leftJoin('transaction_items', 'products.id', '=', 'transaction_items.product_id')
            ->leftJoin('transactions', function($join) use ($startDate, $endDate) {
                $join->on('transaction_items.transaction_id', '=', 'transactions.id')
                    ->whereBetween(DB::raw('DATE(transactions.created_at)'), [$startDate, $endDate]);
            })
            ->with('category')
            ->groupBy('products.id')
            ->orderBy('total_sales', 'desc')
            ->limit(5)
            ->get();

            // Get product sales for pie chart
            $productSales = Transaction::whereBetween(DB::raw('DATE(transactions.created_at)'), [$startDate, $endDate])
                ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
                ->join('products', 'transaction_items.product_id', '=', 'products.id')
                ->select(
                    'products.name',
                    DB::raw('SUM(transaction_items.quantity * transaction_items.price) as total_sales'),
                    DB::raw('COUNT(DISTINCT transactions.id) as orders_count')
                )
                ->groupBy('products.id', 'products.name')
                ->orderBy('total_sales', 'desc')
                ->limit(5)
                ->get();

            // Get recent orders
            $recentOrders = Transaction::with(['user', 'items'])
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
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
}