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
                <img src="assets/Logo.png" alt="Logo" class="logo">
                <h1 class="brand-name">SMKN 10 SURABAYA</h1>
            </div>
            <div class="header-actions">
                <a href="notif.php" class="notif-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notif-badge">2</span>
                </a>
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
                    <h1 class="profile-name">Muhammad Rizki Pratama</h1>
                    <p class="profile-nisn">NISN: 0123456789</p>
                    <p class="profile-class">Kelas: XII RPL 1</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="edit_profile.php" class="edit-btn">
                    <i class="fas fa-edit"></i>
                    Edit Profil
                </a>
                <a href="../index.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </section>
    </div>
</body>
</html>
