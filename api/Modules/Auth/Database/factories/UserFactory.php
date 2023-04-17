<?php

namespace Modules\Auth\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Shared\Entities\User\User;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
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
        ];
    }
}
