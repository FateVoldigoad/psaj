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

// Ambil guru info untuk menampilkan nama
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

if ($id_siswa_selected) {
    // Ambil data siswa untuk ditampilkan
    $query_siswa = "SELECT * FROM siswa WHERE id_siswa = '$id_siswa_selected'";
    $result_siswa = mysqli_query($conn, $query_siswa);
    $siswa_selected = mysqli_fetch_assoc($result_siswa);
    
    // Ambil semua pesan dengan siswa ini
    $query_messages = "SELECT * FROM chat WHERE id_siswa = '$id_siswa_selected' 
                       ORDER BY waktu ASC";
    $result_messages = mysqli_query($conn, $query_messages);
    while ($row = mysqli_fetch_assoc($result_messages)) {
        $messages[] = $row;
    }
    
    // Update pesan siswa menjadi sudah dibaca oleh guru
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
    <link rel="stylesheet" href="css/pesan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .chat-container { display: flex; flex-direction: column; gap: 20px; }
        .chat-list { border: 1px solid #ddd; border-radius: 8px; background: white; }
        .chat-item { padding: 15px; border-bottom: 1px solid #eee; cursor: pointer; background: white; }
        .chat-item:hover { background: #f5f5f5; }
        .chat-item.active { background: #e3f2fd; border-left: 4px solid #2196F3; }
        .chat-item-name { font-weight: bold; }
        .chat-item-preview { font-size: 12px; color: #999; margin-top: 5px; }
        .chat-item-badge { display: inline-block; background: #ff9800; color: white; font-size: 11px; padding: 2px 6px; border-radius: 10px; float: right; }
        .messages-area { background: white; border-radius: 8px; border: 1px solid #ddd; padding: 20px; }
        .message-item { padding: 15px; margin-bottom: 15px; border-radius: 5px; border-left: 4px solid #ddd; }
        .message-item.siswa { background: #e3f2fd; border-left-color: #2196F3; }
        .message-item.guru { background: #c8e6c9; border-left-color: #4CAF50; }
        .message-sender { font-weight: bold; margin-bottom: 8px; }
        .message-sender.siswa { color: #1976D2; }
        .message-sender.guru { color: #2e7d32; }
        .message-content { color: #333; line-height: 1.6; margin-bottom: 8px; }
        .message-time { font-size: 12px; color: #999; }
        .siswa-info { padding: 15px; background: #f5f5f5; border-bottom: 1px solid #ddd; }
        .reply-area { padding: 15px; background: white; border-top: 1px solid #ddd; }
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

        <div class="chat-container">
            
            <!-- Conversations List -->
            <div class="chat-list">
                <h3 style="padding: 15px; margin: 0; border-bottom: 1px solid #ddd;">Daftar Percakapan (<?php echo count($conversations); ?>)</h3>
                
                <?php if (count($conversations) === 0): ?>
                <div style="padding: 20px; text-align: center; color: #999;">
                    Tidak ada pesan
                </div>
                <?php else: ?>
                    <?php foreach ($conversations as $conv): ?>
                    <div class="chat-item <?php echo $id_siswa_selected == $conv['id_siswa'] ? 'active' : ''; ?>" 
                         onclick="window.location.href='guru_pesan_masuk.php?siswa=<?php echo $conv['id_siswa']; ?>'">
                        <div class="chat-item-name">
                            <?php echo htmlspecialchars($conv['nama']); ?>
                            <?php if ($conv['pesan_belum'] > 0): ?>
                            <span class="chat-item-badge"><?php echo $conv['pesan_belum']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="chat-item-preview"><?php echo htmlspecialchars($conv['nisn']); ?> • <?php echo date('d/m/Y H:i', strtotime($conv['waktu_terakhir'])); ?></div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Messages Detail -->
            <?php if ($siswa_selected): ?>
            
            <!-- Siswa Info -->
            <div class="siswa-info">
                <strong><?php echo htmlspecialchars($siswa_selected['nama']); ?></strong> 
                <span style="color: #999;">(<?php echo htmlspecialchars($siswa_selected['nisn']); ?>)</span>
                <div style="font-size: 12px; color: #999; margin-top: 5px;">
                    Email: <?php echo htmlspecialchars($siswa_selected['email'] ?? '-'); ?> | 
                    Telpon: <?php echo htmlspecialchars($siswa_selected['telpon'] ?? '-'); ?>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="messages-area">
                <?php if (count($messages) === 0): ?>
                <div style="text-align: center; color: #999; padding: 40px;">
                    Belum ada pesan dengan siswa ini
                </div>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                    <div class="message-item <?php echo $msg['pengirim']; ?>">
                        <div class="message-sender <?php echo $msg['pengirim']; ?>">
                            <?php echo ($msg['pengirim'] == 'siswa') ? '📝 ' . htmlspecialchars($siswa_selected['nama']) : '🎓 Guru BK'; ?>
                        </div>
                        <div class="message-content">
                            <?php echo nl2br(htmlspecialchars($msg['pesan'])); ?>
                        </div>
                        <div class="message-time"><?php echo date('d/m/Y H:i', strtotime($msg['waktu'])); ?></div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Reply Area -->
            <div class="reply-area">
                <form method="POST" action="proses_pesan.php?aksi=balas" style="display: flex; gap: 10px;">
                    <input type="hidden" name="id_siswa" value="<?php echo $id_siswa_selected; ?>">
                    <input type="hidden" name="id_chat_original" value="<?php echo isset($messages[0]) ? $messages[0]['id_chat'] : '0'; ?>">
                    <textarea name="pesan" placeholder="Ketik balasan di sini..." style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: Arial; font-size: 14px; resize: vertical; min-height: 60px;" required></textarea>
                    <button type="submit" style="padding: 10px 20px; background: #2196F3; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                        <i class="fas fa-paper-plane"></i> Kirim
                    </button>
                </form>
            </div>

            <?php else: ?>
            
            <div style="display: flex; align-items: center; justify-content: center; height: 400px; font-size: 18px; color: #999;">
                Pilih percakapan untuk memulai
            </div>

            <?php endif; ?>
            </div>

        </div>

    </div>

</div>

</body>
</html>
