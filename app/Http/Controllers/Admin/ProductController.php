<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Contracts\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;     
        $this->middleware('can:show-products')->only(['allproducts']);
        $this->middleware('can:create-product')->only(['createproduct','storeproduct']); 
        $this->middleware('can:edit-product')->only(['editproduct','updateproduct']);  
        $this->middleware('can:delete-product')->only(['deleteproduct']);
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
        $image = $request->hasFile('image') ? $request->file('image'): null;
        try {
           
            // ذخیره محصول جدید از طریق Repository
            $product = app(ProductRepositoryInterface::class)->store($validatedData, $image);
    
           
            return redirect()->route('products.index')
                ->with('message', 'Data saved successfully.');
        } catch (\Exception $e) {
            // مدیریت خطاها و بازگرداندن پیام خطا
            return back()->withErrors(['error' => 'Failed to save data. ' . $e->getMessage()]);
        }
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
        $image = $request->file('image')->store('photos', 'public');   
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
        try {
            $product = $this->productRepository->destroy($id);
    
            // اگر محصول حذف شد، بازگشت پیام موفقیت
            if ($product) {
                return response()->json(['status' => 'Data deleted successfully.']);
            } else {
                return response()->json(['status' => 'Product not found.'], 404);
            }
        } catch (\Exception $e) {
            // مدیریت خطاها و بازگرداندن پیام خطا
            return response()->json(['status' => 'Error deleting data.', 'error' => $e->getMessage()], 500);
        }   
    }
   
   
    

}
