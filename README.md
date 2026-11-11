<div align="center">

# 📚 Aplikasi Manajemen Siswa

Aplikasi web untuk mengelola data siswa (CRUD) yang dibuat dengan **Laravel**.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

</div>

---

## 📖 Tentang Project

Aplikasi ini dibuat untuk memudahkan pengelolaan data siswa di sekolah. Data siswa dapat ditambah, diubah, dan dihapus melalui tampilan dashboard yang modern dan mudah digunakan. Project ini dibuat sebagai tugas Pemrograman Web.

## ✨ Fitur

- ➕ **Insert** – menambah data siswa baru
- ✏️ **Update** – mengubah data siswa
- 🗑️ **Delete** – menghapus satu data siswa
- ☑️ **Hapus massal** – menghapus beberapa siswa sekaligus lewat checkbox
- 🔍 **Pencarian** – cari berdasarkan nama, NIS, atau kelas
- 🗂️ **Filter tab** – Semua / Laki-laki / Perempuan beserta jumlahnya
- 📄 **Pagination** – data dibagi per halaman (10 data)
- ✅ **Validasi form** – NIS dan email tidak boleh ganda
- 📱 **Responsif** – nyaman dibuka di laptop maupun HP


## 🛠️ Teknologi

| Teknologi | Kegunaan |
|---|---|
| Laravel | Framework backend (pola MVC) |
| PHP 8.2+ | Bahasa pemrograman |
| MySQL | Database |
| Blade | Template engine |
| Bootstrap 5 & Bootstrap Icons | Tampilan antarmuka |

## 🚀 Cara Menjalankan

### Kebutuhan

- PHP 8.2 atau lebih baru
- Composer
- MySQL (XAMPP / Laragon)

### Instalasi

1. **Clone repository**

   ```bash
   git clone https://github.com/USERNAME/NAMA-REPOSITORY.git
   cd NAMA-REPOSITORY
   ```

2. **Install dependency**

   ```bash
   composer install
   ```

3. **Salin file environment dan buat app key**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   (Di Windows CMD, gunakan `copy .env.example .env`.)

4. **Buat database** bernama `db_siswa` di phpMyAdmin, lalu atur `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_siswa
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migration**

   ```bash
   php artisan migrate
   ```

6. **Jalankan server**

   ```bash
   php artisan serve
   ```

7. Buka **http://127.0.0.1:8000** di browser.

## 🗺️ Route

| Method | URL | Fungsi |
|---|---|---|
| GET | `/students` | Menampilkan daftar siswa |
| GET | `/students/create` | Form tambah siswa |
| POST | `/students` | Menyimpan siswa baru |
| GET | `/students/{id}/edit` | Form edit siswa |
| PUT | `/students/{id}` | Memperbarui data siswa |
| DELETE | `/students/{id}` | Menghapus satu siswa |
| DELETE | `/students/bulk-destroy` | Menghapus beberapa siswa |

## 🗄️ Struktur Tabel `students`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| nis | string | Unik |
| nama | string | Nama lengkap |
| email | string | Opsional, unik |
| jenis_kelamin | enum (L/P) | Laki-laki / Perempuan |
| tanggal_lahir | date | Tanggal lahir |
| kelas | string | Contoh: X IPA 1 |
| alamat | text | Opsional |

## 📁 File Penting

```
app/
├── Http/Controllers/StudentController.php   # Logika CRUD
└── Models/Student.php                       # Model siswa
database/migrations/                         # Struktur tabel students
resources/views/
├── layouts/app.blade.php                    # Layout utama
└── students/                                # Halaman index, create, edit
routes/web.php                               # Daftar route
```

## 👨‍💻 Pembuat

**Moch Nafis Adhimukti**
Kelas XI-RPL (Rekayasa Perangkat Lunak)

---

<div align="center">
Dibuat dengan ❤️ menggunakan Laravel
</div>
