# 📚 Panduan Lengkap Database PSAJ

## 🎯 Ringkasan

Anda telah mengatur database lengkap untuk sistem **Pusat Layanan Pengaduan & Konsultasi Siswa (PSAJ)** di SMKN 10 Surabaya dengan:

✅ **5 Tabel Database** dengan relasi lengkap  
✅ **2 Guru BK** dengan akun login  
✅ **10 Siswa** dari berbagai kelas  
✅ **10 Pengaduan** dengan berbagai status dan jenis  
✅ **12 Notifikasi** untuk siswa  
✅ **8 Percakapan Chat** guru-siswa  
✅ **Dokumentasi Lengkap** untuk setup dan referensi

---

## 📁 File-File yang Tersedia

### 1. 🗄️ `psaj_complete.sql`
**Untuk: Membuat dan mengisi database**

File SQL yang berisi:
- Struktur lengkap 5 tabel (guru_bk, siswa, pengaduan, notifikasi, chat)
- Data dummy yang sudah realistis dan lengkap
- Foreign key constraints untuk integritas data
- Auto-increment configuration

**Cara Pakai:**
- Import melalui phpMyAdmin, atau
- Run via command line: `mysql -u root < psaj_complete.sql`

---

### 2. 📋 `SETUP_DATABASE.md`
**Untuk: Panduan Setup Cepat (BACA INI DULU!)**

Berisi:
- 3 Cara mengimpor database (phpMyAdmin, CLI, PHP)
- Langkah-langkah detail dengan screenshot
- Checklist verifikasi
- Tips dan troubleshooting

**Kapan Baca:** Saat pertama kali setup database

---

### 3. 🔐 `AKUN_LOGIN.md`
**Untuk: Referensi Cepat Akun Login**

Berisi:
- 2 Akun Guru BK (username & password)
- 10 Akun Siswa (NISN & password)
- Testing scenarios
- URL navigasi cepat

**Kapan Baca:** Saat akan login dan testing

---

### 4. 📊 `STRUKTUR_DATABASE.md`
**Untuk: Detail Teknis Struktur Database**

Berisi:
- Entity Relationship Diagram (ERD)
- Detail setiap tabel (kolom, tipe, constraint)
- Penjelasan relasi antar tabel
- Alur data sistem
- Tips maintenance

**Kapan Baca:** Untuk development dan troubleshooting

---

### 5. 📖 `DOKUMENTASI_DATABASE.md`
**Untuk: Dokumentasi Lengkap (Referensi Komprehensif)**

Berisi:
- Cara membuat database (multiple methods)
- Daftar akun login lengkap
- Ringkasan struktur setiap tabel
- Penjelasan data dummy
- Alur sistem end-to-end

**Kapan Baca:** Untuk pemahaman menyeluruh

---

## 🚀 Quick Start (5 Menit)

### Step 1: Import Database (2 menit)
```bash
# Buka phpMyAdmin
http://localhost/phpmyadmin

# Import psaj_complete.sql
# Klik Import → Pilih File → Go
```

### Step 2: Cek Database (1 menit)
```
Database: psaj ✅
Tabel: guru_bk, siswa, pengaduan, notifikasi, chat ✅
Data: Ada di setiap tabel ✅
```

### Step 3: Test Login (2 menit)
```
Guru BK:  http://localhost/psaj/index.php
          Username: admin
          Password: admin123

Siswa:    http://localhost/psaj/siswa/index.php
          NISN: 2024001001
          Password: password123
```

---

## 📊 Data Summary

| Item | Jumlah | Status |
|------|--------|--------|
| **Guru BK** | 2 | Aktif |
| **Siswa** | 10 | Aktif |
| **Pengaduan** | 10 | Baru (2), Diproses (2), Selesai (6) |
| **Notifikasi** | 12 | Belum dibaca (2), Sudah dibaca (10) |
| **Chat** | 8 | Aktif & Historic |

---

## 🎯 Jenis Pengaduan (10 Contoh)

| No | Nama Siswa | Jenis | Status | Tanggapan |
|----|----|----|----|---|
| 1 | Andi Saputra | Bullying | Diproses | - |
| 2 | Siti Aisyah | Masalah Belajar | Selesai | Ada ✓ |
| 3 | Rizky Pratama | Konflik Teman | Selesai | Ada ✓ |
| 4 | Nur Azizah | Masalah Keluarga | Selesai | Ada ✓ |
| 5 | Budi Hermawan | Masalah Ekonomi | Diproses | - |
| 6 | Dewi Lestari | Masalah Kesehatan | Selesai | Ada ✓ |
| 7 | Arif Wiryanto | Bullying | Baru | - |
| 8 | Indah Permatasari | Masalah Belajar | Diproses | - |
| 9 | Fajar Mulyana | Lainnya | Selesai | Ada ✓ |
| 10 | Sinta Wahyuni | Masalah Belajar | Selesai | Ada ✓ |

---

## 🔍 Alur Penggunaan Sistem

### Untuk Developer:
1. Import database: `psaj_complete.sql`
2. Pelajari struktur: Baca `STRUKTUR_DATABASE.md`
3. Development dengan referensi: `DOKUMENTASI_DATABASE.md`

### Untuk Tester:
1. Setup database: Ikuti `SETUP_DATABASE.md`
2. Login dengan akun: Lihat `AKUN_LOGIN.md`
3. Test scenarios di dalam file tersebut

### Untuk End-User (Guru/Siswa):
1. Login: `AKUN_LOGIN.md`
2. Gunakan sistem sesuai panduan di setiap halaman

---

## 🔐 Akun Default

### 👨‍🏫 Guru BK (2)
```
1. admin / admin123
2. ahmad_bk / password123
```

### 👨‍🎓 Siswa (10)
```
NISN: 2024001001-2024001010
Password: password123 (semua sama)
```

---

## ⚠️ PENTING untuk Production

Sebelum go live, lakukan:

1. **Ubah Password:**
   ```sql
   UPDATE guru_bk SET password = PASSWORD('password_baru');
   UPDATE siswa SET password = PASSWORD('password_baru');
   ```

2. **Implementasikan Security:**
   - Gunakan `password_hash()` untuk password
   - Tambahkan CSRF token
   - Gunakan prepared statements
   - Implementasikan rate limiting

3. **Backup Database:**
   ```bash
   mysqldump -u root psaj > backup_psaj.sql
   ```

4. **Pertahankan Data:**
   - Jangan hapus data dummy (gunakan untuk training)
   - Buat database terpisah untuk production

---

## 📞 Troubleshooting

### ❌ Database tidak terimpor
- Cek MySQL service sudah running
- Cek file `psaj_complete.sql` ada di folder
- Lihat error message di phpMyAdmin

### ❌ Login gagal
- Cek username/password benar di `AKUN_LOGIN.md`
- Cek file `koneksi.php` konfigurasinya sesuai
- Cek database sudah ada tabelnya

### ❌ Data tidak lengkap
- Re-import file `psaj_complete.sql`
- Cek di phpMyAdmin apakah semua tabel ada dan punya data
- Jalankan command: `SELECT COUNT(*) FROM [nama_tabel];`

---

## 📚 Navigasi File

```
psaj/
├── psaj_complete.sql              ← File SQL untuk import
├── SETUP_DATABASE.md              ← Mulai dari sini!
├── AKUN_LOGIN.md                  ← Daftar akun
├── STRUKTUR_DATABASE.md           ← Detail teknis
├── DOKUMENTASI_DATABASE.md        ← Referensi lengkap
├── README.md                       ← File asli (original)
│
├── dashboard.php                  ← Halaman guru
├── index.php                       ← Login guru
│
└── siswa/
    ├── index.php                  ← Login siswa
    ├── dashboard.php              ← Halaman siswa
    └── ...
```

---

## ✅ Checklist Implementasi

- [ ] Database `psaj` berhasil dibuat
- [ ] 5 Tabel ada dan terisi data
- [ ] Login Guru BK: `admin/admin123` berfungsi
- [ ] Login Siswa: NISN `2024001001` berfungsi
- [ ] 10 Pengaduan visible di "Data Pengaduan"
- [ ] Chat dan notifikasi berfungsi
- [ ] Semua halaman dapat diakses
- [ ] Dokumentasi sudah dibaca

---

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Baca file dokumentasi yang relevan
2. Cek error message di browser (F12)
3. Cek log MySQL di phpMyAdmin

**Database siap untuk development, testing, dan training!** 🎉

---

**Last Updated:** April 13, 2026  
**Status:** ✅ Complete dan Ready to Use
