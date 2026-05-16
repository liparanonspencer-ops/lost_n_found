<?php

use Illuminate\Support\Facades\Route;
use App\Models\Item; 
use App\Models\User;
use App\Models\Claim;

// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Admin\ClaimController; // Admin Logic
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\UserClaimController;  // User Logic
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;

// 1. Public Routes
Route::get('/', function () {
    return view('welcome');
});

// 2. Protected Routes (Must be logged in)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- DASHBOARD & SYSTEM ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/api/events', [CalendarController::class, 'getEvents']);

    // --- ITEMS & SEARCH ---
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

    // --- NOTIFICATIONS ---
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/delete-all-unread', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    // --- USER CLAIM SUBMISSION ---
    Route::post('/claims', [UserClaimController::class, 'store'])->name('claims.store');

    // --- THE ADS & PRINT SYSTEM (USER ACCESS) ---
    // These routes point to UserClaimController to check 'is_resolved'
    Route::get('/claims/{claim}/ads', [UserClaimController::class, 'showAds'])->name('claims.ads');
    Route::get('/claims/{claim}/print', [UserClaimController::class, 'showPrint'])->name('claims.print');

    // --- PROFILE & SETTINGS ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // 3. Admin Only Routes (Role Check)
    Route::middleware(['can:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // --- ADMIN CLAIM MANAGEMENT ---
        Route::get('/claims', [ClaimController::class, 'index'])->name('claims.index');
        Route::get('/claims/history', [ClaimController::class, 'history'])->name('claims.history');
        Route::get('/verify-claim/{claim}', [ClaimController::class, 'verify'])->name('verify.claim');
        
        // This is the CRITICAL route where Admin sets is_resolved = true
        Route::patch('/claims/{claim}', [ClaimController::class, 'update'])->name('claims.update');

        // --- USER MANAGEMENT ---
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Admin API Stats
    Route::get('/api/admin/stats', function (){
        return response()->json([
            'active' => Item::where('status','available')->count(),
            'pending' => Claim::where('status','pending')->count(),
            'resolved' => Claim::where('status','approved')->count(),
            'rejected' => Claim::where('status','rejected')->count(),
            'users' => User::count(),
        ]);
    })->middleware(['can:admin']);

});

require __DIR__.'/auth.php';