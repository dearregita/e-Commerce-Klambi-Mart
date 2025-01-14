<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_sizes')->insert([
            ['size' => 'XS, S, M, L, XL, XXL', 'created_at' => now(), 'updated_at' => now()],
            ['size' => 'XS, S, XL, XXL', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
