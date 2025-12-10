# Basmalah Agency -- Landing Page & CMS

Aplikasi berbasis **Laravel** yang menyediakan **Landing Page** untuk
publik serta **CMS (Admin Panel)** untuk mengelola data submission
pengguna, housing partner, dan export data ke file Excel.\
Dibangun untuk mendukung operasional Basmalah Agency sebagai agen
properti.

------------------------------------------------------------------------

## 🚀 Fitur Utama

### 🔹 Landing Page

-   Halaman hero & branding Basmalah Agency
-   Section "Kenapa Pilih Basmalah Agency?"
-   FAQ\
-   Housing Partner section
-   Form submission untuk calon client / user

### 🔹 CMS / Admin Panel

-   Manajemen data user submission
-   Manajemen data housing partner
-   Export Data ke Excel (Laravel Excel)
-   Dashboard ringkas

------------------------------------------------------------------------

# ⚙️ Instalasi & Setup

## Clone Repository

``` bash
git clone https://github.com/BagusFary/basmallah-agency
cd basmallah-agency
```

## Install Dependency Backend (Laravel)

``` bash
composer install
```

## Install Dependency Frontend

Jika menggunakan NPM:

``` bash
npm install
```

## Copy File Environment

``` bash
cp .env.example .env
```

## Atur Konfigurasi Database di `.env`

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=basmallah_agency_app
DB_USERNAME=root
DB_PASSWORD=
```

## Generate App Key

``` bash
php artisan key:generate
```

## Migrasi Database

``` bash
php artisan migrate
```

``` bash
php artisan db:seed
```

## Jalankan Aplikasi

``` bash
composer run dev
```

Akses:\
Landing Page → http://localhost:8000\


Admin Panel → http://dashboard.localhost:8000/admin

superadmin credentials:
- email = superadmin@gmail.com
- password = 12345678

------------------------------------------------------------------------


