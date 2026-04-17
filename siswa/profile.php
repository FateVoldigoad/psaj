<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../index.php");
    exit;
}

// Get siswa data dari database
$id_siswa = $_SESSION['id_siswa'];
$query = "SELECT s.*, k.nama_kelas FROM siswa s 
          LEFT JOIN kelas k ON s.id_kelas = k.id_kelas 
          WHERE s.id_siswa = $id_siswa";
$result = mysqli_query($conn, $query);
$siswa = mysqli_fetch_assoc($result);

if (!$siswa) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- Navigation Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
             <i class="fa-solid fa-shield-heart fa-3x"></i>
                <h1 class="brand-name">SPEAKTEN</h1>
            </div>
            <div class="header-actions">
                <a href="notif.php" class="notif-btn">
                    <i class="fas fa-bell"></i>
                    
                <a href="profile.php" class="profile-btn active">
                    <i class="fas fa-user-circle"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Background Decoration -->
    <div class="shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Back Button -->
        <a href="dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

        <!-- Profile Section -->
        <section class="profile-section">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <h1 class="profile-name"><?php echo htmlspecialchars($siswa['nama']); ?></h1>
                    <p class="profile-nisn">NISN: <?php echo htmlspecialchars($siswa['nisn']); ?></p>
                    <p class="profile-class">Kelas: <?php echo htmlspecialchars($siswa['nama_kelas'] ?? '-'); ?></p>
                    <p class="profile-email"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($siswa['email']); ?></p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="edit_profile.php" class="edit-btn">
                    <i class="fas fa-edit"></i>
                    Edit Profil
                </a>
                <a href="../logout.php" class="logout-btn" onclick="return confirm('Yakin ingin logout?');">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </section>
    </div>
</body>
</html>
