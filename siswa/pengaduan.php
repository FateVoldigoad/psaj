<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];

// Get data siswa
$query_siswa = "SELECT * FROM siswa WHERE id_siswa='$id_siswa'";
$result_siswa = mysqli_query($conn, $query_siswa);
$siswa = mysqli_fetch_assoc($result_siswa);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan - PSAJ</title>
    <link rel="stylesheet" href="css/pengaduan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- Floating Stars Background -->
<div class="floating-stars" id="floatingStars"></div>

<div class="complaint-container">
    
    <!-- Header Section -->
    <div class="complaint-header">
        <h1>📝 Pengaduan & Laporan</h1>
        <p>Sampaikan pengaduan atau laporan Anda kepada Guru Bimbingan Konseling dengan aman dan terjaga kerahasiaannya</p>
    </div>

    <!-- Main Wrapper -->
    <div class="complaint-wrapper">

        <!-- Form Section -->
        <div class="complaint-form-section">
            <div class="complaint-form-card">
                <h2>Form Pengaduan Baru</h2>

                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                    <span>/</span>
                    <span>Form Pengaduan</span>
                </div>

                <!-- Alert Messages -->
                <?php if (isset($_SESSION['pesan'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['tipe']; ?>">
                        <i class="fas fa-<?php echo $_SESSION['tipe'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                        <?php echo $_SESSION['pesan']; ?>
                    </div>
                    <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
                <?php endif; ?>

                <!-- Info Box -->
                <div class="info-box">
                    <strong><i class="fas fa-info-circle"></i> Informasi Penting:</strong>
                    Pengaduan Anda akan ditinjau oleh Guru BK dalam waktu maksimal 3 hari kerja. Semua informasi yang Anda berikan akan dirahasiakan.
                </div>

                <!-- Form -->
                <form method="POST" action="proses_pengaduan.php" enctype="multipart/form-data">
                    <input type="hidden" name="aksi" value="tambah">
                    
                    <!-- User Info Section -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" readonly disabled>
                        </div>
                        <div class="form-group">
                            <label for="nisn">NISN</label>
                            <input type="text" id="nisn" name="nisn" value="<?php echo htmlspecialchars($siswa['nisn']); ?>" readonly disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" id="kelas" name="kelas" value="<?php 
                            $query_kelas = "SELECT nama_kelas FROM kelas WHERE id_kelas='{$siswa['id_kelas']}'";
                            $result_kelas = mysqli_query($conn, $query_kelas);
                            if (mysqli_num_rows($result_kelas) > 0) {
                                $kelas = mysqli_fetch_assoc($result_kelas);
                                echo htmlspecialchars($kelas['nama_kelas']);
                            }
                        ?>" readonly disabled>
                    </div>

                    <!-- Complaint Type -->
                    <div class="form-group">
                        <label for="jenis">Jenis Pengaduan <span class="required">*</span></label>
                        <select id="jenis" name="jenis" required>
                            <option value="">-- Pilih Jenis Pengaduan --</option>
                            <option value="pengaduan">📢 Pengaduan</option>
                            <option value="laporan">📋 Laporan</option>
                        </select>
                    </div>

                    <!-- Title -->
                    <div class="form-group">
                        <label for="judul">Judul Pengaduan <span class="required">*</span></label>
                        <input type="text" id="judul" name="judul" placeholder="Masukkan judul pengaduan Anda..." required maxlength="150">
                    </div>

                    <!-- Content -->
                    <div class="form-group">
                        <label for="isi">Isi Pengaduan <span class="required">*</span></label>
                        <textarea id="isi" name="isi" placeholder="Jelaskan secara detail pengaduan atau laporan Anda. Tuliskan fakta-fakta yang akurat dan objektif..." required maxlength="5000"></textarea>
                        <span class="char-count"><span id="charCount">0</span>/5000</span>
                    </div>

                    <!-- Buttons -->
                    <div class="btn-group">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                        </button>
                        <a href="dashboard.php" class="btn btn-cancel">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

<script>
    // Floating Stars Animation
    function createFloatingStars() {
        const container = document.getElementById('floatingStars');
        const stars = ['✨', '⭐', '💫', '🌟'];
        const starCount = 30;

        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.className = 'floating-star';
            star.textContent = stars[Math.floor(Math.random() * stars.length)];
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 8 + 's';
            star.style.animationDuration = (Math.random() * 4 + 6) + 's';
            container.appendChild(star);
        }
    }

    // Character Count
    document.getElementById('isi').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });

    // Initialize on page load
    window.addEventListener('DOMContentLoaded', createFloatingStars);
</script>

</body>
</html>