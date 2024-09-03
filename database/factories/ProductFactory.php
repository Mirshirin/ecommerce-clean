<?php

namespace Database\Factories;
use App\Models\Product;
use App\Models\Category;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $categoryIds = Category::pluck('id')->toArray(); // دریافت همه شناسه‌های موجود در جدول categories
        $categoryId = $this->faker->randomElement($categoryIds); // انتخاب یک شناسه تصادفی

        return [
            'image' => $this->faker->imageUrl(640,480),
            'title' => $this->faker->name(),
            'description'  => $this->faker->sentence,         
            'price' => $this->faker->numberBetween(1000,2000),
            'discount_price' => $this->faker->numberBetween(1,10),
            'quantity' => $this->faker->numberBetween(1,10),
            'category_id' => $categoryId,
         
        ];
    }
}
