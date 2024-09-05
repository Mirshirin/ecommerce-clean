<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
   
    public function testAProductHasName(): void
    {
        $product= new Product();
    }
}
