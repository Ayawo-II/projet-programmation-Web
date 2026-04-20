<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Compte modérateur
        User::create([
            'name'       => 'Admin Mod',
            'email'      => 'kossiayawoabel@gmail.com',
            'password'   => Hash::make('kossiayawo'),
            'role'       => 'moderator',
            'reputation' => 0,
        ]);
    }
}