<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

// Get semua siswa
$query = "SELECT s.*, k.nama_kelas FROM siswa s 
          LEFT JOIN kelas k ON s.id_kelas = k.id_kelas 
          ORDER BY s.nama";
$result = mysqli_query($conn, $query);
$siswa_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $siswa_list[] = $row;
}

// Get kelas untuk dropdown
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
    <title>Data Siswa - Guru</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/data_siswa.css">
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
        
        .btn {
            padding: 8px 15px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover { background: #0056b3; }
        .btn-warning {
            background: #ffc107;
            color: #333;
        }
        .btn-warning:hover { background: #e0a800; }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover { background: #c82333; }
        
        .table-actions {
            white-space: nowrap;
        }
        
        .action-btn-group {
            display: flex;
            gap: 5px;
            margin-bottom: 20px;
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
            <li class="active"><a href="guru_data_siswa.php">Data Siswa</a></li>
            <li><a href="guru_pesan_masuk.php">Pesan Masuk</a></li>
            <li><a href="guru_pengaturan.php">Pengaturan</a></li>
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

        <h2 style="margin-bottom: 20px;">👥 Data Siswa</h2>

        <!-- Action Buttons -->
        <div class="action-btn-group">
            <a href="tambah_siswa_guru.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Siswa
            </a>
        </div>

        <!-- Search Bar -->
        <div style="margin-bottom: 20px;">
            <input type="text" id="searchInput" placeholder="Cari siswa..." style="padding: 10px; border: 1px solid #ddd; border-radius: 4px; width: 300px;" onkeyup="filterTable()">
        </div>

        <!-- Table Scroll Container -->
        <div class="table-scroll">
        <!-- Table -->
        <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 1px solid #ddd;">No</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 1px solid #ddd;">Nama</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 1px solid #ddd;">NISN</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 1px solid #ddd;">Kelas</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 1px solid #ddd;">Email</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600; border-bottom: 1px solid #ddd;">Aksi</th>
                </tr>
            </thead>
            <tbody id="siswaTable">
                <?php if (count($siswa_list) > 0): ?>
                    <?php 
                    $no = 1;
                    foreach ($siswa_list as $siswa): 
                    ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 12px;"><?php echo $no++; ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($siswa['nama']); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($siswa['nisn']); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($siswa['nama_kelas'] ?? '-'); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($siswa['email']); ?></td>
                        <td style="padding: 12px; text-align: center; table-actions;">
                            <a href="edit_siswa.php?id=<?php echo $siswa['id_siswa']; ?>" class="btn btn-warning" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button onclick='deleteConfirm(<?php echo $siswa['id_siswa']; ?>)' class="btn btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center; color: #999;">Tidak ada data siswa</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>

    </div>

</div>

<script>
function deleteConfirm(id_siswa) {
    if (confirm('Apakah Anda yakin ingin menghapus siswa ini?')) {
        window.location.href = 'proses_siswa.php?aksi=hapus&id=' + id_siswa;
    }
}

function filterTable() {
    const input = document.getElementById("searchInput").value.toUpperCase();
    const table = document.getElementById("siswaTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let found = false;
        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toUpperCase().indexOf(input) > -1) {
                found = true;
                break;
            }
        }
        rows[i].style.display = found ? "" : "none";
    }
}
</script>

</body>
</html>
