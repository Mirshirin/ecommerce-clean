<?php

namespace Database\Factories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as Faker;
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {

        return [
            'image' => $this->faker->imageUrl(640,480),
            'title' => $this->faker->name(),
            'description'  => $this->faker->sentence,         
            'price' => $this->faker->numberBetween(1000,2000),
            'discount_price' => $this->faker->numberBetween(1,10),
            'quantity' => $this->faker->numberBetween(1,10),
            'category_id'=> $this->faker->numberBetween(3,6),
         
        ];
    }
}
