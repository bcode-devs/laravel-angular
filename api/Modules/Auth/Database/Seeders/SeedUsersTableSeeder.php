<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Shared\Entities\User\User;

class SeedUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        User::create(
            [
                'name' => 'Bcode',
                'last_name' => 'Bcode',
                'email' => 'dev.bcode@gmail.com',
                'phone' => '',
                'phone_verified' => '',
                'password' => bcrypt('dev.bcode@gmail.com'), // secret
                'remember_token' => str_random(10),
                'verify_token' => '',
                'phone_verify_token' => '0',
                'phone_verify_token_expire' => null,
                'role' => User::ROLE_USER,
                'status' => User::STATUS_ACTIVE,
            ]
        );
    }
}
