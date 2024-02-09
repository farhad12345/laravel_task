<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);

        // // Create permissions
        // $createPostsPermission = Permission::create(['name' => 'create comapany']);
        // $editPostsPermission = Permission::create(['name' => 'edit comapany']);
        // $viewPostsPermission = Permission::create(['name' => 'view comapany']);

        // // Assign permissions to roles
        // $adminRole->givePermissionTo([$createPostsPermission, $editPostsPermission]);
        // $editorRole->givePermissionTo($editPostsPermission);
    }
}
