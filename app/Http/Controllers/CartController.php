<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
       
    public function showCarts(Request $request ){
        if(Auth::id()){
            $id = Auth::user()->id;
            $cart=$request->session()->has('cart') ? $request->session()->get('cart') : null;
            
            return view('home.cart.show-carts')->with('cartProducts',$cart);
        }
            return redirect()->route('login');   
    }
    public function addToCart($id)
    {             
        $product = Product::findOrFail($id);
        $user = Auth::user();
        $cart = session()->get('cart',[]);
        
        if(Auth::id()){
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [   
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone,
                'address' => $user->address,
                'product_title' => $product->title,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'user_id' => $user->id,
                'product_id' => $product->id,
            ];
        }
       
          session()->put('cart', $cart);
         
        return redirect()->back()->with('success', '');

    }else  {
        return redirect('login');
    }
   
        // $cart_products = collect(request()->session()->get('cart'));
        // $cart_total = 0;
        // foreach ($cart_products as $key => $product) {
            
        //     $cart_total+= $product['quantity'] * $product['discount_price'];
        // }

        // $renderHTML = view('frontend.cart.mini-cart-render',compact('cart_products','cart_total'))->render();
        // $total_products_count = count(request()->session()->get('cart'));
        // return response()->json(['renderHTML'=>$renderHTML,'total_products_count'=>$total_products_count],200);
    }
 
    public function  deleteCarts(Request $request){
        if ($request->id){
            $cart=session()->get('cart');
            if (isset($cart[$request->id])){
                unset($cart[$request->id]);
                session()->put('cart',$cart);
            }
        }
     session()->flash('success','');  
       return redirect()->back();        
    }

  
}