<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

$id_bk = $_SESSION['id_bk'];

// Get guru data
$query = "SELECT * FROM guru_bk WHERE id_bk='$id_bk'";
$result = mysqli_query($conn, $query);
$guru = mysqli_fetch_assoc($result);

// Get pesan untuk ditampilkan
$pesan = $_SESSION['pesan'] ?? '';
$tipe = $_SESSION['tipe'] ?? '';
unset($_SESSION['pesan']);
unset($_SESSION['tipe']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Guru</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/pengaturan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        .settings-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .btn-simpan {
            background-color: #4CAF50;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
            font-weight: 600;
        }
        .btn-simpan:hover {
            background-color: #45a049;
        }
        .settings-container h3 {
            color: #333;
            margin-top: 25px;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Layanan Pengaduan</h2>
        <ul>
            <li><a href="guru_dashboard.php">Dashboard</a></li>
            <li><a href="guru_data_pengaduan.php">Data Pengaduan</a></li>
            <li><a href="guru_riwayat_pengaduan.php">Riwayat</a></li>
            <li><a href="guru_data_siswa.php">Data Siswa</a></li>
            <li><a href="guru_pesan_masuk.php">Pesan Masuk</a></li>
            <li class="active"><a href="guru_pengaturan.php">Pengaturan</a></li>
            <li><a href="logout.php" onclick="return confirm('Yakin ingin logout?');">Logout</a></li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">

        <div class="user"><?php echo htmlspecialchars($_SESSION['nama_guru']); ?></div>

        <?php if (!empty($pesan)): ?>
            <div class="alert alert-<?php echo $tipe; ?>">
                <i class="fas fa-<?php echo ($tipe == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($pesan); ?>
            </div>
        <?php endif; ?>

        <!-- Form Pengaturan -->
        <div class="settings-container">

            <h3>⚙️ Informasi Akun</h3>

            <form method="POST" action="proses_pengaturan.php">
                <input type="hidden" name="aksi" value="update_profil">

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($guru['nama'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($guru['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username_guru" value="<?php echo htmlspecialchars($guru['username_guru'] ?? ''); ?>" readonly style="background: #f5f5f5; cursor: not-allowed;">
                    <small style="color: #999;">Username tidak dapat diubah</small>
                </div>

                <div class="form-group">
                    <label for="telpon">No Telepon</label>
                    <input type="text" id="telpon" name="telpon" value="<?php echo htmlspecialchars($guru['telpon'] ?? ''); ?>">
                </div>

                <button type="submit" class="btn-simpan">
                    <i class="fas fa-save"></i> Simpan Profil
                </button>

            </form>

            <h3>🔒 Ubah Password</h3>

            <form method="POST" action="proses_pengaturan.php">
                <input type="hidden" name="aksi" value="update_password">

                <div class="form-group">
                    <label for="password_lama">Password Lama</label>
                    <input type="password" id="password_lama" name="password_lama" required>
                </div>

                <div class="form-group">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" id="password_baru" name="password_baru" required>
                    <small style="color: #999;">Minimal 6 karakter</small>
                </div>

                <div class="form-group">
                    <label for="password_konfirmasi">Konfirmasi Password</label>
                    <input type="password" id="password_konfirmasi" name="password_konfirmasi" required>
                </div>

                <button type="submit" class="btn-simpan">
                    <i class="fas fa-key"></i> Ubah Password
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
