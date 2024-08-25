<?php

namespace Database\Seeders;

use ProductSeeder;
use App\Models\User;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\Product::factory(10)->create();
      User::factory()->count(900)->create();
    //    Product::factory()->count(125)->create();
    //     // \App\Models\User::factory()->create([
    //     //     'name' => 'Test User',
    //     //     'email' => 'test@example.com',
    //     // ]);
    // DB::table('users')->insert([

    //     ]);

    //      $this->call([
    //              DatabaseSeeder::class,

    //           DefaultUserSeeder::class,
    //  ]);
       
    }
}
