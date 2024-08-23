<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $mailmessage;
    public $subject;
    public $orderDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailmessage,$subject,$orderDetails)
    {
        $this->mailmessage = $mailmessage;
        $this->subject = $subject;
        $this->orderDetails = $orderDetails;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
       
            subject:  $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'home.email.order',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
    public function build()
    {
        return $this->view('home.email.order')
                    ->subject($this->subject)
                    ->with(['message' => $this->mailmessage, 'order' => $this->orderDetails]);
    }
}
