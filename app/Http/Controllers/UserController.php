<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Show all users to the Admin
    public function index()
    {
        abort_unless(
            Auth::guard('admin')->check(),
            403,
            'Only admin can access User Management.'
        );

        $users = User::select(
            'id',
            'name',
            'email',
            'role',
            'created_at'
        )->latest()->get();

        return view('admin.users', compact('users'));
    }

    // Update a user's role
    public function updateRole(Request $request, $id)
    {
        abort_unless(
            Auth::guard('admin')->check(),
            403,
            'Only admin can change user roles.'
        );

        $validated = $request->validate([
            'role' => ['required', 'in:owner,admin'],
        ]);

        $user = User::findOrFail($id);

        // Prevent changing the role of the last admin
        if (
            $user->role === 'admin' &&
            $validated['role'] === 'owner' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return back()->with(
                'error',
                'At least one admin account must remain.'
            );
        }

        $user->role = $validated['role'];
        $user->save();

        return redirect()
            ->route('admin.users')
            ->with('success', 'User role updated successfully!');
    }
}
