<?php

use Illuminate\Database\Seeder;
use App\Models\Product; // Adjust the namespace according to your Product model location

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        App\Models\Product::factory()
            ->count(150) // Specify how many products you want to create
            ->create();
    }
}
