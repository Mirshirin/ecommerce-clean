<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipient;
    public $message;
    public $subject;
    public $mailable; // Assuming you have a Mailable instance or similar

    /**
     * Create a new event instance.
     *
     * @param string $recipient Recipient's email address
     * @param string $message Message body
     * @param string $subject Email subject
     * @param mixed $mailable Mailable instance or similar
     */
    public function __construct(string $recipient, string $message, string $subject, $mailable)
    {
        $this->recipient = $recipient;
        $this->message = $message;
        $this->subject = $subject;
        $this->mailable = $mailable;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
