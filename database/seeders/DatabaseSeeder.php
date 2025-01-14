<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            SizeSeeder::class,
            ProductSeeder::class,
            
            SettingSeeder::class,
            FAQSeeder::class,
            AboutSeeder::class,
            ContactSeeder::class,
            PolicySeeder::class,
        ]);
    }
}
