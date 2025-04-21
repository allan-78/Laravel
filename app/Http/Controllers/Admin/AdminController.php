<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSales = \App\Models\Transaction::sum('total_price');
        $orderCount = \App\Models\Transaction::count();
        $totalCustomers = \App\Models\User::where('role', 'user')->count();
        $pendingOrders = \App\Models\Transaction::where('status', 'pending')->count();
        
        return view('admin.dashboard', compact(
            'totalSales',
            'orderCount',
            'totalCustomers',
            'pendingOrders'
        ));
    }
}