<!DOCTYPE html>
<html>
<head>

<title>Tambah Data Siswa</title>

<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/tambah_siswa.css">

</head>
<body>

<div class="container">

<!-- Sidebar -->

<div class="sidebar">
<h2>Guru BK</h2>

<ul>
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="data_pengaduan.php">Data Pengaduan</a></li>
<li><a href="riwayat_pengaduan.php">Riwayat Pengaduan</a></li>
<li class="active"><a href="siswa.php">Data Siswa</a></li>
<li><a href="pesan_masuk.php">Pesan Masuk</a></li>
<li><a href="pengaturan.php">Pengaturan</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>

</div>

<!-- Main -->

<div class="main">

<div class="navbar">

<div class="nav-left">
<img src="assets/logo.png" class="logo">
<h3>Tambah Data Siswa</h3>
</div>

<div class="user">
Guru BK
</div>

</div>


<!-- Form -->

<div class="form-container">

<h2>Form Tambah Siswa</h2>

<form>

<label>Nama Siswa</label>
<input type="text" placeholder="Masukkan nama siswa">

<label>NISN</label>
<input type="text" placeholder="Masukkan NISN">

<label>Password</label>
<input type="password" placeholder="Masukkan password login siswa">

<button type="submit" class="btn-simpan">Simpan</button>

</form>

</div>

</div>

</div>

</body>
</html>