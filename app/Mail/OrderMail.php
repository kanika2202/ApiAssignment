<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // ✅ បន្ថែមនេះ

    public function __construct($order)
    {
        $this->order = $order; // ✅ assign
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order',
            with: [
                'order' => $this->order // ✅ pass data ទៅ view
            ],
        );
    }
}
