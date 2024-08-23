<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
  
    public function __construct(array $details)
    {
        $this->details = $details;
       
    }    

    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: $this->details['subject'],
    //     );
    // }
    
    public function build()
    {
        return $this->view('home.email.contact')
                    ->with([                  
                        'message' => $this->details['message'], 
                        'subject' => $this->details['subject'],
                        'userName' => $this->details['userName'],
                        'userPhone' => $this->details['userPhone'],
                        'userAddress' => $this->details['userAddress'],

                ])
                ->subject($this->details['subject']);

                 
    }

    public function attachments()
    {
        return [];
    }
}
