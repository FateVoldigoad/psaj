<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- Navigation Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="assets/Logo.png" alt="Logo" class="logo">
                <h1 class="brand-name">SMKN 10 SURABAYA</h1>
            </div>
            <div class="header-actions">
                <a href="notif.php" class="notif-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notif-badge">2</span>
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
                <h2 class="welcome-title">Selamat Datang! 👋</h2>
                <p class="welcome-subtitle">Pusat Layanan Pengaduan & Konsultasi Siswa</p>
                <p class="welcome-desc">Silakan pilih layanan yang ingin digunakan untuk melaporkan atau berkonsultasi dengan Guru BK</p>
            </div>
        </section>

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