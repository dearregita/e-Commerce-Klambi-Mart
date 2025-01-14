<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'address' => 'Jalan Semarang, Jakarta, DKI Jakarta, 10110',
            'email' => 'contact@klambi.com',
            'country_code' => '+62',
            'phone_number' => '81234567890',
        ]);        
    }
}
