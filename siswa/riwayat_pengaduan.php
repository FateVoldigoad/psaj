<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];

// Get siswa data
$query_siswa = "SELECT * FROM siswa WHERE id_siswa='$id_siswa'";
$result_siswa = mysqli_query($conn, $query_siswa);
$siswa = mysqli_fetch_assoc($result_siswa);

// Get pengaduan dari siswa ini
$query = "SELECT p.*, g.nama as guru_nama FROM pengaduan p 
          LEFT JOIN guru_bk g ON p.id_bk = g.id_bk 
          WHERE p.id_siswa='$id_siswa' 
          ORDER BY p.tanggal DESC";
$result = mysqli_query($conn, $query);
$pengaduan_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pengaduan_list[] = $row;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengaduan - PSAJ</title>
    <link rel="stylesheet" href="assets/css/pengaduan.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header-section { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header-section h1 { color: #333; margin-bottom: 10px; }
        .breadcrumb { margin-bottom: 15px; }
        .breadcrumb a { color: #007bff; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .btn-new { display: inline-block; background: #28a745; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-bottom: 20px; }
        .btn-new:hover { background: #218838; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .card-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px; }
        .card-title { font-size: 18px; font-weight: 600; color: #333; }
        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status-baru { background: #ffc107; color: #333; }
        .status-diproses { background: #17a2b8; color: white; }
        .status-selesai { background: #28a745; color: white; }
        .card-content { font-size: 14px; color: #666; line-height: 1.6; }
        .card-meta { display: flex; gap: 20px; margin-top: 15px; font-size: 13px; color: #999; }
        .card-footer { display: flex; gap: 10px; margin-top: 15px; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; text-decoration: none; display: inline-block; }
        .btn-view { background: #007bff; color: white; }
        .btn-view:hover { background: #0056b3; }
        .btn-cancel { background: #dc3545; color: white; }
        .btn-cancel:hover { background: #c82333; }
        .tanggapan-box { background: #f8f9fa; padding: 15px; border-radius: 4px; margin-top: 15px; border-left: 4px solid #28a745; }
        .tanggapan-box strong { color: #333; }
        .tanggapan-text { margin-top: 10px; color: #666; }
        .no-data { text-align: center; padding: 40px; color: #999; }
        .label-jenis { font-size: 12px; padding: 3px 8px; border-radius: 3px; margin-left: 10px; }
        .label-pengaduan { background: #e7f3ff; color: #004085; }
        .label-laporan { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>

<div class="container">
    
    <div class="header-section">
        <div class="breadcrumb">
            <a href="dashboard.php">Dashboard</a> / <span>Riwayat Pengaduan</span>
        </div>
        <h1>📋 Riwayat Pengaduan Saya</h1>
        <p style="color: #666; margin-top: 5px;">Total Pengaduan: <strong><?php echo count($pengaduan_list); ?></strong></p>
    </div>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="alert alert-<?php echo $_SESSION['tipe']; ?>">
            <?php echo $_SESSION['pesan']; ?>
        </div>
        <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
    <?php endif; ?>

    <a href="pengaduan.php" class="btn-new">+ Buat Pengaduan Baru</a>

    <?php if (count($pengaduan_list) > 0): ?>
        
        <?php foreach ($pengaduan_list as $pengaduan): ?>
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">
                            <?php echo htmlspecialchars($pengaduan['judul']); ?>
                            <span class="label-jenis label-<?php echo $pengaduan['jenis']; ?>">
                                <?php echo ucfirst($pengaduan['jenis']); ?>
                            </span>
                        </div>
                    </div>
                    <span class="status-badge status-<?php echo $pengaduan['status']; ?>">
                        <?php echo ucfirst($pengaduan['status']); ?>
                    </span>
                </div>

                <div class="card-content">
                    <?php echo htmlspecialchars(substr($pengaduan['isi'], 0, 200)); ?>
                    <?php if (strlen($pengaduan['isi']) > 200): ?>...<?php endif; ?>
                </div>

                <div class="card-meta">
                    <span>📅 <?php echo date('d/m/Y H:i', strtotime($pengaduan['tanggal'])); ?></span>
                    <?php if ($pengaduan['id_bk']): ?>
                        <span>👨‍❤️ Diutasi ke: <?php echo htmlspecialchars($pengaduan['guru_nama']); ?></span>
                    <?php endif; ?>
                </div>

                <?php if ($pengaduan['tanggapan']): ?>
                    <div class="tanggapan-box">
                        <strong>✅ Tanggapan dari Guru BK:</strong>
                        <div class="tanggapan-text">
                            <?php echo htmlspecialchars($pengaduan['tanggapan']); ?>
                        </div>
                        <small style="color: #999;">
                            📅 <?php echo date('d/m/Y H:i', strtotime($pengaduan['tanggal_tanggapan'])); ?>
                        </small>
                    </div>
                <?php endif; ?>

                <div class="card-footer">
                    <button class="btn btn-view" onclick="viewDetail(<?php echo $pengaduan['id_pengaduan']; ?>)">
                        👁️ Lihat Detail
                    </button>
                    <?php if ($pengaduan['status'] == 'baru'): ?>
                        <button class="btn btn-cancel" onclick="batalkan(<?php echo $pengaduan['id_pengaduan']; ?>)">
                            ✕ Batalkan
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <div class="card no-data">
            <p>📭 Anda belum membuat pengaduan apapun</p>
            <p style="margin-top: 10px; font-size: 14px;">
                <a href="pengaduan.php" style="color: #007bff; text-decoration: none;">Buat pengaduan pertama Anda →</a>
            </p>
        </div>
    <?php endif; ?>

</div>

<script>
function viewDetail(id) {
    // Bisa di-expand untuk menampilkan detail lengkap
    alert('Detail Pengaduan ID: ' + id);
}

function batalkan(id) {
    if (confirm('Apakah Anda yakin ingin membatalkan pengaduan ini?')) {
        window.location.href = 'proses_pengaduan.php?aksi=batalkan&id=' + id;
    }
}
</script>

</body>
</html>
