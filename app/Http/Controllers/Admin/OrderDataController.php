<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\OrderDataTable;
use Illuminate\Http\Request;

class OrderDataController extends Controller
{
    public function __invoke(Request $request)
    {
        return (new OrderDataTable())->render();
    }
}