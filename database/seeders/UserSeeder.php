<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =  [
            [
                'name' => "Admin",
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456789'),
            ],
            [
                'name' => "User1",
                'email' => 'user1@gmail.com',
                'password' => Hash::make('123456789'),
            ],
            [
                'name' => "User2",
                'email' => 'user2@gmail.com',
                'password' => Hash::make('123456789'),
            ],
          ];

          User::insert($users);
    }
}
