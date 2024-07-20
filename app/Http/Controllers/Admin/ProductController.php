<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
        // $this->middleware('permission:view-product|create-product|edit-product|delete-product', ['only' => ['index','show']]);
        // $this->middleware('permission:create-product', ['only' => ['create','store']]);
        // $this->middleware('permission:edit-product', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = $this->productRepository->getAllProducts();
        return view('admin.products.all-products', ['products' => $products]);
    }
    public function show()
    {
        $products = $this->productRepository->getAllProducts();
        return view('admin.products.all-products', ['products' => $products]);
    }
    public function create()
    {
        $categories = $this->productRepository->getAllCategories(); 
        return view('admin.products.create-product', ['categories' => $categories]);
    }
    public function store(UpdateProductRequest $request){
        $validatedData = $request->validated(); 
        $image = $request->file('image');       
        $product = app(ProductRepositoryInterface::class)->store($validatedData, $image);        
        $product->save();
        return redirect()->route('products.index')
        ->with('message', 'Data saved.');
    }
   
    public function edit($id)
    {
        $product = $this->productRepository->getProductById($id);
        $categories = $this->productRepository->getAllCategories(); 
        return view('admin.products.edit-product', ['product' => $product, 'categories' => $categories]);
    }
    
    public function update(UpdateProductRequest $request, $id)
    {
        $validatedData = $request->validated();       
        $image = $request->file('image');
        try {
            $product = app(ProductRepositoryInterface::class)->update($id, $validatedData, $image);
            $categories = $this->productRepository->getAllCategories(); 
            return redirect(route('products.index')) ->with('categories', $categories)
            ->with('message', 'Data updated.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    public function destroy($id)
    {       
        $product= $this->productRepository->destroy($id);
        if ($product) {
            $product->delete();
            return response()->json(['status' => 'Data deleted successfully.']);
        }     
    }
   
   
    

}
