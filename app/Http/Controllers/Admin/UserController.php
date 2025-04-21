<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\DataTables\UserDataTable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        $user->update(['is_active' => $request->is_active]);
        
        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully'
        ]);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}