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

## ⚡ Pilihan Metode Instalasi Aplikasi

Anda dapat memilih salah satu dari dua metode di bawah ini untuk mendapatkan berkas aplikasi (Source Code) sebelum melakukan konfigurasi web server:

---

### Opsi 1: Menggunakan Berkas ZIP Pre-Built (Siap Pakai & Instan)

Metode ini sangat disarankan untuk pelanggan umum karena berkas ZIP **sudah di-build** (sudah menyertakan folder `vendor/` dan aset frontend terkompilasi). Anda tidak perlu memasang Node.js/Composer untuk menjalankan aplikasi.

#### 1. Ekstraksi File ZIP
* Ekstrak berkas `tgx-culture.zip`.
* Pindahkan seluruh folder hasil ekstrak ke direktori server lokal Anda:
  * **Laragon**: `C:\laragon\www\tgx-culture`
  * **XAMPP**: `C:\xampp\htdocs\tgx-culture`

#### 2. Konfigurasi Database (.env)
* Buka folder project tersebut, cari berkas `.env` (Jika belum ada, ubah nama `.env.example` menjadi `.env`).
* Buka berkas `.env` menggunakan Notepad atau text editor lain.
* Buat database baru di `http://localhost/phpmyadmin` dengan nama: `tgx_culture`.
* Sesuaikan konfigurasi database Anda:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=tgx_culture
  DB_USERNAME=root
  DB_PASSWORD=
  ```
  *(Catatan: `APP_KEY` sudah terisi otomatis di dalam berkas `.env` bawaan ZIP).*

#### 3. Migrasi Database & Seeder
* Buka **Terminal** Laragon atau **Command Prompt / CMD** Windows.
* Masuk ke folder project Anda:
  * Laragon: `cd C:\laragon\www\tgx-culture`
  * XAMPP: `cd C:\xampp\htdocs\tgx-culture`
* Jalankan perintah berikut untuk mengisi database Anda dengan struktur tabel dan data bawaan:
  ```bash
  php artisan migrate --seed
  ```

---

### Opsi 2: Menggunakan Git Clone (Untuk Developer / Pengembangan)

Metode ini digunakan jika Anda ingin mengklon repositori Git secara langsung. Anda wajib menginstal **Composer**, **Node.js**, dan **Git** terlebih dahulu.

#### 1. Kloning Repositori
* Buka Command Prompt (CMD) atau Git Bash.
* Masuk ke folder web server Anda:
  * Laragon: `cd C:\laragon\www`
  * XAMPP: `cd C:\xampp\htdocs`
* Jalankan perintah clone:
  ```bash
  git clone <URL_REPOSITORI_GIT_ANDA> tgx-culture
  ```
* Masuk ke dalam direktori project:
  ```bash
  cd tgx-culture
  ```

#### 2. Instal Dependensi Backend & Frontend
* Jalankan perintah untuk mengunduh modul PHP:
  ```bash
  composer install
  ```
* Jalankan perintah untuk mengunduh modul Node.js (frontend):
  ```bash
  npm install
  ```

#### 3. Konfigurasi Environment & Database
* Salin berkas konfigurasi default:
  ```bash
  copy .env.example .env
  ```
* Buka berkas `.env` dengan Notepad.
* Buat database baru di `phpMyAdmin` bernama `tgx_culture`.
* Sesuaikan konfigurasi database Anda di `.env`:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=tgx_culture
  DB_USERNAME=root
  DB_PASSWORD=
  ```

#### 4. Generate Application Key & Migrasi
* Jalankan perintah untuk membuat kunci enkripsi Laravel:
  ```bash
  php artisan key:generate
  ```
* Jalankan perintah untuk migrasi tabel database dan mengisi data demo:
  ```bash
  php artisan migrate --seed
  ```

#### 5. Jalankan Aset Frontend (Development Mode)
* Jalankan perintah berikut untuk mengompilasi aset tampilan:
  ```bash
  npm run dev
  ```
  *(Atau jalankan `npm run build` untuk mengompilasi aset secara permanen untuk versi produksi).*

---

## 🌐 Konfigurasi Web Server & Document Root

Untuk menjalankan aplikasi tanpa perlu mengetikkan perintah `php artisan serve` di terminal, Anda harus mengarahkan Document Root web server ke folder **`public`** di dalam folder project `tgx-culture`.

### Opsi 1: Menggunakan Laragon (Sangat Mudah & Otomatis)
Laragon memiliki fitur *Auto Virtual Hosts* yang secara otomatis mendeteksi folder dan mengarahkan domain lokal ke folder `public`.
1. Pastikan folder project berada di `C:\laragon\www\tgx-culture`.
2. Buka aplikasi Laragon, lalu klik tombol **Start All**.
3. Laragon akan mendeteksi project dan membuat domain virtual secara otomatis (misalnya `http://tgx-culture.test`).
4. Anda bisa langsung membuka browser dan mengakses alamat tersebut: `http://tgx-culture.test`.
5. *(Opsional)* Jika ingin mengubah domain atau setelan lainnya, klik kanan pada area Laragon -> **Preferences** -> tab **Services & Ports** -> ubah bagian **Document Root** atau format **Hostname**.

### Opsi 2: Menggunakan XAMPP (Konfigurasi Manual Apache)
Secara bawaan, XAMPP mengarahkan localhost ke `C:\xampp\htdocs`. Anda harus mengubah Document Root Apache agar mengarah langsung ke folder `public` project agar routing Laravel berjalan dengan benar.

#### Cara A: Mengubah Document Root Global (Mengubah localhost utama)
1. Buka **XAMPP Control Panel**, lalu pastikan modul **Apache** dalam kondisi **Stop**.
2. Klik tombol **Config** di baris **Apache**, lalu pilih **Apache (httpd.conf)**.
3. Cari baris berikut (gunakan shortcut `Ctrl + F` untuk mencari kata `DocumentRoot`):
   ```apache
   DocumentRoot "C:/xampp/htdocs"
   <Directory "C:/xampp/htdocs">
   ```
4. Ubah kedua baris tersebut agar mengarah ke folder `/public` project:
   ```apache
   DocumentRoot "C:/xampp/htdocs/tgx-culture/public"
   <Directory "C:/xampp/htdocs/tgx-culture/public">
   ```
5. Simpan file `httpd.conf` tersebut (`Ctrl + S`).
6. Jalankan kembali modul Apache di XAMPP Control Panel (**Start**).
7. Buka browser Anda dan akses alamat: `http://localhost`. Aplikasi katalog budaya akan langsung terbuka.

#### Cara B: Menggunakan Virtual Host (Menggunakan domain kustom, misal http://tgx-culture.local)
1. Jalankan Notepad sebagai Administrator (**Run as Administrator**).
2. Buka file konfigurasi Virtual Host Apache yang berada di: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
3. Tambahkan konfigurasi berikut di bagian paling bawah file tersebut:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "C:/xampp/htdocs/tgx-culture/public"
       ServerName tgx-culture.local
       <Directory "C:/xampp/htdocs/tgx-culture/public">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
4. Simpan file tersebut.
5. Masih di Notepad dengan hak akses Administrator, buka file hosts Windows di: `C:\Windows\System32\drivers\etc\hosts`
6. Tambahkan baris berikut di bagian paling bawah file:
   ```hosts
   127.0.0.1 tgx-culture.local
   ```
7. Simpan file hosts.
8. Restart Apache di XAMPP Control Panel.
9. Buka browser Anda dan akses: `http://tgx-culture.local`.

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
   * Buat sebuah database baru dengan nama `tgx_culture`.

6. **Hubungkan Aplikasi ke Database**:
   * Buka folder aplikasi `tgx-culture` di file manager komputer Anda.
   * Cari file bernama `.env.example`, lalu ubah nama file tersebut menjadi `.env` (hapus tulisan `.example`-nya).
   * Buka file `.env` tersebut menggunakan Notepad atau text editor lain.
   * Cari baris konfigurasi database dan pastikan tulisannya seperti berikut:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=tgx_culture
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
   * Buat sebuah database baru bernama `tgx_culture`.

6. **Hubungkan Aplikasi ke Database**:
   * Cari file bernama `.env.example` di dalam folder `C:\xampp\htdocs\tgx-culture`.
   * Ubah nama file tersebut menjadi `.env`.
   * Buka file `.env` dengan Notepad, pastikan pengaturannya seperti di bawah ini, lalu simpan file:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=tgx_culture
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