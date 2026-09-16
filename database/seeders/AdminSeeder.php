<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@megaofertas.com'],
            [
                'name' => 'Administrador',
                'password' => 'admin1234', // hashed por el cast "hashed"
                'is_super' => true,
            ]
        );
    }
}
