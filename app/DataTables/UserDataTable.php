<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('is_active', function ($user) {
                return $user->is_active 
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($user) {
                $buttons = '<button class="btn btn-sm btn-outline-primary update-status" 
                        data-user-id="'.$user->id.'"
                        data-current-status="'.$user->is_active.'"
                        data-bs-toggle="modal" 
                        data-bs-target="#statusModal">Update Status</button>';

                if ($user->id !== auth()->id()) {
                    $buttons .= ' <form action="'.route('admin.users.destroy', $user->id).'" method="POST" class="d-inline">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>';
                }

                return $buttons;
            })
            ->rawColumns(['is_active', 'action']);
    }

    public function query(User $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0);
    }

    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('is_active')->title('Status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->title('Actions')
                ->render(function($row) {
                    $html = '';
                    $userId = is_object($row) ? $row->id : (isset($row['id']) ? $row['id'] : null);
                    if ($userId && $userId !== auth()->id()) {
                        $html = '<form action="'.route('admin.users.destroy', $userId).'" method="POST" class="d-inline">';
                        $html .= csrf_field();
                        $html .= method_field('DELETE');
                        $html .= '<button type="submit" class="btn btn-sm btn-danger delete-user-btn">';
                        $html .= '<i class="fas fa-trash"></i> Delete';
                        $html .= '</button>';
                        $html .= '</form>';
                    }
                    return $html;
                }),
        ];
    }
}