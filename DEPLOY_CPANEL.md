# Deploy ke hosting shared dengan folder `htdocs`

Project ini menggunakan Laravel 12 dan memerlukan PHP 8.2 atau lebih baru. Paket ZIP deploy memisahkan document root publik (`htdocs`) dari source Laravel (`penggajian_app`) dan menyertakan dependency `vendor`. Jangan unggah `.env` lokal, `node_modules`, atau kredensial ke Git maupun folder yang bisa diakses publik.

Contoh domain target adalah `penggajian-karyawan.xo.je`. Ganti dengan domain Anda jika berbeda.

## 1. Siapkan hosting

- Atur versi PHP domain ke 8.2 atau lebih baru dan aktifkan ekstensi PHP yang dibutuhkan Laravel.
- Buat database MySQL dan user database melalui cPanel. Catat nama database, user, password, dan host database yang diberikan cPanel.
- Pastikan `htdocs` adalah document root domain dan hosting mengizinkan `.htaccess` serta `mod_rewrite`.

## 2. Unggah paket deploy

- Unggah `website_ukk-upload.zip` ke folder `Home`, yaitu folder yang berisi `htdocs`, bukan ke dalam `htdocs`.
- Ekstrak ZIP dari `Home`. Hasilnya harus berupa folder `htdocs` dan `penggajian_app` yang sejajar.
- Jangan pindahkan `penggajian_app` ke dalam `htdocs`. Folder itu berisi source Laravel, `.env`, dan `vendor`.
- Paket ZIP sudah membawa aset produksi dan `vendor`; Node.js dan Composer tidak perlu dijalankan di server.

File `htdocs/index.php` di paket sudah diarahkan ke `../penggajian_app`. Jangan salin `index.php` itu ke lokasi lain.

## 3. Atur environment dan database

Di File Manager, edit `penggajian_app/.env` dan isi nilai database yang dibuat di panel hosting:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://penggajian-karyawan.xo.je

DB_CONNECTION=mysql
DB_HOST=HOST_DATABASE_DARI_PANEL
DB_PORT=3306
DB_DATABASE=NAMA_DATABASE
DB_USERNAME=USER_DATABASE
DB_PASSWORD=PASSWORD_DATABASE

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

ZIP menyediakan `.env` dengan `APP_KEY` unik dan nilai database kosong. Jangan membagikan isi `.env`. Pastikan PHP dapat menulis ke `penggajian_app/storage` dan `penggajian_app/bootstrap/cache`; gunakan izin minimum yang disarankan penyedia hosting, bukan `777`.

## 4. Buat tabel aplikasi

Jika hosting menyediakan Terminal, jalankan dari folder `penggajian_app`:

```sh
php artisan migrate --force
```

Pastikan database yang dipilih benar sebelum menjalankan migrasi. Jika hosting tidak menyediakan Terminal atau SSH, minta bantuan penyedia hosting untuk menjalankan migrasi Laravel; jangan membuat tabel dengan menebak struktur.

## 5. Periksa hasil deploy

- Buka domain menggunakan HTTPS dan pastikan halaman serta aset CSS/JavaScript termuat.
- Pastikan `APP_DEBUG=false` dan `penggajian_app/.env` berada di luar `htdocs`.
- Jika muncul error, periksa `penggajian_app/storage/logs/laravel.log` dan konfigurasi PHP/database di panel hosting.
