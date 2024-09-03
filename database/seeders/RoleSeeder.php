<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
        
        $permissions = [
            'create-user',
            'edit-user',
            'delete-user',
            'create-product',
            'edit-product',
            'delete-product',
            'view-product'
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

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

        $superAdminUser->assignRole($superAdminRole );
        $hasRoleRecord = DB::table('model_has_roles')
        ->where('model_id', 1)
        ->where('role_id', 1)
        ->exists();

    if (!$hasRoleRecord) {
        DB::table('model_has_roles')->insert([
            'model_type' => 'App\Models\User',
            'model_id' => 1,
            'role_id' => 1,
        ]);
    }
    $superAdminRole->syncPermissions($permissions);

    // بررسی وجود رکورد در جدول model_has_permissions
    foreach ($permissions as $permission) {
        $hasPermissionRecord = DB::table('model_has_permissions')
            ->where('model_type', 'App\Models\User')
            ->where('model_id', 1)
            ->where('permission_id', Permission::findByName($permission)->id)
            ->exists();

        if (!$hasPermissionRecord) {
            DB::table('model_has_permissions')->insert([
                'model_type' => 'App\Models\User',
                'model_id' => 1,
                'permission_id' => Permission::findByName($permission)->id,
            ]);
        }
    }
    $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);

    $permissions = [
        'create-user',
        'edit-user',
        'delete-user',
        'create-product',
        'edit-product',
        'delete-product'
    ];
     foreach ($permissions as $permission) {
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
    }

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
            $adminUser->assignRole( $adminRole);
            $hasRoleRecord = DB::table('model_has_roles')
            ->where('model_id', 2)
            ->where('role_id', 2)
            ->exists();

        if (!$hasRoleRecord) {
            DB::table('model_has_roles')->insert([
                'model_type' => 'App\Models\User',
                'model_id' => 2,
                'role_id' => 2,
            ]);
        }
        $adminRole->syncPermissions($permissions);


        foreach ($permissions as $permission) {
            $hasPermissionRecord = DB::table('model_has_permissions')
                ->where('model_type', 'App\Models\User')
                ->where('model_id', 2)
                ->where('permission_id', Permission::findByName($permission)->id)
                ->exists();

            if (!$hasPermissionRecord) {
                DB::table('model_has_permissions')->insert([
                    'model_type' => 'App\Models\User',
                    'model_id' => 2,
                    'permission_id' => Permission::findByName($permission)->id,
                ]);
            }
        }

        $productManagerRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Product Manager']);

        $permissions = [           
            'create-product',
            'edit-product',
            'delete-product'
        ];
         foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

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
            $productManagerUser->assignRole( $adminRole);
                $hasRoleRecord = DB::table('model_has_roles')
                ->where('model_id', 3)
                ->where('role_id', 3)
                ->exists();

            if (!$hasRoleRecord) {
                DB::table('model_has_roles')->insert([
                    'model_type' => 'App\Models\User',
                    'model_id' => 3,
                    'role_id' => 3,
                ]);
            }
        $productManagerRole->syncPermissions($permissions);

            foreach ($permissions as $permission) {
                $hasPermissionRecord = DB::table('model_has_permissions')
                    ->where('model_type', 'App\Models\User')
                    ->where('model_id', 3)
                    ->where('permission_id', Permission::findByName($permission)->id)
                    ->exists();

                if (!$hasPermissionRecord) {
                    DB::table('model_has_permissions')->insert([
                        'model_type' => 'App\Models\User',
                        'model_id' => 3,
                        'permission_id' => Permission::findByName($permission)->id,
                    ]);
                }
            }
            $userRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'User']);

            $permissions = [           
                 'view-product'
    
            ];
             foreach ($permissions as $permission) {
                \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
            }
    
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
            $userUser->assignRole(  $userRole);
                $hasRoleRecord = DB::table('model_has_roles')
                ->where('model_id', 4)
                ->where('role_id', 4)
                ->exists();
        
            if (!$hasRoleRecord) {
                DB::table('model_has_roles')->insert([
                    'model_type' => 'App\Models\User',
                    'model_id' => 4,
                    'role_id' => 4,
                ]);
            }
        $userRole->syncPermissions($permissions);
        
        
        foreach ($permissions as $permission) {
            $hasPermissionRecord = DB::table('model_has_permissions')
                ->where('model_type', 'App\Models\User')
                ->where('model_id', 4)
                ->where('permission_id', Permission::findByName($permission)->id)
                ->exists();
    
            if (!$hasPermissionRecord) {
                DB::table('model_has_permissions')->insert([
                    'model_type' => 'App\Models\User',
                    'model_id' => 4,
                    'permission_id' => Permission::findByName($permission)->id,
                ]);
            }
        }
    
        
    }
}