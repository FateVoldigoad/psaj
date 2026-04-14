<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

// Get all students dari database
$query = "SELECT s.*, k.nama_kelas FROM siswa s LEFT JOIN kelas k ON s.id_kelas = k.id_kelas ORDER BY s.id_siswa ASC";
$result = mysqli_query($conn, $query);
$siswa_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $siswa_list[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="css/dashboard.css">   
    <link rel="stylesheet" href="css/data_siswa.css">
    <style>
        .pesan {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .pesan.success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .pesan.error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
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

    <!-- Main -->
    <div class="main">

        <div class="user">Guru BK</div>

        <!-- Pesan -->
        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="pesan <?php echo $_SESSION['tipe']; ?>">
                <?php echo $_SESSION['pesan']; ?>
            </div>
            <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
        <?php endif; ?>

        <!-- Tombol Tambah -->
        <div style="margin-top:20px;">
            <a href="tambah_siswa.php">
                <button class="btn-tambah">+ Tambah Data Siswa</button>
            </a>
        </div>

        <!-- Tabel -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($siswa_list) > 0) {
                        $no = 1;
                        foreach ($siswa_list as $siswa) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($siswa['nisn']) . "</td>";
                            echo "<td>" . htmlspecialchars($siswa['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($siswa['nama_kelas'] ?? '-') . "</td>";
                            echo "<td>" . htmlspecialchars($siswa['telpon'] ?? '-') . "</td>";
                            echo "<td>" . htmlspecialchars($siswa['email'] ?? '-') . "</td>";
                            echo "<td>";
                            echo "<a href='edit_siswa.php?id=" . $siswa['id_siswa'] . "'>";
                            echo "<button class='btn-edit'>Edit</button>";
                            echo "</a> ";
                            echo "<a href='proses_siswa.php?aksi=hapus&id=" . $siswa['id_siswa'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")'>";
                            echo "<button class='btn-hapus'>Hapus</button>";
                            echo "</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center'>Tidak ada data siswa</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>