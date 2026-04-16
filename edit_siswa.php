<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

$id_siswa = $_GET['id'] ?? null;

if (!$id_siswa) {
    header("Location: guru_data_siswa.php");
    exit;
}

// Get siswa data
$query = "SELECT * FROM siswa WHERE id_siswa = '$id_siswa'";
$result = mysqli_query($conn, $query);
$siswa = mysqli_fetch_assoc($result);

if (!$siswa) {
    $_SESSION['pesan'] = 'Data siswa tidak ditemukan!';
    $_SESSION['tipe'] = 'error';
    header("Location: guru_data_siswa.php");
    exit;
}

// Get list kelas
$query_kelas = "SELECT * FROM kelas ORDER BY nama_kelas ASC";
$result_kelas = mysqli_query($conn, $query_kelas);
$kelas_list = [];
while ($row = mysqli_fetch_assoc($result_kelas)) {
    $kelas_list[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/edit_siswa.css">
    <style>
        .form-container {
            width: 900px;
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
        <h2>Layanan Pengaduan</h2>
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

        <div class="form-container">
            <h2>Edit Data Siswa</h2>
            
            <form method="POST" action="proses_siswa.php?aksi=edit">
                
                <input type="hidden" name="id_siswa" value="<?php echo $siswa['id_siswa']; ?>">

                <div class="form-group">
                    <label for="nisn">NISN <span style="color:red;">*</span></label>
                    <input type="text" id="nisn" name="nisn" required value="<?php echo htmlspecialchars($siswa['nisn']); ?>" maxlength="20">
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap <span style="color:red;">*</span></label>
                    <input type="text" id="nama" name="nama" required value="<?php echo htmlspecialchars($siswa['nama']); ?>">
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span style="color:red;">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" <?php echo ($siswa['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php echo ($siswa['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?php echo htmlspecialchars($siswa['tempat_lahir'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($siswa['tanggal_lahir'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat"><?php echo htmlspecialchars($siswa['alamat'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="telpon">Nomor Telepon</label>
                    <input type="text" id="telpon" name="telpon" value="<?php echo htmlspecialchars($siswa['telpon'] ?? ''); ?>" maxlength="15">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($siswa['email'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="id_kelas">Kelas <span style="color:red;">*</span></label>
                    <select id="id_kelas" name="id_kelas" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas_list as $kelas): ?>
                            <option value="<?php echo $kelas['id_kelas']; ?>" <?php echo ($siswa['id_kelas'] == $kelas['id_kelas']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($kelas['nama_kelas']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-submit">Update</button>
                    <a href="guru_data_siswa.php" class="btn-cancel">Batal</a>
                </div>

            </form>
        </div>

    </div>
</div>

</body>
</html>