<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        $admin = Role::create(['name' => 'admin']);
        $distributor = Role::create(['name' => 'distributor']);
        $employee = Role::create(['name' => 'employee']);

        if (env('APP_ENV') === 'local') {
            $user = new User([
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
    }
}
