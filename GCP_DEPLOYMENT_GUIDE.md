# Panduan Deployment & Optimasi di GCP

Berikut adalah langkah-langkah untuk memperbarui dan mengoptimalkan aplikasi Anda di server GCP.

## 1. Tarik Update Terbaru
Di terminal server (SSH), masuk ke folder project dan tarik perubahan terbaru (termasuk konfigurasi Docker dan Caddy baru).
```bash
cd ~/sinergi
git pull origin main
```
> **Catatan:** Jika Anda mengedit file langsung di server, mungkin perlu di-stash dulu (`git stash`) sebelum pull.

## 2. Update Environment Variable
Edit file `.env` untuk mode produksi.
```bash
nano .env
```
Pastikan setting berikut:
```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sinergismki1.com

# Optimasi Cache
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```
*Simpan dengan `Ctrl+O`, lalu keluar dengan `Ctrl+X`.*

## 3. Restart Docker Container
Karena kita mengubah `compose.yaml` (menambah volume mounting), container perlu direstart.
```bash
docker-compose down
docker-compose up -d --build
```

## 4. Build Aset Frontend (Vite)
Jalankan build aset di dalam container agar file CSS/JS terkompilasi (tidak pakai mode dev server lagi).
```bash
docker-compose exec laravel.test npm install
docker-compose exec laravel.test npm run build
```

## 5. Optimasi Cache Laravel
Jalankan perintah optimasi PHP/Laravel untuk production.
```bash
docker-compose exec laravel.test php artisan optimize:clear
docker-compose exec laravel.test php artisan optimize
docker-compose exec laravel.test php artisan view:cache
docker-compose exec laravel.test php artisan config:cache
docker-compose exec laravel.test php artisan route:cache
```

## 6. Cek Status
Pastikan semua berjalan normal:
```bash
docker-compose ps
docker stats
```

## Kenapa Langkah Ini Penting?
1.  **Static Files (Caddy)**: Caddy sekarang melayani file CSS/JS/Gambar langsung dari disk, tanpa membebani PHP.
2.  **HTTPS/Gzip**: Kompresi Gzip diaktifkan untuk memperkecil ukuran transfer data.
3.  **Production Mode**: Mematikan debug bar dan error reporting yang berat.
4.  **Caching**: Laravel menyimpan konfigurasi dan routing di RAM untuk respon super cepat.
