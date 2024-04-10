<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::create([
            'first_name' => 'Admin',
            'email' => 'admin@localhost.local',
            'password' => 'admin',
            'address' => 'Sylhet, Bangladesh',
            'phone' => '01797216574',
            'dob' => '2000-01-01',
            'role' => 1
        ]);

        // create 95 users
        User::factory(95)->create();
    }
}
