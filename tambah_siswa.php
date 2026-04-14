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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/tambah_siswa.css">
    <style>
        .form-container {
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
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="data_pengaduan.php">Data Pengaduan</a></li>
            <li><a href="riwayat_pengaduan.php">Riwayat</a></li>
            <li class="active"><a href="data_siswa.php">Data Siswa</a></li>
            <li><a href="pesan_masuk.php">Pesan Masuk</a></li>
            <li><a href="pengaturan.php">Pengaturan</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="user">Guru BK</div>

        <div class="form-container">
            <h2>Tambah Data Siswa Baru</h2>
            
            <form method="POST" action="proses_siswa.php?aksi=tambah">
                
                <div class="form-group">
                    <label for="nisn">NISN <span style="color:red;">*</span></label>
                    <input type="text" id="nisn" name="nisn" required placeholder="Masukkan NISN siswa" maxlength="20">
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap <span style="color:red;">*</span></label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan nama lengkap">
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
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir">
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap"></textarea>
                </div>

                <div class="form-group">
                    <label for="telpon">Nomor Telepon</label>
                    <input type="text" id="telpon" name="telpon" placeholder="081234567890" maxlength="15">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="siswa@email.com">
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
                    <input type="password" id="password" name="password" required placeholder="Masukkan password">
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-submit">Simpan</button>
                    <a href="data_siswa.php" class="btn-cancel">Batal</a>
                </div>

            </form>
        </div>

    </div>
</div>

</body>
</html>