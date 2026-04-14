<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // UPDATE - Tandai notifikasi sebagai dibaca
    if ($aksi == 'baca') {
        $id_notif = mysqli_real_escape_string($conn, $_GET['id']);
        
        $query = "UPDATE notifikasi SET status='sudah' WHERE id_notif='$id_notif' AND id_siswa='$id_siswa'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['pesan'] = 'Notifikasi ditandai sebagai dibaca.';
            $_SESSION['tipe'] = 'success';
        }
    }
    
    // UPDATE - Tandai semua notifikasi sebagai dibaca
    if ($aksi == 'baca_semua') {
        $query = "UPDATE notifikasi SET status='sudah' WHERE id_siswa='$id_siswa' AND status='belum'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['pesan'] = 'Semua notifikasi ditandai sebagai dibaca.';
            $_SESSION['tipe'] = 'success';
        }
    }
    
    // DELETE - Hapus notifikasi
    if ($aksi == 'hapus') {
        $id_notif = mysqli_real_escape_string($conn, $_GET['id']);
        
        $query = "DELETE FROM notifikasi WHERE id_notif='$id_notif' AND id_siswa='$id_siswa'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['pesan'] = 'Notifikasi telah dihapus.';
            $_SESSION['tipe'] = 'success';
        } else {
            $_SESSION['pesan'] = 'Gagal menghapus notifikasi: ' . mysqli_error($conn);
            $_SESSION['tipe'] = 'error';
        }
    }
}

header("Location: siswa/notif.php");
exit;
?>
