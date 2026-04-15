<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

// Query pengaduan dengan join ke siswa dan guru_bk
$query = "SELECT p.*, s.nama as siswa_nama, s.nisn, k.nama_kelas, g.nama as guru_nama 
          FROM pengaduan p 
          JOIN siswa s ON p.id_siswa = s.id_siswa 
          LEFT JOIN kelas k ON s.id_kelas = k.id_kelas 
          LEFT JOIN guru_bk g ON p.id_bk = g.id_bk 
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
    <title>Data Pengaduan - Guru</title>
    <link rel="stylesheet" href="css/data_pengaduan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-baru { background: #ffc107; color: #333; }
        .status-diproses { background: #17a2b8; color: white; }
        .status-selesai { background: #28a745; color: white; }
        .action-btn {
            padding: 6px 12px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-lihat { background: #007bff; color: white; }
        .btn-lihat:hover { background: #0056b3; }
        .btn-tanggapi { background: #28a745; color: white; }
        .btn-tanggapi:hover { background: #218838; }
        
        .btn-proses { background: #ffc107; color: #333; }
        .btn-proses:hover { background: #e0a800; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; }
        
        .table-wrapper {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border: 1px solid #ddd;
            height: 600px;
            overflow: hidden;
        }
        
        .table-scroll {
            width: 100%;
            height: 100%;
            overflow-y: scroll;
            overflow-x: auto;
        }
        
        #tabelPengaduan {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }
        
        #tabelPengaduan th,
        #tabelPengaduan td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        #tabelPengaduan th {
            background: #f8f9fa;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        #tabelPengaduan tbody tr:hover {
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
    </style>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Layanan Pengaduan</h2>
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

    <!-- Main -->
    <div class="main">

        <div class="user">Guru BK</div>

        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipe']; ?>">
                <?php echo $_SESSION['pesan']; ?>
            </div>
            <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
        <?php endif; ?>

        <!-- Header Table -->
        <div class="table-header">
            <input type="text" placeholder="Cari pengaduan..." class="search" id="searchInput" onkeyup="filterTable()">
        </div>


        <!-- Table Container dengan Scroll -->
        <div class="table-wrapper" id="tableWrapper">
            <div class="table-scroll">
                <table id="tabelPengaduan">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Kelas</th>
                        <th>Jenis</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Ditugaskan ke</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (count($pengaduan_list) > 0): ?>
                        <?php 
                        $no = 1;
                        foreach ($pengaduan_list as $pengaduan): 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($pengaduan['siswa_nama']); ?></td>
                            <td><?php echo htmlspecialchars($pengaduan['nisn']); ?></td>
                            <td><?php echo htmlspecialchars($pengaduan['nama_kelas'] ?? '-'); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($pengaduan['jenis'])); ?></td>
                            <td><?php echo htmlspecialchars(substr($pengaduan['judul'], 0, 40)); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $pengaduan['status']; ?>">
                                    <?php echo ucfirst(htmlspecialchars($pengaduan['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($pengaduan['guru_nama'] ?? 'Belum ditugaskan'); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($pengaduan['tanggal'])); ?></td>
                            <td>
                                <a href="guru_tanggapi.php?id=<?php echo $pengaduan['id_pengaduan']; ?>" class="action-btn btn-tanggapi">
                                    Tanggapi
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 20px;">
                                Tidak ada data pengaduan
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
function filterTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("tabelPengaduan");
    const tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName("td");
        let found = false;
        for (let j = 0; j < td.length; j++) {
            if (td[j].innerText.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        tr[i].style.display = found ? "" : "none";
    }
}
</script>

</body>
</html>
