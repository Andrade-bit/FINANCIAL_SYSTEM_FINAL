<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert([
            [
                'firstName'  => 'Admin',
                'middleName' => null,
                'lastName'   => 'User',
                'username'   => 'admin',
                'password'   => Hash::make('admin123'),
                'role'       => 'admin',
                'status'     => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName'  => 'Maria',
                'middleName' => null,
                'lastName'   => 'Santos',
                'username'   => 'msantos',
                'password'   => Hash::make('msantos123'),
                'role'       => 'treasurer',
                'status'     => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName'  => 'Juan',
                'middleName' => null,
                'lastName'   => 'dela Cruz',
                'username'   => 'jdelacruz',
                'password'   => Hash::make('jdelacruz123'),
                'role'       => 'treasurer',
                'status'     => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName'  => 'Ana',
                'middleName' => null,
                'lastName'   => 'Reyes',
                'username'   => 'areyes',
                'password'   => Hash::make('areyes123'),
                'role'       => 'encoder',
                'status'     => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName'  => 'Carlo',
                'middleName' => null,
                'lastName'   => 'Bautista',
                'username'   => 'cbautista',
                'password'   => Hash::make('cbautista123'),
                'role'       => 'encoder',
                'status'     => 'Inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}