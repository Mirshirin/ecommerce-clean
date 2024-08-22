<?php

namespace App\Http\Controllers;

use App\Mail\OrderEmail;
use Illuminate\Http\Request;
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
}
