<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function showPage(Request $request)
    {
        $pendingUser = $request->session()->get('pending_user');
    
        if (!$pendingUser && !auth()->check()) {
            return redirect()->route('register')->with('error', 'Please create an account first.');
        }
    
        return view('payments.checkout');
    }
    

    public function createSession(Request $request)
{
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $pendingUser = $request->session()->get('pending_user');
    $email = auth()->check() ? auth()->user()->email : ($pendingUser['email'] ?? null);

    if (!$email) {
        return redirect()->route('register')->with('error', 'User email not found.');
    }

    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => 'Premium Membership'],
                'unit_amount' => 500, // $5.00
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => url('/payment-success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('payments.cancel'),
        'customer_email' => $email,
    ]);

    return redirect($session->url);
}


public function success(Request $request)
{
    $sessionId = $request->query('session_id');

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    $session = \Stripe\Checkout\Session::retrieve($sessionId);

    if ($session && $session->payment_status === 'paid') {
        // If user was logged in, upgrade them
        if (auth()->check()) {
            $user = auth()->user();
            $user->membership_type = 'paid';
            $user->save();
            return redirect()->route('dashboard')->with('success', 'Your membership has been upgraded!');
        }

        // Otherwise create the new user from session
        $pendingUser = session()->pull('pending_user');

        if ($pendingUser) {
            $user = \App\Models\User::create([
                'name' => $pendingUser['name'],
                'email' => $pendingUser['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($pendingUser['password']),
                'membership_type' => 'paid',
                'role' => 'user',
            ]);

            \Illuminate\Support\Facades\Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Welcome! Premium account created successfully.');
        }
    }

    return redirect()->route('register')->with('error', 'Payment not successful.');
}


    public function cancel()
    {
        return redirect()->route('register')->with('error', 'Payment was cancelled.');
    }
}
