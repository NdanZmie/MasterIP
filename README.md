<div align="center">

```
███╗   ███╗ █████╗ ███████╗████████╗███████╗██████╗ ██╗██████╗ 
████╗ ████║██╔══██╗██╔════╝╚══██╔══╝██╔════╝██╔══██╗██║██╔══██╗
██╔████╔██║███████║███████╗   ██║   █████╗  ██████╔╝██║██████╔╝
██║╚██╔╝██║██╔══██║╚════██║   ██║   ██╔══╝  ██╔══██╗██║██╔═══╝ 
██║ ╚═╝ ██║██║  ██║███████║   ██║   ███████╗██║  ██║██║██║     
╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝   ╚═╝   ╚══════╝╚═╝  ╚═╝╚═╝╚═╝     
```

# 🖥️ MasterIP — Web Monitoring EDP

**Manajemen Spesifikasi PC · Monitoring IP · Network Scanner**

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Vite](https://img.shields.io/badge/Vite-Latest-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-Latest-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/Status-Beta-f59e0b?style=for-the-badge)]()

> Dibuat oleh **Zmie** · v1.0 Beta

</div>

---

## 📋 Requirements

Pastikan semua tools berikut sudah terinstall sebelum memulai:

| Tools | Versi | Keterangan |
|-------|-------|------------|
| 🐘 **PHP** | 8.3 | Wajib |
| 🎼 **Composer** | Latest | Package manager PHP |
| 🟢 **Node.js** | Latest (LTS) | Untuk build assets |
| 🔷 **VSCode** | Latest | Code editor |
| 🐙 **Git** | Latest | Version control |
| 🦅 **Laragon** | v6 ⭐ Recommended | Local server Windows |
| 🗄️ **phpMyAdmin** | via Laragon | Database manager (MySQL) |
| 💾 **Database** | `.sql` file | Import dari file yang disediakan |

> ⭐ **Laragon v6 sangat direkomendasikan** karena sudah include Apache, MySQL, PHP, dan phpMyAdmin dalam satu paket.

---

## ⚠️ Perhatian Sebelum Mulai

> **Baca dulu sebelum install!**

```
❗ Perhatikan PATH PHP dan Node di environment variables Windows
❗ Buka php.ini di Laragon → hapus titik koma (;) pada baris extension=zip
   Sebelum : ;extension=zip
   Sesudah : extension=zip
❗ Jalankan npm run build SEBELUM testing web
❗ Pastikan IIS (Internet Information Services) Windows dimatikan
   agar tidak bentrok dengan Apache Laragon di port 80
```

---

## 🚀 Tutor Clone / Migrasi (Install Pertama Kali)

### Step 1 — Clone Repository

```bash
# Masuk ke folder web Laragon
cd D:\laragon\www

# Clone project dari GitHub
git clone https://github.com/username/repo.git masterip

# Masuk ke folder project
cd masterip
```

### Step 2 — Install Dependencies

```bash
# Install package PHP
composer install

# Install package Node & build assets
npm install
npm run build
```

### Step 3 — Setup Environment

```bash
# Copy file env
cp .env.example .env
```

> ✏️ **Edit file `.env` di VSCode sebelum lanjut!**
> Wajib isi bagian ini:

```env
APP_URL=http://192.168.75.117        # ← ganti dengan IP server kamu

DB_DATABASE=masterip                 # ← nama database
DB_USERNAME=root                     # ← user MySQL
DB_PASSWORD=                         # ← password MySQL (default Laragon kosong)
```

### Step 4 — Finalisasi

```bash
# Generate application key
php artisan key:generate

# Link storage folder
php artisan storage:link

# Cache semua config
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 5 — Import Database

```
Buka phpMyAdmin → http://localhost/phpmyadmin
→ Buat database baru dengan nama sesuai .env
→ Import file .sql yang disediakan
```

---

## ✅ Checklist Migrasi / Clone

Centang semua sebelum testing:

```
□ Folder ada di D:\laragon\www\masterip
□ composer install selesai tanpa error
□ npm install & npm run build selesai
□ File .env sudah diisi (DB & APP_URL)
□ php artisan key:generate sudah dijalankan
□ php artisan storage:link sudah dijalankan
□ Nama DB di .env sama dengan DB yang sudah diimport
□ Virtual host .conf sudah dibuat di Laragon
□ Apache Laragon sudah di-restart
□ Firewall port 80 sudah dibuka
□ Auto-start Laragon sudah diaktifkan
□ Bisa diakses dari browser: http://localhost
□ Bisa diakses dari PC lain: http://192.168.75.117
```

---

## 🔄 Tutor Update Git

### Alur Kerja

```
PC Developer (192.168.75.147)        GitHub            Server (192.168.75.117)
──────────────────────────────       ──────            ──────────────────────
  Edit kode di VSCode           →   git push    →        git pull
  Test di lokal                                          php artisan ...
```

---

### 📤 Push Update — Di PC Developer

```bash
# 1. Cek file apa saja yang berubah
git status

# 2. Tambahkan semua perubahan
git add .

# 3. Commit dengan pesan yang jelas
git commit -m "keterangan perubahan"

# 4. Push ke GitHub
git push origin main
```

---

### 📥 Tarik Update — Di Server (192.168.75.117)

```bash
# Masuk ke folder project
cd D:\laragon\www\masterip

# Ambil update terbaru dari GitHub
git pull origin main

# Kalau ada package PHP baru (composer.json berubah)
composer install

# Kalau ada perubahan CSS / JS / Vite (resources/)
npm install
npm run build

# Kalau ada file migration baru
php artisan migrate

# ⚡ WAJIB dijalankan setiap selesai pull
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### ⚡ Kapan Perlu Perintah Tambahan?

| Kondisi | Perintah Tambahan |
|---------|-------------------|
| Hanya ubah logic PHP / Blade | `git pull` + `config:cache` saja |
| Ada package baru di `composer.json` | + `composer install` |
| Ada ubahan di `resources/` (CSS/JS) | + `npm run build` |
| Ada file migration baru | + `php artisan migrate` |

---

### 🛠️ Script Update Otomatis

Buat file `update.bat` di folder project untuk kemudahan update:

```bat
@echo off
echo ================================
echo   UPDATE MASTERIP DARI GITHUB
echo ================================
cd D:\laragon\www\masterip
echo [1/5] Git Pull...
git pull origin main
echo [2/5] Composer Install...
composer install --no-dev --optimize-autoloader
echo [3/5] NPM Build...
npm run build
echo [4/5] Artisan Migrate...
php artisan migrate --force
echo [5/5] Clear Cache...
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo ================================
echo   SELESAI! Web sudah terupdate.
echo ================================
pause
```

> 💡 Cukup **double klik** `update.bat` setiap kali mau update server.

---

## 🗂️ Struktur Project

```
masterip/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── SpekpcController.php
│   │   ├── NetworkController.php
│   │   ├── LoginController.php
│   │   └── RegisterController.php
│   └── Models/
│       └── Spekpc.php
├── resources/
│   └── views/
│       ├── layouts/app.blade.php
│       ├── pages/
│       │   ├── dashboard.blade.php
│       │   ├── spekpc.blade.php
│       │   ├── network.blade.php
│       │   └── ...
│       └── aset/
│           ├── modal_tambah_spekpc.blade.php
│           ├── modal_edit_spekpc.blade.php
│           └── modal_delete_spekpc.blade.php
├── routes/
│   └── web.php
├── .env.example        ← copy ke .env lalu edit
├── update.bat          ← script update server
└── README.md
```

---

## 🌐 Fitur

- 🖥️ **Spek PC** — Manajemen spesifikasi & inventori komputer
- 📡 **Network Monitor** — Ping & scan IP secara real-time
- 📊 **Dashboard** — Overview statistik sistem & jaringan
- 📋 **Clipboard** — Catatan cepat
- 📤 **Export** — Download data ke Excel / CSV
- 🔐 **Auth** — Login & Register dengan proteksi password EDP

---

## 🧰 Troubleshooting

```bash
# Error: APP_KEY not set
php artisan key:generate

# Error: Storage tidak bisa ditulis
php artisan storage:link

# Error: Class not found
composer dump-autoload

# Error: Vite manifest not found
npm run build

# Error: 500 setelah deploy
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Ping semua offline di Network Monitor
# → Cek permission ping di Windows Firewall
# → Pastikan IIS tidak aktif (bentrok port 80)
```

---

<div align="center">

**MasterIP** · Crafted with ❤️ by **Zmie** · v1.0 Beta

`© 2025 MasterIP — All rights reserved`

</div>
