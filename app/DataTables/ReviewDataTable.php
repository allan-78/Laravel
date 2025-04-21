<?php

namespace App\DataTables;

use App\Models\Review;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReviewDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($review) {
                return '<div class="btn-group">
                    <a href="'.route('admin.reviews.edit', $review->id).'" class="btn btn-sm btn-primary">Edit</a>
                    <form action="'.route('admin.reviews.destroy', $review->id).'" method="POST">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>';
            })
            ->rawColumns(['action']);
    }

    public function query(Review $model)
    {
        return $model->newQuery()->with(['user', 'product']);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('reviews-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0);
    }

    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('user.name')->title('User'),
            Column::make('product.name')->title('Product'),
            Column::make('rating'),
            Column::make('comment'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }
}