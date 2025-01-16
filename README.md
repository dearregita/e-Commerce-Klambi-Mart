## Cara menjalankan aplikasi
#### Persyaratan

-   Git
-   PHP 8.2 (minimal)
-   Composer
-   MySQL atau MariaDB
### Langkah-langkah

1. `Clone repositori` ini atau `download file ZIP-nya`.

2. Masuk ke direktori/folder `e-Commerce-Klambi-Mart`
    ```bash
    cd e-Commerce-Klambi-Mart
    ```
    atau

    `open folder` di visual studio code atau aplikasi lainnya 

3. Hapus file `composer.lock`
   
4.  Install dependensi
    ```bash
    composer install
    ```
    dan
     ```bash
    npm install
    ```
5. Copy file `.env.example` menjadi `.env`

6. Buat Database
   > Dengan nama database `klambi_mart`

7. Migrasi Database
   > Jalankan perintah berikut untuk membuat tabel di database:
    ```bash
    php artisan migrate
    ```
8. Seed Database
   > Jalankan perintah berikut untuk mengisi database dengan data awal:
    ```bash
    php artisan migrate:fresh --seed
    ```
9. Public/Storage
   > cek folder public, jika tidak ada bisa lanjut ke step berikutnya. jika ada file bernama storage hapus terlebih dahulu, lalu jalankan sintak perintah berikut pada terminal
    ```bash
    php artisan storage:link    
    ```

10. Jalankan Aplikasi
-   Buka 2 terminal untuk menjalankan server
-   Pertama, jalankan perintah berikut untuk memulai server:    
    ```bash
    php artisan serve
    ```
-   Kedua, jalankan perintah berikut untuk meng-compile aset frontend:
    ```bash
    npm run dev
    ```

11. Akses Aplikasi
    Buka browser dan akses:    
    ```bash
    http://127.0.0.1:8000/masuk
    ```

    > [!NOTE]
    > Pastikan _dua terminal berjalan_:
    > Satu terminal menjalankan `npm run dev`.
    > Satu terminal menjalankan `php artisan serve`.

## Akun Login
#### Akun Admin
- Email: _admin@admin.gmail_
- Password: _admin123_
#### Akun Pengguna
Silakan registrasi untuk membuat akun pengguna.