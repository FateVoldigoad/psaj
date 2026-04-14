<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];

// Get data siswa
$query_siswa = "SELECT * FROM siswa WHERE id_siswa='$id_siswa'";
$result_siswa = mysqli_query($conn, $query_siswa);
$siswa = mysqli_fetch_assoc($result_siswa);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan - PSAJ</title>
    <link rel="stylesheet" href="assets/css/pengaduan.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .form-group textarea { resize: vertical; min-height: 150px; }
        .form-group input:disabled { background: #f8f9fa; cursor: not-allowed; }
        .btn-group { display: flex; gap: 10px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; text-decoration: none; }
        .btn-submit { background: #28a745; color: white; }
        .btn-submit:hover { background: #218838; }
        .btn-cancel { background: #6c757d; color: white; display: inline-block; }
        .btn-cancel:hover { background: #5a6268; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .breadcrumb { margin-bottom: 20px; }
        .breadcrumb a { color: #007bff; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        h1 { color: #333; margin-bottom: 30px; }
        .info-box { background: #f8f9fa; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #007bff; }
        .required { color: red; }
    </style>
</head>
<body>

<div class="container">
    
    <div class="breadcrumb">
        <a href="dashboard.php">Dashboard</a> / <span>Form Pengaduan</span>
    </div>

    <h1>📝 Buat Pengaduan Baru</h1>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="alert alert-<?php echo $_SESSION['tipe']; ?>">
            <?php echo $_SESSION['pesan']; ?>
        </div>
        <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
    <?php endif; ?>

    <div class="info-box">
        <strong>ℹ️ Informasi:</strong> Pengaduan Anda akan ditinjau oleh Guru BK. Anda dapat membatalkan pengaduan yang masih dalam status "Baru". Informasi yang Anda berikan akan dirahasiakan.
    </div>

    <div class="form-container">
        <form method="POST" action="proses_pengaduan.php" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="tambah">
            
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" readonly disabled>
            </div>

            <div class="form-group">
                <label for="nisn">NISN</label>
                <input type="text" id="nisn" name="nisn" value="<?php echo htmlspecialchars($siswa['nisn']); ?>" readonly disabled>
            </div>

            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" id="kelas" name="kelas" value="<?php 
                    $query_kelas = "SELECT nama_kelas FROM kelas WHERE id_kelas='{$siswa['id_kelas']}'";
                    $result_kelas = mysqli_query($conn, $query_kelas);
                    if (mysqli_num_rows($result_kelas) > 0) {
                        $kelas = mysqli_fetch_assoc($result_kelas);
                        echo htmlspecialchars($kelas['nama_kelas']);
                    }
                ?>" readonly disabled>
            </div>

            <div class="form-group">
                <label for="jenis">Jenis Pengaduan <span class="required">*</span></label>
                <select id="jenis" name="jenis" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="pengaduan">Pengaduan</option>
                    <option value="laporan">Laporan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="judul">Judul Pengaduan <span class="required">*</span></label>
                <input type="text" id="judul" name="judul" placeholder="Masukkan judul pengaduan..." required maxlength="150">
            </div>

            <div class="form-group">
                <label for="isi">Isi Pengaduan <span class="required">*</span></label>
                <textarea id="isi" name="isi" placeholder="Jelaskan secara detail pengaduan atau laporan Anda..." required></textarea>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-submit">✓ Kirim Pengaduan</button>
                <a href="riwayat_pengaduan.php" class="btn btn-cancel">✕ Batal</a>
            </div>

        </form>
    </div>

</div>

</body>
</html>