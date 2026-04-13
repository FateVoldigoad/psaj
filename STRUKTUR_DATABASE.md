# 🗄️ Struktur dan Relasi Database PSAJ

## 📊 Entity Relationship Diagram (ERD)

```
┌─────────────────┐          ┌──────────────┐
│   GURU_BK       │          │    SISWA     │
├─────────────────┤          ├──────────────┤
│ id_bk (PK)      │◄─────────│ id_siswa(PK) │
│ nama            │          │ nama         │
│ email           │          │ nisn (UQ)    │
│ no_telp         │          │ email (UQ)   │
│ username (UQ)   │          │ no_telp      │
│ password        │          │ kelas        │
│ tanggal_daftar  │          │ jurusan      │
│ foto            │          │ password     │
└─────────────────┘          │ tanggal_daftar
         ▲                    │ foto
         │                    │ status
         │         ┌──────────├──────────────┘
         │         │          │
         │         │          ▼
         │         │    ┌─────────────────┐
         │         │    │  PENGADUAN      │
         │         │    ├─────────────────┤
         │         │    │ id_pengaduan(PK)│
         │         │    │ id_siswa (FK)   │
         │         └────│ id_bk (FK)      │
         │              │ jenis_pengaduan │
         │              │ judul           │
         │              │ isi             │
         │              │ tanggal_pengaduan
         │              │ status          │
         │              │ tanggapan       │
         │              │ tanggal_tanggapan
         │              │ file_lampiran   │
         │              └─────────────────┘
         │
         └──┐
            │
        ┌───┴──────────────┐
        │    NOTIFIKASI    │        ┌────────────┐
        ├──────────────────┤        │   CHAT     │
        │ id_notif (PK)    │        ├────────────┤
        │ id_siswa (FK)    │────────│ id_chat(PK)│
        │ pesan            │        │ id_siswa(FK)
        │ tipe             │        │ id_bk (FK) │
        │ status           │        │ pengirim   │
        │ waktu            │        │ pesan      │
        │ id_referensi     │        │ waktu      │
        └──────────────────┘        │ dibaca     │
                                    └────────────┘
```

---

## 📋 Detail Tabel

### 1️⃣ Tabel `GURU_BK` (Guru Pembimbing Konseling)

**Fungsi:** Menyimpan data guru BK yang mengelola pengaduan siswa

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|-----------|-----------|
| id_bk | INT | PRIMARY KEY, AUTO_INCREMENT | Identitas unik guru |
| nama | VARCHAR(100) | NOT NULL | Nama lengkap guru |
| email | VARCHAR(100) | NOT NULL, UNIQUE | Email guru |
| no_telp | VARCHAR(15) | - | Nomor telepon |
| username | VARCHAR(50) | NOT NULL, UNIQUE | Username login |
| password | VARCHAR(100) | NOT NULL | Password terenkripsi |
| tanggal_daftar | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu daftar |
| foto | VARCHAR(255) | - | Path foto profil |

**Data Awal:** 2 guru BK
- Ibu Sri Handayani (admin)
- Bapak Ahmad Wijaya (ahmad_bk)

---

### 2️⃣ Tabel `SISWA` (Data Siswa)

**Fungsi:** Menyimpan data profil siswa yang menggunakan sistem

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|-----------|-----------|
| id_siswa | INT | PRIMARY KEY, AUTO_INCREMENT | Identitas unik siswa |
| nama | VARCHAR(100) | NOT NULL | Nama lengkap siswa |
| nisn | VARCHAR(20) | NOT NULL, UNIQUE | NISN (No. Induk Siswa Nasional) |
| email | VARCHAR(100) | UNIQUE | Email siswa |
| no_telp | VARCHAR(15) | - | Nomor telepon |
| kelas | VARCHAR(20) | NOT NULL | Kelas siswa (X/XI/XII) |
| jurusan | VARCHAR(50) | - | Program keahlian/jurusan |
| password | VARCHAR(100) | NOT NULL | Password login |
| tanggal_daftar | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu daftar |
| foto | VARCHAR(255) | - | Path foto profil |
| status | ENUM('aktif','nonaktif') | DEFAULT 'aktif' | Status keanggotaan |

**Data Awal:** 10 siswa dari berbagai kelas (X, XI, XII)

---

### 3️⃣ Tabel `PENGADUAN` (Laporan/Pengaduan Siswa)

**Fungsi:** Menyimpan laporan dan pengaduan dari siswa ke guru BK

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|-----------|-----------|
| id_pengaduan | INT | PRIMARY KEY, AUTO_INCREMENT | Identitas unik pengaduan |
| id_siswa | INT | NOT NULL, FOREIGN KEY (siswa) | Referensi siswa pelapor |
| id_bk | INT | FOREIGN KEY (guru_bk) | Referensi guru yang menangani |
| jenis_pengaduan | ENUM | NOT NULL | Tipe pengaduan |
| judul | VARCHAR(150) | NOT NULL | Judul singkat pengaduan |
| isi | TEXT | NOT NULL | Detail lengkap pengaduan |
| tanggal_pengaduan | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu pengaduan dibuat |
| status | ENUM('baru','diproses','selesai') | DEFAULT 'baru' | Status penanganan |
| tanggapan | TEXT | - | Respon dari guru BK |
| tanggal_tanggapan | DATETIME | - | Waktu guru memberikan respons |
| file_lampiran | VARCHAR(255) | - | File bukti pendukung |

**Jenis Pengaduan:**
- 🚨 `bullying` - Perundungan/ejekan
- 📚 `masalah_belajar` - Kesulitan akademik
- 👥 `konflik_teman` - Perselisihan dengan rekan
- 👨‍👩‍👧 `masalah_keluarga` - Masalah rumah tangga
- 💰 `masalah_ekonomi` - Kesulitan finansial
- 🏥 `masalah_kesehatan` - Gangguan kesehatan
- 📋 `lainnya` - Kategori lainnya

**Data Awal:** 10 pengaduan dengan status:
- 2 Baru (baru masuk)
- 2 Diproses (sedang ditangani)
- 6 Selesai (sudah ada tanggapan)

---

### 4️⃣ Tabel `NOTIFIKASI` (Notifikasi Siswa)

**Fungsi:** Menyimpan notifikasi untuk memberitahu siswa tentang update pengaduan

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|-----------|-----------|
| id_notif | INT | PRIMARY KEY, AUTO_INCREMENT | Identitas unik notifikasi |
| id_siswa | INT | NOT NULL, FOREIGN KEY | Referensi siswa penerima |
| pesan | VARCHAR(255) | NOT NULL | Isi pesan notifikasi |
| tipe | ENUM('pengaduan','pesan','informasi') | DEFAULT 'informasi' | Tipe notifikasi |
| status | ENUM('belum dibaca','sudah dibaca') | DEFAULT 'belum dibaca' | Status dibaca |
| waktu | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu notifikasi terkirim |
| id_referensi | INT | - | ID referensi (pengaduan/chat) |

**Data Awal:** 12 notifikasi

---

### 5️⃣ Tabel `CHAT` (Percakapan Guru-Siswa)

**Fungsi:** Menyimpan pesan/chat antara siswa dan guru BK

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|-----------|-----------|
| id_chat | INT | PRIMARY KEY, AUTO_INCREMENT | Identitas unik chat |
| id_siswa | INT | NOT NULL, FOREIGN KEY | Referensi siswa |
| id_bk | INT | NOT NULL, FOREIGN KEY | Referensi guru BK |
| pengirim | ENUM('siswa','guru') | NOT NULL | Siapa pengirim pesan |
| pesan | TEXT | NOT NULL | Isi pesan |
| waktu | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu pesan terkirim |
| dibaca | TINYINT(1) | DEFAULT 0 | Status dibaca (0=belum, 1=sudah) |

**Data Awal:** 8 percakapan

---

## 🔗 Relasi Antar Tabel

### Foreign Key Constraints:

1. **PENGADUAN → SISWA**
   - `pengaduan.id_siswa` → `siswa.id_siswa`
   - Aksi: Jika siswa dihapus, pengaduan juga dihapus
   
2. **PENGADUAN → GURU_BK**
   - `pengaduan.id_bk` → `guru_bk.id_bk`
   - Aksi: Guru dapat ditugaskan ke banyak pengaduan

3. **NOTIFIKASI → SISWA**
   - `notifikasi.id_siswa` → `siswa.id_siswa`
   - Aksi: Setiap notifikasi untuk satu siswa

4. **CHAT → SISWA**
   - `chat.id_siswa` → `siswa.id_siswa`
   - Aksi: Siswa dapat memiliki banyak chat

5. **CHAT → GURU_BK**
   - `chat.id_bk` → `guru_bk.id_bk`
   - Aksi: Guru dapat memiliki chat dengan banyak siswa

---

## 📊 Alur Data Sistem

### Alur 1: Pengaduan
```
Siswa membuat pengaduan
  ↓
INSERT ke tabel PENGADUAN (status='baru')
  ↓
INSERT notifikasi ke NOTIFIKASI
  ↓
Guru BK lihat di Data Pengaduan
  ↓
UPDATE pengaduan (status='diproses')
  ↓
Guru BK kirim tanggapan
  ↓
UPDATE pengaduan (tanggapan, status='selesai')
  ↓
Siswa terima notifikasi ada tanggapan
```

### Alur 2: Chat
```
Siswa/Guru mengirim pesan
  ↓
INSERT ke tabel CHAT
  ↓
INSERT notifikasi ke penerima
  ↓
Penerima lihat chat
  ↓
UPDATE chat (dibaca=1)
```

---

## 🔐 Unique Constraints

Untuk mencegah data duplikat:
- `guru_bk.username` - Username guru harus unik
- `guru_bk.email` - Email guru harus unik
- `siswa.nisn` - NISN siswa harus unik
- `siswa.email` - Email siswa harus unik

---

## 📈 Kapasitas & Skalabilitas

**Data Awal:**
- Guru: 2 orang
- Siswa: 10 orang
- Pengaduan: 10 laporan
- Notifikasi: 12 notifikasi
- Chat: 8 percakapan

**Bisa diskalakan untuk:**
- Ribuan siswa dan puluhan guru
- Puluhan ribu pengaduan
- Jutaan pesan chat

---

## 🔧 Maintenance Tips

1. **Backup Database:**
   ```sql
   -- Export database
   mysqldump -u root psaj > backup_psaj.sql
   ```

2. **Cleanup Data Lama:**
   ```sql
   -- Hapus pengaduan lebih dari 1 tahun
   DELETE FROM pengaduan WHERE DATEDIFF(NOW(), tanggal_pengaduan) > 365;
   ```

3. **Optimasi Tabel:**
   ```sql
   OPTIMIZE TABLE guru_bk, siswa, pengaduan, notifikasi, chat;
   ```

4. **Cek Integritas:**
   ```sql
   -- Lihat orphaned records
   SELECT * FROM pengaduan WHERE id_siswa NOT IN (SELECT id_siswa FROM siswa);
   ```

---

**Database siap digunakan untuk testing dan development!** ✅
