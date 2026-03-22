<?php

namespace App\Http\Controllers;

use App\Models\Item; 
use App\Models\Claim; // Added Claim import
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        // STEP 5: Only show items that are NOT resolved by default
        // This keeps your feed clean of already-found items
        $query->where('is_resolved', false);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->paginate(12);
        return view('items.index', compact('items'));
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function claim(Request $request, Item $item)
    {
        // STEP 3 LOGIC: Prevent claiming if the item is already resolved/claimed
        if ($item->is_resolved || $item->status === 'claimed') {
            return back()->with('error', 'This item has already been successfully claimed.');
        }

        // Prevent owner from claiming their own item
        if (auth()->id() === $item->user_id) {
            return back()->with('error', 'You cannot claim your own item.');
        }

        // Prevent double-claiming by the same user
        $existingClaim = Claim::where('item_id', $item->id)
                             ->where('user_id', auth()->id())
                             ->first();
                             
        if ($existingClaim) {
            return back()->with('error', 'You have already submitted a claim for this item.');
        }

        // Create the claim
        Claim::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'message' => 'I would like to claim this item.',
            'status'  => 'pending', // Explicitly set starting status
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
        $item->status      = 'available'; // Set initial status
        $item->is_resolved = false;       // Set initial resolved state

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

   public function verifyClaim($id)
{
    $item = Item::findOrFail($id);

    // Update the status to 'returned' or 'claimed'
    $item->status = 'claimed';
    $item->save();

    // Redirect with a success message
    return redirect('/dashboard')->with('success', 'Item #' . $id . ' has been successfully claimed!');
}
}