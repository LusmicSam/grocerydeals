<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DealAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $deal;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($deal, $user)
    {
        $this->deal = $deal;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
                    ->subject('New Grocery Deal Alert: ' . $this->deal->name)
                    ->view('emails.deal-alert');
    }
}
