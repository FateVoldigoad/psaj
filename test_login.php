<?php
session_start();
include 'koneksi.php';

// Buat dokumentasi login system
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Test Login System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 { color: #333; border-bottom: 3px solid #667eea; padding-bottom: 10px; }
        h2 { color: #667eea; margin-top: 30px; }
        .creds {
            background: #f0f4ff;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #667eea;
        }
        .creds strong { color: #667eea; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover { background: #764ba2; }
        .success { color: #28a745; font-weight: bold; }
        .warning { color: #ffc107; font-weight: bold; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th { background: #f8f9fa; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔐 Dokumentasi Login System PSAJ</h1>
    
    <h2>✅ Fitur yang Sudah Diimplementasikan:</h2>
    <ul>
        <li><span class="success">✓</span> Login Siswa (menggunakan NISN atau Email + Password)</li>
        <li><span class="success">✓</span> Login Guru (menggunakan Username atau Email + Password)</li>
        <li><span class="success">✓</span> Session Management (Siswa & Guru)</li>
        <li><span class="success">✓</span> Logout Functionality</li>
        <li><span class="success">✓</span> Proteksi halaman (auto redirect jika belum login)</li>
        <li><span class="success">✓</span> Error handling & validasi</li>
    </ul>

    <h2>🔓 Akun untuk Testing:</h2>
    
    <h3>Akun SISWA:</h3>
    <table>
        <tr>
            <th>Username (NISN)</th>
            <th>Password</th>
            <th>Nama</th>
        </tr>
        <tr>
            <td>0001234567</td>
            <td>password123</td>
            <td>Muhammad Rizki Pratama</td>
        </tr>
        <tr>
            <td>0009876543</td>
            <td>password123</td>
            <td>Siti Aisyah Nurul</td>
        </tr>
        <tr>
            <td>0002345678</td>
            <td>password123</td>
            <td>Budi Santoso</td>
        </tr>
        <tr>
            <td>0003456789</td>
            <td>password123</td>
            <td>Rina Kusuma Dewi</td>
        </tr>
    </table>

    <p>🔗 Atau bisa gunakan Email siswa (cek database, atau contoh: rizki@email.com)</p>

    <h3>Akun GURU:</h3>
    <table>
        <tr>
            <th>Username</th>
            <th>Password</th>
            <th>Nama</th>
        </tr>
        <tr>
            <td>admin</td>
            <td>admin123</td>
            <td>Guru BK</td>
        </tr>
        <tr>
            <td>ibu_siti</td>
            <td>password123</td>
            <td>Ibu Siti Rahma S.Pd</td>
        </tr>
        <tr>
            <td>pak_haryanto</td>
            <td>password123</td>
            <td>Bapak Haryanto M.Pd</td>
        </tr>
    </table>

    <p>🔗 Atau bisa gunakan Email guru (cek database)</p>

    <h2>🚀 Cara Testing:</h2>
    <ol>
        <li>Buka: <a href="index.php" class="btn">Login Page</a></li>
        <li>Pilih role (Guru atau Siswa)</li>
        <li>Masukkan username/NISN dan password</li>
        <li>Jika berhasil, akan redirect ke dashboard</li>
        <li>Untuk logout, klik tombol logout atau di menu</li>
    </ol>

    <h2>📁 File yang Sudah Diupdate:</h2>
    <ul>
        <li>✅ <strong>login_proses.php</strong> - File BARU untuk proses login validation</li>
        <li>✅ <strong>logout.php</strong> - File BARU untuk logout</li>
        <li>✅ <strong>index.php</strong> - Update: form action ke login_proses.php + error display</li>
        <li>✅ <strong>dashboard.php</strong> - Update: proteksi login guru + update logout link</li>
        <li>✅ <strong>siswa/dashboard.php</strong> - Update: logout link</li>
        <li>✅ <strong>data_pengaduan.php</strong> - Update: proteksi login guru</li>
        <li>✅ <strong>data_siswa.php</strong> - Update: proteksi login guru</li>
        <li>✅ <strong>tambah_siswa.php</strong> - Update: proteksi login guru</li>
        <li>✅ <strong>edit_siswa.php</strong> - Update: proteksi login guru</li>
        <li>✅ <strong>proses_siswa.php</strong> - Update: proteksi login guru</li>
    </ul>

    <h2>🔧 Alur Login Siswa:</h2>
    <pre>
1. User di index.php pilih TAB "Siswa"
2. Input NISN/Email + Password
3. Form POST ke login_proses.php
4. login_proses.php query ke tabel siswa
5. Jika cocok → SET $_SESSION['id_siswa'] + data siswa
6. Redirect ke siswa/dashboard.php
7. siswa/dashboard.php cek isset($_SESSION['id_siswa'])
8. Jika ada → tampilkan dashboard
9. Jika tidak ada → redirect ke index.php
    </pre>

    <h2>🔧 Alur Login Guru:</h2>
    <pre>
1. User di index.php pilih TAB "Guru" (default aktif)
2. Input Username/Email + Password
3. Form POST ke login_proses.php
4. login_proses.php query ke tabel guru_bk
5. Jika cocok → SET $_SESSION['id_bk'] + data guru
6. Redirect ke dashboard.php
7. dashboard.php cek isset($_SESSION['id_bk'])
8. Jika ada → tampilkan dashboard guru
9. Jika tidak ada → redirect ke index.php
    </pre>

    <h2>⚠️ Catatan Penting:</h2>
    <ul>
        <li>Password belum di-hash (gunakan untuk testing saja, di production harus di-hash dengan password_hash())</li>
        <li>Session berlaku sampai browser ditutup atau logout di-klik</li>
        <li>Setiap halaman guru sudah dilindungi dengan pengecekan isset($_SESSION['id_bk'])</li>
        <li>Setiap halaman siswa sudah dilindungi dengan pengecekan isset($_SESSION['id_siswa'])</li>
        <li>Jika belum login, user otomatis redirect ke index.php</li>
    </ul>

    <h2>🧪 Test Sekarang:</h2>
    <a href="index.php" class="btn" style="background: #28a745; font-size: 16px; padding: 12px 24px;">
        🔐 Buka Login Page
    </a>

</div>
</body>
</html>
