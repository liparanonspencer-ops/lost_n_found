<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;

class UserClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::with('item')
            ->where('user_id', Auth::id())
            ->get();
        
        return view('dashboard', compact('claims'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
        ]);

        $existingClaim = Claim::where('item_id', $request->item_id)
                             ->where('user_id', Auth::id())
                             ->first();

        if ($existingClaim) {
            return back()->with('info', 'You already have an active claim for this item.');
        }

        Claim::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'status'  => 'pending',
            'is_resolved' => false, 
        ]);

        return back()->with('success', 'Your claim request has been sent to the Admin!');
    }

    
    public function showAds(Claim $claim) 
    {
        
        if (Auth::id() !== $claim->user_id || !$claim->is_resolved) {
            abort(403, 'This claim is not yet approved by admin.');
        }

        return view('admin.claims.ads', compact('claim'));
    }


    public function showPrint(Claim $claim) 
    {
        if (Auth::id() !== $claim->user_id || !$claim->is_resolved) {
            abort(403, 'Unauthorized access to printing.');
        }

        return view('admin.claims.print', compact('claim'));
    }
}