<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // You can seed the users table with default data here
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'HwEwI@example.com',
                'password' => 'password123',
            ]
        ]);

        
    }
}
