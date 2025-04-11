<?php

namespace App\DataTables;

use App\Models\Transaction;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
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
            ->rawColumns(['actions']);
    }

    public function query(Transaction $model)
    {
        return $model->newQuery()->with(['user', 'product']);
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('orders-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc');
    }

    protected function getColumns()
    {
        return [
            'id',
            'customer',
            'date',
            'total',
            'actions'
        ];
    }
}