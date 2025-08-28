<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ComplaintAdminController;
use App\Http\Controllers\Staff\StaffComplaintController;
use Illuminate\Support\Facades\Route;

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
        Route::resource('complaints', ComplaintController::class)->only(['index','create','store','show']);
    });

    // Staff area
    Route::prefix('staff')->name('staff.')->middleware('role:staff')->group(function () {
        Route::get('complaints', [StaffComplaintController::class,'index'])->name('complaints.index');
        Route::patch('complaints/{complaint}/status', [StaffComplaintController::class,'updateStatus'])->name('complaints.update-status');
    });

    // Admin area
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('complaints', [ComplaintAdminController::class,'index'])->name('complaints.index');
        Route::get('complaints/{complaint}/edit', [ComplaintAdminController::class,'edit'])->name('complaints.edit');
        Route::patch('complaints/{complaint}/assign', [ComplaintAdminController::class,'assign'])->name('complaints.assign');
        Route::patch('complaints/{complaint}/status', [ComplaintAdminController::class,'updateStatus'])->name('complaints.update-status');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
