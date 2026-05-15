<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use App\Notifications\ClaimStatusNotification; 
use App\Notifications\AdminActivityNotification; // Added this import
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
            'status' => 'required|string',
            'is_resolved' => 'required' 
        ]);

        DB::transaction(function () use ($request, $claim) {
            
            $resolvedValue = (bool) $request->is_resolved;

            // 1. Update the current claim status
            $claim->update([
                'status' => $request->status,
                'is_resolved' => $resolvedValue,
            ]);

            // 2. Notify the person who made THIS claim (The Student)
            if ($claim->user) {
                $claim->user->notify(new ClaimStatusNotification($claim, $request->status));
            }

            // 3. Notify ALL Admins (This populates the "Recent Activity Logs" on the Dashboard)
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new AdminActivityNotification($claim, $request->status));
            }

            // 4. Handle rejections for everyone else IF this one was approved
            if (strtolower($request->status) === 'approved' && $claim->item) {
                
                // Mark the item as gone (Set to "not available" as per instructions)
                $claim->item->update([
                    'status' => 'not available', 
                    'is_resolved' => true
                ]);

                // Fetch other pending claims for the same item
                $otherClaims = Claim::where('item_id', $claim->item_id)
                    ->where('id', '!=', $claim->id)
                    ->where('status', 'pending')
                    ->get();

                foreach ($otherClaims as $otherClaim) {
                    $otherClaim->update([
                        'status' => 'rejected',
                        'is_resolved' => true
                    ]);
                    
                    // Notify the other students that their claim was rejected
                    if ($otherClaim->user) {
                        $otherClaim->user->notify(new ClaimStatusNotification($otherClaim, 'rejected'));
                    }
                }
            }
        });

        return redirect()->route('admin.claims.index')->with('success', 'Claim processed and students notified.');
    }
}