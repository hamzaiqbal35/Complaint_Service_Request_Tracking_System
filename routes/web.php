<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ComplaintAdminController;
use App\Http\Controllers\Staff\StaffComplaintController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Temporary logout route for testing
Route::get('/logout-get', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('success', 'Logged out successfully!');
})->name('logout.get');

// Landing page remains public

Route::middleware(['auth'])->group(function () {
    // User area
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');
        Route::resource('complaints', ComplaintController::class)->only(['index','create','store','show']);
    });

    // Staff area
    Route::prefix('staff')->name('staff.')->middleware('role:staff')->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Staff\StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard/export', [App\Http\Controllers\Staff\StaffDashboardController::class, 'export'])->name('dashboard.export');
        Route::get('complaints', [StaffComplaintController::class,'index'])->name('complaints.index');
        Route::get('complaints/{complaint}', [StaffComplaintController::class,'show'])->name('complaints.show');
        Route::patch('complaints/{complaint}/status', [StaffComplaintController::class,'updateStatus'])->name('complaints.update-status');
    });

    // Admin area
    Route::middleware(['auth', 'role:admin'])->group(function () {
        // Admin routes
        Route::prefix('admin')->name('admin.')->group(function () {
            // Dashboard routes
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('dashboard/export', [App\Http\Controllers\Admin\AdminDashboardController::class, 'export'])->name('dashboard.export');
            Route::get('complaints', [ComplaintAdminController::class,'index'])->name('complaints.index');
            Route::get('complaints/{complaint}', [ComplaintAdminController::class,'show'])->name('complaints.show');
            Route::get('complaints/{complaint}/edit', [ComplaintAdminController::class,'edit'])->name('complaints.edit');
            Route::patch('complaints/{complaint}/assign', [ComplaintAdminController::class,'assign'])->name('complaints.assign');
            Route::patch('complaints/{complaint}/status', [ComplaintAdminController::class,'updateStatus'])->name('complaints.update-status');
            
            // User Management
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('export', [UserController::class, 'export'])->name('export');
                
                // Define routes individually for better control
                Route::get('', [UserController::class, 'index'])->name('index');
                Route::get('create', [UserController::class, 'create'])->name('create');
                Route::post('', [UserController::class, 'store'])->name('store');
                Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
                Route::match(['put', 'patch'], '{user}', [UserController::class, 'update'])->name('update');
                Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
                
                // Keep the show route after other resource routes to avoid conflicts
                Route::get('{user}', [UserController::class, 'show'])->name('show');
                Route::post('{user}/verify-email', [UserController::class, 'verifyEmail'])->name('verify-email');
            });
            
            // Category Management
            // Define the custom export route BEFORE the resource route to avoid conflicts
            Route::get('categories/export', [App\Http\Controllers\Admin\CategoryController::class, 'export'])
                ->name('categories.export');
            Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Email verification route for admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/users/{user}/verify-email', [App\Http\Controllers\Admin\UserController::class, 'verifyEmail'])
        ->name('admin.users.verify-email');
});

require __DIR__.'/auth.php';
