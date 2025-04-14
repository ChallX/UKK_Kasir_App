<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email'=> 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('1234'),
        ]);

        User::create([
            'name' => 'petugas',
            'email'=> 'petugas@gmail.com',
            'role' => 'petugas',
            'password' => Hash::make('1234'),
        ]);
    }
}
