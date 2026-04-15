<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login sebagai siswa
if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../index.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];
$nama_siswa = $_SESSION['nama_siswa'] ?? 'Siswa';

// Ambil curhat siswa terbaru saja dari database
$query_curhat = "SELECT c.id_chat, c.pesan, c.waktu, c.pengirim, g.nama as guru_nama
                 FROM chat c
                 LEFT JOIN guru_bk g ON c.id_bk = g.id_bk
                 WHERE c.id_siswa = '$id_siswa'
                 ORDER BY c.waktu DESC
                 LIMIT 1";
$result_curhat = mysqli_query($conn, $query_curhat);
$curhat_terbaru = mysqli_fetch_assoc($result_curhat);

// Ambil semua balasan untuk curhat terbaru
$curhat_list = [];
if ($curhat_terbaru && $curhat_terbaru['pengirim'] == 'siswa') {
    // Ambil curhat terbaru dan semua balasnnya
    $query_thread = "SELECT c.id_chat, c.pesan, c.waktu, c.pengirim, g.nama as guru_nama
                     FROM chat c
                     LEFT JOIN guru_bk g ON c.id_bk = g.id_bk
                     WHERE c.id_siswa = '$id_siswa'
                     AND c.waktu >= (SELECT waktu FROM chat WHERE id_chat = '" . $curhat_terbaru['id_chat'] . "')
                     ORDER BY c.waktu ASC";
    $result_thread = mysqli_query($conn, $query_thread);
    while ($row = mysqli_fetch_assoc($result_thread)) {
        $curhat_list[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curhat & Konsultasi</title>
    <link rel="stylesheet" href="css/curhat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

<div class="wishing-wall-container">
    
    <!-- Floating Background Elements -->
    <div class="floating-stars"></div>

    <!-- Header -->
    <div class="wishing-header">
        <h1><i class="fas fa-lock"></i> Papan Curhat & Konsultasi</h1>
        <p>Percayakan keluh kesahmu kepada Guru BK. Identitasmu dijaga keamanannya.</p>
    </div>

    <!-- Status Messages -->
    <?php if (isset($_SESSION['pesan'])): ?>
    <div style="margin: 20px auto; max-width: 900px; padding: 15px; background: <?php echo $_SESSION['tipe'] == 'success' ? '#d4edda' : '#f8d7da'; ?>; border-radius: 5px; color: <?php echo $_SESSION['tipe'] == 'success' ? '#155724' : '#721c24'; ?>;">
        <?php echo $_SESSION['pesan']; ?>
    </div>
    <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); endif; ?>

    <!-- Main Wishing Wall -->
    <div class="wishing-wall-wrapper">
        
        <!-- Central Form - Full Width -->
        <div class="wish-form-section-full">
            <div class="wish-form-card">
                <h2>🌟 Sampaikan Curhatmu di Sini</h2>
                <p>Berbagi tanpa takut kehilangan privasi</p>
                
                <form method="POST" action="../proses_curhat.php?aksi=kirim">
                    <div class="form-group">
                        <label for="kategori">Pilih Kategori Curhatmu</label>
                        <select id="kategori" name="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="akademik">📚 Akademik & Pelajaran</option>
                            <option value="pribadi">💭 Pribadimu & Perasaan</option>
                            <option value="sosial">👥 Sosial & Persahabatan</option>
                            <option value="keluarga">👨‍👩‍👧‍👦 Keluarga</option>
                            <option value="kesehatan">🏥 Kesehatan & Mental</option>
                            <option value="lainnya">🌈 Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pesan">Tuliskan Curhatmu...</label>
                        <textarea id="pesan" name="pesan" placeholder="Ceritakan apa yang ada di hatimu... Tidak ada yang perlu dihiraukan, kami siap mendengarkan 💙" required maxlength="1000"></textarea>
                        <small id="charCount">0/1000</small>
                    </div>

                    <button type="submit" class="btn-wish-submit">
                        <i class="fas fa-paper-plane"></i> Kirim Curhatku
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Riwayat Curhat -->
    <div style="margin-top: 50px; max-width: 900px; margin-left: auto; margin-right: auto;">
        <h2 style="text-align: center; margin-bottom: 30px; color: #333;">📖 Riwayat Curhatmu</h2>
        
        <?php if (count($curhat_list) === 0): ?>
        <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #999; font-size: 16px;">Belum ada curhat. Mulai berbagi ceritamu sekarang! 💙</p>
        </div>
        <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php 
            // Display hanya curhat terbaru dengan balasannya
            $siswa_msg = null;
            $guru_replies = [];
            
            foreach ($curhat_list as $msg) {
                if ($msg['pengirim'] == 'siswa' && $siswa_msg === null) {
                    $siswa_msg = $msg;
                } elseif ($msg['pengirim'] == 'guru') {
                    $guru_replies[] = $msg;
                }
            }
            
            if ($siswa_msg !== null):
            ?>
            <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e0e0e0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <!-- Curhat Siswa -->
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                        <div>
                            <strong style="color: #333;">📝 Curhatmu</strong>
                            <small style="color: #999; display: block; margin-top: 3px;"><?php echo date('d/m/Y H:i', strtotime($siswa_msg['waktu'])); ?></small>
                        </div>
                        <a href="../proses_curhat.php?aksi=hapus&id=<?php echo $siswa_msg['id_chat']; ?>" onclick="return confirm('Yakin ingin menghapus curhat ini?');" style="color: #d32f2f; text-decoration: none; font-size: 14px;">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </div>
                    <div style="background: #f8f9fa; padding: 12px; border-radius: 5px; line-height: 1.6; color: #333;">
                        <?php echo nl2br(htmlspecialchars($siswa_msg['pesan'])); ?>
                    </div>
                </div>

                <!-- Respons Guru (jika ada) -->
                <?php if (!empty($guru_replies)): ?>
                <div style="border-top: 1px solid #e0e0e0; padding-top: 15px;">
                    <?php foreach ($guru_replies as $reply): ?>
                    <div style="margin-bottom: 12px;">
                        <strong style="color: #6a1b9a;">💌 Balasan dari Guru BK</strong>
                        <small style="color: #999; display: block; margin-bottom: 8px;"><?php echo htmlspecialchars($reply['guru_nama'] ?? 'Guru BK'); ?> • <?php echo date('d/m/Y H:i', strtotime($reply['waktu'])); ?></small>
                        <div style="background: #f3e5f5; padding: 12px; border-radius: 5px; line-height: 1.6; color: #333;">
                            <?php echo nl2br(htmlspecialchars($reply['pesan'])); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        </div>
        <?php endif; ?>
    </div>

</div>

<!-- Modal untuk lihat jawaban -->
<div class="modal" id="answerModal">
    <div class="modal-overlay" onclick="closeModal()"></div>
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal()">
            <i class="fas fa-times"></i>
        </button>
        <div class="modal-body" id="modalBody">
            <!-- Konten jawaban akan di-load di sini -->
        </div>
    </div>
</div>

<script>
    // Character counter
    document.getElementById('pesan').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length + '/1000';
    });

    // Tutup modal
    function closeModal() {
        document.getElementById('answerModal').style.display = 'none';
    }

    // Load saat halaman dibuka
    window.addEventListener('DOMContentLoaded', function() {
        createFloatingStars();
    });

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
</script>

</body>
</html>