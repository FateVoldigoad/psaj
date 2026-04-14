<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishing Wall - Curhat Anonim</title>
    <link rel="stylesheet" href="css/curhat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

<div class="wishing-wall-container">
    
    <!-- Floating Background Elements -->
    <div class="floating-stars"></div>

    <!-- Header -->
    <div class="wishing-header">
        <h1><i class="fas fa-lock"></i> Papan Curhat Siswa</h1>
        <p>Percayakan keluh kesahmu kepada kami. Identitasmu dijaga keamanannya.</p>
    </div>

    <!-- Main Wishing Wall -->
    <div class="wishing-wall-wrapper">
        
        <!-- Central Form - Full Width -->
        <div class="wish-form-section-full">
            <div class="wish-form-card">
                <h2>🌟 Buat Harapanmu di Sini</h2>
                <p>Berbagi tanpa takut kehilangan privasi</p>
                
                <form id="submitForm">
                    <div class="form-group">
                        <label for="kategori">Pilih Kategori Harapanmu</label>
                        <select id="kategori" required>
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
                        <label for="pertanyaan">Tuliskan Harapanmu...</label>
                        <textarea id="pertanyaan" placeholder="Ceritakan apa yang ada di hatimu... Tidak ada yang perlu dihiraukan, kami siap mendengarkan 💙" required maxlength="1000"></textarea>
                        <small id="charCount">0/1000</small>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" id="anonymous" checked>
                        <label for="anonymous">✓ Kirim secara Anonim (Identitas Terlindungi)</label>
                    </div>

                    <button type="submit" class="btn-wish-submit">
                        <i class="fas fa-paper-plane"></i> Gantungkan Harapanku di Dinding
                    </button>
                </form>
            </div>
        </div>

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
    // Data dummy harapan/pertanyaan
    const allQuestions = [
        {
            id: 1,
            kategori: 'akademik',
            pertanyaan: 'Bagaimana cara menghadapi ujian yang sulit? Saya merasa gelisah setiap kali ada ujian penting.',
            tanggal: '2026-04-12',
            answered: true,
            answer: 'Gelisah sebelum ujian adalah hal yang normal. Cobalah teknik breathing exercise 5 menit sebelumnya. Berlatih soal-soal sebelumnya juga bisa meningkatkan kepercayaan diri.',
            answerBy: 'Bu Siti Rahma - Guru BK'
        },
        {
            id: 2,
            kategori: 'pribadi',
            pertanyaan: 'Saya merasa kurang percaya diri dengan penampilan fisik saya. Bagaimana cara menerimanya?',
            tanggal: '2026-04-11',
            answered: true,
            answer: 'Kepercayaan diri bukan hanya tentang penampilan fisik. Fokus pada hal-hal yang bisa kamu kontrol: kualitas karakter, kemampuan, dan prestasi. Ingat, setiap orang unik dan indah dengan cara mereka sendiri.',
            answerBy: 'Bu Siti Rahma - Guru BK'
        },
        {
            id: 3,
            kategori: 'sosial',
            pertanyaan: 'Teman-teman saya sering mengasingkan saya. Apa yang harus saya lakukan?',
            tanggal: '2026-04-10',
            answered: false,
            answer: null,
            answerBy: null
        },
        {
            id: 4,
            kategori: 'keluarga',
            pertanyaan: 'Orangtua saya sering bertengkar. Bagaimana cara saya menghadapinya?',
            tanggal: '2026-04-09',
            answered: true,
            answer: 'Hal ini sulit untuk diterima, tapi penting untuk diingat bahwa pertengkaran orangtua bukan kesalahmu. Cari ruang aman untuk diri sendiri, dan jangan ragu untuk berbicara dengan mereka atau orang dewasa terpercaya tentang perasaanmu.',
            answerBy: 'Bu Siti Rahma - Guru BK'
        },
        {
            id: 5,
            kategori: 'kesehatan',
            pertanyaan: 'Saya sering sulit tidur karena stres. Apa yang bisa saya coba?',
            tanggal: '2026-04-08',
            answered: true,
            answer: 'Coba rutinitas tidur yang konsisten, hindari gadget 30 menit sebelum tidur, dan lakukan relaksasi seperti meditasi atau musik lembut. Jika berlanjut, konsultasikan dengan dokter.',
            answerBy: 'Bu Siti Rahma - Guru BK'
        },
        {
            id: 6,
            kategori: 'pribadi',
            pertanyaan: 'Saya takut tidak bisa lulus semester ini karena nilai-nilai saya menurun.',
            tanggal: '2026-04-07',
            answered: false,
            answer: null,
            answerBy: null
        },
        {
            id: 7,
            kategori: 'akademik',
            pertanyaan: 'Bagaimana cara memilih jurusan yang tepat untuk masa depan?',
            tanggal: '2026-04-06',
            answered: true,
            answer: 'Pikirkan apa yang kamu sukai, kuat dalam, dan apa yang ingin kamu capai. Bicarakan dengan orang tua, guru, dan cari informasi tentang berbagai pilihan jurusan. Jadwalkan sesi konseling dengan saya untuk diskusi lebih lanjut.',
            answerBy: 'Bu Siti Rahma - Guru BK'
        },
        {
            id: 8,
            kategori: 'sosial',
            pertanyaan: 'Saya baru di sekolah ini dan merasa sendirian. Bagaimana cara membuat teman?',
            tanggal: '2026-04-05',
            answered: true,
            answer: 'Jangan malu untuk memulai percakapan. Ikuti kegiatan ekstrakurikuler, klub, atau organisasi yang kamu minati. Tunjukkan diri aslimu dan bersikaplah sopan. Teman sejati akan datang dengan waktu.',
            answerBy: 'Bu Siti Rahma - Guru BK'
        }
    ];

    // Character counter
    document.getElementById('pertanyaan').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length + '/1000';
    });



    // Tutup modal
    function closeModal() {
        document.getElementById('answerModal').style.display = 'none';
    }

    // Submit form harapan baru
    document.getElementById('submitForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const kategori = document.getElementById('kategori').value;
        const pertanyaan = document.getElementById('pertanyaan').value;
        const anonymous = document.getElementById('anonymous').checked;

        if (!kategori || !pertanyaan) {
            alert('Silakan lengkapi semua field');
            return;
        }

        // Tambah harapan baru ke array
        const newQuestion = {
            id: Math.max(...allQuestions.map(q => q.id)) + 1,
            kategori: kategori,
            pertanyaan: pertanyaan,
            tanggal: new Date().toISOString().split('T')[0],
            answered: false,
            answer: null,
            answerBy: null
        };

        allQuestions.unshift(newQuestion);
        alert('✨ Harapanmu telah dikirim! Guru BK akan segera menjawabnya.');
        
        document.getElementById('submitForm').reset();
        document.getElementById('charCount').textContent = '0/1000';
        
        // Tampilkan notifikasi terbaru
        displayNotifications();
    });

    // Load saat halaman dibuka
    window.addEventListener('DOMContentLoaded', function() {
        createFloatingStars();
    });

    // Buat floating stars animation
    function createFloatingStars() {
        const container = document.querySelector('.floating-stars');
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
</script>

</body>
</html>