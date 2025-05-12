<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Eski seeder'lar yorum satırına alındı
            // UserSeeder::class,
            // CategorySeeder::class,
            // ProductSeeder::class,
            
            // Yeni temiz veri seeder'ı kullanılacak
            CleanDatabaseSeeder::class,
        ]);
    }
}
