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
    header("Location: profile.php");
    exit;
}

// Check for success message
$success_msg = '';
if (isset($_SESSION['pesan'])) {
    $success_msg = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Siswa</title>
    <link rel="stylesheet" href="css/edit_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: none;
        }
        .alert.show {
            display: block;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
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
        <!-- Back Button -->
        <a href="profile.php" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Profil
        </a>

        <!-- Edit Profile Section -->
        <section class="edit-profile-section">
            <!-- Page Title -->
            <div class="page-title">
                <h2>Edit Profil Siswa</h2>
                <p>Perbarui informasi profil Anda</p>
            </div>

            <!-- Success/Error Alert -->
            <?php if (!empty($success_msg)): ?>
                <div class="alert alert-success show">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_msg); ?>
                </div>
            <?php endif; ?>

            <!-- Edit Form -->
            <form class="edit-form" id="editForm" method="POST" action="proses_edit_profile.php">
                <!-- Personal Information -->
                <div class="form-group">
                    <h3 class="form-section-title">Informasi Profil</h3>
                    
                    <div class="form-field">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" value="<?php echo htmlspecialchars($siswa['nama']); ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label for="nisn">NISN</label>
                            <input type="text" id="nisn" name="nisn" placeholder="Masukkan NISN" value="<?php echo htmlspecialchars($siswa['nisn']); ?>" readonly>
                        </div>
                        <div class="form-field">
                            <label for="kelas">Kelas</label>
                            <input type="text" id="kelas" name="kelas" placeholder="Masukkan kelas" value="<?php echo htmlspecialchars($siswa['nama_kelas'] ?? '-'); ?>" readonly>
                        </div>
                    </div>

                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email" value="<?php echo htmlspecialchars($siswa['email']); ?>" required>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="form-group">
                    <h3 class="form-section-title">Ubah Password</h3>
                    <p style="color: #666; font-size: 14px; margin-bottom: 15px;">Kosongkan jika tidak ingin mengubah password</p>
                    
                    <div class="form-field">
                        <label for="password_lama">Password Saat Ini</label>
                        <div class="password-input-group">
                            <input type="password" id="password_lama" name="password_lama" placeholder="Masukkan password saat ini">
                            <button type="button" class="toggle-password" data-target="password_lama">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label for="password_baru">Password Baru</label>
                            <div class="password-input-group">
                                <input type="password" id="password_baru" name="password_baru" placeholder="Masukkan password baru (minimal 6 karakter)">
                                <button type="button" class="toggle-password" data-target="password_baru">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="password_konfirmasi">Konfirmasi Password</label>
                            <div class="password-input-group">
                                <input type="password" id="password_konfirmasi" name="password_konfirmasi" placeholder="Konfirmasi password baru">
                                <button type="button" class="toggle-password" data-target="password_konfirmasi">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="profile.php" class="btn btn-cancel">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>
    </div>

    <script>
        // Toggle password visibility
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Form submission with validation
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const passwordBaru = document.getElementById('password_baru').value;
            const passwordKonfirmasi = document.getElementById('password_konfirmasi').value;
            const passwordLama = document.getElementById('password_lama').value;

            // Jika ada password baru, validasi
            if (passwordBaru || passwordKonfirmasi) {
                if (!passwordLama) {
                    e.preventDefault();
                    alert('Masukkan password saat ini terlebih dahulu!');
                    return;
                }
                
                if (passwordBaru.length < 6) {
                    e.preventDefault();
                    alert('Password baru minimal 6 karakter!');
                    return;
                }
                
                if (passwordBaru !== passwordKonfirmasi) {
                    e.preventDefault();
                    alert('Password baru dan konfirmasi tidak sesuai!');
                    return;
                }
            }
        });

        // Auto-hide success alert after 5 seconds
        const alert = document.querySelector('.alert-success');
        if (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>
