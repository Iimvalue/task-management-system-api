<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'role' => 'Manager',
        ]);

        User::create([
            'name' => 'Employee1',
            'email' => 'employee1@example.com',
            'password' => bcrypt('password'),
            'role' => 'Employee',
        ]);

        User::create([
            'name' => 'Employee2',
            'email' => 'employee2@example.com',
            'password' => bcrypt('password'),
            'role' => 'Employee',
        ]);
    }
}
