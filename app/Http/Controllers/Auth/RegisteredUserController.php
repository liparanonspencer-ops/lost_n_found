<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOTPNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
        ]);

        $otp = (string) rand(100000, 999999);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        event(new Registered($user));

        $user->notify(new SendOTPNotification($otp));

        return redirect()->route('otp.verify', ['email' => $user->email]);
    }

    public function showVerifyOtp(Request $request): View
    {
        return view('auth.verify-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            return back()->withInput()->withErrors(['otp' => 'The provided OTP is invalid or has expired.']);
        }

        $user->email_verified_at = Carbon::now();
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function myApprovedClaims()
    {
        $approvedClaims = \App\Models\Claim::where('user_id', auth()->id())
                            ->where('status', 'approved')
                            ->with('item')
                            ->latest()
                            ->get();

        return view('claims.approved', compact('approvedClaims'));
    }
}