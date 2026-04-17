<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

// Get all pengaduan yang sudah diproses (selesai atau diproses)
$status_filter = $_GET['status'] ?? '';
$query = "SELECT p.*, s.nama as siswa_nama, k.nama_kelas 
          FROM pengaduan p 
          JOIN siswa s ON p.id_siswa = s.id_siswa
          LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
          WHERE p.status != 'baru'";

if ($status_filter && in_array($status_filter, ['selesai', 'diproses'])) {
    $query .= " AND p.status='$status_filter'";
}

$query .= " ORDER BY p.tanggal_tanggapan DESC, p.tanggal DESC";
$result = mysqli_query($conn, $query);
$riwayat_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $riwayat_list[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengaduan - Guru</title>
    <link rel="stylesheet" href="css/riwayat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-diproses { background: #17a2b8; color: white; }
        .status-selesai { background: #28a745; color: white; }
        .filter-section {
            background: white;
            max-width: 290px;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .filter-section label {
            font-weight: 600;
            margin: 0;
        }
        .filter-section select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .table-wrapper {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border: 1px solid #ddd;
            max-height: 700px;
            overflow: hidden;
        }
        
        .table-scroll {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            overflow-x: auto;
        }
        
        #tabelRiwayat {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }
        
        #tabelRiwayat th,
        #tabelRiwayat td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        #tabelRiwayat th {
            background: #f8f9fa;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        #tabelRiwayat tbody tr:hover {
            background: #f8f9fa;
        }
        
        .table-scroll::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }
        
        .table-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
            margin: 5px;
        }
        
        .table-scroll::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
            border: 2px solid #f1f1f1;
        }
        
        .table-scroll::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }
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

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-section">
            <div class="logo-icon">
                <i class="fa-solid fa-shield-heart"></i>
            </div>
           <h2 style="color: #667eea">SPEAKTEN</h2>
        </div>
        <ul>
            <li><a href="guru_dashboard.php">Dashboard</a></li>
            <li><a href="guru_data_pengaduan.php">Data Pengaduan</a></li>
            <li class="active"><a href="guru_riwayat_pengaduan.php">Riwayat</a></li>
            <li><a href="guru_data_siswa.php">Data Siswa</a></li>
            <li><a href="guru_pesan_masuk.php">Pesan Masuk</a></li>
            <li><a href="guru_pengaturan.php">Pengaturan</a></li>
            <li><a href="logout.php" onclick="return confirm('Yakin ingin logout?');">Logout</a></li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">


        <h2 style="margin-bottom: 20px;"> Riwayat Pengaduan</h2>

        <!-- Filter Section -->
        <div class="filter-section">
            <label for="statusFilter"><i class="fas fa-filter"></i> Filter Status:</label>
            <select id="statusFilter" onchange="filterByStatus(this.value)">
                <option value="">Semua</option>
                <option value="diproses" <?php echo ($status_filter == 'diproses') ? 'selected' : ''; ?>>⏳ Diproses</option>
                <option value="selesai" <?php echo ($status_filter == 'selesai') ? 'selected' : ''; ?>>✅ Selesai</option>
            </select>
        </div>

        <!-- Table Container dengan Scroll -->
        <div class="table-wrapper">
            <div class="table-scroll">
                <table id="tabelRiwayat">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Pengaduan</th>
                            <th>Tanggal Pengaduan</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($riwayat_list) > 0): ?>
                            <?php 
                            $no = 1;
                            foreach ($riwayat_list as $riwayat): 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($riwayat['siswa_nama']); ?></td>
                                <td><?php echo htmlspecialchars($riwayat['nama_kelas'] ?? '-'); ?></td>
                                <td><?php echo ucfirst(htmlspecialchars($riwayat['jenis'])); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($riwayat['tanggal'])); ?></td>
                                <td><?php echo !empty($riwayat['tanggal_tanggapan']) ? date('d/m/Y H:i', strtotime($riwayat['tanggal_tanggapan'])) : '-'; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $riwayat['status']; ?>">
                                        <?php 
                                        if ($riwayat['status'] == 'selesai') echo '✅ Selesai';
                                        else if ($riwayat['status'] == 'diproses') echo '⏳ Diproses';
                                        else echo ucfirst(htmlspecialchars($riwayat['status']));
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox" style="font-size: 48px; color: #ddd; display: block; margin-bottom: 10px;"></i>
                                        <p>Tidak ada riwayat pengaduan</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<script>
function filterByStatus(status) {
    if (status) {
        window.location.href = 'guru_riwayat_pengaduan.php?status=' + status;
    } else {
        window.location.href = 'guru_riwayat_pengaduan.php';
    }
}
</script>

</body>
</html>
