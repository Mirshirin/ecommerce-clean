<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OrderEmail;
use App\Jobs\SendEmailJob;
use App\Mail\ContactEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;



class EmailController extends Controller
{

    public function sendContactEmail()
    {
         $users = User::select('id','name', 'email', 'phone', 'address') 
         ->get()
         ->toArray();

    $commonDetails = [
        'message' => 'I want to check your address and your phone then send me the correct address and your mobile phone',
        'subject' => 'check email',
    ];

    User::select('id','name', 'email', 'phone', 'address')
        -> where('id','<=',4)
        ->chunk(100, function ($users) use ($commonDetails) {
            foreach ($users as $user) {
                try {
                    $toEmail = $user->email;
                    $jobDetails = array_merge($commonDetails, [
                        'userName' => $user->name,
                        'userPhone' => $user->phone,
                        'userAddress' => $user->address,
                    ]);           
                    SendEmailJob::dispatch($jobDetails, $toEmail);
                } catch (\Exception $e) {
                    Log::error('Failed to dispatch email job', ['error' => $e->getMessage()]);
                }
            }
        });


    return view('home.email.sent', [
        'message' => 'Emails sent successfully.',
        'users' =>  $users,

    ]);


    }
    
    
}
