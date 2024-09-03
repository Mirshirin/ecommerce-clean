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
    public function sendEmails($order)
    {
     
        $toEmail = $order->email;
        $mailmessage = 'your shopping';
        $subject = 'thanks for shopping';
        $orderDetails=$order;
        Mail::to($toEmail)->send(new OrderEmail($mailmessage,$subject,$orderDetails));
     
    }
    public function sendContactEmail()
    {
         $users = User::select('id','name', 'email', 'phone', 'address') 
        ->get()
         ->toArray();

    //     User::select('id','name', 'email', 'phone', 'address')    
    //     ->chunk(100, function ($users) {
    //         $commonDetails = [
    //             'message' => 'I want to check your address and your phone then send me the correct address and your mobile phone',
    //             'subject' => 'check email',
    //         ];

    //     foreach ($users as $user) {
    //         $toEmail = $user->email;
    //         $jobDetails = array_merge($commonDetails, [
    //             'userName' => $user->name,
    //             'userPhone' => $user->phone,
    //             'userAddress' => $user->address,
                
    //         ]);           
    //         SendEmailJob::dispatch($jobDetails, $toEmail);
    //     }
    // });
    //     return view('home.email.sent', [
    //         'message' => 'Emails sent successfully.',
    //         'users' =>  $users,
    //     ]);

    $commonDetails = [
        'message' => 'I want to check your address and your phone then send me the correct address and your mobile phone',
        'subject' => 'check email',
    ];

    User::select('id','name', 'email', 'phone', 'address')
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
