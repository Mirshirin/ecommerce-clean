<?php

namespace App\Listeners;

use App\Events\EmailSent;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;

class SaveEmailLog
{
    public function handle(EmailSent $event)
    {
        // // Attempt to send the email
        // $result = Mail::send($event->mailable, $event->data, function ($message) use ($event) {
        //     $message->from('from@example.com', 'Mailer');
        //     $message->to($event->recipient)->subject($event->subject);
        // });

        // // Check if the email was sent successfully
        // if ($result) {
        //     // Email was sent successfully
        //     EmailLog::create([
        //         'recipient' => $event->recipient,
        //         'message' => $event->message,
        //         'sent_at' => now(),
        //         'status' => 'success', // Indicate success
        //     ]);
        // } else {
        //     // Failed to send the email
        //     EmailLog::create([
        //         'recipient' => $event->recipient,
        //         'message' => $event->message,
        //         'sent_at' => now(),
        //         'status' => 'failed', // Indicate failure
        //     ]);
        // }
    }
}
