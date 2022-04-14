<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $createAdmin = Permission::create(['name' => 'create admin']);
        $editProfile = Permission::create(['name' => 'edit profile']);

        $admin = Role::create(['name' => 'admin']);

        $admin->syncPermissions([
            $createAdmin,
            $editProfile,
        ]);

        $distributor = Role::create(['name' => 'distributor']);
        $employee = Role::create(['name' => 'employee']);

        if (env('APP_ENV') === 'local') {
            $user = new User([
                'username' => 'admin',
                'title' => 'Administrator',
                'firstname' => 'Firstname',
                'lastname' => 'Lastname',
                'email' => 'admin@example.com',
                'password' => \Hash::make('123321'),
                'company_name' => 'Hotel Express',
                'status' => 1
            ]);

            $user->save();
            $user->assignRole($admin);
        }

        $booking = Role::create(['name' => 'booking']);
    }
}
