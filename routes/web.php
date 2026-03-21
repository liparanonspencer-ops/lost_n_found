<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Admin\ClaimController; // Import this for the admin routes
use Illuminate\Support\Facades\Route;
use App\Models\Item; 

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

    // 2. Items System
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::get('search/items/{items}',[ItemController::class, 'search'])->name('items.search');
    Route::post('/items/{item}/claim', [ItemController::class, 'claim'])->name('items.claim');

  
    // 3. Admin Only Routes (Role Check)
    Route::middleware(['can:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/claims', [ClaimController::class, 'index'])->name('claims.index');
        Route::patch('/claims/{claim}', [ClaimController::class, 'update'])->name('claims.update');
        Route::get('/claims/history', [ClaimController::class, 'history'])->name('claims.history');
    });

    // 4. Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';