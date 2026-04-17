<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

$id_pengaduan = $_GET['id'] ?? 0;

// Get pengaduan detail dengan siswa data
$query = "SELECT p.*, s.nama as nama_siswa, s.nisn, k.nama_kelas 
          FROM pengaduan p 
          JOIN siswa s ON p.id_siswa = s.id_siswa
          LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
          WHERE p.id_pengaduan='$id_pengaduan'";
$result = mysqli_query($conn, $query);
$pengaduan = mysqli_fetch_assoc($result);

if (!$pengaduan) {
    $_SESSION['pesan'] = 'Pengaduan tidak ditemukan!';
    $_SESSION['tipe'] = 'error';
    header("Location: guru_data_pengaduan.php");
    exit;
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
    <title>Tanggapi Pengaduan - PSAJ</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/tanggapi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin: 5px 0;
        }
        .status-baru { background: #ffc107; color: #333; }
        .status-diproses { background: #17a2b8; color: white; }
        .status-selesai { background: #28a745; color: white; }
        .detail-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        .detail-row {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 20px;
            margin-bottom: 12px;
        }
        .detail-label { font-weight: 600; color: #333; }
        .detail-value { color: #666; }
        .isi-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .form-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            min-height: 150px;
            resize: vertical;
        }
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
        }
        .btn-submit {
            background: #28a745;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-submit:hover { background: #218838; }
        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-cancel:hover { background: #5a6268; }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .logo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-bottom: 25px;
        }
        .logo-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #667eea 25%, #764ba2 75%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            color: white;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s ease;
        }
        .logo-icon:hover {
            transform: translateY(-5px);
        }
        .logo-section h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #333;
            text-align: center;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <div class="logo-section">
            <div class="logo-icon">
              <i class="fa-solid fa-shield-heart"></i>
            </div>
           <h2 style="color: #667eea">SPEAKTEN</h2>
        </div>
        <ul>
            <li><a href="guru_dashboard.php">Dashboard</a></li>
            <li class="active"><a href="guru_data_pengaduan.php">Data Pengaduan</a></li>
            <li><a href="guru_riwayat_pengaduan.php">Riwayat</a></li>
            <li><a href="guru_data_siswa.php">Data Siswa</a></li>
            <li><a href="guru_pesan_masuk.php">Pesan Masuk</a></li>
            <li><a href="guru_pengaturan.php">Pengaturan</a></li>
            <li><a href="logout.php" onclick="return confirm('Yakin ingin logout?');">Logout</a></li>
        </ul>
    </div>

    <div class="main">

        <?php if (!empty($pesan)): ?>
            <div class="alert alert-<?php echo $tipe; ?>">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($pesan); ?>
            </div>
        <?php endif; ?>

        <h2 style="margin-bottom: 20px;"> Tanggapi Pengaduan</h2>

        <!-- Detail Pengaduan -->
        <div class="detail-box">
            <h3 style="margin-bottom: 15px;">Detail Pengaduan Siswa</h3>
            
            <div class="detail-row">
                <span class="detail-label">👤 Nama Siswa</span>
                <span class="detail-value"><?php echo htmlspecialchars($pengaduan['nama_siswa']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">🆔 NISN</span>
                <span class="detail-value"><?php echo htmlspecialchars($pengaduan['nisn']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">📚 Kelas</span>
                <span class="detail-value"><?php echo htmlspecialchars($pengaduan['nama_kelas'] ?? '-'); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">📁 Jenis</span>
                <span class="detail-value"><?php echo ucfirst(htmlspecialchars($pengaduan['jenis'])); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">📅 Tanggal</span>
                <span class="detail-value"><?php echo date('d/m/Y H:i', strtotime($pengaduan['tanggal'])); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">📌 Status</span>
                <span>
                    <span class="status-badge status-<?php echo $pengaduan['status']; ?>">
                        <?php echo ucfirst(htmlspecialchars($pengaduan['status'])); ?>
                    </span>
                </span>
            </div>
        </div>

        <!-- Judul Pengaduan -->
        <div class="detail-box">
            <h4 style="margin-bottom: 10px;">📌 Judul Pengaduan:</h4>
            <p style="font-size: 16px; color: #333; font-weight: 500;">
                <?php echo htmlspecialchars($pengaduan['judul']); ?>
            </p>
        </div>

        <!-- Isi Pengaduan -->
        <div class="isi-box">
            <h4 style="margin-bottom: 15px;">📝 Isi Pengaduan:</h4>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 4px; line-height: 1.6; color: #333;">
                <?php echo nl2br(htmlspecialchars($pengaduan['isi'])); ?>
            </div>
        </div>

        <!-- Tanggapan Sebelumnya (jika ada) -->
        <?php if (!empty($pengaduan['tanggapan'])): ?>
        <div class="detail-box" style="background: #e8f5e9; border-left-color: #28a745;">
            <h4 style="margin-bottom: 15px; color: #28a745;">✅ Tanggapan Sebelumnya:</h4>
            <div style="background: white; padding: 15px; border-radius: 4px; line-height: 1.6; color: #333;">
                <?php echo nl2br(htmlspecialchars($pengaduan['tanggapan'])); ?>
            </div>
            <p style="margin-top: 10px; font-size: 12px; color: #666;">
                📅 Ditanggapi: <?php echo date('d/m/Y H:i', strtotime($pengaduan['tanggal_tanggapan'])); ?>
            </p>
        </div>
        <?php endif; ?>

        <!-- Form Tanggapan -->
        <div class="form-box">
            <h3 style="margin-bottom: 20px;">💬 Berikan Tanggapan</h3>
            
            <form method="POST" action="proses_tanggapi.php?aksi=tanggapi">
                <input type="hidden" name="id_pengaduan" value="<?php echo $id_pengaduan; ?>">
                
                <div class="form-group">
                    <label for="tanggapan">Tulis Tanggapan / Solusi <span style="color: red;">*</span></label>
                    <textarea 
                        id="tanggapan" 
                        name="tanggapan" 
                        placeholder="Tulis tanggapan atau solusi untuk siswa..." 
                        required><?php echo htmlspecialchars($pengaduan['tanggapan'] ?? ''); ?></textarea>
                    <small style="color: #666; display: block; margin-top: 5px;">Minimal 10 karakter</small>
                </div>

                <div class="form-group">
                    <label for="status">Ubah Status Pengaduan <span style="color: red;">*</span></label>
                    <select id="status" name="status" required>
                        <option value="" disabled>-- Pilih Status --</option>
                        <option value="diproses" <?php echo ($pengaduan['status'] == 'diproses') ? 'selected' : ''; ?>>
                            ⏳ Diproses
                        </option>
                        <option value="selesai" <?php echo ($pengaduan['status'] == 'selesai') ? 'selected' : ''; ?>>
                            ✅ Selesai
                        </option>
                    </select>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Kirim Tanggapan
                    </button>
                    <a href="guru_data_pengaduan.php" class="btn-cancel">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>

</body>
</html>
