<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionActivatedMail;

class PaymentController extends Controller
{
    /**
     * Show checkout page
     */
    public function showPage(Request $request)
    {
        $pendingUserId = $request->session()->get('pending_user_id');

        // Redirect if neither a pending user nor a logged-in user
        if (!$pendingUserId && !auth()->check()) {
            return redirect()->route('register')->with('error', 'Please create an account first.');
        }

        return view('payments.checkout');
    }

    /**
     * Create Stripe Checkout session
     */
    public function createSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Try to get user email
        $email = null;

        if (auth()->check()) {
            $email = auth()->user()->email;
        } elseif ($request->session()->has('pending_user_id')) {
            $pendingUser = User::find($request->session()->get('pending_user_id'));
            $email = $pendingUser?->email;
        }

        if (!$email) {
            return redirect()->route('register')->with('error', 'User email not found.');
        }

        // Create Stripe session
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

    /**
     * Payment success handler
     */
    public function success(Request $request)
    {
        // Case 1: Newly registered user (from session)
        if ($request->session()->has('pending_user_id')) {
            $user = User::find($request->session()->get('pending_user_id'));

            if ($user) {
                $user->update([
                    'membership_type' => 'premium',
                    'membership_start' => now(),
                    'membership_end' => now()->addMonth(),
                ]);

                try {
                    Mail::to($user->email)->send(new SubscriptionActivatedMail($user));
                } catch (\Exception $e) {
                    \Log::error('Mail sending failed: ' . $e->getMessage());
                }

                Auth::login($user);
                $request->session()->forget('pending_user_id');

                return redirect()->route('dashboard')->with('success', 'Payment successful! Welcome to Premium.');
            }
        }

        // Case 2: Existing logged-in user
        if (Auth::check()) {
            $user = Auth::user();
            $user->update([
                'membership_type' => 'premium',
                'membership_start' => now(),
                'membership_end' => now()->addMonth(),
            ]);

            try {
                Mail::to($user->email)->send(new SubscriptionActivatedMail($user));
            } catch (\Exception $e) {
                \Log::error('Mail sending failed: ' . $e->getMessage());
            }

            return redirect()->route('dashboard')->with('success', 'Payment successful! You are now Premium.');
        }

        // Fallback
        return redirect()->route('login')->with('error', 'Payment could not be verified.');
    }

    /**
     * Payment cancel handler
     */
    public function cancel()
    {
        return redirect()->route('register')->with('error', 'Payment was cancelled.');
    }
}
