<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

$id_bk = $_SESSION['id_bk'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';
    
    // CREATE - Guru memberikan jawaban/respons
    if ($aksi == 'balas') {
        $id_chat_original = mysqli_real_escape_string($conn, $_POST['id_chat_original']);
        $id_siswa = mysqli_real_escape_string($conn, $_POST['id_siswa']);
        $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);
        
        // Validasi
        if (empty($pesan)) {
            $_SESSION['pesan'] = 'Isi balasan tidak boleh kosong!';
            $_SESSION['tipe'] = 'error';
        } else {
            // Insert respons guru ke chat table
            $query = "INSERT INTO chat (id_siswa, id_bk, pengirim, pesan, dibaca, waktu) 
                      VALUES ('$id_siswa', '$id_bk', 'guru', '$pesan', 'belum', NOW())";
            
            if (mysqli_query($conn, $query)) {
                // Update pesan asli siswa agar terbaca
                $update = mysqli_query($conn, "UPDATE chat SET dibaca='sudah' WHERE id_chat='$id_chat_original'");
                
                $_SESSION['pesan'] = '✅ Balasan telah dikirim ke siswa.';
                $_SESSION['tipe'] = 'success';
                
                // Buat notifikasi untuk siswa
                $query_notif = "INSERT INTO notifikasi (id_siswa, id_bk, judul, pesan, tipe, status, waktu) 
                               VALUES ('$id_siswa', '$id_bk', 'Balasan Curhat Baru', 'Guru BK telah membalas curhatmu. Silakan cek balasan kami.', 'chat', 'belum', NOW())";
                if (mysqli_query($conn, $query_notif)) {
                    $notif_id = mysqli_insert_id($conn);
                    error_log("Notifikasi chat baru DIBUAT untuk siswa ID $id_siswa dengan ID notifikasi $notif_id pada " . date('Y-m-d H:i:s'));
                } else {
                    error_log("Gagal membuat notifikasi chat untuk siswa ID $id_siswa: " . mysqli_error($conn));
                }
            } else {
                $_SESSION['pesan'] = 'Gagal mengirim balasan: ' . mysqli_error($conn);
                $_SESSION['tipe'] = 'error';
            }
        }
    }
    
    // UPDATE - Tandai sebagai dibaca
    if ($aksi == 'baca') {
        $id_chat = mysqli_real_escape_string($conn, $_GET['id']);
        
        $query = "UPDATE chat SET dibaca='sudah' WHERE id_chat='$id_chat' AND id_siswa IS NOT NULL";
        if (mysqli_query($conn, $query)) {
            $_SESSION['pesan'] = 'Pesan ditandai sebagai sudah dibaca.';
            $_SESSION['tipe'] = 'success';
        }
    }
    
    // DELETE - Hapus pesan (soft delete atau hard delete)
    if ($aksi == 'hapus') {
        $id_chat = mysqli_real_escape_string($conn, $_GET['id']);
        
        $delete = mysqli_query($conn, "DELETE FROM chat WHERE id_chat='$id_chat'");
        if ($delete) {
            $_SESSION['pesan'] = 'Pesan telah dihapus.';
            $_SESSION['tipe'] = 'success';
        } else {
            $_SESSION['pesan'] = 'Gagal menghapus pesan: ' . mysqli_error($conn);
            $_SESSION['tipe'] = 'error';
        }
    }
}

header("Location: guru_pesan_masuk.php");
exit;
?>
