<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login sebagai guru
if (!isset($_SESSION['id_bk'])) {
    header("Location: index.php");
    exit;
}

$id_bk = $_SESSION['id_bk'];
$nama_guru = $_SESSION['nama_guru'] ?? 'Guru BK';

// Get guru info untuk menampilkan nama
$query_guru = "SELECT nama FROM guru_bk WHERE id_bk = '$id_bk'";
$result_guru = mysqli_query($conn, $query_guru);
$guru_data = mysqli_fetch_assoc($result_guru);
if ($guru_data) {
    $nama_guru = $guru_data['nama'];
}

// Ambil daftar siswa yang memiliki pesan
$query_conversations = "SELECT DISTINCT c.id_siswa, s.nama, s.nisn, 
                        COUNT(CASE WHEN c.pengirim='siswa' AND c.dibaca='belum' THEN 1 END) as pesan_belum,
                        MAX(c.waktu) as waktu_terakhir
                        FROM chat c
                        JOIN siswa s ON c.id_siswa = s.id_siswa
                        WHERE c.id_siswa IS NOT NULL
                        GROUP BY c.id_siswa, s.nama, s.nisn
                        ORDER BY MAX(c.waktu) DESC";
$result_conv = mysqli_query($conn, $query_conversations);
$conversations = [];
while ($row = mysqli_fetch_assoc($result_conv)) {
    $conversations[] = $row;
}

// Ambil ID siswa dari GET parameter jika ada
$id_siswa_selected = isset($_GET['siswa']) ? mysqli_real_escape_string($conn, $_GET['siswa']) : (count($conversations) > 0 ? $conversations[0]['id_siswa'] : null);

$messages = [];
$siswa_selected = null;
$guru_reply = null;

if ($id_siswa_selected) {
    // Ambil data siswa untuk ditampilkan
    $query_siswa = "SELECT * FROM siswa WHERE id_siswa = '$id_siswa_selected'";
    $result_siswa = mysqli_query($conn, $query_siswa);
    $siswa_selected = mysqli_fetch_assoc($result_siswa);
    
    // Ambil pesan terakhir dari siswa
    $query_messages = "SELECT * FROM chat WHERE id_siswa = '$id_siswa_selected' AND pengirim='siswa'
                       ORDER BY waktu DESC LIMIT 1";
    $result_messages = mysqli_query($conn, $query_messages);
    if ($msg = mysqli_fetch_assoc($result_messages)) {
        $messages = $msg;
    }
    
    // Ambil balasan terakhir dari guru
    $query_reply = "SELECT * FROM chat WHERE id_siswa = '$id_siswa_selected' AND pengirim='guru'
                    ORDER BY waktu DESC LIMIT 1";
    $result_reply = mysqli_query($conn, $query_reply);
    $guru_reply = mysqli_fetch_assoc($result_reply);
    
    // Update pesan siswa menjadi sudah dibaca
    $update_baca = "UPDATE chat SET dibaca='sudah' WHERE id_siswa='$id_siswa_selected' AND pengirim='siswa'";
    mysqli_query($conn, $update_baca);
}

$total_unread = "SELECT COUNT(*) as total FROM chat WHERE pengirim='siswa' AND dibaca='belum' AND id_siswa IS NOT NULL";
$result_total = mysqli_query($conn, $total_unread);
$total_data = mysqli_fetch_assoc($result_total);
$total_unread_count = $total_data['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Masuk - Guru</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/tanggapi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .siswa-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .siswa-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #ddd;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
        }
        .siswa-card:hover {
            border-color: #2196F3;
            background: #f0f8ff;
            transform: translateY(-2px);
        }
        .siswa-card.active {
            border-color: #2196F3;
            background: #e3f2fd;
        }
        .siswa-card-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .siswa-card-info {
            font-size: 12px;
            color: #666;
        }
        .siswa-card-badge {
            display: inline-block;
            background: #ff9800;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            margin-top: 8px;
        }
        .pesan-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .pesan-header {
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .pesan-content {
            color: #333;
            line-height: 1.8;
        }
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            min-height: 150px;
            resize: vertical;
        }
        .btn-submit {
            background: #28a745;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-submit:hover { background: #218838; }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Layanan Pengaduan</h2>
        <ul>
            <li><a href="guru_dashboard.php">Dashboard</a></li>
            <li><a href="guru_data_pengaduan.php">Data Pengaduan</a></li>
            <li><a href="guru_riwayat_pengaduan.php">Riwayat</a></li>
            <li><a href="guru_data_siswa.php">Data Siswa</a></li>
            <li class="active"><a href="guru_pesan_masuk.php">Pesan Masuk</a></li>
            <li><a href="guru_pengaturan.php">Pengaturan</a></li>
            <li><a href="logout.php" onclick="return confirm('Yakin ingin logout?');">Logout</a></li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">

        <div class="user"><?php echo htmlspecialchars($nama_guru); ?></div>

        <h2>📬 Pesan Masuk <?php if ($total_unread_count > 0) echo "<span style='background: #ff9800; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; margin-left: 10px;'>$total_unread_count Baru</span>"; ?></h2>

        <!-- Status Messages -->
        <?php if (isset($_SESSION['pesan'])): ?>
        <div style="margin: 20px 0; padding: 15px; background: <?php echo $_SESSION['tipe'] == 'success' ? '#d4edda' : '#f8d7da'; ?>; border-radius: 5px; color: <?php echo $_SESSION['tipe'] == 'success' ? '#155724' : '#721c24'; ?>;">
            <?php echo $_SESSION['pesan']; ?>
        </div>
        <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); endif; ?>

        <!-- Daftar Siswa -->
        <h3 style="margin-bottom: 15px;">Pilih Siswa untuk Menanggapi Pesan</h3>
        <?php if (count($conversations) === 0): ?>
        <div class="empty-state">
            <p>Tidak ada pesan dari siswa</p>
        </div>
        <?php else: ?>
        <div class="siswa-grid">
            <?php foreach ($conversations as $conv): ?>
            <a href="guru_pesan_masuk.php?siswa=<?php echo $conv['id_siswa']; ?>" 
               class="siswa-card <?php echo $id_siswa_selected == $conv['id_siswa'] ? 'active' : ''; ?>">
                <div class="siswa-card-name">👤 <?php echo htmlspecialchars($conv['nama']); ?></div>
                <div class="siswa-card-info">NISN: <?php echo htmlspecialchars($conv['nisn']); ?></div>
                <?php if ($conv['pesan_belum'] > 0): ?>
                <div class="siswa-card-badge">📨 <?php echo $conv['pesan_belum']; ?> Belum Dibaca</div>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Detail Pesan (jika ada siswa terpilih) -->
        <?php if ($siswa_selected && !empty($messages)): ?>

        <!-- Info Siswa -->
        <div class="detail-box">
            <h3 style="margin-bottom: 15px;">Detail Siswa</h3>
            
            <div class="detail-row">
                <span class="detail-label">👤 Nama</span>
                <span class="detail-value"><?php echo htmlspecialchars($siswa_selected['nama']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">🆔 NISN</span>
                <span class="detail-value"><?php echo htmlspecialchars($siswa_selected['nisn']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">📧 Email</span>
                <span class="detail-value"><?php echo htmlspecialchars($siswa_selected['email'] ?? '-'); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">📱 Telepon</span>
                <span class="detail-value"><?php echo htmlspecialchars($siswa_selected['telpon'] ?? '-'); ?></span>
            </div>
        </div>

        <!-- Pesan dari Siswa -->
        <div class="pesan-box">
            <div class="pesan-header">💬 Pesan dari Siswa</div>
            <div style="font-size: 12px; color: #999; margin-bottom: 10px;">
                <?php echo date('d/m/Y H:i', strtotime($messages['waktu'])); ?>
            </div>
            <div class="pesan-content">
                <?php echo nl2br(htmlspecialchars($messages['pesan'])); ?>
            </div>
        </div>

        <!-- Balasan Sebelumnya (jika ada) -->
        <?php if (!empty($guru_reply)): ?>
        <div class="detail-box" style="background: #e8f5e9; border-left-color: #28a745;">
            <h4 style="margin-bottom: 15px; color: #28a745;">✅ Balasan Terbaru:</h4>
            <div style="background: white; padding: 15px; border-radius: 4px; line-height: 1.6; color: #333;">
                <?php echo nl2br(htmlspecialchars($guru_reply['pesan'])); ?>
            </div>
            <p style="margin-top: 10px; font-size: 12px; color: #666;">
                📅 <?php echo date('d/m/Y H:i', strtotime($guru_reply['waktu'])); ?>
            </p>
        </div>
        <?php endif; ?>

        <!-- Form Balasan -->
        <div class="form-box">
            <h3 style="margin-bottom: 20px;">💌 Balas Pesan</h3>
            
            <form method="POST" action="proses_pesan.php?aksi=balas">
                <input type="hidden" name="id_siswa" value="<?php echo $id_siswa_selected; ?>">
                <input type="hidden" name="id_chat_original" value="<?php echo $messages['id_chat']; ?>">
                
                <div class="form-group">
                    <label for="pesan">Tulis Balasan <span style="color: red;">*</span></label>
                    <textarea 
                        id="pesan" 
                        name="pesan" 
                        placeholder="Tulis balasan untuk siswa..." 
                        required></textarea>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Kirim Balasan
                    </button>
                </div>
            </form>
        </div>

        <?php elseif ($siswa_selected): ?>
        <div class="empty-state">
            <p>Tidak ada pesan dari siswa ini</p>
        </div>
        <?php endif; ?>

    </div>

</div>

</body>
</html>
