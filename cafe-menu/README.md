# Sistem Menu Kafe (Tugasan 2)

Laravel 12 + Oracle XE (Docker) + Laravel Breeze. Data resipi ditarik dari TheMealDB.

## Keperluan
PHP 8.3 (dengan sambungan oci8 + Oracle Instant Client 19), Composer, Node.js, Docker Desktop.

## Cara jalankan
1. Mulakan Oracle:
   docker run -d --name oracle-xe -p 1521:1521 -e ORACLE_PASSWORD=oracle -e APP_USER=cafe -e APP_USER_PASSWORD=cafe123 gvenzl/oracle-xe:21-slim
2. composer install
3. npm install && npm run build
4. cp .env.example .env  (kemudian tetapkan DB_CONNECTION=oracle, DB_HOST=127.0.0.1, DB_PORT=1521, DB_SERVICE_NAME=XEPDB1, DB_DATABASE=XEPDB1, DB_USERNAME=cafe, DB_PASSWORD=cafe123, SESSION_DRIVER=file, CACHE_STORE=file, QUEUE_CONNECTION=sync)
5. php artisan key:generate
6. php artisan migrate --seed   (mencipta skema penuh dan akaun admin)
7. php artisan serve  ->  http://127.0.0.1:8000

## Akaun
- Admin: admin@cafe.test / admin123
- Pengguna biasa: daftar melalui halaman Register (peranan lalai: user, hanya boleh lihat menu)

## Ciri
CRUD + carian, pagination (10 baris), export CSV, login + peranan (admin/user), tarik data dari API dan simpan ke Oracle, semakan duplicate (meal_id unik), tapisan kategori dari API, halaman butiran (gambar, bahan, sukatan).

## Alat AI
Claude (Anthropic) digunakan untuk membantu menjana kod dan menyelesaikan masalah persediaan.
