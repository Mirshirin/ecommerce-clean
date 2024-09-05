<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;  // Correct model from Spatie
use Spatie\Permission\Models\Permission;  // Correct Permission model if needed
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Super Admin', 'Admin', 'Product Manager', 'User'];

        // ایجاد یا دریافت نقش‌ها
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
        $this->call([
            PermissionSeeder::class,
        ]);

        $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminUser = User::firstOrCreate([
            'email' => 'mirshirin8353@gmail.com'
        ], [
            'name' => 'Shirin',
            'phone' => '09127196483',
            'address' => 'Tehran , Azadi,Seconed Bimeh, forth allay, NO4',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => \Illuminate\Support\Str::random(10)
        ]);
        $permissions = [
            'create-user',
            'edit-user',
            'delete-user',
            'create-product',
            'edit-product',
            'delete-product',
            'view-product'
        ];
        // Use the helper function to assign role and permissions
        $this->assignRoleAndPermissions($superAdminUser, $superAdminRole, $permissions); 
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        $permissions = [
            'create-user',
            'edit-user',
            'delete-user',
            'create-product',
            'edit-product',
            'delete-product'
        ];
        $adminUser =User::firstOrCreate([
            'email' => 'o.arvand8@gmail.com'
        ], [
            'name' => 'Omid', 
            'phone' => '09127196483',
            'address' => 'Tehran , Azadi,Seconed Bimeh, forth allay, NO4',
            'password' => bcrypt('password'), // Use bcrypt for password hashing
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        $this->assignRoleAndPermissions( $adminUser, $adminRole , $permissions); 
        $productManagerRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Product Manager']);
            $permissions = [           
                'create-product',
                'edit-product',
                'delete-product'
            ];
        $productManagerUser =User::firstOrCreate([
            'email' => 'mirshirin83@gmail.com'
        ], [
            'name' => 'Aria', 
            'phone' => '09127196483',
            'address' => 'Tehran , Azadi,Seconed Bimeh, forth allay, NO4',
            'password' => bcrypt('password'), // Use bcrypt for password hashing
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        $this->assignRoleAndPermissions(  $productManagerUser,   $productManagerRole , $permissions); 
        $userRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'User']);
        $permissions = [   'view-product' ];
        $userUser =User::firstOrCreate([
                'email' => 'mirshekari@processingworld.com'
            ], [
                'name' => 'shohreh', 
                'phone' => '09127196483',
                'address' => 'Tehran , Azadi,Seconed Bimeh, forth allay, NO4',
                'password' => bcrypt('password'), // Use bcrypt for password hashing
                'email_verified_at' => now(),
                'remember_token' => Str::random(10)
            ]); 
            $this->assignRoleAndPermissions( $userUser, $userRole , $permissions); 

    }     
   
    
    /**
     * Assign a role and permissions to a user.
     *
     * @param User $user
     * @param Role $role
     * @param array $permissions
     */
    protected function assignRoleAndPermissions(User $user, Role $role, array $permissions): void
    {
        // Create or update permissions and assign to the role
        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            if ($permission) {
                // Ensure the permission is assigned to the user
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

        // Assign the role to the user if not already assigned
        if (!$user->hasRole($role)) {
            DB::table('model_has_roles')->updateOrInsert([
                'model_type' => 'App\Models\User',
                'model_id' => $user->id,
                'role_id' => $role->id,
            ]);
        }
    }

}