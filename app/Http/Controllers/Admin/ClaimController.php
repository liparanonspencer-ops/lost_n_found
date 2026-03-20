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

    public function update(Request $request, Claim $claim)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);
        
        $claim->update(['status' => $request->status]);

        // If approved, you might want to mark the item as resolved
        if ($request->status === 'approved') {
            $claim->item->update(['is_resolved' => true]);
        }

        return back()->with('success', 'Claim status updated to ' . $request->status);
    }
}