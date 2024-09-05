<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function showCarts(Request $request ){
        if(Auth::id()){
         
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
                'code'  => $product->discount_price,
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