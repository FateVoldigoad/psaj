<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Siswa</title>
    <link rel="stylesheet" href="css/edit_profile.css">
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

            <!-- Edit Form -->
            <form class="edit-form" id="editForm">
                <!-- Personal Information -->
                <div class="form-group">
                    <h3 class="form-section-title">Informasi Profil</h3>
                    
                    <div class="form-field">
                        <label for="fullname">Nama Lengkap</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Masukkan nama lengkap" value="Muhammad Rizki Pratama">
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label for="nisn">NISN</label>
                            <input type="text" id="nisn" name="nisn" placeholder="Masukkan NISN" value="0123456789" readonly>
                        </div>
                        <div class="form-field">
                            <label for="class">Kelas</label>
                            <input type="text" id="class" name="class" placeholder="Masukkan kelas" value="XII RPL 1">
                        </div>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="form-group">
                    <h3 class="form-section-title">Ubah Password</h3>
                    
                    <div class="form-field">
                        <label for="currentPassword">Password Saat Ini</label>
                        <div class="password-input-group">
                            <input type="password" id="currentPassword" name="currentPassword" placeholder="Masukkan password saat ini">
                            <button type="button" class="toggle-password" data-target="currentPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label for="newPassword">Password Baru</label>
                            <div class="password-input-group">
                                <input type="password" id="newPassword" name="newPassword" placeholder="Masukkan password baru">
                                <button type="button" class="toggle-password" data-target="newPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="confirmPassword">Konfirmasi Password</label>
                            <div class="password-input-group">
                                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Konfirmasi password baru">
                                <button type="button" class="toggle-password" data-target="confirmPassword">
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
            e.preventDefault();
            
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Check if password fields are filled
            if ((newPassword || confirmPassword) && newPassword !== confirmPassword) {
                alert('Password baru dan konfirmasi password tidak cocok!');
                return;
            }
            
            alert('Profil berhasil diperbarui!');
            window.location.href = 'profile.php';
        });
    </script>
</body>
</html>
