<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionActivatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $startDate;
    public $endDate;

    public function __construct(User $user)
    {
        $this->user = $user;

        // Safely format dates (avoid calling format() on null)
        $this->startDate = $user->membership_start
            ? \Carbon\Carbon::parse($user->membership_start)->format('F j, Y')
            : 'N/A';

        $this->endDate = $user->membership_end
            ? \Carbon\Carbon::parse($user->membership_end)->format('F j, Y')
            : 'N/A';
    }

    public function build()
    {
        return $this->subject('🎉 Your Premium Subscription is Active!')
                    ->view('emails.subscription_activated')
                    ->with([
                        'user' => $this->user,
                        'startDate' => $this->startDate,
                        'endDate' => $this->endDate,
                    ]);
    }
}
