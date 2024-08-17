<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;


class HomeController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;     
    }

    public function productDetail($id){
        $product = $this->productRepository->getProductById($id);
        return view('home.product.single-product',compact('product'));
    }  
    public function homeProducts(Request $request){
        $products = $this->productRepository->getAllProducts();         
        return view('home.index',compact('products'));
    }
}  