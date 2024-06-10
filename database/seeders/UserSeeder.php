<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Officer User',
            'email' => 'officer@example.com',
            'password' => bcrypt('password'),
            'role' => 'officer'
        ]);

        \App\Models\User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'role' => 'manager'
        ]);

        \App\Models\User::create([
            'name' => 'Finance User',
            'email' => 'finance@example.com',
            'password' => bcrypt('password'),
            'role' => 'finance'
        ]);
    }

}
