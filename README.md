# Sistem Pendukung Keputusan Prioritas Perbaikan Jalan - PUPR Kota Bandar Lampung

Aplikasi web berbasis PHP Laravel untuk menghitung prioritas perbaikan jalan menggunakan metode MOORA.

## Fitur
- Login admin/petugas
- CRUD data kriteria dan bobot
- CRUD data ruas jalan
- Input nilai alternatif/ruas jalan
- Perhitungan MOORA otomatis
- Ranking prioritas perbaikan jalan
- Laporan dan export CSV
- Upload foto dokumentasi ruas jalan

## Kriteria yang disiapkan
- Panjang jalan
- Lebar jalan
- Banyaknya lubang
- Kedalaman lubang
- Tingkat kerusakan
- Kepentingan jalan
- Biaya perbaikan

## Login default
- Email: admin@pupr.test
- Password: password

## Cara pakai di Laragon
1. Buat project Laravel 11 baru di Laragon atau jalankan composer install pada project ini.
2. Set database MySQL lokal di file .env.
3. Jalankan migrasi dan seeder.
4. Jalankan storage link agar foto bisa tampil.
5. Login sebagai admin, lalu isi ruas jalan dan nilai kriterianya.

## Menjalankan lokal
- Jika tidak memakai virtual host Laragon, jalankan `php artisan serve` lalu buka `http://127.0.0.1:8000`.
- Jika ingin tetap memakai domain `.test`, pastikan Auto Virtual Hosts Laragon aktif dan domain yang dipakai mengarah ke folder project ini, lalu sesuaikan `APP_URL` dengan domain tersebut.

## Struktur perhitungan MOORA
- Normalisasi nilai tiap kriteria
- Kalikan bobot kriteria
- Jumlah benefit dikurangi cost
- Urutkan dari nilai tertinggi ke terendah
