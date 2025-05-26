<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MataKuliahSeeder::class,
            KelasJadwalSeeder::class,
            KrsSeeder::class, // Kita akan update ini
            KhsSeeder::class,
        ]);
    }
}
