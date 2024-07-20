<?php

namespace App\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function getAllProducts(int $perPage = 7);
    public function getProductById($id);
    public function getAllCategories();
    public function store(array $data, $imageFile = null);
    public function update($id, array $data , $imageFile = null);
    public function destroy($id);
}
