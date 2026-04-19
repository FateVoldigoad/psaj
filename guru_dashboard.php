<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

// Get statistics
$query_total = "SELECT COUNT(*) as total FROM pengaduan";
$result_total = mysqli_query($conn, $query_total);
$total = mysqli_fetch_assoc($result_total)['total'];

$query_baru = "SELECT COUNT(*) as baru FROM pengaduan WHERE status='baru'";
$result_baru = mysqli_query($conn, $query_baru);
$baru = mysqli_fetch_assoc($result_baru)['baru'];

$query_proses = "SELECT COUNT(*) as proses FROM pengaduan WHERE status='diproses'";
$result_proses = mysqli_query($conn, $query_proses);
$proses = mysqli_fetch_assoc($result_proses)['proses'];

$query_selesai = "SELECT COUNT(*) as selesai FROM pengaduan WHERE status='selesai'";
$result_selesai = mysqli_query($conn, $query_selesai);
$selesai = mysqli_fetch_assoc($result_selesai)['selesai'];

// Get statistics untuk kategori curhat
$query_kategori = "SELECT kategori, COUNT(*) as total 
                   FROM chat 
                   WHERE pengirim = 'siswa' AND kategori IS NOT NULL
                   GROUP BY kategori
                   ORDER BY total DESC";
$result_kategori = mysqli_query($conn, $query_kategori);
$kategori_stats = [];
while ($row = mysqli_fetch_assoc($result_kategori)) {
    $kategori_stats[] = $row;
}

// Default kategori jika tidak ada data
$default_kategori = ['akademik', 'pribadi', 'sosial', 'keluarga', 'kesehatan', 'lainnya'];
$kategori_labels = [];
$kategori_data = [];

foreach ($default_kategori as $kat) {
    $kategori_labels[] = ucfirst($kat);
    $found = false;
    foreach ($kategori_stats as $stat) {
        if ($stat['kategori'] == $kat) {
            $kategori_data[] = $stat['total'];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $kategori_data[] = 0;
    }
}

// Get recent pengaduan
$query_recent = "SELECT p.*, s.nama as nama_siswa FROM pengaduan p JOIN siswa s ON p.id_siswa = s.id_siswa ORDER BY p.tanggal DESC LIMIT 5";
$result_recent = mysqli_query($conn, $query_recent);
$recent_list = [];
while ($row = mysqli_fetch_assoc($result_recent)) {
    $recent_list[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru - Layanan Pengaduan</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <style>
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-baru {
            background-color: #ffc107;
            color: #333;
        }
        .status-diproses {
            background-color: #17a2b8;
            color: white;
        }
        .status-selesai {
            background-color: #28a745;
            color: white;
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
        
        /* Chart Styles */
        .chart-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        
        .chart-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
            margin-bottom: 20px;
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
            <li class="active"><a href="guru_dashboard.php">Dashboard</a></li>
            <li><a href="guru_data_pengaduan.php">Data Pengaduan</a></li>
            <li><a href="guru_riwayat_pengaduan.php">Riwayat</a></li>
            <li><a href="guru_data_siswa.php">Data Siswa</a></li>
            <li><a href="guru_pesan_masuk.php">Pesan Masuk</a></li>
            <li><a href="guru_pengaturan.php">Pengaturan</a></li>
            <li><a href="logout.php" onclick="return confirm('Yakin ingin logout?');">Logout</a></li>
        </ul>
    </div>

    <div class="main">

        <!-- Statistik -->
        <div class="cards">

            <div class="card">
                <h4>Total Pengaduan</h4>
                <p><?php echo $total; ?></p>
            </div>

            <div class="card">
                <h4>Pengaduan Diproses</h4>
                <p><?php echo $proses; ?></p>
            </div>

            <div class="card">
                <h4>Pengaduan Selesai</h4>
                <p><?php echo $selesai; ?></p>
            </div>

            <div class="card">
                <h4>Pengaduan Baru</h4>
                <p><?php echo $baru; ?></p>
            </div>

        </div>

        <!-- Chart Kategori Curhat -->
        <div class="chart-section">
            <div class="chart-title">
                <i class="fas fa-chart-bar" style="color: #667eea;"></i>
                Statistik Kategori Curhat Siswa
            </div>
            <div class="chart-container">
                <canvas id="kategoriChart"></canvas>
            </div>
            <p style="font-size: 12px; color: #999; text-align: center;">
                Data menampilkan jumlah curhat siswa berdasarkan kategori yang dipilih saat mengirimkan curhat
            </p>
        </div>

        <!-- Tabel Pengaduan -->
        <div class="table-container">

            <h3>Pengaduan Terbaru</h3>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Judul Pengaduan</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($recent_list) > 0) {
                        $no = 1;
                        foreach ($recent_list as $pengaduan) {
                            $status_class = 'status-' . $pengaduan['status'];
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($pengaduan['nama_siswa']) . "</td>";
                            echo "<td>" . htmlspecialchars($pengaduan['judul']) . "</td>";
                            echo "<td>" . ucfirst(htmlspecialchars($pengaduan['jenis'])) . "</td>";
                            echo "<td><span class='status-badge $status_class'>" . ucfirst(htmlspecialchars($pengaduan['status'])) . "</span></td>";
                            echo "<td>" . date('d/m/Y H:i', strtotime($pengaduan['tanggal'])) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center'>Tidak ada data pengaduan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
    // Chart Kategori Curhat
    const ctx = document.getElementById('kategoriChart');
    if (ctx) {
        const labels = <?php echo json_encode($kategori_labels); ?>;
        const data = <?php echo json_encode($kategori_data); ?>;
        
        const colors = [
            '#667eea',
            '#764ba2',
            '#f093fb',
            '#4facfe',
            '#00f2fe',
            '#43e97b'
        ];
        Chart.register(ChartDataLabels);
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Curhat',
                    data: data,
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: function(value, context) {
                            return value > 0 ? value : '';
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 12
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' curhat';
                            }
                        }
                    }
                }
            }
        });
    }
</script>

</body>
</html>
