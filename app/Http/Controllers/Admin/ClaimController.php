<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Item;
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

    /**
     * This is the ONLY method you need for updating status.
     * It handles Approval, Item status change, and Auto-rejections.
     */
    public function update(Request $request, Claim $claim)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        DB::transaction(function () use ($request, $claim) {
            // 1. Update the specific claim status (e.g., 'approved')
            $claim->update([
                'status' => $request->status
            ]);

            // 2. If approved, update the Item and reject others
            if (strtolower($request->status) === 'approved' && $claim->item) {
                
                // Change Item status to 'not available'
                $claim->item->update([
                    'status' => 'not available' 
                ]);

                // Auto-reject other pending claims for this specific item
                Claim::where('item_id', $claim->item_id)
                    ->where('id', '!=', $claim->id)
                    ->where('status', 'pending')
                    ->update(['status' => 'rejected']);
                    
                // Refresh the item in the current request memory
                $claim->item->refresh();
            }
        });

        return back()->with('success', 'Process completed! Item is now marked as not available.');
    }
}