<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendLeaseExpiryMail extends Mailable
{
    
    /**
     * Create a new message instance.
     */
    public $content;

    public function __construct($content) {
        $this->content = $content;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
       
        return $this->markdown('email.send-lease-expiry-mail')
            ->from(env('MAIL_FROM_ADDRESS','support@signature.in'),'Signature Group Team')
            ->subject('Lease Expiration Reminder')
            ->with($this->content);
    }
}
