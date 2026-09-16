<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PurchaseSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
