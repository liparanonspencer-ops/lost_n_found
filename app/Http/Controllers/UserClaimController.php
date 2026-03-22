<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;

class UserClaimController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate the request
        $request->validate([
            'item_id' => 'required|exists:items,id',
        ]);

        // 2. Check if the user already has a pending or approved claim for this item
        $existingClaim = Claim::where('item_id', $request->item_id)
                             ->where('user_id', Auth::id())
                             ->first();

        if ($existingClaim) {
            return back()->with('success', 'You have already submitted a claim for this item.');
        }

        // 3. Create the claim
        Claim::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'status'  => 'pending', // It starts as pending until Admin approves
        ]);

        return back()->with('success', 'Your claim request has been sent to the Admin for review!');
    }
}
