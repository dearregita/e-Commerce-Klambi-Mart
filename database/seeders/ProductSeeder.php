<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'product_sizes_id' => 1,
                'name' => "Men's Shirt",
                'description' => 'Kaos Lengan Pendek',
                'price' => 150000,
                'category_id' => 1,
                'stock_quantity' => 100,
                'discount' => 0,
                'image' => 'mens-shirt.png',
                'slug' => 'mens-shirt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_sizes_id' => 2,
                'name' => "Men's Jeans",
                'description' => 'Celana Jeans Biru',
                'price' => 250000,
                'category_id' => 1,
                'stock_quantity' => 80,
                'discount' => 0,
                'image' => 'mens-jeans.png',
                'slug' => 'mens-jeans',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}