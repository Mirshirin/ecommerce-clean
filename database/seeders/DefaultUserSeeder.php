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
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Shirin', 
            'email' => 'mirshirin8353@gmail.com',
            'password' => Hash::make('123456789'),
            'email_verified_at' => now(),
            'remmeber_token' => Str::random(10)
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Omid', 
            'email' => 'omid@gmail.com',
            'password' => Hash::make('123456789'),
            'email_verified_at' => now(),
            'remmeber_token' => Str::random(10)


        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'Aria', 
            'email' => 'aria@codeme.com',
            'password' => Hash::make('123456789'),
            'email_verified_at' => now(),
            'remmeber_token' => Str::random(10)

        ]);
        $productManager->assignRole('Product Manager');

        // Creating Application User
        $user = User::create([
            'name' => 'shohreh', 
            'email' => 'shohreh@codeme.com',
            'password' => Hash::make('123456789'),
            'email_verified_at' => now(),
            'remmeber_token' => Str::random(10)

        ]);
        $user->assignRole('User');
    }
}