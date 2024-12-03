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
├── /config                      # File konfigurasi
│ └── db.php                     # Pengaturan koneksi database
├── /public                      # File yang dapat diakses oleh web server
│ ├── index.php                  # Entry point, file utama yang memberi tampilan login dan menangani login
│ ├── register.php               # File yang akan menangani dan menampilkan proses registrasi user
│ ├── logout.php                 # File yang menangani proses logout user
│ ├── dashboard.php              # File yang akan menampilkan halaman utama yang akan dilihat user setelah login
│ ├── forgot-password.php        # File yang menangani dan menampilkan proses forgot password
│ ├── reset-password.php         # File yang menangani login
│ └── /assets                    # File CSS, JS, dan gambar
│ │ ├── /css                     # CSS file
│ │ ├── /js                      # JavaScript file
│ │ └── /img                     # Gambar dan media
├── /src                         # Folder untuk logika aplikasi
│ ├── /Controller                # Logika aplikasi
│ │ └── AuthController.php       # Menangani login dan pendaftaran
│ ├── /Model                     # Interaksi dengan database
│ │ └── UserModel.php            # Query database 
│ └── /Service                   # Proses tambahan seperti MFA dan throttling
│ │ ├── AuthService.php
│ │ ├── LoginAttemptService.php
│ │ └── LogService.php
├── /vendor                      
├── .env                    
├── composer.json     
└── composer.lock      
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
4. Kemudian akses aplikasi melalui http://localhost:8000 atau sesuaikan dengan konfigurasi yang dilakukan.

---

## 🤝 Kontribusi
Kontribusi sangat terbuka! Silakan fork repository ini, buat fitur baru, atau perbaikan bug, lalu ajukan pull request.
