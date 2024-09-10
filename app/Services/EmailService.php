<?php 
namespace App\Services;

use App\Mail\OrderEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    public function sendOrderConfirmation($orderResults)
    {      
        try {
                // Check the full structure first
                if (!isset($orderResults['orderResults'])) {
                    throw new \Exception("Missing 'orderResults' key in data");
                }

                // Access the first order's email as an example
                $firstOrder = $orderResults['orderResults'][0] ?? null;
                if (!$firstOrder || !isset($firstOrder['email'])) {
                    throw new \Exception("Email information is missing in the first order of orderResults");
                }
                $toEmail = $firstOrder['email'];
            
                $mailMessage = 'Your shopping details are attached.';
                $subject = 'Thanks for Shopping';

                $orderDetails=$orderResults;
                Mail::to($toEmail)->send(new OrderEmail($mailMessage,$subject,$orderDetails));
            
    } catch (\Exception $e) {
        Log::error('Error in sendOrderConfirmation method', ['exception' => $e]);
        throw new \Exception("An error occurred while processing your order: " . $e->getMessage());
    }
    
    }
}