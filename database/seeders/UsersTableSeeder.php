<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => Hash::make('password'),
                'remember_token' => null,
                'previous_names' => json_encode([])
            ],
            [
                'id'             => 2,
                'name'           => 'User',
                'email'          => 'user@user.com',
                'password'       => Hash::make('password'),
                'remember_token' => null,
                'previous_names' => json_encode([])
            ],
            [
                'id'             => 3,
                'name'           => 'Reporter',
                'email'          => 'reporter@reporter.com',
                'password'       => Hash::make('password'),
                'remember_token' => null,
                'previous_names' => json_encode([])
            ],
        ];

        User::insert($users);
    }
}
