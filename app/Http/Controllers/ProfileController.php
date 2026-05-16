<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
     public function update(Request $request): RedirectResponse
{
    // 1. Validation
    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'phone_number' => ['required','string','max:20'],
        'email' => [
            'required', 
            'string', 
            'lowercase', 
            'email', 
            'max:255', 
            Rule::unique(User::class)->ignore($request->user()->id)
        ],
        'profile_photo' => ['nullable', 'image', 'max:2048'], 
    ]);

    $user = $request->user();
    
    // Fill the user model with validated data (except the photo for now)
    $user->fill($validated);

    // 2. Handle Photo Upload
    if ($request->hasFile('profile_photo')) {
        // Delete old photo from storage if it exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo and save the path
        $file = $request->file('profile_photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/profiles'), $filename);
        $user->profile_photo = 'uploads/profiles/' . $filename;
    }

    // 3. Reset Email Verification if changed
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

  public function show()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Return a SIMPLE Blade view
        return view('profile.show', compact('user'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
