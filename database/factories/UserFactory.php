<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;
//$2y$10$sEVQw4EaG29wfNGB8lXxDuQse/LIQsv3GbQZZfSa9cAjJb7zPCBem
//'password' => bcrypt($this->faker->password()), // store bcrypt hash of password

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),

            'password' => '$2y$10$sEVQw4EaG29wfNGB8lXxDuQse/LIQsv3GbQZZfSa9cAjJb7zPCBem', // store bcrypt hash of password
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
        ];
        $user->assignRole('User');

    }
}
