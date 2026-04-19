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
        $token = $_POST['token'] ?? '';
        $expected_token = md5($id_notif . session_id() . 'read_confirm');
        
        // Verifikasi token keamanan
        if ($token !== $expected_token) {
            error_log("SECURITY VIOLATION: Token tidak valid untuk notifikasi ID $id_notif, siswa ID $id_siswa");
            $_SESSION['pesan'] = 'Akses tidak sah! Token keamanan tidak valid.';
            $_SESSION['tipe'] = 'error';
            header("Location: siswa/notif.php");
            exit;
        }
        
        // Log bahwa request diterima
        error_log("Request baca notifikasi ID $id_notif diterima dari siswa ID $id_siswa pada " . date('Y-m-d H:i:s'));
        
        // Verifikasi bahwa notifikasi milik user yang login
        $check_query = "SELECT id_siswa, status FROM notifikasi WHERE id_notif='$id_notif'";
        $check_result = mysqli_query($conn, $check_query);
        $check_data = mysqli_fetch_assoc($check_result);
        
        if ($check_data) {
            error_log("Notifikasi ID $id_notif ditemukan - Status: {$check_data['status']}, Pemilik: {$check_data['id_siswa']}");
            
            if ($check_data['id_siswa'] == $id_siswa && $check_data['status'] == 'belum') {
                $query = "UPDATE notifikasi SET status='sudah' WHERE id_notif='$id_notif' AND id_siswa='$id_siswa'";
                if (mysqli_query($conn, $query)) {
                    // Log perubahan status
                    error_log("Notifikasi ID $id_notif BERHASIL ditandai sebagai dibaca oleh siswa ID $id_siswa pada " . date('Y-m-d H:i:s'));
                    $_SESSION['pesan'] = 'Notifikasi ditandai sebagai dibaca.';
                    $_SESSION['tipe'] = 'success';
                } else {
                    error_log("GAGAL update notifikasi ID $id_notif: " . mysqli_error($conn));
                    $_SESSION['pesan'] = 'Gagal menandai notifikasi: ' . mysqli_error($conn);
                    $_SESSION['tipe'] = 'error';
                }
            } else {
                error_log("Notifikasi ID $id_notif TIDAK bisa diubah - User mismatch atau sudah dibaca");
                $_SESSION['pesan'] = 'Notifikasi tidak ditemukan atau sudah dibaca.';
                $_SESSION['tipe'] = 'error';
            }
        } else {
            error_log("Notifikasi ID $id_notif TIDAK ditemukan di database");
            $_SESSION['pesan'] = 'Notifikasi tidak ditemukan.';
            $_SESSION['tipe'] = 'error';
        }
    }
    
    // UPDATE - Tandai semua notifikasi sebagai dibaca
    if ($aksi == 'baca_semua') {
        $token = $_POST['token'] ?? '';
        $expected_token = md5('all_read_' . session_id() . $id_siswa);
        
        // Verifikasi token keamanan
        if ($token !== $expected_token) {
            error_log("SECURITY VIOLATION: Token tidak valid untuk baca semua notifikasi, siswa ID $id_siswa");
            $_SESSION['pesan'] = 'Akses tidak sah! Token keamanan tidak valid.';
            $_SESSION['tipe'] = 'error';
            header("Location: siswa/notif.php");
            exit;
        }
        
        $query = "UPDATE notifikasi SET status='sudah' WHERE id_siswa='$id_siswa' AND status='belum'";
        if (mysqli_query($conn, $query)) {
            error_log("Semua notifikasi siswa ID $id_siswa ditandai sebagai dibaca pada " . date('Y-m-d H:i:s'));
            $_SESSION['pesan'] = 'Semua notifikasi ditandai sebagai dibaca.';
            $_SESSION['tipe'] = 'success';
        }
    }
    
    // DELETE - Hapus notifikasi
    if ($aksi == 'hapus') {
        $id_notif = mysqli_real_escape_string($conn, $_GET['id']);
        $token = $_POST['token'] ?? '';
        $expected_token = md5($id_notif . session_id() . 'delete_confirm');
        
        // Verifikasi token keamanan
        if ($token !== $expected_token) {
            error_log("SECURITY VIOLATION: Token tidak valid untuk hapus notifikasi ID $id_notif, siswa ID $id_siswa");
            $_SESSION['pesan'] = 'Akses tidak sah! Token keamanan tidak valid.';
            $_SESSION['tipe'] = 'error';
            header("Location: siswa/notif.php");
            exit;
        }
        
        $query = "DELETE FROM notifikasi WHERE id_notif='$id_notif' AND id_siswa='$id_siswa'";
        if (mysqli_query($conn, $query)) {
            error_log("Notifikasi ID $id_notif dihapus oleh siswa ID $id_siswa pada " . date('Y-m-d H:i:s'));
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
