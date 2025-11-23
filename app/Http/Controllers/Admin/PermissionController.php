<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Permission::query();

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Get all unique categories for filter dropdown
        $categories = Permission::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Get permissions with filters applied
        $permissions = $query->orderBy('category')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();
        
        return view('admin.permissions.index', compact('permissions', 'categories'));
    }

    /**
     * Show the form for creating a new permission.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Admins cannot create new permission types - only update existing ones
        return redirect()->route('admin.permissions.index')
            ->with('error', 'Creating new permission types is not allowed. Only updating existing permissions is permitted.');
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Admins cannot create new permission types - only update existing ones
        return redirect()->route('admin.permissions.index')
            ->with('error', 'Creating new permission types is not allowed. Only updating existing permissions is permitted.');
    }

    /**
     * Display the specified permission.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\View\View
     */
    public function show(Permission $permission)
    {
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified permission.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        $categories = Permission::select('category')->distinct()->pluck('category');
        return view('admin.permissions.edit', compact('permission', 'categories'));
    }

    /**
     * Update the specified permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($permission->id),
            ],
            'description' => 'nullable|string|max:500',
            'category' => 'required|string|max:100',
        ]);

        // Generate slug from name if name was changed
        if ($permission->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $permission->update($validated);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Permission $permission)
    {
        // Admins cannot delete permission types - only update existing ones
        return back()->with('error', 'Deleting permission types is not allowed. Only updating existing permissions is permitted.');
    }
}
