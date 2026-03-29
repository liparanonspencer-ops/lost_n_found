<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Claim; // Added Claim model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Added Auth facade

class DashboardController extends Controller
{
    public function index(Request $request)
    {    
        // 1. YOUR EXISTING LOGIC: Fetch Items with Search
        $query = Item::with('user')->where('is_resolved', false);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->limit(4)->get();

        // 2. THE FIX: Fetch Claims for the logged-in user
        // We fetch claims so the @foreach($claims as $claim) in your blade works.
        $claims = Claim::with('item')
            ->where('user_id', Auth()->id())
            ->latest()
            ->get();

        // 3. Return BOTH variables to the view
        return view('dashboard', compact('items', 'claims'));
    }
}