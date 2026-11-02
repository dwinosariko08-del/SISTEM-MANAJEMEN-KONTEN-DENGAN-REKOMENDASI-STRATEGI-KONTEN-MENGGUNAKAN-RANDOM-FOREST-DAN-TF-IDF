<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // LEADER
        User::create([
            'name' => 'Leader Tim',
            'email' => 'leader@test.com',
            'password' => Hash::make('password'),
            'role' => 'leader',
        ]);

        // EDITOR
        User::create([
            'name' => 'Editor Tim',
            'email' => 'editor@test.com',
            'password' => Hash::make('password'),
            'role' => 'editor',
        ]);

        // LAPANGAN
        User::create([
            'name' => 'Tim Lapangan',
            'email' => 'lapangan@test.com',
            'password' => Hash::make('password'),
            'role' => 'lapangan',
        ]);
    }
}
