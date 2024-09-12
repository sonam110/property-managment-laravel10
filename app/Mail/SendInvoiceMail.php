<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

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
        $htmlFilePath = $this->content['FilePath']; 
        $filename =  $this->content['FileName']; 
        $mime =  $this->content['mime']; 
        $subject =  $this->content['subject']; 
        return $this->markdown('email.send-invoice-to-mail')
            ->from(env('MAIL_FROM_ADDRESS','support@signature.in'),'Signature Group Team')
            ->subject($subject)
            ->attach($htmlFilePath, [
                'as' => $filename,
                'mime' => $mime,
            ])
            ->with($this->content);
    }
}
