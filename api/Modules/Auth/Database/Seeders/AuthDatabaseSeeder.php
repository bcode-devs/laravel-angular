<?php

namespace Modules\Auth\Database\Seeders;

use Modules\Shared\Entities\User\User;
use Illuminate\Database\Seeder;

class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \Modules\Shared\Entities\User\User::create(
            [
                'name' => 'Bcode',
                'email' => 'dev.bcode@gmail.com',
                'phone_verified' => '',
                'password' => bcrypt('dev.bcode@gmail.com'), // secret
                'remember_token' => str_random(10),
                'verify_token' => '',
                'phone_verify_token' => '0',
                'phone_verify_token_expire' => null,
                'role' => \Modules\Shared\Entities\User\User::ROLE_USER,
                'status' => \Modules\Shared\Entities\User\User::STATUS_ACTIVE,
            ]
        );

        // Model::unguard();
        // $this->call("OthersTableSeeder");
    }
}
