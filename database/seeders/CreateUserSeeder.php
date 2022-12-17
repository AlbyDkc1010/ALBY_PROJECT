<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;

use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' =>'isUser',
                'email' =>'user@email.com',
                'password'=> bcrypt('12345'),
                'roles_id' =>2,
            ],
            [
                'name' =>'isAdmin',
                'email' =>'Admin@mail.com',
                'password' =>bcrypt('12345'),
                'roles_id' =>'1',

            ]
            ];
            foreach ($user as $key => $value){
                user::create($value);
            }
    }
}
