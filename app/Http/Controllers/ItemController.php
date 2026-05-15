<?php

namespace App\Http\Controllers;

use App\Models\Item; 
use App\Models\Claim; 
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
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
        return view('items.index', compact('items'));
    }

    public function show(Item $item)
    { 
        $item->load('user');
        return view('items.show', compact('item'));
    }

    public function claim(Request $request, Item $item)
    {
        // Prevent claiming resolved items
        if ($item->is_resolved || $item->status === 'claimed') {
            return back()->with('error', 'This item has already been successfully claimed.');
        }

        // Require login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        
        if (auth()->id() === $item->user_id) {
            return back()->with('error', 'You cannot claim your own item.');
        }

    
        $exists = Claim::where('item_id', $item->id)
                       ->where('user_id', auth()->id())
                       ->exists();

        if ($exists) {
            return back()->with('error', 'You have already submitted a claim for this item.');
        }

    
        Claim::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'message' => $request->input('message', 'I would like to claim this item.'),
            'status'  => 'pending',
           
        ]);

        return back()->with('success', 'Claim submitted successfully! The admin will review it.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name'   => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:lost,found',
            'category'    => 'required|string',
            'location'    => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $item = new Item();
        $item->user_id = auth()->id();
        $item->item_name   = $request->item_name;
        $item->description = $request->description;
        $item->type        = $request->type;
        $item->category    = $request->category;
        $item->location    = $request->location;
        $item->status      = 'available';
        $item->is_resolved = false;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $item->image_path = $path;
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Item reported successfully!');
    }

    public function create()
    {
        return view('items.create');
    }

  
    public function update(Request $request, Claim $claim)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $item = $claim->item;

        // Prevent approving already resolved items
        if ($item->is_resolved && $request->status === 'approved') {
            return back()->with('error', 'Item already resolved.');
        }

        if ($request->status === 'approved') {

            // 1. Approve selected claim
            $claim->status = 'approved';
            $claim->save();

            // 2. Reject all other claims
            Claim::where('item_id', $item->id)
                ->where('id', '!=', $claim->id)
                ->update(['status' => 'rejected']);

            // 3. Mark item as claimed/resolved
            $item->update([
                'status' => 'claimed',
                'is_resolved' => true,
            ]);

        } else {
            
            $claim->status = 'rejected';
            $claim->is_rejected = true;
            $claim->save();
        }

        return back()->with('success', 'Claim updated successfully!');
    }
}