<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('settings.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email_notifications' => 'boolean',
            'show_phone_publicly' => 'boolean',
            'theme_preference' => 'required|in:light,dark',
        ]);

        // Handle checkboxes (if not checked, they aren't in the request)
        $data['email_notifications'] = $request->has('email_notifications');
        $data['show_phone_publicly'] = $request->has('show_phone_publicly');

        $user->update($data);
return redirect()->route('dashboard');
    }
}