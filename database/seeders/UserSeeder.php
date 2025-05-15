<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@overtune.com'],
            [
                'name' => 'Admin Overtune',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'bio' => 'Administrador del sistema.',
            ]
        );

        User::firstOrCreate(
            ['email' => 'editor@overtune.com'],
            [
                'name' => 'Editor Overtune',
                'password' => Hash::make('password'),
                'role' => User::ROLE_EDITOR,
                'bio' => 'Editor de contenido.',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@overtune.com'],
            [
                'name' => 'Usuario Overtune',
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
                'bio' => 'Fanático de la música.',
            ]
        );
    }
}
