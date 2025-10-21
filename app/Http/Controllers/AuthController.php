<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
        'membership_type' => ['required', 'in:free,paid'],
    ]);

    // Case 1: Free user
    if ($validated['membership_type'] === 'free') {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'membership_type' => 'free',
            'role' => 'user',
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }

    // Case 2: Paid user — create with pending status
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'membership_type' => 'pending', // mark as pending until payment succeeds
        'role' => 'user',
    ]);

    // Store user ID for payment success
    $request->session()->put('pending_user_id', $user->id);

    // Redirect to checkout
    return redirect()->route('payments.checkout');
}



    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
