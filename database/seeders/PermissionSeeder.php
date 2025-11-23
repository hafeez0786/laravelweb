<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Management Permissions
        $userPermissions = [
            ['name' => 'View Users', 'slug' => 'view-users', 'category' => 'User Management', 'description' => 'Can view list of users'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'category' => 'User Management', 'description' => 'Can create new users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'category' => 'User Management', 'description' => 'Can edit existing users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'category' => 'User Management', 'description' => 'Can delete users'],
        ];

        // Permission Management Permissions
        $permissionPermissions = [
            ['name' => 'View Permissions', 'slug' => 'view-permissions', 'category' => 'Permission Management', 'description' => 'Can view list of permissions'],
            ['name' => 'Create Permissions', 'slug' => 'create-permissions', 'category' => 'Permission Management', 'description' => 'Can create new permissions'],
            ['name' => 'Edit Permissions', 'slug' => 'edit-permissions', 'category' => 'Permission Management', 'description' => 'Can edit existing permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'delete-permissions', 'category' => 'Permission Management', 'description' => 'Can delete permissions'],
        ];

        // Dashboard Permissions
        $dashboardPermissions = [
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard', 'category' => 'Dashboard', 'description' => 'Can view the dashboard'],
        ];

        // Product Permissions
        $productPermissions = [
            ['name' => 'View Products', 'slug' => 'view_products', 'category' => 'Products', 'description' => 'Can view products list and details'],
            ['name' => 'Create Products', 'slug' => 'create_products', 'category' => 'Products', 'description' => 'Can create new products'],
            ['name' => 'Edit Products', 'slug' => 'edit_products', 'category' => 'Products', 'description' => 'Can edit existing products'],
            ['name' => 'Delete Products', 'slug' => 'delete_products', 'category' => 'Products', 'description' => 'Can delete products'],
            ['name' => 'Purchase Products', 'slug' => 'purchase_products', 'category' => 'Products', 'description' => 'Can purchase products'],
        ];

        // Role Management Permissions
        $rolePermissions = [
            ['name' => 'View Roles', 'slug' => 'view-roles', 'category' => 'Role Management', 'description' => 'Can view roles and users by role'],
            ['name' => 'Edit Roles', 'slug' => 'edit-roles', 'category' => 'Role Management', 'description' => 'Can edit user roles'],
        ];

        // Task Management Permissions
        $taskPermissions = [
            ['name' => 'Create Tasks', 'slug' => 'create_tasks', 'category' => 'Tasks', 'description' => 'Can create new tasks'],
            ['name' => 'View Tasks', 'slug' => 'view_tasks', 'category' => 'Tasks', 'description' => 'Can view tasks'],
            ['name' => 'Edit Tasks', 'slug' => 'edit_tasks', 'category' => 'Tasks', 'description' => 'Can edit tasks'],
            ['name' => 'Delete Tasks', 'slug' => 'delete_tasks', 'category' => 'Tasks', 'description' => 'Can delete tasks'],
        ];

        // File Management Permissions
        $filePermissions = [
            ['name' => 'Upload Files', 'slug' => 'upload_files', 'category' => 'Files', 'description' => 'Can upload files'],
            ['name' => 'View Files', 'slug' => 'view_files', 'category' => 'Files', 'description' => 'Can view files'],
            ['name' => 'Delete Files', 'slug' => 'delete_files', 'category' => 'Files', 'description' => 'Can delete files'],
        ];

        // Report Permissions
        $reportPermissions = [
            ['name' => 'View Reports', 'slug' => 'view_reports', 'category' => 'Reports', 'description' => 'Can view reports'],
            ['name' => 'Create Reports', 'slug' => 'create_reports', 'category' => 'Reports', 'description' => 'Can create reports'],
            ['name' => 'Export Reports', 'slug' => 'export_reports', 'category' => 'Reports', 'description' => 'Can export reports'],
        ];

        // Combine all permissions
        $permissions = array_merge(
            $userPermissions, 
            $permissionPermissions, 
            $dashboardPermissions,
            $productPermissions,
            $rolePermissions,
            $taskPermissions,
            $filePermissions,
            $reportPermissions
        );

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        $this->command->info('Permissions seeded successfully!');
    }
}
