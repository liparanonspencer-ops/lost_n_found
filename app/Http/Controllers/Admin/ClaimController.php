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
        $request->validate([
            'status' => 'required|string'
        ]);

        DB::transaction(function () use ($request, $claim) {
            // 2. Update the specific claim status
            $claim->update([
                'status' => $request->status
            ]);

            // 3. Notify the specific claimant (Manual action)
            $claim->user->notify(new ClaimStatusNotification($claim, $request->status));
           // Admin gets notif as well after admin approves request
           auth()->user()->notify(new ClaimStatusNotification($claim, $request->status));
            // 4. If approved, update the Item and reject others
            if (strtolower($request->status) === 'approved' && $claim->item) {
                
                $claim->item->update([
                    'status' => 'not available' 
                ]);

                // 5. Handle Auto-rejections for other users
                $otherClaims = Claim::where('item_id', $claim->item_id)
                    ->where('id', '!=', $claim->id)
                    ->where('status', 'pending')
                    ->get();

                foreach ($otherClaims as $otherClaim) {
                    $otherClaim->update(['status' => 'rejected']);
                    
                    // Notify other users that they were rejected because the item is gone
                    $otherClaim->user->notify(new ClaimStatusNotification($otherClaim, 'rejected'));
                }
                    
                $claim->item->refresh();
            }
        });

        $message = $request->status === 'approved' 
            ? 'Claim approved and others auto-rejected.' 
            : 'Claim has been rejected.';

        return back()->with('success', $message);
    }
}