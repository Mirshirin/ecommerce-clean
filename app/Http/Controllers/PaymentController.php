<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;


class PaymentController extends Controller
{
    
    public function cashOrder(Request $request){
        
        $cart=$request->session()->has('cart') ? $request->session()->get('cart') : null;        
      
        if (empty($cart)) {
         
            return redirect()->route('home')->with('error', 'سبد خرید شما خالی است. لطفاً محصولاتی را به سبد اضافه کنید.');
        } 
        $totalAmount = 0;   
        foreach ($cart as $productId => $product) 
        {
            $order= Order::create([
                'name'=>$product['name'],
                'email'=>$product['email'],
                'phone_number'=> $product['phone_number'],
                'address' => $product['address'],
                'product_title'=> $product['product_title'],       
                'price'=>$product['price'] ,                       
                'image'=> $product['image'],
                'quantity'=>$product['quantity'],                    
                'product_id'=> $product['product_id'],
                'payment_status'=> 'cash on delivery',  
                'delivery_status'=>'processing',    
            ]);
            $totalAmount += $product['price'] * $product['quantity']; // محاسبه مجموع قیمت کل سفارش

        }
            
        $payment = PaymentOrder::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'amount_paid' => $totalAmount,
            'payment_date' => now(),
        ]);

        
        $invoice = (new Invoice)->amount($totalAmount);
        
        return Payment::callbackUrl(route("pay-result"))->purchase(
            $invoice, 
            function($driver, $transactionId) use($payment)  {
                // We can store $transactionId in database.
                $payment->update([
                    'transaction_id' => $transactionId                   
                ]);
            }
        )->pay()->render();
   
        return redirect()->route('payment_result')->with('message','we have recieved your order ');
    }
    public function payResult(Request $request)
    {
        //dd($request->all());
        $payment = Payment::where('order_id', $request->order_id)->first();
        
    
        if (!$payment) {
            return redirect()->back()->withErrors(['error' => 'پرداخت انجام نشده است.']);
        }
        $successfulPayment=0;
        if ($successfulPayment) { // فرض بر این است که $successfulPayment یک متغیر است که مشخص می‌کند آیا پرداخت موفق بوده است یا خیر
            $payment->update(['status' => 'completed']);
        } else {
            $payment->update(['status' => 'failed']);
        }
        
        return view('payment_result', compact('payment'));
    }
    

}
