<?php

namespace Database\Seeders;

use ProductSeeder;
use App\Models\User;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\CategorySeeder as SeedersCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
     
      $this->call([
        CategorySeeder::class,
        RoleSeeder::class,
      ]);  
      User::factory()->withRole('User')->count(900)->create(); 
      Product::factory()->count(125)->create();    
    }
}
