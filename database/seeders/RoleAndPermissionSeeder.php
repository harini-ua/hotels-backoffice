<?php

namespace Database\Seeders;

use App\Enums\UserRole;
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
        $createAdmin = Permission::create(['name' => 'create admin', 'guard_name' => 'web']);
        $editProfile = Permission::create(['name' => 'edit profile', 'guard_name' => 'web']);

        $admin = Role::create(['name' => UserRole::ADMIN, 'guard_name' => 'web']);

        $admin->syncPermissions([
            $createAdmin,
            $editProfile,
        ]);

        $distributor = Role::create(['name' => UserRole::DISTRIBUTOR, 'guard_name' => 'web']);
        $employee = Role::create(['name' => UserRole::EMPLOYEE, 'guard_name' => 'web']);

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

        $booking = Role::create(['name' => UserRole::BOOKING, 'guard_name' => 'api']);
        Permission::create(['guard_name' => 'api', 'name' => 'invoice allowed']);
    }
}
