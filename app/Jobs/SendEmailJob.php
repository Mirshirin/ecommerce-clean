<?php

namespace App\Jobs;

use App\Models\EmailLog;
use App\Mail\ContactEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
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
        try{
            Mail::to($this->details['to'])->send(new ContactEmail($this->details)); 
            EmailLog::create([
                'recipient' => $this->details['to'],           
                'message' => $this->details['message'],
                'sent_at' => now(),
             
            ]);
        } catch(\Exception $e){
            Log::error('faield to send or log email:'. $e->getMessage());
        }

        
    }
}
