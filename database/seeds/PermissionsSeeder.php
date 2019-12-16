<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'create-pharmacist',
            'delete-pharmacist',
            'edit-pharmacist',
            'create-medicine',
            'delete-medicine',
            'edit-medicine',
            'edit-store',
         ];
 
         
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
              
         }
         $adminRole = Role::find(1);
         $adminRole->permissions()->sync(Permission::all());
    }
}
