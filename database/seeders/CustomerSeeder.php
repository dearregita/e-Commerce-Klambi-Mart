<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Customer', 'email' => 'customer@gmail.com', 'password' => bcrypt('customer'), 'phone' => '081234567891' , 'role' => 'customer', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
