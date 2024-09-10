<?php 
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(Request $request)
    {
        return $request->session()->has('cart') ? $request->session()->get('cart') : [];
    }
    public function clearCart()
    {

        session()->flash('success','');
        Session()->forget('code');
        return Session::put('cart', []);

        
    }

   
}