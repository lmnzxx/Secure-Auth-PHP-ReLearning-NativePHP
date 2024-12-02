# Secure-Auth-PHP-ReLearning-NativePHP

Repository ini berisi proyek pengembangan sistem autentikasi berbasis PHP native, yang dirancang untuk mempelajari kembali konsep dasar pengembangan aplikasi dengan struktur folder yang terorganisir. Proyek ini bertujuan untuk menerapkan praktik terbaik dalam pemisahan logika aplikasi, manajemen keamanan, dan modularitas kode.

---

## 📌 Fitur Utama
- **Modularitas Kode**  
  Pemisahan antara *Controller*, *Model*, dan *Service* untuk meningkatkan keterbacaan dan skalabilitas.
  
- **Keamanan**  
  Implementasi dasar fitur keamanan seperti autentikasi pengguna dan perlindungan data.

- **Struktur Direktori Terorganisir**
```teks
/secure-auth
│ ├── /public                # File yang dapat diakses oleh web server
│ ├── /assets                # File CSS, JS, dan gambar
│ │ ├── /css                 # CSS file
│ │ ├── /js                  # JavaScript file
│ │ └── /img                 # Gambar dan media
│ ├── index.php              # Entry point, file utama yang menangani login
│ └── login.php              # Halaman login
│ ├── /src                   # Folder untuk logika aplikasi
│ ├── /Controller            # Logika aplikasi
│ │ └── AuthController.php   # Menangani login dan pendaftaran
│ ├── /Model                 # Interaksi dengan database
│ │ └── UserModel.php        # Query database (misal login)
│ └── /Service               # Proses tambahan seperti MFA dan throttling
│ └── AuthService.php
│ ├── /config                # File konfigurasi
│ └── database.php           # Pengaturan koneksi database
│ └── /vendor                # Dependensi (Composer)
```

---

## 🎯 Tujuan Proyek
- Membangun kembali pemahaman dasar tentang pengembangan PHP native.
- Melatih strukturisasi kode yang rapi dan sesuai standar.
- Menyediakan *starter template* untuk proyek autentikasi sederhana.

---

## 🚀 Cara Menjalankan
1. Clone repository ini:
 ```bash
 git clone https://github.com/lmnzxx/Secure-Auth-PHP-ReLearning-NativePHP.git
 ```
 ```bash
 cd Secure-Auth-PHP-ReLearning-NativePHP
 ```
2. Konfigurasi database pada file /config/database.php.
3. Jalankan server PHP lokal, bisa dengan menggunakan developing environment seperti Laragon, XAMPP maupun MAMP, bisa juga dengan menggunakan native PHP dengan cara
   ```bash
   php -S localhost:8000 -t public
   ```
4. Kemudian akses aplikasi melalui http://localhost:8000.

---

## 🤝 Kontribusi
Kontribusi sangat terbuka! Silakan fork repository ini, buat fitur baru, atau perbaikan bug, lalu ajukan pull request.
