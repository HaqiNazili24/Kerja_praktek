# 🌾 Toko Beras Jagat Nusantara — Aplikasi E-Commerce Penjualan Beras

Aplikasi e-commerce penjualan beras berbasis **Laravel 11 + MySQL + Bootstrap 5**. 
Siap dijalankan di **XAMPP**.

---

## 📋 Fitur

### Admin
- Dashboard (ringkasan produk, pesanan, pendapatan)
- CRUD Kategori & Sub Kategori
- CRUD Produk (upload foto, stok, status aktif/nonaktif)
- Manajemen Pesanan (konfirmasi/tolak pembayaran, update status, no. resi)
- Laporan Penjualan + Export PDF (filter tanggal, kategori, status)

### Customer
- Registrasi & Login (dengan fitur show/hide password)
- Browse produk (filter kategori/sub-kategori, sort harga)
- Detail produk
- Pencarian produk
- Keranjang belanja (tersimpan di database)
- Checkout dengan alamat pengiriman
- Metode pembayaran: Transfer Bank & Cash On Delivery (COD)
- Upload bukti pembayaran (JPG/PNG/PDF)
- Riwayat pesanan dengan timeline status
- Konfirmasi pesanan diterima

---

## 🚀 Cara Install di XAMPP

### 1. Persiapan
Pastikan sudah terinstall:
- **XAMPP** (Apache + MySQL + PHP 8.2+)
- **Composer** → https://getcomposer.org
- **Node.js & NPM** → https://nodejs.org

### 2. Clone & Install
```bash
# Clone repo ke folder htdocs
cd C:\xampp\htdocs\
git clone https://github.com/username/repo-name.git tokoberasjagatnusantara
cd tokoberasjagatnusantara

# Install dependency PHP
composer install

# Install dependency frontend
npm install
```

### 3. Setup .env
```bash
copy .env.example .env
php artisan key:generate
```

Edit file `.env` sesuaikan konfigurasi:
```env
APP_NAME="Toko Beras Jagat Nusantara"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tokoberas
DB_USERNAME=root
DB_PASSWORD=

STORE_NAME="Toko Beras Jagat Nusantara"
STORE_BANK_NAME="Bank BCA"
STORE_BANK_ACCOUNT="1234567890"
STORE_BANK_HOLDER="CV Jagat Nusantara"
SHIPPING_FLAT_RATE=10000
```

### 4. Setup Database
- Buka phpMyAdmin → buat database baru dengan nama **`tokoberas`**
- Jalankan migration dan seeder:
```bash
php artisan migrate --seed
php artisan storage:link
```

### 5. Jalankan
Buka **2 terminal terpisah**:

**Terminal 1 — Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 — Vite (Frontend):**
```bash
npm run dev
```

Akses → http://localhost:8000

---

## 🔑 Akun Default

| Role     | Email                          | Password   |
|----------|--------------------------------|------------|
| Admin    | admin@jagatnusantara.test      | admin123   |
| Customer | customer@jagatnusantara.test   | customer123|

---

## 🛒 Produk Default

| Kategori      | Sub Kategori | Produk                                      |
|---------------|--------------|---------------------------------------------|
| Beras         | Premium      | Idola 25kg                                  |
| Beras         | Medium       | Rojo Lele 5kg, 10kg, 25kg                   |
| Beras         | Medium       | Ramos Bandung 5kg, 10kg, 25kg               |
| Beras         | Medium       | SPHP 5kg                                    |
| Minyak Goreng | Minyakita    | Minyakita 1L, 2L                            |

---

## 📁 Struktur Folder
app/Http/Controllers/Admin    → Controller admin

app/Http/Controllers/Customer → Controller customer

app/Http/Middleware           → Middleware admin & customer

app/Models                    → Eloquent models

database/migrations           → Skema database

database/seeders              → Data dummy

resources/views               → Blade templates

routes/web.php                → Route definition

---

## ⚙️ Troubleshooting

- **Error storage** → Jalankan: `php artisan storage:link`
- **Gambar tidak muncul** → Jalankan: `rmdir public\storage` lalu `php artisan storage:link`
- **MySQL error** → Pastikan Apache & MySQL di XAMPP sudah running
- **PDF gagal generate** → Pastikan ekstensi PHP `gd` & `mbstring` aktif di XAMPP
- **Error 419 Page Expired** → Buka URL langsung di browser, jangan pakai tombol back
- **npm not recognized** → Jalankan `Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser` di PowerShell

---

## 👨‍💻 Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Bootstrap 5 + Blade Template
- **Database**: MySQL
- **PDF**: barryvdh/laravel-dompdf
- **Build Tool**: Vite + NPM

---

Selamat mencoba! 🌾