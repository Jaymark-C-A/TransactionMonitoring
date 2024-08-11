<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    /**
     * List of applications to add.
     */
    private $permissions = [
        'create role',
        'view role',
        'update role',
        'delete role',
        'create permission',
        'view permission',
        'update permission',
        'delete permission',
        'create user',
        'view user',
        'update user',
        'delete user'
      
    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create admin User and assign the role to him.
        $user = User::create([
            'employee_no' => 'CCBC012123124',
            'name' => 'Super-admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin')
        ]);

        $role = Role::create(['name' => 'Super-admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}