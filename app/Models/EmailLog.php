<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipient;
    public $message;
    // Add other properties as needed

    public function __construct($recipient, $message /*, other parameters */)
    {
        $this->recipient = $recipient;
        $this->message = $message;
        // Set other properties
    }
}
