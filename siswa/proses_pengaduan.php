<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];
$aksi = $_GET['aksi'] ?? $_POST['aksi'] ?? '';

if ($aksi == 'tambah') {
    // Submit pengaduan baru dari siswa
    if (empty($_POST['jenis']) || empty($_POST['judul']) || empty($_POST['isi'])) {
        $_SESSION['pesan'] = 'Error: Jenis, judul, dan isi pengaduan harus diisi!';
        $_SESSION['tipe'] = 'error';
        header("Location: ./pengaduan.php");
        exit;
    }
    
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);
    
    // Get current timestamp
    $tanggal = date('Y-m-d H:i:s');
    
    $query = "INSERT INTO pengaduan (id_siswa, jenis, judul, isi, status, tanggal) 
              VALUES ('$id_siswa', '$jenis', '$judul', '$isi', 'baru', '$tanggal')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['pesan'] = 'Pengaduan berhasil dikirim!';
        $_SESSION['tipe'] = 'success';
        // Redirect ke halaman riwayat pengaduan siswa
        header("Location: ./riwayat_pengaduan.php");
    } else {
        $_SESSION['pesan'] = 'Error saat menyimpan pengaduan: ' . mysqli_error($conn);
        $_SESSION['tipe'] = 'error';
        header("Location: ./pengaduan.php");
    }
    exit;
}

elseif ($aksi == 'batalkan') {
    // Batalkan pengaduan yang masih baru
    $id_pengaduan = $_GET['id'] ?? 0;
    
    $query_check = "SELECT * FROM pengaduan WHERE id_pengaduan='$id_pengaduan' AND id_siswa='$id_siswa' AND status='baru'";
    $result_check = mysqli_query($conn, $query_check);
    
    if (mysqli_num_rows($result_check) > 0) {
        $query = "DELETE FROM pengaduan WHERE id_pengaduan='$id_pengaduan'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['pesan'] = 'Pengaduan berhasil dibatalkan!';
            $_SESSION['tipe'] = 'success';
        } else {
            $_SESSION['pesan'] = 'Error: ' . mysqli_error($conn);
            $_SESSION['tipe'] = 'error';
        }
    } else {
        $_SESSION['pesan'] = 'Pengaduan tidak dapat dibatalkan (sudah diproses atau bukan milik Anda)';
        $_SESSION['tipe'] = 'error';
    }
    header("Location: ./riwayat_pengaduan.php");
    exit;
}

?>
