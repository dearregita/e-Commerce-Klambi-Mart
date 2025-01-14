<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FAQ::create([
            'question'  => 'Bagaimana cara melakukan pemesanan di toko online ini?',
            'answer'    => 'Anda dapat memilih produk yang diinginkan, menambahkannya ke keranjang, lalu mengikuti proses checkout untuk menyelesaikan pembayaran.',
        ]);
        
        FAQ::create([
            'question'  => 'Metode pembayaran apa saja yang tersedia?',
            'answer'    => 'Kami menerima pembayaran melalui transfer bank, kartu kredit, dompet digital seperti OVO dan GoPay, serta metode pembayaran lainnya.',
        ]);
        
        FAQ::create([
            'question'  => 'Berapa lama waktu pengiriman barang?',
            'answer'    => 'Lama pengiriman tergantung lokasi Anda. Biasanya membutuhkan waktu 2-7 hari kerja untuk pengiriman dalam negeri.',
        ]);
        
        FAQ::create([
            'question'  => 'Apakah saya bisa mengembalikan barang jika tidak sesuai?',
            'answer'    => 'Ya, Anda bisa mengembalikan barang dalam waktu 7 hari setelah barang diterima, dengan syarat barang belum digunakan dan dalam kondisi asli.',
        ]);
        
        FAQ::create([
            'question'  => 'Apakah ada biaya tambahan untuk pengiriman?',
            'answer'    => 'Biaya pengiriman akan dihitung berdasarkan lokasi Anda dan akan ditampilkan saat proses checkout.',
        ]);
        
        FAQ::create([
            'question'  => 'Bagaimana cara melacak pesanan saya?',
            'answer'    => 'Anda bisa melacak pesanan melalui fitur "Lacak Pesanan" di akun Anda atau menggunakan nomor resi yang kami kirimkan melalui email.',
        ]);        
    }
}
