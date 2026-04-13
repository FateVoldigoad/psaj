# 🔐 Daftar Akun Login PSAJ

## 👨‍🏫 Akun Guru BK (Dashboard Guru)

**Halaman Login:** `http://localhost/psaj/index.php`

### Guru 1 (Admin)
```
Username/Email: admin
Password:       admin123
Nama:          Ibu Sri Handayani
Email:         sri.bk@smkn10surabaya.sch.id
No Telp:       081234567890
```

### Guru 2
```
Username:      ahmad_bk
Password:      password123
Nama:          Bapak Ahmad Wijaya
Email:         ahmad.bk@smkn10surabaya.sch.id
No Telp:       081234567891
```

---

## 👨‍🎓 Akun Siswa (Dashboard Siswa)

**Halaman Login:** `http://localhost/psaj/siswa/index.php`

| # | Nama | NISN | Password | Kelas | Jurusan |
|---|------|------|----------|-------|---------|
| 1 | Andi Saputra | 2024001001 | password123 | XII RPL 1 | Rekayasa Perangkat Lunak |
| 2 | Siti Aisyah | 2024001002 | password123 | XII AKL 2 | Akuntansi Keuangan Lembaga |
| 3 | Rizky Pratama | 2024001003 | password123 | XI RPL 1 | Rekayasa Perangkat Lunak |
| 4 | Nur Azizah | 2024001004 | password123 | XII TKJ 1 | Teknik Komputer dan Jaringan |
| 5 | Budi Hermawan | 2024001005 | password123 | XI AKL 1 | Akuntansi Keuangan Lembaga |
| 6 | Dewi Lestari | 2024001006 | password123 | X TMAS | Teknik Mesin Otomotik Servis |
| 7 | Arif Wiryanto | 2024001007 | password123 | XII RPL 2 | Rekayasa Perangkat Lunak |
| 8 | Indah Permatasari | 2024001008 | password123 | XI TKJ 1 | Teknik Komputer dan Jaringan |
| 9 | Fajar Mulyana | 2024001009 | password123 | XII TMAS 1 | Teknik Mesin Otomotik Servis |
| 10 | Sinta Wahyuni | 2024001010 | password123 | X AKL | Akuntansi Keuangan Lembaga |

---

## 📌 Catatan Penting

- **Username Siswa:** Login menggunakan NISN (bukan nama)
- **Password Default:** `password123` untuk semua siswa
- **Password Guru:** Berbeda antara guru satu dengan yang lain
- **Keamanan:** JANGAN gunakan password ini di production!
- **Database:** Sudah include 10 pengaduan dengan berbagai status dan jenis

---

## 🎯 Testing Scenarios

### Skenario 1: Login Guru & Lihat Pengaduan
1. Login sebagai `admin` / `admin123`
2. Di Dashboard, lihat kartu statistik (Total: 25, Diproses: 10, Selesai: 12, Baru: 3)
3. Klik "Data Pengaduan" untuk melihat detail
4. Bisa memberikan tanggapan pada pengaduan

### Skenario 2: Login Siswa & Buat Pengaduan
1. Login sebagai siswa (NISN: `2024001001`)
2. Di Dashboard, klik "Pengaduan Laporan"
3. Isi form pengaduan dan kirim
4. Pengaduan tersimpan dengan status "Baru"
5. Siswa bisa lihat di "Riwayat"

### Skenario 3: Chat Guru-Siswa
1. Login sebagai guru
2. Klik "Chat" atau "Pesan Masuk"
3. Lihat daftar percakapan dengan siswa
4. Bisa mengirim dan menerima pesan

---

## 📊 Statistik Data

- **Guru BK:** 2 orang
- **Siswa:** 10 orang (dari berbagai kelas)
- **Pengaduan Total:** 10 (Status: 2 Baru, 2 Diproses, 6 Selesai)
- **Chat Conversations:** 8 percakapan aktif
- **Notifikasi:** 12 notifikasi untuk siswa

---

## 🔗 Navigasi Cepat

### Dashboard Guru:
- Login: `http://localhost/psaj/index.php`
- Dashboard: `http://localhost/psaj/dashboard.php`
- Data Pengaduan: `http://localhost/psaj/data_pengaduan.php`
- Riwayat: `http://localhost/psaj/riwayat_pengaduan.php`
- Pesan Masuk: `http://localhost/psaj/pesan_masuk.php`
- Pengaturan: `http://localhost/psaj/pengaturan.php`

### Dashboard Siswa:
- Login: `http://localhost/psaj/siswa/index.php`
- Dashboard: `http://localhost/psaj/siswa/dashboard.php`
- Pengaduan: `http://localhost/psaj/siswa/pengaduan.php`
- Dashboard Siswa Alt: `http://localhost/psaj/siswa/dashboard.php`
- Curhat Anonimo: `http://localhost/psaj/siswa/curhat.php`

---

**Semua akun sudah aktif dan siap digunakan!** 🎉

Untuk import database, lihat: `SETUP_DATABASE.md`
