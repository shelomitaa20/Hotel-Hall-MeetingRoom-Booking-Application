<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'mita@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Resepsionis',
                'email' => 'intan@gmail.com',
                'password' => Hash::make('resepsionis123'),
                'role' => 'resepsionis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
