# Basmalah Agency -- Landing Page & CMS

Aplikasi berbasis **Laravel** yang menyediakan **Landing Page** untuk
publik serta **CMS (Admin Panel)** untuk mengelola data submission
pengguna, housing partner, dan export data ke file Excel.\
Dibangun untuk mendukung operasional Basmalah Agency sebagai agen
properti terbesar se-Malang Raya.

------------------------------------------------------------------------

## 🚀 Fitur Utama

### 🔹 Landing Page

-   Halaman hero & branding Basmalah Agency\
-   Section "Kenapa Pilih Basmalah Agency?"\
-   FAQ\
-   Partner section\
-   Form submission untuk calon client / user

### 🔹 CMS / Admin Panel

-   Manajemen data user submission\
-   Manajemen data housing partner\
-   Export Data ke Excel (Laravel Excel)\
-   Dashboard ringkas (opsional)\
-   Role & permission admin (opsional)

------------------------------------------------------------------------

## 🧰 Tech Stack

-   **Laravel 10+**
-   **PHP 8.1+**
-   **MySQL / MariaDB**
-   **Node.js (NPM / Bun / Yarn)**
-   **TailwindCSS (jika digunakan)**
-   **Laravel Excel (maatwebsite/excel)**
-   **Blade Template**

------------------------------------------------------------------------

# ⚙️ Instalasi & Setup

## 1️⃣ Clone Repository

``` bash
git clone https://github.com/username/basmalah-agency.git
cd basmalah-agency
```

## 2️⃣ Install Dependency Backend (Laravel)

``` bash
composer install
```

## 3️⃣ Install Dependency Frontend

Jika menggunakan NPM:

``` bash
npm install
```

atau Bun:

``` bash
bun install
```

## 4️⃣ Copy File Environment

``` bash
cp .env.example .env
```

## 5️⃣ Atur Konfigurasi Database di `.env`

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=basmalah
DB_USERNAME=root
DB_PASSWORD=
```

## 6️⃣ Generate App Key

``` bash
php artisan key:generate
```

## 7️⃣ Migrasi Database

``` bash
php artisan migrate
```

Jika ada seeder:

``` bash
php artisan db:seed
```

## 8️⃣ Compile Frontend Assets

``` bash
npm run dev
```

Untuk build production:

``` bash
npm run build
```

## 9️⃣ Jalankan Aplikasi

``` bash
php artisan serve
```

Akses:\
👉 Landing Page → http://127.0.0.1:8000\
👉 Admin Panel → http://127.0.0.1:8000/admin

------------------------------------------------------------------------

# 📁 Struktur Folder Penting

``` plaintext
app/
└── Http/
    ├── Controllers/
    │   ├── Admin/
    │   │   ├── SubmissionController.php
    │   │   ├── PartnerController.php
    │   │   ├── ExportController.php
    │   └── FrontendController.php
resources/
├── views/
│   ├── frontend/
│   ├── admin/
routes/
├── web.php
└── admin.php (opsional)
```

------------------------------------------------------------------------

# 📤 Export Data Excel

Proyek menggunakan **Laravel Excel** untuk export:

Contoh:

``` php
return Excel::download(new SubmissionsExport, 'submissions.xlsx');
```

------------------------------------------------------------------------

# 🧪 Testing

``` bash
php artisan test
```

------------------------------------------------------------------------

# 🚀 Deployment Production

### 1. Install dependency

``` bash
composer install --optimize-autoloader --no-dev
npm run build
```

### 2. Set Permission

``` bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### 3. Optimasi Laravel

``` bash
php artisan optimize
```

------------------------------------------------------------------------

# 🤝 Kontribusi

Pull Request terbuka untuk pengembangan fitur, UI/UX CMS, dan perbaikan
struktur kode.

------------------------------------------------------------------------

# 📄 Lisensi

Proyek bersifat privat dan hanya digunakan untuk kebutuhan internal
Basmalah Agency.
