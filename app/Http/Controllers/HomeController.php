<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class HomeController extends Controller
{
   
     public function index() 
     {        
        $products = Product::all();   
        return view('home.index',compact('products'));
     }
     public function allProduct(){
        $products=Product::all();
        return view('home.product.all-products')->with('products',$products);
    }
    public function productDetail($id){
        $product = Product::find($id);
        return view('home.product.single-product',compact('product'));
    }  
    public function homeProducts(Request $request){
        $products = Product::all();
        $perPage = 6;
        $currentPage = LengthAwarePaginator::resolveCurrentPage()?: 1;
        $items = $products->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $products = new LengthAwarePaginator($items, count($products), $perPage);
        $products->setPath(url('/'));        
        return view('home.index',compact('products'));
    }
}  