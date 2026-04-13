# 🎯 QUICK REFERENCE - Database PSAJ

## ⚡ 30-Detik Summary

```
✅ Database PSAJ sudah lengkap dengan:
   • 5 Tabel (guru_bk, siswa, pengaduan, notifikasi, chat)
   • 32 Data dummy record
   • 2 Akun guru BK
   • 10 Akun siswa
   • 10 Pengaduan dengan berbagai status

📁 File Utama:
   • psaj_complete.sql         → Database dumpt
   • SETUP_DATABASE.md         → Setup guide
   • AKUN_LOGIN.md             → Daftar akun
   • STRUKTUR_DATABASE.md      → Detail teknis
```

---

## 🚀 3-Langkah Import Database

### ✅ Cara 1: phpMyAdmin (MUDAH)
```
1. Buka: http://localhost/phpmyadmin
2. Klik: Import
3. Pilih: psaj_complete.sql
4. Klik: Go ✓
```

### ✅ Cara 2: Command Line
```bash
mysql -u root < psaj_complete.sql
```

### ✅ Cara 3: PHP Script
```php
// Buat file setup.php di folder psaj
// Jalankan: http://localhost/psaj/setup.php
```

---

## 🔐 Akun Login

### 👨‍🏫 Guru BK
```
Login URL: http://localhost/psaj/index.php

Akun 1 (Admin):
└─ Username: admin
└─ Password: admin123

Akun 2:
└─ Username: ahmad_bk
└─ Password: password123
```

### 👨‍🎓 Siswa
```
Login URL: http://localhost/psaj/siswa/index.php

Semua siswa:
└─ NISN: 2024001001 s/d 2024001010
└─ Password: password123

Contoh Login:
└─ NISN: 2024001001 (Andi Saputra)
└─ Password: password123
```

---

## 📊 Data Overview

```
┌─────────────────────────────────┐
│ GURU_BK (2 orang)               │
├─────────────────────────────────┤
│ • admin (Ibu Sri Handayani)     │
│ • ahmad_bk (Bapak Ahmad Wijaya) │
└─────────────────────────────────┘

┌─────────────────────────────────┐
│ SISWA (10 orang)                │
├─────────────────────────────────┤
│ • NISN 2024001001-2024001010    │
│ • Dari Kelas X, XI, XII          │
│ • Dari 5 Jurusan berbeda        │
└─────────────────────────────────┘

┌─────────────────────────────────┐
│ PENGADUAN (10)                  │
├─────────────────────────────────┤
│ • Status: Baru (2)              │
│ •         Diproses (2)          │
│ •         Selesai (6)           │
│ • Jenis: 7 kategori berbeda     │
└─────────────────────────────────┘

┌─────────────────────────────────┐
│ NOTIFIKASI (12)                 │
├─────────────────────────────────┤
│ • Belum dibaca: 2               │
│ • Sudah dibaca: 10              │
└─────────────────────────────────┘

┌─────────────────────────────────┐
│ CHAT (8 percakapan)             │
├─────────────────────────────────┤
│ • Guru ↔ Siswa                  │
│ • Belum dibaca & Sudah dibaca   │
└─────────────────────────────────┘
```

---

## 📁 File Dokumentasi

| File | Fungsi | Baca Saat |
|------|--------|----------|
| **SETUP_DATABASE.md** | Cara import database | Pertama kali |
| **AKUN_LOGIN.md** | Daftar akun & testing | Mau login |
| **STRUKTUR_DATABASE.md** | Detail tabel & relasi | Development |
| **DOKUMENTASI_DATABASE.md** | Referensi lengkap | Sebagai panduan |
| **INDEX_DOKUMENTASI.md** | Navigasi semua file | Ketika bingung |
| **psaj_complete.sql** | File database | Import ke MySQL |

---

## 🎯 Testing Checklist

- [ ] Import database berhasil
- [ ] Masuk ke phpMyAdmin → Database `psaj` ada
- [ ] Cek 5 tabel ada: guru_bk, siswa, pengaduan, notifikasi, chat
- [ ] Test login guru (admin/admin123)
- [ ] Test login siswa (2024001001/password123)
- [ ] Lihat dashboard guru
- [ ] Lihat dashboard siswa
- [ ] Lihat list pengaduan
- [ ] Lihat chat
- [ ] Lihat notifikasi

---

## 🎓 Skenario Testing

### Scenario 1: Guru melihat statistik
```
1. Login: admin / admin123
2. Dashboard tunjukkan:
   - Total: 25
   - Diproses: 10
   - Selesai: 12
   - Baru: 3
```

### Scenario 2: Guru lihat pengaduan
```
1. Klik "Data Pengaduan"
2. Lihat 10 pengaduan dengan berbagai status
3. Bisa klik detail untuk lihat isi
```

### Scenario 3: Guru beri tanggapan
```
1. Di Data Pengaduan, klik pengaduan
2. Scroll ke bawah
3. Isi form "Tanggapan"
4. Submit → Status berubah "selesai"
```

### Scenario 4: Siswa lihat riwayat
```
1. Login: 2024001001 / password123
2. Klik "Riwayat Pengaduan"
3. Lihat pengaduan yang pernah dibuat
4. Lihat status & tanggapan dari guru
```

### Scenario 5: Chat guru-siswa
```
1. Login sebagai guru atau siswa
2. Buka fitur Chat/Pesan
3. Kirim pesan
4. Balas pesan dari pihak lain
5. Lihat status dibaca
```

---

## 🔍 Verifikasi Database di phpMyAdmin

```sql
-- Jalankan query ini untuk cek data:

-- Hitung tabel
SELECT 
    (SELECT COUNT(*) FROM guru_bk) AS guru_bk,
    (SELECT COUNT(*) FROM siswa) AS siswa,
    (SELECT COUNT(*) FROM pengaduan) AS pengaduan,
    (SELECT COUNT(*) FROM notifikasi) AS notifikasi,
    (SELECT COUNT(*) FROM chat) AS chat;

-- Hasil yang diharapkan:
-- guru_bk: 2
-- siswa: 10
-- pengaduan: 10
-- notifikasi: 12
-- chat: 8
```

---

## 📊 Struktur Tabel Singkat

```
GURU_BK
├─ id_bk (PK)
├─ username (UQ)
├─ password
├─ nama
└─ email (UQ)

SISWA
├─ id_siswa (PK)
├─ nisn (UQ)
├─ password
├─ nama
└─ kelas

PENGADUAN
├─ id_pengaduan (PK)
├─ id_siswa (FK)
├─ id_bk (FK)
├─ jenis_pengaduan
├─ judul
├─ isi
├─ status
└─ tanggapan

NOTIFIKASI
├─ id_notif (PK)
├─ id_siswa (FK)
├─ pesan
├─ tipe
└─ status

CHAT
├─ id_chat (PK)
├─ id_siswa (FK)
├─ id_bk (FK)
├─ pengirim
├─ pesan
└─ dibaca
```

---

## ⚙️ Konfigurasi

### File koneksi.php (sudah benar):
```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "psaj";
```

### Jika berbeda, edit sesuai setup Anda:
- Host MySQL: biasanya `localhost`
- Username MySQL: biasanya `root`
- Password MySQL: kosong atau sesuai setting
- Database: `psaj`

---

## 🚨 Troubleshooting Cepat

| Masalah | Solusi |
|---------|--------|
| Import gagal | Cek MySQL running, file ada, permission ok |
| Login gagal | Cek koneksi.php benar, password sesuai, data ada |
| Page blank | Cek PHP error log, session aktif, koneksi db ok |
| Chart tidak muncul | Jalankan query untuk verifikasi data ada |

---

## 📞 Next Steps

1. **Import database:** Ikuti `SETUP_DATABASE.md`
2. **Test login:** Gunakan akun di `AKUN_LOGIN.md`
3. **Pelajari struktur:** Baca `STRUKTUR_DATABASE.md`
4. **Development:** Gunakan data ini sebagai referensi

---

## ✨ Fitur Yang Sudah Tersedia

✅ Database dengan 5 tabel terhubung  
✅ Data dummy realistis untuk semua tabel  
✅ 10 pengaduan dengan berbagai jenis & status  
✅ Chat history guru-siswa  
✅ Notifikasi untuk siswa  
✅ Dokumentasi lengkap  
✅ Akun testing siap pakai  

---

**Status: ✅ READY TO USE**

Mulai dari: `SETUP_DATABASE.md`  
Kembali ke index: `INDEX_DOKUMENTASI.md`
