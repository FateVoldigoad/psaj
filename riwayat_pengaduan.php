<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Pengaduan</title>
<link rel="stylesheet" href="css/riwayat.css">
</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>BK Panel</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="data_pengaduan.php">Data Pengaduan</a></li>
            <li class="active">Riwayat Pengaduan</li>
            <li><a href="data_siswa.php">Data Siswa</a></li>
            <li><a href="pesan_masuk.php">Pesan Masuk</a></li>
            <li><a href="pengaturan.php">Pengaturan</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Navbar -->
        <div class="navbar">
            <h3>Riwayat Pengaduan Siswa</h3>
            <div class="user">Guru BK</div>
        </div>

        <!-- Filter -->
        <div class="filter">

            <select>
                <option>Semua Status</option>
                <option>Selesai</option>
                <option>Diproses</option>
            </select>

            <input type="date">

            <button class="btn-filter">Filter</button>

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
                        <th>Tanggal Pengaduan</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>1</td>
                        <td>Andi Saputra</td>
                        <td>XII RPL 1</td>
                        <td>Bullying</td>
                        <td>10 Feb 2026</td>
                        <td>12 Feb 2026</td>
                        <td class="selesai">Selesai</td>
                        <td>Sudah dimediasi oleh Guru BK</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Siti Aisyah</td>
                        <td>XII AKL 2</td>
                        <td>Masalah Belajar</td>
                        <td>9 Feb 2026</td>
                        <td>11 Feb 2026</td>
                        <td class="selesai">Selesai</td>
                        <td>Diberikan bimbingan belajar</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Rizky Pratama</td>
                        <td>XI RPL 1</td>
                        <td>Konflik Teman</td>
                        <td>8 Feb 2026</td>
                        <td>10 Feb 2026</td>
                        <td class="selesai">Selesai</td>
                        <td>Diselesaikan melalui mediasi</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>