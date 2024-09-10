<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\EmailService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class PaymentController extends Controller
{
    protected $orderService;
    protected $paymentService;
    protected $cartService;
    protected $emailService;

    public function __construct(OrderService $orderService, PaymentService $paymentService, CartService $cartService, EmailService $emailService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
        $this->cartService = $cartService;
        $this->emailService = $emailService;
    }
    public function checkout(Request $request)
    {
        //dd(method_exists(auth()->user(), 'hasVerifiedEmail')); // Should return true

        $user = Auth::user();
        if ($user && !$user->hasVerifiedEmail()) {
            // اگر ایمیل تأیید نشده باشد، به صفحه تأیید ایمیل هدایت کنید
            return Redirect::route('verification.notice');
        }
        
        $cart=$request->session()->has('cart') ? $request->session()->get('cart') : null;   
        
        if (empty($cart)) {
         
            return response()->json([
                 'status' => false,
                 'message'=> 'سبد خرید شما خالی است. لطفاً محصولاتی را به سبد اضافه کنید.',
            ]);
        }         
     
        if(!Auth::check() )
        {
            return response()->json([
                'status' => false,
                'redirect' => route('ligin'),
                'message' => 'لطفا برای ادامه وارد حساب کاربری خود شوید ',
            ]);
        }
        return view('home.cart.checkout',['user' => $user]);
    }
    public function processCheckout(Request $request)
    {
        $cart = $this->cartService->getCart($request);

        // Step 1: Validate the input
        $validator = $this->validateCheckout($request);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the errors',
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }     
        $userId = Auth::id();
        // Handle COD payment
            if ($request->payment_method == 'cod') {
                $orderResults = $this->orderService->createOrdersFromCart($cart, $userId);
                $totalAmount = $orderResults['totalAmount'];
                $lastOrder = $orderResults['lastOrder'];
                $allOrders = $orderResults['orderResults']; // Full list of orders

                $paymentData = [
                    'user_id' => $userId,
                    'order_id' => $lastOrder->id,
                    'amount_paid' => $totalAmount,
                    'payment_date' => now(),
                ];

                $this->paymentService->createPayment($paymentData);

            // Step 3: Send confirmation email
            //$this->emailService->sendOrderConfirmation($order);
            //$orderResults 
            $this->emailService->sendOrderConfirmation( $orderResults  );
           
            session()->flash('success', '');
            session()->forget('code');
            session()->put('cart', []);       

            return response()->json([
                'message' => 'Order Saved Successfully.',
                'orderId' => $lastOrder->id,
                'status' => true,
            ]);

            }
        return response()->json([
                    'message' => 'Invalid payment method',
                    'status' => false,
                ]);
    }

    private function validateCheckout(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'address' => 'required|min:10',
            'phone' => 'required',
        ]);
    }
    public function thankyou($id)
    {
        return view('admin.orders.thankyou',[
            'id' => $id,
        ]);
    }

   

}
