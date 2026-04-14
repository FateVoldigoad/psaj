<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];
$nama = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$password_lama = $_POST['password_lama'] ?? '';
$password_baru = $_POST['password_baru'] ?? '';
$password_konfirmasi = $_POST['password_konfirmasi'] ?? '';

// Validasi input
$error = '';
if (empty($nama)) {
    $error = 'Nama tidak boleh kosong';
} elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Email tidak valid';
}

// Jika ada password baru, validasi password
if (!empty($password_baru) || !empty($password_konfirmasi)) {
    if (empty($password_lama)) {
        $error = 'Masukkan password saat ini untuk mengubah password';
    } elseif (strlen($password_baru) < 6) {
        $error = 'Password baru minimal 6 karakter';
    } elseif ($password_baru !== $password_konfirmasi) {
        $error = 'Password baru dan konfirmasi tidak sesuai';
    }
}

// Jika ada error, redirect kembali ke edit_profile
if (!empty($error)) {
    $_SESSION['error'] = $error;
    header("Location: edit_profile.php");
    exit;
}

// Get current siswa data to verify password
$query = "SELECT password FROM siswa WHERE id_siswa = $id_siswa";
$result = mysqli_query($conn, $query);
$siswa = mysqli_fetch_assoc($result);

// Jika ada password lama untuk diverifikasi
if (!empty($password_lama)) {
    if ($password_lama !== $siswa['password']) {
        $_SESSION['error'] = 'Password saat ini tidak cocok';
        header("Location: edit_profile.php");
        exit;
    }
}

// Update siswa
$update_query = "UPDATE siswa SET nama = '$nama', email = '$email'";

// Jika ada password baru, tambahkan ke query
if (!empty($password_baru)) {
    $hashed_password = $password_baru; // Ideally use password_hash() untuk security
    $update_query .= ", password = '$hashed_password'";
}

$update_query .= " WHERE id_siswa = $id_siswa";

if (mysqli_query($conn, $update_query)) {
    $_SESSION['pesan'] = 'Profil berhasil diperbarui!';
    header("Location: edit_profile.php");
} else {
    $_SESSION['error'] = 'Gagal memperbarui profil: ' . mysqli_error($conn);
    header("Location: edit_profile.php");
}
?>
