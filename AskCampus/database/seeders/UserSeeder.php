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
            'email'      => 'mod@askcampus.fr',
            'password'   => Hash::make('password'),
            'role'       => 'moderator',
            'reputation' => 999,
        ]);

        // Étudiants
        $students = [
            ['name' => 'Alice Martin',   'email' => 'alice@etud.fr',   'reputation' => 120],
            ['name' => 'Bob Dupont',     'email' => 'bob@etud.fr',     'reputation' => 45],
            ['name' => 'Clara Fontaine', 'email' => 'clara@etud.fr',   'reputation' => 230],
            ['name' => 'David Leroy',    'email' => 'david@etud.fr',   'reputation' => 15],
            ['name' => 'Emma Petit',     'email' => 'emma@etud.fr',    'reputation' => 80],
        ];

        foreach ($students as $student) {
            User::create([
                'name'       => $student['name'],
                'email'      => $student['email'],
                'password'   => Hash::make('password'),
                'role'       => 'student',
                'reputation' => $student['reputation'],
            ]);
        }
    }
}