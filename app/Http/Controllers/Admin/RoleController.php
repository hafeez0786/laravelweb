<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get role statistics
        $roles = DB::table('users')
            ->select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();

        // Get users by role
        $adminUsers = User::where('role', 'admin')->get();
        $normalUsers = User::where('role', 'user')->get();

        return view('admin.roles.index', compact('roles', 'adminUsers', 'normalUsers'));
    }

    /**
     * Show the form for editing user roles.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.roles.edit', compact('user'));
    }

    /**
     * Update user role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        // Prevent user from changing their own role
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->update(['role' => $validated['role']]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'User role updated successfully.');
    }

    /**
     * Show role management dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();

        $recentRoleChanges = DB::table('users')
            ->select('name', 'email', 'role', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.roles.dashboard', compact(
            'totalUsers',
            'adminCount', 
            'userCount',
            'recentRoleChanges'
        ));
    }
}
