# 🚀 Portfolio Website dengan Admin Panel

Website portofolio elegan dan dinamis dengan sistem admin panel untuk mengelola konten.

## ✨ Fitur

### Bagian Publik

- 🎨 Desain modern dan responsif
- 📱 Mobile-friendly interface
- 🎯 Smooth scrolling antar section
- ✨ Animasi halus dan interaktif
- 📊 Menampilkan profile, skills, projects, dan kontak

### Bagian Admin

- 🔐 Sistem login aman dengan password hashing
- 👤 Edit profil lengkap (nama, bio, social media)
- 📚 Kelola skills dengan kategori
- 🚀 Tambah/edit/hapus projects
- 💾 Data tersimpan di database MySQL

## 📁 Struktur Folder

```
portfolio-app/
├── index.php                 # Halaman publik utama
├── config/
│   ├── database.php         # Konfigurasi database
│   └── functions.php        # Fungsi-fungsi aplikasi
├── admin/
│   ├── login.php            # Halaman login
│   ├── dashboard.php        # Dashboard admin
│   ├── profile.php          # Edit profil
│   ├── projects.php         # Kelola projects
│   ├── add-project.php      # Tambah project
│   ├── edit-project.php     # Edit project
│   ├── skills.php           # Kelola skills
│   └── logout.php           # Logout
├── assets/
│   ├── css/                 # File CSS (jika diperlukan)
│   ├── js/                  # File JavaScript (jika diperlukan)
│   └── images/              # Folder untuk gambar
└── public/                  # Folder untuk file publik
```

## 🚀 Cara Menggunakan dengan Laragon

### 1. Setup Laragon

- Buka Laragon
- Klik "Start All" atau pastikan Apache dan MySQL sudah running

### 2. Copy Folder Project

- Copy folder `portfolio-app` ke `C:\laragon\www\`
- Folder akan menjadi: `C:\laragon\www\portfolio-app`

### 3. Akses Website

- **Halaman Publik**: http://localhost/portfolio-app
- **Login Admin**: http://localhost/portfolio-app/admin/login.php

### 4. Login Credentials (Default)

```
Username: admin
Password: admin123
```

⚠️ **PENTING**: Ubah password default setelah login pertama kali!

## 📝 Setup Database

Database akan dibuat otomatis saat Anda mengakses website untuk pertama kalinya.

Tabel yang dibuat:

- **users** - Akun admin
- **profile** - Data profil
- **skills** - Daftar skills
- **projects** - Daftar projects

## 💻 Fitur Admin Panel

### Dashboard

- Overview jumlah projects dan skills
- Informasi profil singkat
- Preview project terbaru

### Edit Profil

- Nama lengkap
- Posisi/Title
- Bio/Deskripsi
- Email, Phone, Lokasi
- Social Media Links (GitHub, LinkedIn, Twitter)

### Kelola Skills

- Tambah skill dengan kategori (Backend, Frontend, Database, DevOps, Tools)
- Set level (Beginner, Intermediate, Advanced, Expert)
- Hapus skill

### Kelola Projects

- Tambah project baru
- Edit detail project
- Hapus project
- Lihat list semua projects

## 🎨 Customization

### Mengubah Warna

Edit file `assets/css/style.css` atau langsung di `index.php` dan file admin:

```css
/* Warna utama */
#667eea (ungu muda)
#764ba2 (ungu gelap)

/* Ubah dengan warna favorit Anda */
```

### Menambah Skills/Projects

1. Login ke admin panel
2. Pergi ke halaman Skills atau Projects
3. Isi form dan klik tombol Tambah

## 🔒 Security Tips

1. ✅ Ubah password admin setelah setup
2. ✅ Jangan share credentials
3. ✅ Backup database secara berkala
4. ✅ Update PHP dan MySQL ke versi terbaru

## 📱 Responsive Design

Website sudah dioptimalkan untuk:

- 📱 Mobile (320px - 768px)
- 💻 Tablet (768px - 1024px)
- 🖥️ Desktop (1024px+)

## 🆘 Troubleshooting

### Database Connection Error

- Pastikan MySQL sudah running di Laragon
- Cek username dan password di `config/database.php`

### Admin Panel Blank

- Clear browser cache (Ctrl + Shift + Delete)
- Refresh halaman

### Gambar Project Tidak Muncul

- Gunakan URL gambar yang valid (https)
- Atau upload gambar ke folder `assets/images/`

## 📞 Support

Jika ada pertanyaan atau error, cek:

1. Browser Developer Tools (F12) - Console tab
2. Error log di Laragon
3. Check PHP version compatibility

## 📄 License

Portfolio ini bebas digunakan untuk keperluan pribadi dan komersial.

---

**Selamat! Website portofolio Anda siap digunakan! 🎉**
