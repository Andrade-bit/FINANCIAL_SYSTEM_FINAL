<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['username' => 'admin'],
            [
                'firstName' => 'Admin',
                'lastName'  => 'User',
                'password'  => bcrypt('password'),
                'role'      => 'admin',
                'status'    => 'Active',
            ]
        );
    }
}