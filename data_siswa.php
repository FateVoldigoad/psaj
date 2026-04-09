<!DOCTYPE html>
<html>
<head>
<title>Data Siswa</title>
<link rel="stylesheet" href="css/dashboard.css">   
<link rel="stylesheet" href="css/data_siswa.css"> 
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
<li class="active">Data Siswa</a></li>
<li><a href="pesan_masuk.php">Pesan Masuk</a></li>
<li><a href="pengaturan.php">Pengaturan</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</div>

<!-- Main -->
<div class="main">

<!-- Navbar -->
<div class="navbar">
<div class="nav-left">
<img src="assets/logo.png" class="logo">
<h3>Data Siswa</h3>
</div>

<div class="user">
Guru BK
</div>
</div>

<!-- Tombol Tambah -->
<div style="margin-top:20px;">
<a href="tambah_siswa.php">
<button class="btn-tambah">+ Tambah Data Siswa</button>
</a>
</div>

<!-- Tabel -->
<div class="table-container">

<table>

<tr>
<th>No</th>
<th>Nama Siswa</th>
<th>NISN</th>
<th>Aksi</th>
</tr>

<tr>
<td>1</td>
<td>Andi Saputra</td>
<td>1234567890</td>
<td>
<button class="btn-edit">Edit</button>
<button class="btn-hapus">Hapus</button>
</td>
</tr>

<tr>
<td>2</td>
<td>Siti Aisyah</td>
<td>9876543210</td>
<td>
<button class="btn-edit">Edit</button>
<button class="btn-hapus">Hapus</button>
</td>
</tr>

<tr>
<td>3</td>
<td>Budi Santoso</td>
<td>1122334455</td>
<td>
<button class="btn-edit">Edit</button>
<button class="btn-hapus">Hapus</button>
</td>
</tr>

</table>

</div>

</div>
</div>

</body>
</html>