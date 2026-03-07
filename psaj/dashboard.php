<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengaduan Siswa</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="container">

    <div class="sidebar">
        <h2>BK Panel</h2>
        <ul>
            <li class="active">Dashboard</li>
            <li><a href="data_pengaduan.php">Data Pengaduan</a></li>
            <li><a href="riwayat_pengaduan.php">Riwayat Pengaduan</a></li>
            <li><a href="pengaturan.php">Pengaturan</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <div class="main">

       <div class="navbar">

    <div class="nav-left">
        <img src="assets/logo.png" class="logo">
        <h3>Layanan Pengaduan</h3>
    </div>
    <div class="nav-right">
    <div class="user">Guru BK</div>
</div>
        </div>

        <!-- Statistik -->
        <div class="cards">

            <div class="card">
                <h4>Total Pengaduan</h4>
                <p>25</p>
            </div>

            <div class="card">
                <h4>Pengaduan Diproses</h4>
                <p>10</p>
            </div>

            <div class="card">
                <h4>Pengaduan Selesai</h4>
                <p>12</p>
            </div>

            <div class="card">
                <h4>Pengaduan Baru</h4>
                <p>3</p>
            </div>

        </div>

        <!-- Tabel Pengaduan -->
        <div class="table-container">

            <h3>Pengaduan Terbaru</h3>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Pengaduan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Andi Saputra</td>
                        <td>XII RPL 1</td>
                        <td>Bullying</td>
                        <td>10 Februari 2026</td>
                        <td class="proses">Diproses</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Siti Aisyah</td>
                        <td>XII AKL 2</td>
                        <td>Masalah Belajar</td>
                        <td>9 Februari 2026</td>
                        <td class="selesai">Selesai</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Rizky Pratama</td>
                        <td>XI RPL 1</td>
                        <td>Konflik Teman</td>
                        <td>8 Februari 2026</td>
                        <td class="baru">Baru</td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>

</div>

</body>
</html>