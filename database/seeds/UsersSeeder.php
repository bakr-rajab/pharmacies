<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                // 'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('20150012'),
            ],
            [
                'name' => 'Abobakr',
                'email' => 'abobakr@gmail.com',
                'password' => bcrypt('20150012'),
            ],
        ];

        foreach ($users as $key => $value) {
            User::create($value);
        }
        $admin = User::find(1);
        $user = User::find(2);
        $userRole = Role::find(2);
        $adminRole = Role::find(1);

        $admin->assignRole($adminRole);
        $user->assignRole($userRole);

    }
}
