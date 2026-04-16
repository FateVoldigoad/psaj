<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];

// Get siswa data
$query_siswa = "SELECT * FROM siswa WHERE id_siswa='$id_siswa'";
$result_siswa = mysqli_query($conn, $query_siswa);
$siswa = mysqli_fetch_assoc($result_siswa);


$query_notif_belum = "SELECT COUNT(*) as belum FROM notifikasi WHERE id_siswa='$id_siswa' AND status='belum'";
$result_notif = mysqli_query($conn, $query_notif_belum);
$notif_belum = mysqli_fetch_assoc($result_notif)['belum'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPEAKTEN</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; }
        .stat-number { font-size: 32px; font-weight: bold; color: #007bff; }
        .stat-label { font-size: 14px; color: #666; margin-top: 5px; }
        .recent-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-top: 20px; }
    </style>
</head>
<body>
    <!-- Navigation Header -->
   <header class="header">
    <div class="header-content">

        <!-- BAGIAN KIRI -->
        <div class="logo-section" style="display: flex; align-items: center; gap: 15px;">
            <img src="../assets/logos.png" alt="logo" style="width: 150px; height: 60px; object-fit: contain;">
            
            <div>
                <h1 class="brand-name" style="margin: 0;">SPEAKTEN</h1>
                <p style="font-size: 14px; color: #666; margin: 0;">
                    Selamat datang, <?php echo htmlspecialchars($siswa['nama']); ?> 👋
                </p>
            </div>
        </div>

        <!-- BAGIAN KANAN -->
        <div class="header-actions">
            <a href="notif.php" class="notif-btn">
                <i class="fas fa-bell"></i>
                <?php if ($notif_belum > 0): ?>
                    <span class="notif-badge"><?php echo $notif_belum; ?></span>
                <?php endif; ?>
            </a>

            <a href="profile.php" class="profile-btn">
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
        <!-- Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-content">
            <h2 class="welcome-title" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
    <span>Dashboard Siswa</span>
    <img src="../assets/interaction.png" alt="logo" style="width: 40px; height: 40px;">
</h2>
                <p class="welcome-desc">Akses layanan pengaduan, konsultasi, dan komunikasi dengan Guru BK secara mudah, aman, dan nyaman dalam satu platform</p>
            </div>
        </section>

        <!-- Statistics Section -->
        

        <!-- Services Grid -->
        <section class="services-grid">
            <!-- Service Card 1 -->
            <a href="pengaduan.php" class="service-card card-gradient-1">
                <div class="card-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Pengaduan Laporan</h3>
                    <p class="card-description">Sampaikan pengaduan Anda kepada Guru BK dengan lengkap</p>
                    <div class="card-footer">
                        <span class="card-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Service Card 2 -->
            <a href="curhat.php" class="service-card card-gradient-2">
                <div class="card-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Curhat & Konsultasi</h3>
                    <p class="card-description">Konsultasi atau curhat dengan Guru BK secara pribadi</p>
                    <div class="card-footer">
                        <span class="card-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
        </section>

        <!-- Info Section -->
        <section class="info-section">
            <div class="info-card">
                <i class="fas fa-shield-alt"></i>
                <h4>Aman & Rahasia</h4>
                <p>Data Anda terlindungi dengan baik</p>
            </div>
            <div class="info-card">
                <i class="fas fa-heart"></i>
                <h4>Dukungan Penuh</h4>
                <p>Guru BK siap membantu kapan saja</p>
            </div>
            <div class="info-card">
                <i class="fas fa-check-circle"></i>
                <h4>Cepat & Efisien</h4>
                <p>Layanan responsif untuk masalah Anda</p>
            </div>
        </section>
    </div>

</body>
</html>