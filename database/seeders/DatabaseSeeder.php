<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Role::create([
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'user'
        ]);

        User::create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@atlas.com',
            'password' => Hash::make('admin123'),
            'status' => 'active',
            'image' => 'https://cdn-icons-png.flaticon.com/512/9703/9703596.png',
            'role_id' => 1, // Admin role
        ]);
    }
}
