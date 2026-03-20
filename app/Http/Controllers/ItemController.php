<?php

namespace App\Http\Controllers;

// FIX 1: Use the correct singular Model name 'Item'
use App\Models\Item; 
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        // FIX 2: Since we imported 'Item' above, we don't need the full path here
        $items = Item::latest()->paginate(10);
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    // FIX 3: Ensure the Type-hint matches the imported Model name 'Item'
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function claim(Request $request, Item $item)
{
    // Prevent owner from claiming their own item
    if (auth()->id() === $item->user_id) {
        return back()->with('error', 'You cannot claim your own item.');
    }

    // Create the claim
    \App\Models\Claim::create([
        'item_id' => $item->id,
        'user_id' => auth()->id(),
        'message' => 'I would like to claim this item.',
    ]);

    return back()->with('success', 'Claim submitted successfully! The owner will be notified.');
}

    public function store(Request $request)
    {
        // 1. Validate all incoming data
        $request->validate([
            'item_name'   => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:lost,found',
            'category'    => 'required|string',
            'location'    => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Create the new item instance (Using the imported 'Item' class)
        $item = new Item();
        $item->user_id = auth()->id();
        
        // 3. Map the Form fields to the Database columns
        $item->item_name   = $request->item_name;
        $item->description = $request->description;
        $item->type        = $request->type;
        $item->category    = $request->category;
        $item->location    = $request->location;

        // 4. Handle the Image Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $item->image_path = $path;
        }

        // 5. Save to Database
        $item->save();

        return redirect()->route('items.index')->with('success', 'Item reported successfully!');
    }
}