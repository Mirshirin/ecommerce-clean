<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Storage;


class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $mailmessage;
    public $subject;
    public $orderDetails;
    //public $photos;

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
        $email = $this->view('home.email.order')
                      ->subject($this->subject)
                      ->with([
                          'message' => $this->mailmessage,
                          'order' => $this->orderDetails,
                          'totalProducts' => $this->orderDetails['total'] ?? 0, // Ensure 'total' key exists
                      ]);
                 
    foreach ($this->orderDetails['orderResults'] as $order) {
        // Check if 'image' key exists and is not empty
        if (!empty($order['image'])) {
            $imagePath = $order['image'];

            // Check if the image exists in the storage
            if (Storage::disk('public')->exists($imagePath)) {
                // Attach the image from storage
                $email->attachFromStorageDisk('public', $imagePath, basename($imagePath), [
                    'mime' => 'image/jpeg', // Adjust the MIME type if necessary
                ]);
            } else {
                // Log or handle cases where the image path is incorrect or the image is missing
                Log::warning('Image not found or inaccessible for order: ' . $order['id']);
            }
        } else {
            // Log if the 'image' key is missing or empty
            Log::info('No image found for order: ' . $order['id']);
        }
    }

    return $email;
}
    
}
