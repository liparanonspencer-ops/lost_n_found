<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Item;
use App\Notifications\ClaimStatusNotification; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    public function index()
    {
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
            ->paginate(15);

        return view('admin.claims.history', compact('claims'));
    }

   public function update(Request $request, Claim $claim)
{
    // 1. Validate (Allow string '1' or '0' for is_resolved)
    $request->validate([
        'status' => 'required|string',
        'is_resolved' => 'required' 
    ]);

    // 2. Use the transaction
    DB::transaction(function () use ($request, $claim) {
        
        // Force the value to a proper integer/boolean for the DB
        $resolvedValue = (bool) $request->is_resolved;

        // Update Claim
        $claim->update([
            'status' => $request->status,
            
        ]);

        if (strtolower($request->status) === 'approved' && $claim->item) {
            // Update Item
            $claim->item->update([
                'status' => 'not available', 
                'is_resolved' => true
            ]);

            // Reject others
            Claim::where('item_id', $claim->item_id)
                ->where('id', '!=', $claim->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected', 'is_resolved' => false]);
            
            // Note: If you use ->update() on a Query Builder (like above), 
            // Notifications won't fire automatically. 
            // If you need notifications for EVERYONE, keep your foreach loop.
        }
    });

    return redirect()->route('admin.claims.index')->with('success', 'Action completed successfully.');
}
  
}