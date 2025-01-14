<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'name' => 'title',
            'value' => 'Frequently asked questions',
            'category' => 'faq'
        ]);

        Setting::create([
            'name' => 'title',
            'value' => 'Tentang Kami',
            'category' => 'about'
        ]);

        Setting::create([
            'name' => 'description',
            'value' => 'Kami adalah organisasi yang berdedikasi memberikan nilai terbaik. Dengan fokus pada kualitas, inovasi, dan kepuasan pelanggan, kami hadir untuk menciptakan solusi yang berdampak positif',
            'category' => 'about'
        ]);

        Setting::create([
            'name' => 'images',
            'value' => 'image.png',
            'category' => 'about'
        ]);

        Setting::create([
            'name' => 'title',
            'value' => 'Kontak Kami',
            'category' => 'contact'
        ]);

        Setting::create([
            'name' => 'description',
            'value' => 'Kami berkomitmen untuk memberikan layanan terbaik dengan berfokus pada kualitas, inovasi, dan kepuasan pelanggan. Tujuan kami adalah menciptakan solusi yang memberikan dampak positif bagi setiap individu dan komunitas yang kami layani.',
            'category' => 'contact'
        ]);

        Setting::create([
            'name' => 'title',
            'value' => 'Kebijakan Privasi',
            'category' => 'policy'
        ]);

        Setting::create([
            'name' => 'description',
            'value' => 'Kami berkomitmen untuk memberikan layanan yang terbaik dengan mengutamakan kualitas, inovasi, dan kepuasan pelanggan. Misi kami adalah menyediakan solusi yang memberi manfaat positif bagi setiap individu dan komunitas yang kami layani.',
            'category' => 'policy'
        ]);
    }
}
