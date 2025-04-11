<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($product) {
                return '<a href="'.route('admin.products.edit', $product->id).'" class="btn btn-sm btn-primary">Edit</a> '.                
                       '<form action="'.route('admin.products.destroy', $product->id).'" method="POST" style="display:inline">'.                
                       csrf_field().                
                       method_field('DELETE').                
                       '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\');">Delete</button>'.                
                       '</form>';
            })
            ->addColumn('images', function($product) {
                return $product->images->count() . ' images';
            })
            ->editColumn('price', function($product) {
                return '$' . number_format($product->price, 2);
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()->with('category');
    }

    public function html(): HtmlBuilder
    {
        $html = $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->buttons([
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
            
        return $html;
    }

    protected function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('description'),
            Column::make('price'),
            Column::make('images'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }
}