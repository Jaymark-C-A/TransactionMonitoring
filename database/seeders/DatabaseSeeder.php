<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * List of permissions to add.
     */
    private $permissions = [
    ];

    /**
     * List of roles to add.
     */
    private $roles = [
        'Super-admin',
        'Admin',
        'Accounting',
        'Guidance',
        'Clinic',
        'Records',
        'Guard',
        'Principal'
    ];

    /**
     * List of users to create for each role.
     */
    private $users = [
        'Super-admin' => [
            'employee_no' => 'CCBC012123124',
            'name' => 'Administrator',
            'email' => 'superadmin@gmail.com',
            'password' => 'superadmin'
        ],
        'Admin' => [
            'employee_no' => 'TMS#1',
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => 'admin123'
        ],
        'Accounting' => [
            'employee_no' => 'TMS#2',
            'name' => 'Accounting User',
            'email' => 'accounting@gmail.com',
            'password' => 'accounting123'
        ],
        'Guidance' => [
            'employee_no' => 'TMS#',
            'name' => 'Guidance User',
            'email' => 'guidance@gmail.com',
            'password' => 'guidance123'
        ],
        'Clinic' => [
            'employee_no' => 'TMS#3',
            'name' => 'Clinic User',
            'email' => 'clinic@gmail.com',
            'password' => 'clinic123'
        ],
        'Records' => [
            'employee_no' => 'TMS#4',
            'name' => 'Records / Emis User',
            'email' => 'emis@gmail.com',
            'password' => 'record123'
        ],
        'Guard' => [
            'employee_no' => 'TMS#5',
            'name' => 'Visitor User',
            'email' => 'visitor@gmail.com',
            'password' => 'visitor123'
        ],
        'Principal' => [
            'employee_no' => 'TMS#06',
            'name' => 'Principal User',
            'email' => 'principal@gmail.com',
            'password' => 'principal123'
        ]
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create permissions
        foreach ($this->permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        // Create roles
        foreach ($this->roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Assign all permissions to the Super-admin role only
            if ($roleName === 'Super-admin') {
                $permissions = Permission::pluck('id', 'id')->all();
                $role->syncPermissions($permissions);
            }
        }
        // Create users and assign roles
        foreach ($this->users as $roleName => $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'employee_no' => $userData['employee_no'],
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                ]
            );
            $role = Role::where('name', $roleName)->first();
            $user->assignRole($role);
        }
    }
}
