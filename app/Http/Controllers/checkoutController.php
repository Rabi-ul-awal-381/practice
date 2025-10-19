<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function show()
    {
        if (!session('pending_user_id')) {
            return redirect()->route('register')->with('error', 'No pending payment found.');
        }

        return view('payments.checkout');
    }

    public function complete(Request $request)
    {
        $user = User::find(session('pending_user_id'));

        if (!$user) {
            return redirect()->route('register')->with('error', 'User not found.');
        }

        // Simulate successful payment
        $user->membership_type = 'premium';
        $user->save();

        Auth::login($user);
        session()->forget('pending_user_id');

        return redirect()->route('dashboard')->with('success', 'Payment successful! You are now a premium member.');
    }
}
