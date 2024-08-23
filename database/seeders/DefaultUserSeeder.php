<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    //password=$2y$10$sEVQw4EaG29wfNGB8lXxDuQse/LIQsv3GbQZZfSa9cAjJb7zPCBem ==123456789
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Shirin', 
            'email' => 'mirshirin8353@gmail.com',
            'phone' => '09127196483',
            'address' => 'Tehran , Azadi,Seconed Bimeh, forth allay, NO4',
            'password' => '$2y$10$sEVQw4EaG29wfNGB8lXxDuQse/LIQsv3GbQZZfSa9cAjJb7zPCBem',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Omid', 
            'email' => 'o.arvand8@gmail.com',
            'phone' => '09127196483',
            'address' => 'Tehran , Azadi,Seconed Bimeh, forth allay, NO4',
            'password' => '$2y$10$sEVQw4EaG29wfNGB8lXxDuQse/LIQsv3GbQZZfSa9cAjJb7zPCBem',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)


        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'Aria', 
            'email' => 'mirshirin83@gmail.com',
            'phone' => '09127196483',
            'address' => 'Tehran , Azadi,Seconed Bimeh, forth allay, NO4',
            'password' => '$2y$10$sEVQw4EaG29wfNGB8lXxDuQse/LIQsv3GbQZZfSa9cAjJb7zPCBem',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)

        ]);
        $productManager->assignRole('Product Manager');

        // Creating Application User
        $user = User::create([
            'name' => 'shohreh', 
            'email' => 'shohreh@codeme.com',
            'phone' => '09127196483',
            'address' => 'Tehran , Azadi,Seconed Bimeh, forth allay, NO4',
            'password' => '$2y$10$sEVQw4EaG29wfNGB8lXxDuQse/LIQsv3GbQZZfSa9cAjJb7zPCBem',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)

        ]);
        $user->assignRole('User');
    }
}