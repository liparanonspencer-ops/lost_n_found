<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the 6 latest items
       $items =Item::with('user')->latest()->get();


        return view('dashboard', compact('items'));
    }
}