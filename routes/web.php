<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Home Page - Redirect to login if not authenticated
Route::get('/', function () {
    if (Auth::check()) {
        // If user is logged in, redirect based on role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    // If not logged in, show login page
    return redirect()->route('login');
})->name('home');

// Authentication Routes
Auth::routes(['register' => false]);

// User Dashboard
Route::get('/user/dashboard', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('user.dashboard');

// Products Routes (only accessible if user has permission)
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');
    
    Route::get('/products/{id}', [ProductController::class, 'show'])
        ->name('products.show');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users Management
    Route::resource('users', AdminController::class);
    Route::post('users/{user}/permissions/grant', [AdminController::class, 'grantPermissions'])
        ->name('users.permissions.grant');
    Route::post('users/{user}/permissions/revoke', [AdminController::class, 'revokePermissions'])
        ->name('users.permissions.revoke');

    // Permissions Management
    Route::resource('permissions', PermissionController::class)->except(['show']);

    // Roles Management
    Route::get('roles/dashboard', [RoleController::class, 'dashboard'])->name('roles.dashboard');
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/{user}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{user}', [RoleController::class, 'update'])->name('roles.update');
});
