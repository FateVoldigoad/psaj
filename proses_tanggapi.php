<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

$id_bk = $_SESSION['id_bk'];
$aksi = $_GET['aksi'] ?? '';

if ($aksi == 'tanggapi') {
    // Guru memberikan tanggapan untuk pengaduan
    $id_pengaduan = $_POST['id_pengaduan'] ?? 0;
    $tanggapan = mysqli_real_escape_string($conn, $_POST['tanggapan']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Cek apakah pengaduan ada dan belum ditugaskan ke guru lain
    $query_check = "SELECT * FROM pengaduan WHERE id_pengaduan='$id_pengaduan'";
    $result_check = mysqli_query($conn, $query_check);
    $pengaduan = mysqli_fetch_assoc($result_check);
    
    if ($pengaduan) {
        // Update pengaduan dengan tanggapan
        $query = "UPDATE pengaduan SET 
                  tanggapan='$tanggapan', 
                  status='$status', 
                  id_bk='$id_bk',
                  tanggal_tanggapan=NOW()
                  WHERE id_pengaduan='$id_pengaduan'";
        
        if (mysqli_query($conn, $query)) {
            // Create notification untuk siswa
            $id_siswa = $pengaduan['id_siswa'];
            $judul_notif = "Pengaduan Sudah Ditanggapi";
            $pesan_notif = "Pengaduan Anda sudah ditanggapi oleh Guru BK. Silakan cek balasan kami.";
            $link_notif = "siswa/riwayat_pengaduan.php?id=" . $id_pengaduan;
            
            $query_notif = "INSERT INTO notifikasi (id_siswa, id_bk, judul, pesan, tipe, status, link, waktu) 
                           VALUES ('$id_siswa', '$id_bk', '$judul_notif', '$pesan_notif', 'pengaduan', 'belum', '$link_notif', NOW())";
            if (mysqli_query($conn, $query_notif)) {
                $notif_id = mysqli_insert_id($conn);
                error_log("Notifikasi pengaduan baru DIBUAT untuk siswa ID $id_siswa dengan ID notifikasi $notif_id pada " . date('Y-m-d H:i:s'));
            } else {
                error_log("Gagal membuat notifikasi pengaduan untuk siswa ID $id_siswa: " . mysqli_error($conn));
            }
            
            $_SESSION['pesan'] = 'Tanggapan berhasil dikirim!';
            $_SESSION['tipe'] = 'success';
        } else {
            $_SESSION['pesan'] = 'Error: ' . mysqli_error($conn);
            $_SESSION['tipe'] = 'error';
        }
    } else {
        $_SESSION['pesan'] = 'Pengaduan tidak ditemukan!';
        $_SESSION['tipe'] = 'error';
    }
    
    header("Location: guru_data_pengaduan.php");
    exit;
}

?>
