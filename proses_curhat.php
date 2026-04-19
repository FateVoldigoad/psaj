<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';
    
    // CREATE - Simpan curhat/pertanyaan baru
    if ($aksi == 'kirim') {
        $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
        $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);
        
        // Validasi
        if (empty($kategori) || empty($pesan)) {
            $_SESSION['pesan'] = 'Kategori dan isi curhat tidak boleh kosong!';
            $_SESSION['tipe'] = 'error';
        } else {
            // Insert ke chat table - gunakan id_bk=1 (Guru BK utama)
            $query = "INSERT INTO chat (id_siswa, id_bk, pengirim, kategori, pesan, dibaca, waktu) 
                      VALUES ('$id_siswa', 1, 'siswa', '$kategori', '$pesan', 'belum', NOW())";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['pesan'] = '✨ Curhatmu telah dikirim! Guru BK akan segera meresponnya.';
                $_SESSION['tipe'] = 'success';
            } else {
                $_SESSION['pesan'] = 'Gagal mengirim curhat: ' . mysqli_error($conn);
                $_SESSION['tipe'] = 'error';
            }
        }
    }
    
    // CREATE - Siswa membalas pesan guru
    if ($aksi == 'balas') {
        $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);
        
        // Validasi
        if (empty($pesan)) {
            $_SESSION['pesan'] = 'Isi balasan tidak boleh kosong!';
            $_SESSION['tipe'] = 'error';
        } else {
            // Insert ke chat table - balasan siswa
            $query = "INSERT INTO chat (id_siswa, id_bk, pengirim, pesan, dibaca, waktu) 
                      VALUES ('$id_siswa', 1, 'siswa', '$pesan', 'belum', NOW())";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['pesan'] = '✨ Balaasanmu telah dikirim ke Guru BK!';
                $_SESSION['tipe'] = 'success';
                
                // Buat notifikasi untuk guru
                $query_notif = "INSERT INTO notifikasi (id_siswa, id_bk, judul, pesan, tipe, status, waktu) 
                               VALUES ('$id_siswa', 1, 'Balasan Siswa Baru', 'Siswa telah membalas curhatnya. Silakan cek balasan kami.', 'chat', 'belum', NOW())";
                if (!mysqli_query($conn, $query_notif)) {
                    error_log("Gagal membuat notifikasi: " . mysqli_error($conn));
                }
            } else {
                $_SESSION['pesan'] = 'Gagal mengirim balasan: ' . mysqli_error($conn);
                $_SESSION['tipe'] = 'error';
            }
        }
    }
    
    // DELETE - Hapus curhat (optional)
    if ($aksi == 'hapus') {
        $id_chat = mysqli_real_escape_string($conn, $_GET['id']);
        
        // Cek apakah curhat milik siswa yang login
        $check = mysqli_query($conn, "SELECT id_siswa, pengirim FROM chat WHERE id_chat='$id_chat'");
        $row = mysqli_fetch_assoc($check);
        
        if ($row && $row['id_siswa'] == $id_siswa && $row['pengirim'] == 'siswa') {
            $delete = mysqli_query($conn, "DELETE FROM chat WHERE id_chat='$id_chat'");
            if ($delete) {
                $_SESSION['pesan'] = 'Curhat telah dihapus.';
                $_SESSION['tipe'] = 'success';
            } else {
                $_SESSION['pesan'] = 'Gagal menghapus curhat: ' . mysqli_error($conn);
                $_SESSION['tipe'] = 'error';
            }
        } else {
            $_SESSION['pesan'] = 'Anda tidak memiliki akses untuk menghapus curhat ini.';
            $_SESSION['tipe'] = 'error';
        }
    }
}

header("Location: siswa/curhat.php");
exit;
?>
