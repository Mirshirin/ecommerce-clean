<?php

namespace Database\Factories;


use App\Models\User;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;  
use Spatie\Permission\Models\Permission;  
use Illuminate\Support\Facades\DB;
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
            'password' =>  bcrypt('password'), // store bcrypt hash of password
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
        ];
        
    }
    public function withRole($roleName)
    {
      
        return $this->afterCreating(function (User $user) use ($roleName) {
            // Create the role and permissions if they do not exist
            $role = Role::firstOrCreate(['name' => $roleName]);
            // Define and create permissions
            $permissions = ['view-product']; 
            foreach ($permissions as $permissionName) {
             
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                //$role->syncPermissions($permissions);
                if ($permission) {
                    DB::table('model_has_permissions')->updateOrInsert(
                        [
                            'model_type' => 'App\Models\User',
                            'model_id' => $user->id,
                            'permission_id' => $permission->id,
                        ],
                        []
                    );
                } else {
                    Log::warning("Permission '{$permissionName}' not found.");
                }
            }
            // Assign the role to the user
            if (!$user->hasRole($role)) {
                DB::table('model_has_roles')->updateOrInsert([
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                    'role_id' => $role->id,
                ]);
                //$user->assignRole($role);

            }
        });
    }
}
