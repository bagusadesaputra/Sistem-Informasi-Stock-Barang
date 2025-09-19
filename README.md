# Sistem Informasi Stock Barang

Sebuah aplikasi web sederhana untuk **manajemen stok barang** di gudang. Proyek ini mencakup pengelolaan barang masuk, barang keluar, stock opname (realisasi stok fisik), dan monitoring stok secara online.

---

## 📋 Fitur Utama

- Login / Logout untuk keamanan akses.  
- Manajemen **barang**: tambah, ubah, hapus data barang.  
- Manajemen **jenis barang**.  
- Manajemen **lokasi** gudang (jika ada beberapa lokasi).  
- Pencatatan **barang masuk** (masuk gudang).  
- Pencatatan **barang keluar** (keluar dari gudang).  
- **Stock opname**: sinkronisasi antara stok sistem vs stok fisik di gudang.  
- Manajemen **satuan** barang.  
- Pengelolaan **petugas** yang bertugas di sistem.

---

## 🔧 Struktur Direktori

Berikut beberapa folder / file penting dan fungsinya:

| Folder / File | Fungsi |
|---------------|--------|
| `assets/css/` | Styling (CSS) untuk tampilan antarmuka |
| `assets/js/` | Script frontend JavaScript (jika ada) |
| `config/` | Konfigurasi, seperti koneksi database |
| `functions/` | Fungsi-fungsi PHP/scripting yang digunakan banyak di beberapa halaman |
| `barang_*`, `masuk_*`, `keluar_*`, `opname_*` | Modul-modul CRUD untuk barang, barang masuk, barang keluar, stock opname |
| `login.php`, `logout.php` | Pengelolaan autentikasi pengguna |
| `petugas.php` | Modul untuk pengelolaan petugas / user sistem |

---

## ⚙️ Teknologi

- Bahasa Pemrograman: **PHP**  
- Database: (misalnya) MySQL / MariaDB  
- Frontend: HTML, CSS, JavaScript  
- Struktur folder: konvensional untuk CRUD berbasis file PHP

---

## 🚀 Cara Menjalankan (Setup)

Berikut langkah-langkah dasar untuk menjalankan aplikasi ini di lingkungan lokal:

1. Clone repositori ini:

   ```bash
   git clone https://github.com/bagusadesaputra/Sistem-Informasi-Stock-Barang.git
