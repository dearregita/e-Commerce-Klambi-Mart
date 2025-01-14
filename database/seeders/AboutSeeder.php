<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'content' => '
                <h1 class="mb-4 text-2xl font-bold">Tentang Kami</h1>
                <p class="mb-4">Kami adalah perusahaan yang berdedikasi untuk memberikan <strong>layanan terbaik</strong> kepada pelanggan. Dengan komitmen terhadap <em>kualitas</em>, <em>integritas</em>, dan <em>inovasi</em>, kami terus berusaha memenuhi kebutuhan pelanggan di setiap langkah perjalanan mereka.</p>
                
                <h2 class="mt-6 mb-2 text-xl font-semibold">Misi Kami</h2>
                <p class="mb-4">Misi kami adalah menciptakan solusi yang memberikan nilai nyata kepada pelanggan, mitra, dan masyarakat melalui layanan berkualitas tinggi dan pengalaman yang luar biasa.</p>
                
                <h2 class="mt-6 mb-2 text-xl font-semibold">Visi Kami</h2>
                <p class="mb-4">Kami berkomitmen untuk menjadi pemimpin dalam industri kami dengan menetapkan standar baru untuk inovasi dan pelayanan pelanggan.</p>
                
                <h3 class="mt-6 mb-2 text-lg font-medium">Nilai Inti Kami</h3>
                <ul class="mb-4 list-disc list-inside">
                    <li>Integritas dalam setiap tindakan.</li>
                    <li>Inovasi untuk menciptakan solusi yang lebih baik.</li>
                    <li>Fokus pada pelanggan sebagai prioritas utama.</li>
                    <li>Kolaborasi untuk mencapai hasil terbaik.</li>
                </ul>
                
                <p class="mb-4">Kami percaya bahwa kerja sama dan kepercayaan adalah kunci untuk menciptakan pengalaman yang berharga. Bergabunglah dengan kami untuk membangun masa depan yang lebih baik bersama.</p>
            ',
        ]);        
    }
}
