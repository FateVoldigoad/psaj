<?php
session_start();
include 'koneksi.php';

$role = $_POST['role'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$error = '';

if (empty($username) || empty($password)) {
    $error = 'Username dan password harus diisi!';
} else {
    if ($role == 'siswa') {
        // Login siswa - gunakan nisn sebagai username
        $username_escaped = mysqli_real_escape_string($conn, $username);
        $password_escaped = mysqli_real_escape_string($conn, $password);
        
        $query = "SELECT * FROM siswa WHERE (nisn='$username_escaped' OR email='$username_escaped') AND password='$password_escaped' AND status='aktif'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $siswa = mysqli_fetch_assoc($result);
            $_SESSION['id_siswa'] = $siswa['id_siswa'];
            $_SESSION['nama_siswa'] = $siswa['nama'];
            $_SESSION['nisn'] = $siswa['nisn'];
            $_SESSION['role'] = 'siswa';
            
            header("Location: siswa/dashboard.php");
            exit;
        } else {
            $error = 'NISN/Email atau password salah!';
        }
    } 
    elseif ($role == 'guru') {
        // Login guru
        $username_escaped = mysqli_real_escape_string($conn, $username);
        $password_escaped = mysqli_real_escape_string($conn, $password);
        
        $query = "SELECT * FROM guru_bk WHERE (username='$username_escaped' OR email='$username_escaped') AND password='$password_escaped' AND status='aktif'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $guru = mysqli_fetch_assoc($result);
            $_SESSION['id_bk'] = $guru['id_bk'];
            $_SESSION['nama_guru'] = $guru['nama'];
            $_SESSION['username_guru'] = $guru['username'];
            $_SESSION['role'] = 'guru';
            
            header("Location: guru_dashboard.php");
            exit;
        } else {
            $error = 'Username/Email atau password salah!';
        }
    } else {
        $error = 'Role tidak valid!';
    }
}

// Jika ada error, kembali ke halaman login dengan pesan
$_SESSION['error'] = $error;
header("Location: index.php");
exit;

?>
