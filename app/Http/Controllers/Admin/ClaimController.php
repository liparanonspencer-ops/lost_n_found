<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        // Adding ->where('status', 'pending') ensures only new requests show up
        $claims = Claim::with(['item', 'user'])
            ->where('status', 'pending') 
            ->latest()
            ->get();

        return view('admin.claims.index', compact('claims'));
    }
    
    public function history()
    {
        $claims = Claim::with(['item', 'user'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->paginate(15); // Use pagination for large sets of records

        return view('admin.claims.history', compact('claims'));
    }

  
public function approveClaim($claimId)
{
    // Use a Transaction to ensure all updates happen together
    DB::transaction(function () use ($claimId) {
        // 1. Find the specific claim being approved
        $claim = \App\Models\Claim::findOrFail($claimId);
        
        // 2. Mark this specific claim as 'approved'
        $claim->update(['status' => 'approved']);

        // 3. Mark the Item itself as 'claimed' (makes it invisible/disabled for others)
        // Note: Ensure 'status' is in the $fillable array of your Item Model
        $item = \App\Models\Item::findOrFail($claim->item_id);
        $item->update(['status' => 'claimed']);

        // --- STEP 3: THE AUTO-REJECT LOGIC ---
        // Find every OTHER claim for this specific item that is still 'pending'
        // and mark them as 'rejected' automatically.
        \App\Models\Claim::where('item_id', $claim->item_id)
            ->where('id', '!=', $claimId) // Don't reject the one we just approved!
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);
    });

    return back()->with('success', 'Claim approved! All other pending requests for this item have been automatically declined.');
}

// Add this inside your Admin\ClaimController class
public function verify(Claim $claim)
{
    // Mark the claim as completed/claimed
    $claim->update(['status' => 'approved']); 

    // Optional: Mark the item itself as resolved so it's no longer "Lost"
    $claim->item->update(['status' => 'claimed']);

    return redirect()->route('admin.claims.index')
        ->with('success', 'Item successfully verified and handed over to the owner!');
}

public function update(Request $request, Claim $claim)
{
    // Update the claim status
    $claim->update([
        'status' => $request->status // This will be 'approved'
    ]);

    // Optional: You can also update the item status here 
    // to hide it from the public list once approved
    // $claim->item->update(['status' => 'approved']);

    return back()->with('success', 'Claim has been approved! The user can now see their QR code.');
}
}