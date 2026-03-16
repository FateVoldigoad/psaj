<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tanggapi Pengaduan</title>
<link rel="stylesheet" href="css/tanggapi.css">
</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>BK Panel</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active"><a href="data_pengaduan.php">Data Pengaduan</a></li>
            <li><a href="riwayat_pengaduan.php">Riwayat Pengaduan</a></li>
            <li><a href="data_siswa.php">Data Siswa</a></li>
            <li><a href="pengaturan.php">Pengaturan</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Navbar -->
        <div class="navbar">
            <h3>Tanggapi Pengaduan Siswa</h3>
            <div class="user">Guru BK</div>
        </div>

        <!-- Detail Pengaduan -->
        <div class="pengaduan-box">

            <h3>Detail Pengaduan</h3>

            <div class="detail">
                <p><b>Nama Siswa :</b> Andi Saputra</p>
                <p><b>Kelas :</b> XII RPL 1</p>
                <p><b>Email :</b> andi.saputra@example.com</p>
                <p><b>Jenis Pengaduan :</b> Bullying</p>
                <p><b>Tanggal :</b> 10 Februari 2026</p>
            </div>

            <div class="isi-pengaduan">
                <label>Isi Pengaduan</label>
                <div class="box-text">
                    Saya sering diejek oleh beberapa teman di kelas sehingga merasa tidak nyaman saat belajar.
                </div>
            </div>

        </div>

        <!-- Form Tanggapan -->
        <div class="tanggapan-box">

            <h3>Tanggapan Guru BK</h3>

            <form>

                <div class="form-group">
                    <label>Tulis Tanggapan</label>
                    <textarea placeholder="Tulis tanggapan atau solusi untuk siswa..."></textarea>
                </div>

                <div class="form-group">
                    <label>Status Pengaduan</label>
                    <select>
                        <option>Diproses</option>
                        <option>Selesai</option>
                    </select>
                </div>

                <a href="riwayat_pengaduan.php" class="btn-kirim">Kirim Tanggapan</a>

            </form>

        </div>

    </div>

</div>

</body>
</html>