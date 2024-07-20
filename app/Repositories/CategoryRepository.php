<?php

namespace App\Repositories;

use App\Models\Category;
use App\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        return Category::query()
            ->orderBy('created_at', 'asc')
            ->paginate();
    }
    public function findCategoryById($id)
    {
        return Category::find($id);
    }
    public function createCategory(array $data)
    {
        return Category::create($data);
    }
    public function updateCategory($id, array $data)
    {
        $category = $this->findCategoryById($id);
        $category->update($data);
        return $category;
    }

    public function destroy($id)
    {

        $category = $this->findCategoryById($id);
        $category->delete();
        return $category; 
    }
}
