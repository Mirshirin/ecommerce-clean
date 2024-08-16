<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PaymentController extends Controller
{

    public function checkout(Request $request)
    {
        $cart=$request->session()->has('cart') ? $request->session()->get('cart') : null;        

        $user = Auth::user();
        if (empty($cart)) {
         
            return redirect()->route('products-index')->with('error', 'سبد خرید شما خالی است. لطفاً محصولاتی را به سبد اضافه کنید.');
        } 
        // Condition based on If User is not logged and click on to (addToCart) Button then redirect to login page
        if(Auth::check() == false)
        {
            return redirect()->route('login');
        }
        return view('home.cart.checkout',['user' => $user]);
    }
    public function processCheckout(Request $request)
    {
     
        $cart=$request->session()->has('cart') ? $request->session()->get('cart') : null;        
        
        // Step -1 Apply validation
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email',
            'address' => 'required|min:15',           
            'phone' => 'required',
        ]);
       
        if($validator->fails())
        {
            return response()->json([
                'message' => 'Plesae fix the errors',
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $user = Auth::user();
            // Step-3 Store data in orders table
            if($request->payment_method == 'cod')
            {


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
                        'payment_status'=> 'not paid',  
                        'delivery_status'=>'pending',    
                    ]);
                   

                    if ($product['code']!=0)
                        $discountprice = $product['price']-($product['price'] * $product['code']) / 100;
                    else{
                        $discountprice = $product['price'];
                    }
                    $totalAmount += $discountprice * $product['quantity']; // محاسبه مجموع قیمت کل سفارش
                    $totalAmount = number_format($totalAmount, 2, '.', '');

                    $productData = Product::find($product['product_id']);
                    if($productData->quantity == 'Yes')
                    {
                        $currentQty = $productData->quantity;
                        $updatedQty = $currentQty-$product['quantity'];
                        $productData->quantity = $updatedQty;
                        $productData->save();
                    }

                }
           
        
                $payment = PaymentOrder::create([
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'amount_paid' => $totalAmount,
                    'payment_date' => now(),
                ]);
        
             
                // Send Order Email
               // orderEmail($order->id,'customer');

               session()->flash('success','');

               Session()->forget('code');
               Session::put('cart', []);


                return response()->json([
                    'message' => 'Order Saved Successfully.',
                    'orderId' => $order->id,
                    'status' => true,
                ]);

            }

    }
    public function thankyou($id)
    {
        return view('admin.orders.thankyou',[
            'id' => $id,
        ]);
    }

    // public function payment(Request $request){
        
    //     $cart=$request->session()->has('cart') ? $request->session()->get('cart') : null;        
      
    //     if (empty($cart)) {
         
    //         return redirect()->route('home')->with('error', 'سبد خرید شما خالی است. لطفاً محصولاتی را به سبد اضافه کنید.');
    //     } 
    //     $totalAmount = 0;   
    //     foreach ($cart as $productId => $product) 
    //     {
    //         $order= Order::create([
    //             'name'=>$product['name'],
    //             'email'=>$product['email'],
    //             'phone_number'=> $product['phone_number'],
    //             'address' => $product['address'],
    //             'product_title'=> $product['product_title'],       
    //             'price'=>$product['price'] ,                       
    //             'image'=> $product['image'],
    //             'quantity'=>$product['quantity'],                    
    //             'product_id'=> $product['product_id'],
    //             'payment_status'=> 'cash on delivery',  
    //             'delivery_status'=>'processing',    
    //         ]);
    //         $totalAmount += $product['price'] * $product['quantity']; // محاسبه مجموع قیمت کل سفارش

    //     }
            
    //     $payment = PaymentOrder::create([
    //         'user_id' => auth()->id(),
    //         'order_id' => $order->id,
    //         'amount_paid' => $totalAmount,
    //         'payment_date' => now(),
    //     ]);

        
    //     $invoice = (new Invoice)->amount($totalAmount);
        
    //     return Payment::callbackUrl(route("pay-result"))->purchase(
    //         $invoice, 
    //         function($driver, $transactionId) use($payment)  {
    //             // We can store $transactionId in database.
    //             $payment->update([
    //                 'transaction_id' => $transactionId                   
    //             ]);
    //         }
    //     )->pay()->render();
   
    //     return redirect()->route('payment_result')->with('message','we have recieved your order ');
    // }
    // public function payResult(Request $request)
    // {
    //     //dd($request->all());
    //     $payment = Payment::where('order_id', $request->order_id)->first();
        
    
    //     if (!$payment) {
    //         return redirect()->back()->withErrors(['error' => 'پرداخت انجام نشده است.']);
    //     }
    //     $successfulPayment=0;
    //     if ($successfulPayment) { // فرض بر این است که $successfulPayment یک متغیر است که مشخص می‌کند آیا پرداخت موفق بوده است یا خیر
    //         $payment->update(['status' => 'completed']);
    //     } else {
    //         $payment->update(['status' => 'failed']);
    //     }
        
    //     return view('payment_result', compact('payment'));
    // }
    

}
