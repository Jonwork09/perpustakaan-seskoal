# 📚 Sistem Informasi Perpustakaan Seskoal (SIPER-S)

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)

**SIPER-S** adalah platform manajemen perpustakaan digital yang dirancang khusus untuk lingkungan **Seskoal**. Aplikasi ini mengintegrasikan sistem peminjaman buku manual dengan antarmuka web bagi Admin dan layanan API bagi Siswa untuk akses yang lebih cepat.

---

## 🚀 Fitur Utama

### 👨‍💼 Panel Admin
- **Manajemen Buku:** CRUD (Create, Read, Update, Delete) buku lengkap dengan sistem upload sampul.
- **Manajemen Kategori:** Organisasi buku berdasarkan genre atau bidang studi.
- **Manajemen Pengguna:** Pendaftaran user (Siswa/Admin) dengan **Validasi Keamanan Domain Email** (`@seskoal.id`).
- **Dashboard Statis:** Ringkasan data buku dan pengguna.

### 📱 Layanan API (Siswa)
- **Endpoint Peminjaman:** Siswa dapat mengajukan peminjaman buku melalui request API.
- **Security:** Dilengkapi dengan autentikasi Token (Sanctum) untuk menjamin keamanan data.

---

## 🛠️ Tech Stack
- **Backend:** PHP 8.x, Laravel 10.x/11.x
- **Frontend:** Blade Templating, Bootstrap 4/5, AdminLTE / SB Admin 2
- **Database:** MySQL / MariaDB
- **Authentication:** Laravel Sanctum (API) & Laravel UI/Breeze (Web)

---

## 💻 Panduan Instalasi

Ikuti langkah berikut untuk menjalankan project di lingkungan lokal:

1. **Clone Repository**
   ```bash
   git clone [https://github.com/Jonwork09/perpustakaan-seskoal.git](https://github.com/Jonwork09/perpustakaan-seskoal.git)
   cd perpustakaan-seskoal
