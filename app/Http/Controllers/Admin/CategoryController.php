<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Contracts\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->middleware('can:show-categories')->only(['allCategories']);
        $this->middleware('can:create-category')->only(['createCategory','storeCategory']); 
        $this->middleware('can:edit-category')->only(['editCategory','updateCategory']);  
        $this->middleware('can:delete-category')->only(['deleteCategory']);
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAllCategories();
        return view('admin.categories.all-categories', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.categories.create-category');
    }
    
    public function store(StoreCategoryRequest $request)
    {
        try {
            $validatedData = $request->validated();  
            $category = app(CategoryRepositoryInterface::class)->createCategory($validatedData);
            return redirect()->route('categories.index', $category)->with('message', 'Category was created');
        } catch (\Exception $e) {
            // Log the exception
            Log::error("Failed to create category: {$e->getMessage()}");
    
            // Return a response with an error message
            return back()->withErrors(['message' => 'There was an error creating the category. Please try again.'])->withInput();
        }
    }
    

    public function edit($id)
    {
        $category = $this->categoryRepository->findCategoryById($id);
        return view('admin.categories.edit-category')->with('category', $category);
    }

    public function update(UpdateCategoryRequest $request, $id)
    { 
        try {
            $validatedData = $request->validated();  
            $category = app(CategoryRepositoryInterface::class)->updateCategory($id, $validatedData);
            return redirect()->route('categories.index', $category)->with('message', 'Category was updated');
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error("Failed to update category: {$e->getMessage()}");
            
            // Return a response with an error message
            return back()->withErrors(['message' => 'There was an error updating the category. Please try again.'])->withInput();
        }
    }
    

    public function destroy($id)
    {    
        try {
            $response = $this->categoryRepository->destroy($id);
            $response->delete();
            return response()->json([ 'status' => 'category deleted successfully' ], 200);
        } catch (\Exception $e) {
            // Log the exception
            //jLog::error("Failed to delete category: {$e->getMessage()}");
    
            // Return a response with an error message
            return response()->json(['error' => 'There was an error deleting the category.'], 500);
        }
    }
    
}
