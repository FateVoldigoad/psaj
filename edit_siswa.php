<!DOCTYPE html>
<html>
<head>

<title>Edit Data Siswa</title>

<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/edit_siswa.css">

</head>
<body>

<div class="container">

<!-- Sidebar -->
<div class="sidebar">
<h2>Guru BK</h2>

<ul>
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="data_pengaduan.php">Data Pengaduan</a></li>
<li><a href="riwayat_pengaduan.php">Riwayat</a></li>
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
<h3>Edit Data Siswa</h3>
</div>

<div class="user">Guru BK</div>
</div>

<!-- Form -->
<div class="form-container">

<h2>Edit Siswa</h2>

<form>

<label>Nama Siswa</label>
<input type="text" value="Andi Saputra">

<label>NISN</label>
<input type="text" value="1234567890">

<label>Password</label>
<input type="password" value="admin123">

<button type="submit" class="btn-simpan">Update</button>

</form>

</div>

</div>

</div>

</body>
</html>