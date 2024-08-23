<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OrderEmail;
use App\Jobs\SendEmailJob;
use App\Mail\ContactEmail;
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
        //$users = User::all();
        $users = User::where('id', '>=', 106)->get(); // Fetch users with ID >= 106

        $commonDetails = [  
            'message' => 'I want to check your address and your phone then send me the correct address and your mobile phone',
            'subject' => 'check email',            
        ]; 
    
        foreach ($users as $user) {
            if ($user->id >= 106) {

            $toEmail = $user->email;
            $jobDetails = array_merge($commonDetails, [
                'userName' => $user->name,
                'userPhone' => $user->phone,
                'userAddress' => $user->address,
            ]); 
    
            SendEmailJob::dispatch($jobDetails, $toEmail);
        }
        }
    
        return view('home.email.sent', [
            'message' => 'Emails sent successfully.',
            'users' => $users,
        ]);
    }
    
    
}
