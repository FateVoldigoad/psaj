<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengaturan Akun BK</title>
<link rel="stylesheet" href="css/pengaturan.css">
</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>BK Panel</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="data_pengaduan.php">Data Pengaduan</a></li>
            <li><a href="riwayat_pengaduan.php">Riwayat Pengaduan</a></li>
            <li class="active"><a href="pengaturan.php">Pengaturan</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Navbar -->
        <div class="navbar">
            <h3>Pengaturan Akun Guru BK</h3>
            <div class="user">Guru BK</div>
        </div>

        <!-- Form Pengaturan -->
        <div class="settings-container">

            <h3>Informasi Akun</h3>

            <form>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" value="Budi Santoso">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="bk@sekolah.sch.id">
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" value="guru_bk">
                </div>

                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" value="08123456789">
                </div>

                <h3>Ubah Password</h3>

                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password">
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password">
                </div>

                <button type="submit" class="btn-simpan">Simpan Perubahan</button>

            </form>

        </div>

    </div>

</div>

</body>
</html>