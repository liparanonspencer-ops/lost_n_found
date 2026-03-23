<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Admin\ClaimController;
use App\Http\Controllers\Admin\UserController; // Import the new Admin UserController
use Illuminate\Support\Facades\Route;
use App\Models\Item; 
use App\Models\User;
use App\Models\Claim;
use App\Http\Controllers\UserClaimController;
use App\Http\Controllers\NotificationController;
// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Protected Routes (Must be logged in)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', function () {
        $items = Item::latest()->take(6)->get(); 
        return view('dashboard', compact('items'));
    })->name('dashboard');

    // --- NOTIFICATION ROUTES ---
   
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');


    // 2. Items System
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::get('search/items/{items}',[ItemController::class, 'search'])->name('items.search');
    
    Route::post('/claims', [UserClaimController::class, 'store'])->name('claims.store');

  
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
    
    // Legacy route redirected to the new clean admin route
    Route::get('/profile/users', function() {
        return redirect()->route('admin.users.index');
    })->name('profile.users.usersindex');
});

require __DIR__.'/auth.php';