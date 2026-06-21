# Panduan Instalasi Aplikasi - TGX Culture (Via ZIP Pre-Built)

Dokumen ini menjelaskan langkah-langkah instalasi aplikasi **TGX Culture (Katalog Budaya Kabupaten Trenggalek)** menggunakan file ZIP siap pakai (pre-built). Metode ini sangat praktis karena semua dependensi sistem (`vendor/` dan aset tampilan terkompilasi) sudah terpasang. Anda tidak perlu mengunduh Composer atau Node.js.

---

## 📋 Prasyarat Sistem
Sebelum memulai, pastikan komputer Anda memiliki salah satu dari server lokal berikut:
1. **Laragon (Sangat Direkomendasikan)**: [laragon.org](https://laragon.org/)
2. **XAMPP**: [apachefriends.org](https://www.apachefriends.org/)

---

## ⚡ Langkah 1: Ekstraksi & Penempatan Folder Aplikasi

1. Ekstrak file ZIP `tgx-culture.zip` yang telah Anda terima.
2. Pindahkan seluruh folder hasil ekstrak (`tgx-culture`) ke direktori server lokal Anda:
   * Jika menggunakan **Laragon**: Pindahkan ke `C:\laragon\www\tgx-culture`
   * Jika menggunakan **XAMPP**: Pindahkan ke `C:\xampp\htdocs\tgx-culture`

---

## 💾 Langkah 2: Konfigurasi Database

1. Buka browser Anda (seperti Chrome), lalu akses halaman phpMyAdmin di: **`http://localhost/phpmyadmin`**
2. Buat database baru bernama **`tgx_culture`**.
3. Buka folder project aplikasi Anda, lalu cari file bernama **`.env`** (jika belum ada, ubah nama file `.env.example` menjadi `.env`).
4. Buka file `.env` tersebut menggunakan Notepad atau aplikasi editor teks lainnya.
5. Cari pengaturan database dan pastikan konfigurasinya sesuai dengan berikut ini:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tgx_culture
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Catatan: Kunci keamanan `APP_KEY` sudah terisi secara otomatis di berkas `.env` bawaan ZIP).*
6. Simpan file `.env` tersebut.

---

## 🛠️ Langkah 3: Migrasi Database & Seeder (Isi Data Awal)

1. Buka **Terminal** (jika menggunakan Laragon) atau **Command Prompt / CMD** Windows (jika menggunakan XAMPP).
2. Masuk ke folder utama project aplikasi Anda dengan mengetikkan perintah berikut lalu tekan **Enter**:
   * **Laragon**:
     ```bash
     cd C:\laragon\www\tgx-culture
     ```
   * **XAMPP**:
     ```bash
     cd C:\xampp\htdocs\tgx-culture
     ```
3. Jalankan perintah di bawah ini untuk membuat tabel database dan mengisi data demo secara otomatis:
   ```bash
   php artisan migrate --seed
   ```

---

## 🌐 Langkah 4: Konfigurasi Web Server & Document Root

Agar aplikasi Laravel dapat berjalan dengan benar, web server harus diarahkan langsung ke folder **`public`** di dalam folder project Anda. Ikuti petunjuk sesuai server yang Anda gunakan:

### Opsi A: Menggunakan Laragon (Otomatis & Sangat Mudah)
Laragon memiliki fitur pembuatan domain virtual otomatis (*Auto Virtual Hosts*).
1. Pastikan folder project Anda berada di `C:\laragon\www\tgx-culture`.
2. Buka aplikasi **Laragon**, lalu klik tombol **Start All**.
3. Laragon akan otomatis membuat domain virtual baru, secara umum bernama: `http://tgx-culture.test`
4. Buka browser Anda dan akses alamat tersebut. Aplikasi sudah siap digunakan!

---

### Opsi B: Menggunakan XAMPP (Konfigurasi Manual Apache)
Secara bawaan, XAMPP mengarah ke `C:\xampp\htdocs`. Anda harus mengarahkan Document Root Apache ke folder `/public` project.

#### Cara 1: Mengubah Document Root Global (Menggunakan localhost utama)
1. Buka **XAMPP Control Panel**, lalu pastikan modul **Apache** dalam kondisi **Stop**.
2. Klik tombol **Config** di baris **Apache**, lalu pilih **Apache (httpd.conf)**.
3. Cari baris berikut (gunakan pencarian `Ctrl + F` dengan kata kunci `DocumentRoot`):
   ```apache
   DocumentRoot "C:/xampp/htdocs"
   <Directory "C:/xampp/htdocs">
   ```
4. Ubah kedua baris tersebut menjadi:
   ```apache
   DocumentRoot "C:/xampp/htdocs/tgx-culture/public"
   <Directory "C:/xampp/htdocs/tgx-culture/public">
   ```
5. Simpan file tersebut (`Ctrl + S`).
6. Jalankan kembali modul Apache di XAMPP Control Panel (**Start**).
7. Buka browser Anda dan akses alamat: `http://localhost`.

#### Cara 2: Menggunakan Virtual Host (Menggunakan domain kustom, misal http://tgx-culture.local)
1. Buka aplikasi Notepad dengan hak akses Administrator (**Run as Administrator**).
2. Buka berkas konfigurasi Virtual Host Apache di: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
3. Tambahkan konfigurasi berikut di bagian paling bawah file:
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
5. Masih di Notepad dengan akses Administrator, buka berkas hosts Windows di: `C:\Windows\System32\drivers\etc\hosts`
6. Tambahkan baris berikut di bagian paling bawah:
   ```hosts
   127.0.0.1 tgx-culture.local
   ```
7. Simpan file hosts.
8. Restart Apache di XAMPP Control Panel (klik **Stop** lalu **Start**).
9. Buka browser Anda dan akses: `http://tgx-culture.local`.

---

## 🔑 Kredensial Akun Login Demo (Bawaan Seeder)

Setelah berhasil masuk ke halaman login, Anda dapat menggunakan akun demo berikut untuk mencoba sistem:

| Hak Akses / Role | Username | Password |
| :--- | :--- | :--- |
| **Administrator (Admin)** | `superadmin` | `password` |
| **User (User Biasa)** | `user` | `password` |
