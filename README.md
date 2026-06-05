# Struktur Folder

```
resources/views/
resources/views/
├── admin/                  # Halaman Khusus Admin
│   ├── dashboard.blade.php
│   ├── kategori/           # Manajemen Kategori Budaya
│   │   └── index.blade.php  
│   └── user/               # Manajemen Pengguna
│       ├── index.blade.php  
│       └── edit.blade.php
│
├── user/                   # Halaman Khusus User (Kontributor)
│   └── dashboard.blade.php
│
├── katalog/                # SHARD VIEW (Halaman Katalog yang Dipakai Bersama)
│   ├── index.blade.php     # Tampilan list katalog (Admin & User melihat ini)
│   ├── create.blade.php    # Form tambah katalog
│   ├── edit.blade.php      # Form edit katalog
│   └── show.blade.php      # Detail internal katalog
│
├── landing/                # Halaman Publik (Landing Page)
│   ├── index.blade.php     # Landing Page Utama
│   ├── jelajah.blade.php   # Tampilan katalog untuk pengunjung umum
│   └── detail.blade.php    # Detail budaya untuk pengunjung umum
│
├── auth/                   # Autentikasi
│   ├── login.blade.php
│   └── register.blade.php
│
└── layouts/                # Master Template
    ├── dashboard.blade.php # Satu Layout Utama untuk Dashboard (Admin & User)
    └── public.blade.php    # Layout Navbar + Footer untuk Umum
```