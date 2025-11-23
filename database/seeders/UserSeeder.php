<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing user_permission relationships
        DB::table('user_permission')->truncate();

        // Get permissions
        $allPermissions = Permission::all();
        $basicPermissions = Permission::whereIn('slug', [
            'view-dashboard',
        ])->get();
        
        $productPermissions = Permission::whereIn('slug', [
            'view_dashboard',
            'view_products',
            'purchase_products',
        ])->get();
        
        $taskPermissions = Permission::whereIn('slug', [
            'view_dashboard',
            'create_tasks',
            'view_tasks',
            'edit_tasks',
        ])->get();

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Admin doesn't need explicit permissions - has all access via role

        // Create regular users with different permission sets
        $users = [
            [
                'email' => 'user1@example.com',
                'name' => 'John Doe',
                'permissions' => $basicPermissions,
                'description' => 'Basic user with dashboard access only'
            ],
            [
                'email' => 'user2@example.com', 
                'name' => 'Jane Smith',
                'permissions' => $productPermissions,
                'description' => 'Product manager with product permissions'
            ],
            [
                'email' => 'user3@example.com',
                'name' => 'Mike Johnson',
                'permissions' => $taskPermissions,
                'description' => 'Task manager with task permissions'
            ],
            [
                'email' => 'user4@example.com',
                'name' => 'Sarah Wilson',
                'permissions' => Permission::whereIn('slug', [
                    'view_dashboard',
                    'view_products',
                    'upload_files',
                    'view_files',
                ])->get(),
                'description' => 'Content manager with file and product permissions'
            ],
            [
                'email' => 'user5@example.com',
                'name' => 'Tom Brown',
                'permissions' => Permission::whereIn('slug', [
                    'view_dashboard',
                    'view_reports',
                    'create_reports',
                    'export_reports',
                ])->get(),
                'description' => 'Report analyst with reporting permissions'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );

            // Assign specific permissions
            $user->permissions()->sync($userData['permissions']->pluck('id'));
        }

        $this->command->info('Users created successfully!');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('Users: user1@example.com to user5@example.com / password');
        $this->command->info('Each user has different permission sets for testing');
    }
}
