<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];

// Get all notifications untuk siswa ini
$query = "SELECT n.*, g.nama as guru_nama 
          FROM notifikasi n
          LEFT JOIN guru_bk g ON n.id_bk = g.id_bk
          WHERE n.id_siswa = '$id_siswa'
          ORDER BY n.waktu DESC";
$result = mysqli_query($conn, $query);
$notifications = [];
while ($row = mysqli_fetch_assoc($result)) {
    $notifications[] = $row;
}

// Count unread notifications
$query_unread = "SELECT COUNT(*) as total FROM notifikasi WHERE id_siswa='$id_siswa' AND status='belum'";
$result_unread = mysqli_query($conn, $query_unread);
$unread_data = mysqli_fetch_assoc($result_unread);
$total_unread = $unread_data['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Jawaban Guru BK</title>
    <link rel="stylesheet" href="css/notif.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .notif-header-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-mark-all { background: #2196F3; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-mark-all:hover { background: #1976D2; }
        .notification-item { 
            background: white; 
            padding: 20px; 
            margin-bottom: 15px; 
            border-radius: 8px; 
            border-left: 4px solid #2196F3;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            animation: slideInLeft 0.3s ease;
        }
        .notification-item.unread { background: #f0f8ff; }
        .notification-item.read { opacity: 0.8; }
        .notification-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px; }
        .notification-category { 
            display: inline-block;
            padding: 4px 12px; 
            background: #e3f2fd; 
            color: #1976D2; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: bold;
        }
        .notification-date { font-size: 12px; color: #999; }
        .notification-title { font-size: 16px; font-weight: 600; color: #333; margin-bottom: 8px; }
        .notification-message { font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 10px; }
        .notification-teacher { font-size: 12px; color: #2196F3; margin-top: 10px; }
        .notification-actions { 
            display: flex; 
            gap: 10px; 
            margin-top: 12px; 
            padding-top: 12px; 
            border-top: 1px solid #eee;
        }
        .btn-action { 
            font-size: 12px; 
            padding: 6px 12px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-read { background: #4CAF50; color: white; }
        .btn-read:hover { background: #45a049; }
        .btn-delete { background: #f44336; color: white; }
        .btn-delete:hover { background: #da190b; }
        .empty-state { text-align: center; padding: 60px 20px; color: #999; }
        .empty-icon { font-size: 60px; margin-bottom: 20px; }
        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="floating-stars"></div>

        <!-- Header -->
        <div class="wishing-header">
            <h1>💌 Jawaban dari Guru BK</h1>
            <p>Lihat jawaban dan bimbingan dari guru untuk setiap pertanyaanmu</p>
        </div>

        <!-- Notifications Section -->
        <div class="notifications-section">
            <div style="margin-bottom: 20px;">
                <div class="notif-header-top">
                    <h2>📬 Notifikasi Anda (<?php echo $total_unread > 0 ? $total_unread . ' Belum Dibaca' : 'Semua Sudah Dibaca'; ?>)</h2>
                    <?php if ($total_unread > 0): ?>
                    <form method="POST" action="../proses_notifikasi.php?aksi=baca_semua" style="display: inline;">
                        <button type="submit" class="btn-mark-all">Tandai Semua Sebagai Dibaca</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="notifications-container" id="notificationsContainer">
                <?php if (count($notifications) === 0): ?>
                <div class="empty-state">
                    <div class="empty-icon">📬</div>
                    <p style="font-size: 18px;">Belum ada notifikasi</p>
                    <small>Notifikasi akan muncul di sini ketika Guru BK membalas pertanyaanmu atau tanggapan pengaduanmu</small>
                </div>
                <?php else: ?>
                    <?php foreach ($notifications as $notif): ?>
                    <div class="notification-item <?php echo $notif['status'] == 'belum' ? 'unread' : 'read'; ?>" id="notif-<?php echo $notif['id_notif']; ?>">
                        <div class="notification-header">
                            <div>
                                <span class="notification-category">
                                    <?php
                                        if ($notif['tipe'] == 'pengaduan') {
                                            echo '📋 Pengaduan';
                                        } elseif ($notif['tipe'] == 'chat') {
                                            echo '💬 Curhat';
                                        } else {
                                            echo '🔔 Sistem';
                                        }
                                    ?>
                                </span>
                            </div>
                            <span class="notification-date"><?php echo date('d/m/Y H:i', strtotime($notif['waktu'])); ?></span>
                        </div>
                        <div class="notification-title">
                            <?php if ($notif['status'] == 'belum'): ?>
                            <span style="background: #ff9800; color: white; padding: 2px 8px; border-radius: 3px; font-size: 11px; margin-right: 5px;">🆕 BARU</span>
                            <?php endif; ?>
                            <?php echo htmlspecialchars($notif['judul']); ?>
                        </div>
                        <div class="notification-message">
                            <?php echo nl2br(htmlspecialchars($notif['pesan'])); ?>
                        </div>
                        <?php if ($notif['id_bk']): ?>
                        <div class="notification-teacher">
                            <i class="fas fa-user-circle"></i> Dari: <?php echo htmlspecialchars($notif['guru_nama'] ?? 'Guru BK'); ?>
                        </div>
                        <?php endif; ?>
                        <div class="notification-actions">
                            <a href="<?php echo ($notif['tipe'] == 'chat') ? 'curhat.php' : 'riwayat_pengaduan.php'; ?>" class="btn-action" style="background: #2196F3; color: white; text-decoration: none;">
                                <i class="fas fa-eye"></i> Lihat Balasan
                            </a>
                            <?php if ($notif['status'] == 'belum'): ?>
                            <form method="POST" action="../proses_notifikasi.php?aksi=baca&id=<?php echo $notif['id_notif']; ?>" style="display: inline;">
                                <button type="submit" class="btn-action btn-read">
                                    <i class="fas fa-check"></i> Tandai Dibaca
                                </button>
                            </form>
                            <?php endif; ?>
                            <form method="POST" action="../proses_notifikasi.php?aksi=hapus&id=<?php echo $notif['id_notif']; ?>" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus notifikasi ini?');">
                                <button type="submit" class="btn-action btn-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <a href="dashboard.php" class="back-to-curhat">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <script>
        // Buat floating stars animation
        function createFloatingStars() {
            const container = document.querySelector('.floating-stars');
            if (container) {
                for (let i = 0; i < 20; i++) {
                    const star = document.createElement('div');
                    star.className = 'floating-star';
                    star.textContent = '✨';
                    star.style.left = Math.random() * 100 + '%';
                    star.style.top = Math.random() * 100 + '%';
                    star.style.animationDelay = Math.random() * 5 + 's';
                    container.appendChild(star);
                }
            }
        }

        // Load saat halaman dibuka
        window.addEventListener('DOMContentLoaded', function() {
            createFloatingStars();
        });
    </script>
</body>
</html>