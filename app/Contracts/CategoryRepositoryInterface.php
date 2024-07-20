<?php

namespace App\Contracts;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function findCategoryById($id);
    public function createCategory(array $data);
    public function updateCategory($id, array $data);
    public function destroy($id);
}