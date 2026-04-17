<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

// Get list kelas
$query_kelas = "SELECT * FROM kelas ORDER BY nama_kelas ASC";
$result_kelas = mysqli_query($conn, $query_kelas);
$kelas_list = [];
while ($row = mysqli_fetch_assoc($result_kelas)) {
    $kelas_list[] = $row;
}

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
    <title>Tambah Data Siswa</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/edit_siswa.css">
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
        
        .form-container {
    width: 100%;
    margin: 10px 0; /* jarak kecil saja */
    padding: 25px;
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
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .btn-submit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-submit:hover {
            background-color: #45a049;
        }
        .btn-cancel {
            background-color: #f44336;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-cancel:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
      <h2 style="color: #667eea">SPEAKTEN</h2>
        <ul>
            <li><a href="guru_dashboard.php">Dashboard</a></li>
            <li><a href="guru_data_pengaduan.php">Data Pengaduan</a></li>
            <li><a href="guru_riwayat_pengaduan.php">Riwayat</a></li>
            <li class="active"><a href="guru_data_siswa.php">Data Siswa</a></li>
            <li><a href="guru_pesan_masuk.php">Pesan Masuk</a></li>
            <li><a href="guru_pengaturan.php">Pengaturan</a></li>
            <li><a href="logout.php" onclick="return confirm('Yakin ingin logout?');">Logout</a></li>
        </ul>
    </div>

    <div class="main">

        <?php if (!empty($pesan)): ?>
            <div class="alert alert-<?php echo $tipe; ?>">
                <i class="fas fa-<?php echo ($tipe == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($pesan); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <h2>Tambah Data Siswa Baru</h2>
            
            <form method="POST" action="proses_siswa.php?aksi=tambah">

                <div class="form-group">
                    <label for="nisn">NISN <span style="color:red;">*</span></label>
                    <input type="text" id="nisn" name="nisn" required maxlength="20">
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap <span style="color:red;">*</span></label>
                    <input type="text" id="nama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span style="color:red;">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir <span style="color:red;">*</span></label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir <span style="color:red;">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat <span style="color:red;">*</span></label>
                    <textarea id="alamat" name="alamat" required></textarea>
                </div>

                <div class="form-group">
                    <label for="telpon">Nomor Telepon <span style="color:red;">*</span></label>
                    <input type="text" id="telpon" name="telpon" required maxlength="15">
                </div>

                <div class="form-group">
                    <label for="email">Email <span style="color:red;">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="id_kelas">Kelas <span style="color:red;">*</span></label>
                    <select id="id_kelas" name="id_kelas" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas_list as $kelas): ?>
                            <option value="<?php echo $kelas['id_kelas']; ?>">
                                <?php echo htmlspecialchars($kelas['nama_kelas']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Password <span style="color:red;">*</span></label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-submit">Simpan</button>
                    <a href="guru_data_siswa.php" class="btn-cancel">Batal</a>
                </div>

            </form>
        </div>

    </div>
</div>

</body>
</html>
