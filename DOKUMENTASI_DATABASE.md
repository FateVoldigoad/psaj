# Dokumentasi Database PSAJ - Pusat Layanan Pengaduan & Konsultasi Siswa
**SMKN 10 Surabaya**

---

## 📋 Daftar Isi
1. [Cara Membuat Database](#cara-membuat-database)
2. [Akun Login](#akun-login)
3. [Struktur Database](#struktur-database)
4. [Data Dummy](#data-dummy)
5. [Alur Sistem](#alur-sistem)

---

## 🔧 Cara Membuat Database

### Langkah 1: Buka phpMyAdmin
- Akses `http://localhost/phpmyadmin`
- Login dengan username: `root` (password kosong)

### Langkah 2: Import File SQL
1. Klik menu **Import**
2. Pilih file `psaj_complete.sql` dari folder proyek
3. Klik **Go** untuk mengimpor database

### Alternatif: Gunakan Command Line
```bash
mysql -u root < psaj_complete.sql
```

---

## 👤 Akun Login

### Akun Guru BK (Dashboard Guru)

| Peran | Email | Username | Password | Halaman |
|-------|-------|----------|----------|---------|
| Guru BK 1 | sri.bk@smkn10surabaya.sch.id | **admin** | **admin123** | `index.php` |
| Guru BK 2 | ahmad.bk@smkn10surabaya.sch.id | **ahmad_bk** | **password123** | `index.php` |

**Fitur Guru:**
- Dashboard dengan statistik pengaduan
- Melihat data pengaduan siswa
- Memberikan tanggapan/respon pada pengaduan
- Melihat riwayat pengaduan
- Melakukan chat dengan siswa
- Melihat dan mengirim pesan masuk
- Pengaturan profil
- Logout

---

### Akun Siswa (Dashboard Siswa)

| No | Nama | NISN | Kelas | Username | Password | Halaman |
|----|----|------|-------|----------|----------|---------|
| 1 | Andi Saputra | 2024001001 | XII RPL 1 | 2024001001 | password123 | `siswa/index.php` |
| 2 | Siti Aisyah | 2024001002 | XII AKL 2 | 2024001002 | password123 | `siswa/index.php` |
| 3 | Rizky Pratama | 2024001003 | XI RPL 1 | 2024001003 | password123 | `siswa/index.php` |
| 4 | Nur Azizah | 2024001004 | XII TKJ 1 | 2024001004 | password123 | `siswa/index.php` |
| 5 | Budi Hermawan | 2024001005 | XI AKL 1 | 2024001005 | password123 | `siswa/index.php` |
| 6 | Dewi Lestari | 2024001006 | X TMAS | 2024001006 | password123 | `siswa/index.php` |
| 7 | Arif Wiryanto | 2024001007 | XII RPL 2 | 2024001007 | password123 | `siswa/index.php` |
| 8 | Indah Permatasari | 2024001008 | XI TKJ 1 | 2024001008 | password123 | `siswa/index.php` |
| 9 | Fajar Mulyana | 2024001009 | XII TMAS 1 | 2024001009 | password123 | `siswa/index.php` |
| 10 | Sinta Wahyuni | 2024001010 | X AKL | 2024001010 | password123 | `siswa/index.php` |

**Fitur Siswa:**
- Dashboard dengan layanan pengaduan, curhat, dan riwayat
- Membuat pengaduan laporan ke Guru BK
- Fitur curhat anonimo (Wishing Wall)
- Melihat riwayat pengaduan
- Chat dengan Guru BK
- Notifikasi pengaduan
- Edit profil
- Logout

---

## 📊 Struktur Database

### 1. Tabel `guru_bk`
Menyimpan data guru pembimbing konseling

| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id_bk | INT (PK) | ID Guru BK (auto increment) |
| nama | VARCHAR(100) | Nama Guru BK |
| email | VARCHAR(100) | Email (unique) |
| no_telp | VARCHAR(15) | Nomor telepon |
| username | VARCHAR(50) | Username login (unique) |
| password | VARCHAR(100) | Password terenkripsi |
| tanggal_daftar | DATETIME | Tanggal pendaftaran |
| foto | VARCHAR(255) | Path foto profil |

**Data:** 2 guru BK

---

### 2. Tabel `siswa`
Menyimpan data profil siswa

| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id_siswa | INT (PK) | ID Siswa (auto increment) |
| nama | VARCHAR(100) | Nama siswa |
| nisn | VARCHAR(20) | NISN (unique) |
| email | VARCHAR(100) | Email (unique) |
| no_telp | VARCHAR(15) | Nomor telepon |
| kelas | VARCHAR(20) | Kelas siswa |
| jurusan | VARCHAR(50) | Jurusan/Program keahlian |
| password | VARCHAR(100) | Password |
| tanggal_daftar | DATETIME | Tanggal daftar |
| foto | VARCHAR(255) | Path foto profil |
| status | ENUM | Status aktif/nonaktif |

**Data:** 10 siswa dari berbagai kelas dan jurusan

---

### 3. Tabel `pengaduan`
Menyimpan laporan/pengaduan dari siswa

| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id_pengaduan | INT (PK) | ID Pengaduan (auto increment) |
| id_siswa | INT (FK) | Referensi siswa yang mengadukan |
| id_bk | INT (FK) | Referensi guru BK yang menangani |
| jenis_pengaduan | ENUM | Tipe: bullying, masalah_belajar, konflik_teman, masalah_keluarga, masalah_ekonomi, masalah_kesehatan, lainnya |
| judul | VARCHAR(150) | Judul pengaduan |
| isi | TEXT | Isi/deskripsi detail pengaduan |
| tanggal_pengaduan | DATETIME | Tanggal dibuat |
| status | ENUM | Status: baru, diproses, selesai |
| tanggapan | TEXT | Respon dari guru BK |
| tanggal_tanggapan | DATETIME | Tanggal guru memberikan respon |
| file_lampiran | VARCHAR(255) | Path file bukti (opsional) |

**Data:** 10 pengaduan dengan status beragam

---

### 4. Tabel `notifikasi`
Menyimpan notifikasi untuk siswa

| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id_notif | INT (PK) | ID Notifikasi (auto increment) |
| id_siswa | INT (FK) | Referensi siswa |
| pesan | VARCHAR(255) | Isi notifikasi |
| tipe | ENUM | Tipe: pengaduan, pesan, informasi |
| status | ENUM | Status: belum dibaca, sudah dibaca |
| waktu | DATETIME | Waktu notifikasi |
| id_referensi | INT | ID referensi (pengaduan/pesan) |

**Data:** 12 notifikasi

---

### 5. Tabel `chat`
Menyimpan percakapan (chat) antara siswa dan guru BK

| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id_chat | INT (PK) | ID Chat (auto increment) |
| id_siswa | INT (FK) | Referensi siswa |
| id_bk | INT (FK) | Referensi guru BK |
| pengirim | ENUM | Siapa pengirim: siswa atau guru |
| pesan | TEXT | Isi pesan |
| waktu | DATETIME | Waktu terkirim |
| dibaca | TINYINT | Status dibaca (0/1) |

**Data:** 8 pesan chat

---

## 📝 Data Dummy

### Ringkasan Data:
- **Guru BK**: 2 orang
- **Siswa**: 10 orang
- **Pengaduan**: 10 laporan dengan status bervariasi (baru, diproses, selesai)
- **Notifikasi**: 12 notifikasi untuk siswa
- **Chat**: 8 percakapan antara siswa dan guru

### Jenis-jenis Pengaduan:
1. ✅ **Bullying** - Ejekan dan hinaan dari teman (3 kasus)
2. 📚 **Masalah Belajar** - Kesulitan memahami pelajaran (4 kasus)
3. 👥 **Konflik Teman** - Perselisihan dalam kelompok atau persahabatan (1 kasus)
4. 👨‍👩‍👧 **Masalah Keluarga** - Masalah di rumah (1 kasus)
5. 💰 **Masalah Ekonomi** - Kesulitan membayar uang sekolah (1 kasus)
6. 🏥 **Masalah Kesehatan** - Gangguan kesehatan (1 kasus)
7. 📋 **Lainnya** - Pertanyaan/informasi umum (1 kasus)

---

## 🔄 Alur Sistem

### Alur Login Guru BK:
```
Login (index.php)
  ↓
Verifikasi username & password dari tabel guru_bk
  ↓
Dashboard Guru (dashboard.php)
  ├── Statistik pengaduan
  ├── Data pengaduan terbaru
  └── Opsi menu
```

### Alur Login Siswa:
```
Login (siswa/index.php)
  ↓
Verifikasi NISN & password dari tabel siswa
  ↓
Dashboard Siswa (siswa/dashboard.php)
  ├── Layanan Pengaduan
  ├── Papan Curhat (Anonymous)
  ├── Riwayat Pengaduan
  ├── Chat dengan Guru BK
  └── Notifikasi
```

### Alur Pengaduan:
```
Siswa buat pengaduan (siswa/pengaduan.php)
  ↓
Data disimpan ke tabel pengaduan (status: baru)
  ↓
Notifikasi dikirim ke siswa
  ↓
Guru BK lihat di Data Pengaduan (data_pengaduan.php)
  ↓
Guru BK ubah status menjadi "diproses"
  ↓
Guru BK memberikan tanggapan
  ↓
Status berubah menjadi "selesai"
  ↓
Siswa menerima notifikasi ada tanggapan
```

### Alur Chat:
```
Siswa / Guru BK mengirim pesan (chat.php)
  ↓
Data disimpan ke tabel chat
  ↓
Penerima melihat pesan baru (dibaca = 0)
  ↓
Setelah dibaca, dibaca = 1
  ↓
Notifikasi dikirim ke penerima
```

---

## 🔐 Keamanan

> **PENTING**: Untuk production, lakukan hal berikut:
> 1. Ubah semua password (gunakan password_hash)
> 2. Implementasikan CSRF token
> 3. Tambahkan prepared statements untuk mencegah SQL injection
> 4. Gunakan HTTPS
> 5. Tambahkan validasi input yang ketat
> 6. Implementasikan rate limiting pada login

---

## 📞 Kontak Dukungan

Jika ada pertanyaan tentang database atau struktur sistem:
- Dashboard Guru: Login sebagai `admin / admin123`
- Dashboard Siswa: Login sebagai siswa manapun (contoh: NISN `2024001001 / password123`)

---

**Terakhir diperbarui**: April 13, 2026
