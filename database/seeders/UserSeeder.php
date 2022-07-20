<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

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
                    'firstname' => $data[10],
                    'lastname' => $data[11],
                    'address' => $data[12],
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
                    $user->firstname = $user_data['firstname'];
                    $user->lastname = $user_data['lastname'];
                    $user->address = $user_data['address'];

                    $user->master = $user_data['role'] === UserRole::DISTRIBUTOR ? 1 :0;

                    $user->save();

                    if ($user_data['role'] === 'super') {
                        $user->assignRole(UserRole::ADMIN);

//                        $tfa = App::make('Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider');
//                        $enable = new EnableTwoFactorAuthentication($tfa);
//                        $enable($user);
                    } elseif ($user_data['role'] === 'whitelabel') {
                        $user->assignRole(UserRole::EMPLOYEE);
                    } else {
                        $user->assignRole(UserRole::DISTRIBUTOR);
                    }
                }
            }
        }
    }
}
