# TGX Culture - Katalog Budaya Kabupaten Trenggalek

Aplikasi katalog warisan budaya Kabupaten Trenggalek berbasis web yang memfasilitasi pelestarian data warisan adat istiadat, manuskrip, ritus, seni, dan bahasa lokal. Sistem ini dilengkapi otorisasi role untuk Administrator dan User.

---

## Struktur Folder

```
resources/views/
├── admin/                  # Halaman Khusus Admin
│   ├── dashboard.blade.php # Dashboard Ringkasan Admin
│   ├── kategori/           # CRUD Kategori Budaya (Dinamis + Upload Gambar)
│   │   └── index.blade.php  
│   └── user/               # CRUD Pengguna (Dinamis)
│       └── index.blade.php  
│
├── katalog/                # SHARED VIEW (Manajemen Katalog Bersama Admin & User)
│   ├── index.blade.php     # Daftar katalog (milik user yang login)
│   ├── create.blade.php    # Form tambah katalog baru (Halaman mandiri)
│   ├── edit.blade.php      # Form ubah katalog (Halaman mandiri)
│   └── show.blade.php      # Halaman detail katalog budaya
│
├── landing/                # Halaman Publik (Landing Page)
│   ├── index.blade.php     # Landing Page Utama (Grid Kategori)
│   ├── jelajah.blade.php   # Cari & filter katalog budaya untuk pengunjung umum
│   └── tentang.blade.php   # Informasi Dinas Kebudayaan & Pariwisata Trenggalek
│
├── auth/                   # Autentikasi
│   └── login.blade.php     # Halaman Masuk
│
└── layouts/                # Master Template
    ├── dashboard.blade.php # Layout utama untuk Admin & User
    └── public.blade.php    # Layout utama untuk Publik
```

---

## Panduan Instalasi Aplikasi (Untuk Pemula / Non-Developer)

Sebelum memulai, pastikan komputer Anda sudah memiliki beberapa aplikasi pendukung berikut. Jika belum, silakan unduh dan pasang terlebih dahulu:

### 📋 Prasyarat Aplikasi (Wajib Terinstal)
1. **Node.js**: Berfungsi untuk memproses tampilan antarmuka aplikasi.
   * *Unduh di*: [nodejs.org](https://nodejs.org/) (Pilih versi LTS/terbaru yang disarankan).
2. **Composer**: Berfungsi untuk mengunduh mesin utama aplikasi Laravel.
   * *Unduh di*: [getcomposer.org](https://getcomposer.org/) (Ikuti petunjuk instalasi untuk Windows).
3. **Local Server (Pilih salah satu: Laragon atau XAMPP)**:
   * **Laragon (Sangat Direkomendasikan)**: Lebih mudah digunakan dan otomatis mendeteksi database. Unduh di [laragon.org](https://laragon.org/).
   * **XAMPP**: Alternatif server lokal yang populer. Unduh di [apachefriends.org](https://www.apachefriends.org/).

---

### Opsi A: Instalasi Menggunakan Laragon (Direkomendasikan)

Ikuti langkah-langkah mudah berikut ini jika Anda menggunakan **Laragon**:

1. **Pindahkan Folder Aplikasi**:
   * Salin atau pindahkan folder folder project `tgx-culture` ini ke dalam folder utama Laragon di komputer Anda, biasanya terletak di:
     `C:\laragon\www\tgx-culture`

2. **Jalankan Laragon**:
   * Buka aplikasi **Laragon**.
   * Klik tombol **Start All** untuk menyalakan server dan database MySQL.

3. **Buka Terminal Laragon**:
   * Klik kanan di area mana saja di dalam aplikasi Laragon.
   * Arahkan kursor ke **Tools**, lalu klik **Terminal**.
   * Di dalam layar hitam terminal yang muncul, masuk ke folder aplikasi dengan mengetikkan perintah berikut lalu tekan **Enter**:
     ```bash
     cd C:\laragon\www\tgx-culture
     ```

4. **Unduh Berkas Pendukung Aplikasi**:
   * Ketik perintah di bawah ini untuk mengunduh modul sistem backend, lalu tekan **Enter** dan tunggu hingga selesai:
     ```bash
     composer install
     ```
   * Setelah selesai, ketik perintah berikut untuk mengunduh modul tampilan frontend, lalu tekan **Enter** dan tunggu hingga selesai:
     ```bash
     npm install
     ```

5. **Buat Database Baru**:
   * Buka web browser Anda (seperti Google Chrome), lalu akses alamat: `http://localhost/phpmyadmin`
   * Buat sebuah database baru dengan nama `tgx-culture`.

6. **Hubungkan Aplikasi ke Database**:
   * Buka folder aplikasi `tgx-culture` di file manager komputer Anda.
   * Cari file bernama `.env.example`, lalu ubah nama file tersebut menjadi `.env` (hapus tulisan `.example`-nya).
   * Buka file `.env` tersebut menggunakan Notepad atau text editor lain.
   * Cari baris konfigurasi database dan pastikan tulisannya seperti berikut:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=tgx-culture
     DB_USERNAME=root
     DB_PASSWORD=
     ```
   * Simpan file tersebut setelah selesai mengedit.

7. **Menyiapkan Kunci Aplikasi dan Data Awal**:
   * Kembali ke jendela terminal Laragon Anda.
   * Jalankan perintah ini untuk membuat kunci keamanan aplikasi:
     ```bash
     php artisan key:generate
     ```
   * Jalankan perintah ini untuk mengisi database dengan tabel dan akun demo bawaan:
     ```bash
     php artisan migrate:fresh --seed
     ```

8. **Menjalankan Aplikasi**:
   * Jalankan perintah berikut untuk mengaktifkan server aplikasi:
     ```bash
     php artisan serve
     ```
   * Buka jendela terminal Laragon baru (Klik kanan Laragon -> Tools -> Terminal), lalu ketikkan perintah berikut untuk menjalankan tampilan aplikasi:
     ```bash
     npm run dev
     ```
   * Sekarang, buka web browser Anda dan ketikkan alamat: `http://127.0.0.1:8000`
   * Aplikasi Anda sudah siap digunakan!

---

### Opsi B: Instalasi Menggunakan XAMPP

Ikuti langkah-langkah berikut ini jika Anda menggunakan **XAMPP**:

1. **Pindahkan Folder Aplikasi**:
   * Salin atau pindahkan folder folder project `tgx-culture` ini ke dalam folder `htdocs` XAMPP Anda, biasanya terletak di:
     `C:\xampp\htdocs\tgx-culture`

2. **Jalankan XAMPP**:
   * Buka **XAMPP Control Panel**.
   * Klik tombol **Start** pada bagian **Apache** dan **MySQL** hingga indikatornya berwarna hijau.

3. **Buka Command Prompt (CMD) Windows**:
   * Tekan tombol Windows di keyboard Anda, ketik `cmd`, lalu tekan **Enter**.
   * Masuk ke folder aplikasi dengan mengetikkan perintah berikut lalu tekan **Enter**:
     ```cmd
     cd C:\xampp\htdocs\tgx-culture
     ```

4. **Unduh Berkas Pendukung Aplikasi**:
   * Ketik perintah di bawah ini untuk mengunduh modul backend, lalu tekan **Enter** dan tunggu hingga selesai:
     ```bash
     composer install
     ```
   * Setelah selesai, ketik perintah berikut untuk mengunduh modul tampilan frontend, lalu tekan **Enter** dan tunggu hingga selesai:
     ```bash
     npm install
     ```

5. **Buat Database Baru**:
   * Buka web browser Anda, lalu akses alamat: `http://localhost/phpmyadmin`
   * Buat sebuah database baru bernama `tgx-culture`.

6. **Hubungkan Aplikasi ke Database**:
   * Cari file bernama `.env.example` di dalam folder `C:\xampp\htdocs\tgx-culture`.
   * Ubah nama file tersebut menjadi `.env`.
   * Buka file `.env` dengan Notepad, pastikan pengaturannya seperti di bawah ini, lalu simpan file:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=tgx-culture
     DB_USERNAME=root
     DB_PASSWORD=
     ```

7. **Menyiapkan Kunci Aplikasi dan Data Awal**:
   * Kembali ke Command Prompt (CMD) Anda.
   * Jalankan perintah ini untuk membuat kunci keamanan aplikasi:
     ```bash
     php artisan key:generate
     ```
   * Jalankan perintah ini untuk mengisi database dengan struktur tabel dan data demo awal:
     ```bash
     php artisan migrate:fresh --seed
     ```

8. **Menjalankan Aplikasi**:
   * Jalankan perintah berikut di CMD untuk mengaktifkan server:
     ```bash
     php artisan serve
     ```
   * Buka jendela Command Prompt (CMD) baru lagi, masuk kembali ke folder aplikasi (`cd C:\xampp\htdocs\tgx-culture`), kemudian jalankan perintah pendukung tampilan:
     ```bash
     npm run dev
     ```
   * Sekarang, buka web browser Anda dan ketikkan alamat: `http://127.0.0.1:8000`
   * Aplikasi Anda sudah siap digunakan!

---

## Panduan Penggunaan Aplikasi

### Kredensial Akun Demo (Default Seeder)

| Hak Akses / Role | Username | Password |
| :--- | :--- | :--- |
| **Administrator (Admin)** | `superadmin` | `password` |
| **User (User Biasa)** | `user` | `password` |

---

### Fitur Pengguna Umum (Publik / Tamu)
- **Beranda (Landing)**: Melihat daftar kategori budaya Kabupaten Trenggalek yang disajikan dalam bentuk grid kartu yang estetik. Jika gambar kategori ada di server lokal, gambar tersebut akan tampil; jika tidak, sistem secara dinamis menampilkan gambar beresolusi tinggi dari internet (Unsplash).
- **Cari Kategori**: Mencari kategori budaya secara real-time pada beranda menggunakan kolom pencarian.
- **Jelajah Katalog**: Mencari koleksi warisan budaya dengan filter pencarian kata kunci dan drop-down pilihan kategori secara responsif.

---

### Fitur Administrator (Admin - Akun: `superadmin`)
- **Dashboard Ringkasan**: Melihat statistik total kategori, katalog budaya, dan pengguna sistem terdaftar.
- **CRUD Kategori Budaya**:
  - Mengelola data kategori (Tambah, Ubah, Hapus).
  - Unggah gambar secara langsung ke folder publik tanpa perlu symlink storage.
  - Gambar lama di disk akan dihapus secara otomatis jika diperbarui atau dihapus.
- **CRUD Pengguna (User)**:
  - Mengelola user pengelola data katalog (Tambah, Ubah, Hapus).
  - Dilengkapi fitur pengaman proteksi akun aktif diri sendiri dan akun `superadmin` agar tidak terhapus.
- **CRUD Katalog Budaya**:
  - Membaca, menambah, mengubah, dan menghapus katalog budaya yang dikelola sendiri.

---

### Fitur User Biasa (User - Akun: `user`)
- **Dashboard Selamat Datang**: Menyajikan informasi perkenalan dan statistik data yang dikelola.
- **CRUD Katalog Budaya (Halaman Mandiri)**:
  - Mengakses halaman **Manajemen Katalog** yang hanya menampilkan katalog milik user bersangkutan.
  - Menambahkan katalog baru, memperbarui metadata, mengunggah gambar katalog, melihat detail katalog di halaman terdedikasi, serta menghapus katalog miliknya sendiri.