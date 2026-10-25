# Free Fire Event & Super Admin Panel

Web aplikasi event Free Fire bertema Dunia Mistis Halloween beserta panel kontrol admin lengkap.

## 📁 Struktur Folder
- `index.html`: Landing page statis Free Fire Event yang siap dideploy langsung ke **Vercel** / Netlify / GitHub Pages.
- `images/`: Aset gambar visual, banner ultra HD, dan thumbnail hadiah item Free Fire.
- `laravel-app/`: Aplikasi full-stack Laravel yang memuat sistem klaim dinamis, database, verifikasi, integrasi Telegram bot, serta Super Admin Panel.
- `vercel.json`: Konfigurasi deployment Vercel.

## 🚀 Cara Menjalankan Frontend Statis
Buka file `index.html` langsung di browser Anda atau gunakan live server:
```bash
npx serve .
```

## 🛠️ Cara Menjalankan Laravel App & Admin Panel
Masuk ke direktori `laravel-app`:
```bash
cd laravel-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Akses Admin Panel di: `http://127.0.0.1:8000/panel/login`
- **Default Username**: `admin@gmail.com`
- **Default Password**: `admin123`
