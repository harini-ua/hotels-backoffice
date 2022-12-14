<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
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
        $createAdmin = Permission::create(['name' => \App\Enums\Permission::CTREATE_ADMIN, 'guard_name' => 'web']);
        $editProfile = Permission::create(['name' => \App\Enums\Permission::EDIT_PROFILE, 'guard_name' => 'web']);
        $editHotel = Permission::create(['name' => \App\Enums\Permission::EDIT_HOTEL, 'guard_name' => 'web']);

        $admin = Role::create(['name' => UserRole::ADMIN, 'guard_name' => 'web']);

        $admin->syncPermissions([
            $createAdmin,
            $editProfile,
            $editHotel
        ]);

        $distributor = Role::create(['name' => UserRole::DISTRIBUTOR, 'guard_name' => 'web']);
        $employee = Role::create(['name' => UserRole::EMPLOYEE, 'guard_name' => 'web']);

        if (App::environment(['local', 'staging'])) {
            $user = new User([
                'username' => 'admin',
                'title' => 'Administrator',
                'firstname' => 'Firstname',
                'lastname' => 'Lastname',
                'email' => 'admin@example.com',
                'password' => \Hash::make('123321'),
                'company_name' => 'Hotel',
                'status' => 1
            ]);

            $user->save();
            $user->assignRole($admin);
        }

        $booking = Role::create(['name' => UserRole::BOOKING, 'guard_name' => 'api']);
        $invoiceAllowed = Permission::create(['name' => \App\Enums\Permission::INVOICE_ALLOWED, 'guard_name' => 'api']);
    }
}
