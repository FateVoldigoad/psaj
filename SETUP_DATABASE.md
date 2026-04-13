# 🚀 Panduan Cepat Setup Database

## Opsi 1: Menggunakan phpMyAdmin (Paling Mudah)

### Langkah-Langkah:

1. **Buka phpMyAdmin**
   - Akses: `http://localhost/phpmyadmin`
   - Login dengan username: `root` (password kosong)

2. **Impor Database**
   - Klik menu **Import** di bagian atas
   - Pilih file `psaj_complete.sql`
   - Scroll ke bawah dan klik tombol **Go** (berwarna biru)
   - Tunggu proses selesai

3. **Verifikasi Sukses**
   - Cari database `psaj` di panel sebelah kiri
   - Lihat 5 tabel: `guru_bk`, `siswa`, `pengaduan`, `notifikasi`, `chat`
   - Jika semua ada, database siap digunakan! ✅

---

## Opsi 2: Menggunakan Command Line

### Mac/Linux:
```bash
cd /path/to/psaj
mysql -u root < psaj_complete.sql
```

### Windows (Command Prompt):
```bash
cd C:\xampp\mysql\bin
mysql -u root < C:\xampp\htdocs\psaj\psaj_complete.sql
```

---

## Opsi 3: Menggunakan Kode PHP

Buat file `setup_database.php` di folder `psaj`:

```php
<?php
$host = "localhost";
$user = "root";
$pass = "";

$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql = file_get_contents('psaj_complete.sql');
$queries = explode(';', $sql);

foreach ($queries as $query) {
    $query = trim($query);
    if (!empty($query)) {
        if (!mysqli_query($conn, $query)) {
            echo "Error: " . mysqli_error($conn) . "<br>";
        }
    }
}

echo "<h2>✅ Database berhasil dibuat!</h2>";
echo "<p><a href='index.php'>Kembali ke Login</a></p>";

mysqli_close($conn);
?>
```

Kemudian akses: `http://localhost/psaj/setup_database.php`

---

## 📋 Data Awal Setelah Import

### Guru BK (2 orang):
- Username: `admin` | Password: `admin123`
- Username: `ahmad_bk` | Password: `password123`

### Siswa (10 orang):
- NISN: `2024001001` s/d `2024001010` | Password: `password123`

### Pengaduan (10 kasus):
- Status: Baru (2), Diproses (2), Selesai (6)
- Jenis: Bullying, Masalah Belajar, Konflik, Keluarga, Ekonomi, Kesehatan, Lainnya

### Chat (8 percakapan):
- Antara siswa dan guru BK
- Sebagian sudah dibaca, sebagian belum

---

## 🔗 Koneksi Database

File `koneksi.php` sudah tersedia dengan konfigurasi:
```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "psaj";
```

**Jika konfigurasi berbeda**, edit file ini sesuai dengan setting MySQL Anda.

---

## 💡 Tips

- Jika hanya ingin database tanpa data dummy, gunakan `psaj.sql` (file original)
- Untuk reset database, hapus tabel dan jalankan import ulang
- Database sudah include struktur dengan Foreign Key constraints
- Semua tanggal dummy menggunakan waktu April 2026

---

## ✅ Checklist Verifikasi

- [ ] phpMyAdmin bisa diakses
- [ ] Database `psaj` sudah ada
- [ ] Tabel `guru_bk`, `siswa`, `pengaduan`, `notifikasi`, `chat` ada
- [ ] Ada data di setiap tabel
- [ ] Bisa login guru dengan `admin/admin123`
- [ ] Bisa login siswa dengan NISN `2024001001` / password `password123`
- [ ] Website sudah bisa akses halaman login

---

**Jika ada masalah, cek:**
1. MySQL service sudah running
2. XAMPP/LAMP server aktif
3. File `psaj_complete.sql` ada di folder
4. Username dan password MySQL sesuai di file `koneksi.php`

Untuk detail lebih lengkap, buka: `DOKUMENTASI_DATABASE.md`
