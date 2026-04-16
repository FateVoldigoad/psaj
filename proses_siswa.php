<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

$aksi = $_GET['aksi'] ?? '';

if ($aksi == 'tambah') {
    $nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telpon = mysqli_real_escape_string($conn, $_POST['telpon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $id_kelas = mysqli_real_escape_string($conn, $_POST['id_kelas']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $query = "INSERT INTO siswa (nisn, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, telpon, email, id_kelas, password, status) 
              VALUES ('$nisn', '$nama', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$telpon', '$email', '$id_kelas', '$password', 'aktif')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['pesan'] = 'Siswa berhasil ditambahkan!';
        $_SESSION['tipe'] = 'success';
    } else {
        $_SESSION['pesan'] = 'Error: ' . mysqli_error($conn);
        $_SESSION['tipe'] = 'error';
    }
    header("Location: guru_data_siswa.php");
    exit;
}

elseif ($aksi == 'edit') {
    $id_siswa = mysqli_real_escape_string($conn, $_POST['id_siswa']);
    $nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telpon = mysqli_real_escape_string($conn, $_POST['telpon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $id_kelas = mysqli_real_escape_string($conn, $_POST['id_kelas']);
    
    $query = "UPDATE siswa SET 
              nisn='$nisn', nama='$nama', jenis_kelamin='$jenis_kelamin', 
              tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', 
              alamat='$alamat', telpon='$telpon', email='$email', id_kelas='$id_kelas'
              WHERE id_siswa='$id_siswa'";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['pesan'] = 'Siswa berhasil diupdate!';
        $_SESSION['tipe'] = 'success';
    } else {
        $_SESSION['pesan'] = 'Error: ' . mysqli_error($conn);
        $_SESSION['tipe'] = 'error';
    }
    header("Location: guru_data_siswa.php");
    exit;
}

elseif ($aksi == 'hapus') {
    $id_siswa = mysqli_real_escape_string($conn, $_GET['id']);
    
    $query = "DELETE FROM siswa WHERE id_siswa='$id_siswa'";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['pesan'] = 'Siswa berhasil dihapus!';
        $_SESSION['tipe'] = 'success';
    } else {
        $_SESSION['pesan'] = 'Error: ' . mysqli_error($conn);
        $_SESSION['tipe'] = 'error';
    }
    header("Location: guru_data_siswa.php");
    exit;
}
?>
