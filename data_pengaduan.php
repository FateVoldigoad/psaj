<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pengaduan Siswa</title>
<link rel="stylesheet" href="css/data_pengaduan.css">
</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Layanan Pengaduan</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Data Pengaduan</li>
            <li><a href="riwayat_pengaduan.php">Riwayat</a></li>
            <li><a href="data_siswa.php">Data Siswa</a></li>
            <li><a href="pesan_masuk.php">Pesan Masuk</a></li>
            <li><a href="pengaturan.php">Pengaturan</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">

        <div class="user">Guru BK</div>

        <!-- Header Table -->
        <div class="table-header">

            <input type="text" placeholder="Cari pengaduan..." class="search">
        </div>

        <!-- Table -->
        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Pengaduan</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>1</td>
                        <td>Andi Saputra</td>
                        <td>XII RPL 1</td>
                        <td>Bullying</td>
                        <td>Dibully oleh teman kelas</td>
                        <td>10 Feb 2026</td>
                        <td class="proses">Diproses</td>
                        <td>
                            <a href="tanggapi.php" class="btn-tanggapi">Tanggapi</a>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Siti Aisyah</td>
                        <td>XII AKL 2</td>
                        <td>Masalah Belajar</td>
                        <td>Kesulitan memahami pelajaran</td>
                        <td>9 Feb 2026</td>
                        <td class="selesai">Selesai</td>
                        <td>
                            <a href="tanggapi.php" class="btn-tanggapi">Tanggapi</a>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Rizky Pratama</td>
                        <td>XI RPL 1</td>
                        <td>Konflik Teman</td>
                        <td>Perselisihan dengan teman</td>
                        <td>8 Feb 2026</td>
                        <td class="baru">Baru</td>
                        <td>
                            <a href="tanggapi.php" class="btn-tanggapi">Tanggapi</a>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>