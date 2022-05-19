<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];


        if (($open = fopen(storage_path('app/seed') . "/users.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $users[] = [
                    'id' => (int)$data[0],
                    'username' => $data[1],
                    'password' => $data[3],
                    'email' => $data[7],
                    'role' => $data[8],
                ];
            }

            fclose($open);
        }

        if(!empty($users)) {
            foreach (array_chunk($users, 1000) as $users_data) {
                foreach ($users_data as $user_data) {
                    $user = new User();
                    $user->id = (int)$user_data['id'];
                    $user->username = $user_data['username'];
                    $user->password = $user_data['password'];
                    $user->email = $user_data['email'];

                    $user->save();
                    $user->assignRole($user_data['role'] == 'super' ? UserRole::ADMIN :
                        ($user_data['role'] == 'whitelabel' ? UserRole::EMPLOYEE : UserRole::DISTRIBUTOR));
                }
            }
        }

    }
}
