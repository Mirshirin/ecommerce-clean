<?php

namespace App\Jobs;

use App\Mail\ContactEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    public function __construct(array $details, string $toEmail)
    {
        $this->details = [
            'to' => $toEmail,
            'message' => $details['message'],
            'subject' => $details['subject'],
            'userName' => $details['userName'],
            'userPhone' => $details['userPhone'],
            'userAddress' => $details['userAddress'],
        ];
    }


    public function handle()
    {
        Mail::to($this->details['to'])->send(new ContactEmail($this->details)); 

    }
}
