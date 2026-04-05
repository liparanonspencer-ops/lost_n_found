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
        'status' => 'required|string',
        'is_resolved' => 'required' 
    ]);

    DB::transaction(function () use ($request, $claim) {
        
        $resolvedValue = (bool) $request->is_resolved;

        $claim->update([
            'status' => $request->status,
            'is_resolved' => $resolvedValue,
        ]);

        if (strtolower($request->status) === 'approved' && $claim->item) {
            
            $claim->item->update([
                'status' => 'not available', 
                'is_resolved' => true
            ]);

            
            Claim::where('item_id', $claim->item_id)
                ->where('id', '!=', $claim->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected', 
                    'is_resolved' => true 
                ]);
        }
    });

    return redirect()->route('admin.claims.index')->with('success', 'Action completed successfully.');
}
  
}