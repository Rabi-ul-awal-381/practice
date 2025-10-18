<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use App\Models\User;

class PaymentController extends Controller
{
    public function showPage()
    {
        return view('payments.checkout');
    }

    public function createSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = auth()->user();

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Premium Membership',
                    ],
                    'unit_amount' => 500, // $5.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
          'success_url' => url('/payment-success') . '?user=' . $user->id . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
            'customer_email' => $user->email,
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
{
    $userId = $request->query('user');
    $sessionId = $request->query('session_id');

    if (!$userId) {
        return redirect('/')->with('error', 'User not found after payment.');
    }

    $user = User::find($userId);

    if (!$user) {
        return redirect('/')->with('error', 'User not found.');
    }

    // ✅ Optional: verify payment via Stripe API (to be extra safe)
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    $session = \Stripe\Checkout\Session::retrieve($sessionId);

    if ($session && $session->payment_status === 'paid') {
        $user->membership = 'premium';
        $user->save();
    }

    return view('payments.success', ['session_id' => $sessionId]);
}


    public function cancel()
    {
        return view('payments.cancel');
    }
}
