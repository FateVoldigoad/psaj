<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

$aksi = $_POST['aksi'] ?? '';
$id_bk = $_SESSION['id_bk'];

if ($aksi == 'update_profil') {
    // UPDATE - Edit profil guru
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telpon = mysqli_real_escape_string($conn, $_POST['telpon']);
    
    // Validasi
    if (empty($nama) || empty($email)) {
        $_SESSION['pesan'] = 'Nama dan Email harus diisi!';
        $_SESSION['tipe'] = 'error';
    } else {
        // Update guru profil
        $query = "UPDATE guru_bk SET nama='$nama', email='$email', telpon='$telpon' WHERE id_bk='$id_bk'";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['pesan'] = 'Profil berhasil diperbarui!';
            $_SESSION['tipe'] = 'success';
            $_SESSION['nama_guru'] = $nama;
        } else {
            $_SESSION['pesan'] = 'Error: ' . mysqli_error($conn);
            $_SESSION['tipe'] = 'error';
        }
    }
    header("Location: guru_pengaturan.php");
    exit;
}

else if ($aksi == 'update_password') {
    // UPDATE PASSWORD - Ubah password guru
    $password_lama = mysqli_real_escape_string($conn, $_POST['password_lama']);
    $password_baru = mysqli_real_escape_string($conn, $_POST['password_baru']);
    $password_konfirmasi = mysqli_real_escape_string($conn, $_POST['password_konfirmasi']);
    
    // Validasi
    if (empty($password_lama) || empty($password_baru) || empty($password_konfirmasi)) {
        $_SESSION['pesan'] = 'Semua field password harus diisi!';
        $_SESSION['tipe'] = 'error';
    } else if ($password_baru !== $password_konfirmasi) {
        $_SESSION['pesan'] = 'Password baru tidak cocok dengan konfirmasi!';
        $_SESSION['tipe'] = 'error';
    } else if (strlen($password_baru) < 6) {
        $_SESSION['pesan'] = 'Password minimal 6 karakter!';
        $_SESSION['tipe'] = 'error';
    } else {
        // Get guru data untuk verifikasi password lama
        $query_check = "SELECT password FROM guru_bk WHERE id_bk='$id_bk'";
        $result_check = mysqli_query($conn, $query_check);
        $guru = mysqli_fetch_assoc($result_check);
        
        // Cek password lama
        if ($password_lama !== $guru['password']) {
            $_SESSION['pesan'] = 'Password lama tidak sesuai!';
            $_SESSION['tipe'] = 'error';
        } else {
            // Update password
            $query_update = "UPDATE guru_bk SET password='$password_baru' WHERE id_bk='$id_bk'";
            
            if (mysqli_query($conn, $query_update)) {
                $_SESSION['pesan'] = 'Password berhasil diubah!';
                $_SESSION['tipe'] = 'success';
            } else {
                $_SESSION['pesan'] = 'Error: ' . mysqli_error($conn);
                $_SESSION['tipe'] = 'error';
            }
        }
    }
    header("Location: guru_pengaturan.php");
    exit;
}
?>
