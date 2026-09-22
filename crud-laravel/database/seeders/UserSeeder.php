<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Administrator',
                'role'     => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Kasir / Staff User Account
        User::updateOrCreate(
            ['email' => 'kasir@gmail.com'],
            [
                'name'     => 'Kasir Store',
                'role'     => 'kasir',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name'     => 'Staff Kasir',
                'role'     => 'kasir',
                'password' => Hash::make('password'),
            ]
        );
    }
}
