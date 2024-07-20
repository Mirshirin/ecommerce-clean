<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use App\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts(int $perPage = 7)
    {
        return Product::paginate($perPage);
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }

    public function getAllCategories()
    {
        return Category::all();
    }


    public function store(array $data, $imageFile = null)
    {
        $product = new Product($data);      
        if ($imageFile!== null) {        
            $imageName = time().'.'.$imageFile->getClientOriginalExtension();            
            $path='productImage/';
            $imageFile->move($path, $imageName);
            $product->image = $imageName;
        }        
        $product->save();
        return $product;
    }

    public function update($id, array $data, $imageFile =null)
    {
        
        $product = Product::find($id);

        if (!$product) {
            throw new \Exception('Product not found.'); 
        }
        
        if ($imageFile!== null) {
            if ($product->image) {

            $oldImage = $product->image;

            if ($oldImage && File::exists(public_path('productImage/'. $oldImage))) {
                File::delete(public_path('productImage/'. $oldImage));

            }

            $imageName = time(). '.'. $imageFile->getClientOriginalExtension();

            $imageFile->move('productImage/', $imageName);
            $data['image'] = $imageName;
            }
        }

        $product->update($data);
        
        return $product;    
    }


    public function destroy($id)
    {
     
        $product = Product::find($id);
    
        if ($product && File::exists(public_path('productImage/'. $product->image))) {
            File::delete(public_path('productImage/'. $product->image));
        }
        // if ($product) {
        //     $product->delete();
        //     return response()->json(['status' => 'Data deleted successfully.']);
        // } else {
            
        //     return response()->json(['error' => 'Product not found'], 404);
        // }
        return $product;    


    }
}
