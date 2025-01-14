<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Policy::create([
            'content' => '
                <h1 class="mb-4 text-2xl font-bold">Kebijakan Privasi</h1>
        
                <p class="mb-4">Kami menghargai privasi Anda dan berkomitmen untuk melindungi informasi pribadi yang Anda berikan saat mengakses dan menggunakan layanan kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda.</p>
        
                <h2 class="mt-6 mb-2 text-xl font-semibold">Informasi yang Kami Kumpulkan</h2>
                <p class="mb-4">Kami mengumpulkan informasi pribadi yang Anda berikan secara sukarela saat menggunakan layanan kami, termasuk nama, alamat email, nomor telepon, dan informasi pembayaran. Kami juga dapat mengumpulkan data terkait penggunaan situs web kami, seperti alamat IP, jenis perangkat, dan informasi navigasi untuk meningkatkan pengalaman pengguna.</p>
        
                <h2 class="mt-6 mb-2 text-xl font-semibold">Bagaimana Kami Menggunakan Informasi Anda</h2>
                <p class="mb-4">Informasi yang kami kumpulkan digunakan untuk tujuan berikut:</p>
                <ul class="mb-4 list-disc list-inside">
                    <li>Memproses dan mengelola pesanan Anda.</li>
                    <li>Menghubungi Anda terkait status pesanan atau permintaan layanan.</li>
                    <li>Memperbaiki dan meningkatkan layanan kami berdasarkan umpan balik pengguna.</li>
                    <li>Mematuhi kewajiban hukum dan peraturan yang berlaku.</li>
                </ul>
        
                <h2 class="mt-6 mb-2 text-xl font-semibold">Keamanan Data</h2>
                <p class="mb-4">Kami berkomitmen untuk menjaga keamanan data pribadi Anda. Kami menggunakan berbagai langkah keamanan teknis dan prosedural untuk melindungi informasi yang Anda berikan kepada kami, termasuk enkripsi dan pengamanan akses terbatas ke data Anda.</p>
        
                <h2 class="mt-6 mb-2 text-xl font-semibold">Berbagi Informasi</h2>
                <p class="mb-4">Kami tidak akan menjual, menyewakan, atau membagikan informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali untuk tujuan yang dijelaskan dalam kebijakan ini atau jika diwajibkan oleh hukum.</p>
        
                <h2 class="mt-6 mb-2 text-xl font-semibold">Perubahan Kebijakan Privasi</h2>
                <p class="mb-4">Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Jika ada perubahan yang signifikan, kami akan memberi tahu Anda melalui situs web kami atau melalui saluran komunikasi lainnya. Pastikan untuk memeriksa halaman ini secara berkala untuk melihat perubahan terbaru.</p>
        
                <h2 class="mt-6 mb-2 text-xl font-semibold">Hubungi Kami</h2>
                <p class="mb-4">Jika Anda memiliki pertanyaan atau kekhawatiran mengenai Kebijakan Privasi ini atau bagaimana kami mengelola data pribadi Anda, silakan hubungi kami melalui <a href="mailto:contact@klambi.com" class="text-indigo-600">contact@klambi.com</a>.</p>
            ',
        ]);
        
    }
}
