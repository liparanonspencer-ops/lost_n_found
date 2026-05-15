<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.Usersindex', compact('users')); // Ensure path matches your blade
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'profile_photo' => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return Redirect::back()->with('success', 'User updated successfully!');
    }
    public function edit(Request $request): View
    {
        return view('admin.users.edit', ['user' => $request->user(),]);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return Redirect::back()->with('error', 'You cannot delete your own account here.');
        }

        $user->delete();

        return Redirect::back()->with('success', 'User deleted successfully.');
    }
      public function destroyAll()
    {
        // Delete all unread notifications for the logged-in user
        auth()->user()->unreadNotifications()->delete();

        return back()->with('success', 'All unread notifications deleted.');
    }
}