<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Admin\ClaimController;
use App\Http\Controllers\Admin\UserController; 
use Illuminate\Support\Facades\Route;
use App\Models\Item; 
use App\Models\User;
use App\Models\Claim;
use App\Http\Controllers\UserClaimController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;


// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Protected Routes (Must be logged in)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
 
    // --- NOTIFICATION ROUTES ---  
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    // 2. Items System
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::get('search/items/{items}',[ItemController::class, 'search'])->name('items.search');
    
    Route::post('/claims', [UserClaimController::class, 'store'])->name('claims.store');

    // --- UPDATED: USER PRINTING & ADS SYSTEM ---
    // We added 'admin.' to the view path because that is where your files are located
    Route::get('/claims/{claim}/ads', function (Claim $claim) {
        return view('admin.claims.ads', compact('claim'));
    })->name('claims.ads');

    Route::get('/claims/{claim}/print', function (Claim $claim) {
        return view('admin.claims.print', compact('claim'));
    })->name('claims.print');

  
    // 3. Admin Only Routes (Role Check)
    Route::middleware(['can:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/claims', [ClaimController::class, 'index'])->name('claims.index');
        Route::patch('/claims/{claim}', [ClaimController::class, 'update'])->name('claims.update');
        Route::get('/claims/history', [ClaimController::class, 'history'])->name('claims.history');
        Route::get('/verify-claim/{claim}', [ClaimController::class, 'verify'])->name('verify.claim');

        // --- CLEAN USER MANAGEMENT ---
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Admin dashboard monitoring report routes
    Route::get('/api/admin/stats', function (){
        return response()->json([
            'active' => Item::where('status','available')->count(),
            'pending' => Claim::where('status','pending')->count(),
            'resolved' => Claim::where('status','approved')->count(),
            'users' => User::count(),
        ]);
    })->middleware(['can:admin']);

    // 4. Profile Management (Self-service)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('profile.show');
    // Legacy route redirected to the new clean admin route
    Route::get('/profile/users', function() {
        return redirect()->route('admin.users.index');
    })->name('profile.users.usersindex');

    // 5. Settings routes
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    // 6. calendar routes
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/api/events', [CalendarController::class, 'getEvents']);

});

require __DIR__.'/auth.php';