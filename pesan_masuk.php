<!DOCTYPE html>
<html>
<head>

<title>Pesan Masuk</title>

<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/pesan.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>

<div class="container">

<!-- Sidebar -->
<div class="sidebar">
<div class="logo-section">
    <img src="assets/Logo.png" alt="Logo" class="logo">
</div>
<h2>Layanan Pengaduan</h2>

<ul>
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="data_pengaduan.php">Data Pengaduan</a></li>
<li><a href="riwayat_pengaduan.php">Riwayat</a></li>
<li class="active"><a href="pesan_masuk.php">Pesan Masuk</a></li>
<li><a href="pengaturan.php">Pengaturan</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</div>

<!-- Main -->
<div class="main">


<!-- Wishing Wall untuk Guru -->
<div class="guru-wishing-wall">
    
    <!-- Header -->
    <div class="guru-header">
        <h2><i class="fas fa-lock"></i> Pertanyaan Anonim Siswa</h2>
        <p>Balas pertanyaan siswa yang membutuhkan jawaban dari Anda</p>
    </div>

    <!-- Filter Buttons -->
    <div class="guru-filter-section">
        <button class="guru-filter-btn active" onclick="filterWishes('all')">Semua Pertanyaan</button>
        <button class="guru-filter-btn" onclick="filterWishes('belum')"><i class="fas fa-hourglass"></i> Belum Dijawab</button>
        <button class="guru-filter-btn" onclick="filterWishes('sudah')"><i class="fas fa-check"></i> Sudah Dijawab</button>
    </div>

    <!-- Wishes Grid -->
    <div id="wishesGrid" class="guru-wishes-grid">
        <!-- Harapan akan ditampilkan di sini -->
    </div>

</div>

<!-- Modal untuk Jawab Harapan -->
<div class="guru-modal" id="answerModal" style="display: none;">
    <div class="guru-modal-overlay" onclick="closeAnswerModal()"></div>
    <div class="guru-modal-content">
        <button class="guru-modal-close" onclick="closeAnswerModal()">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="guru-modal-body">
            <div id="wishDetail" class="wish-detail">
                <!-- Detail harapan akan ditampilkan di sini -->
            </div>

            <form id="answerForm" class="guru-answer-form">
                <label for="answerText">Jawaban Anda untuk Siswa:</label>
                <textarea id="answerText" placeholder="Tulis jawaban yang penuh perhatian dan membantu untuk siswa ini..." required></textarea>
                
                <div class="form-actions">
                    <button type="submit" class="btn-submit-answer">
                        <i class="fas fa-check"></i> Kirim Jawaban
                    </button>
                    <button type="button" onclick="closeAnswerModal()" class="btn-cancel">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Data dummy harapan siswa
    const allQuestions = [
        {
            id: 1,
            kategori: 'akademik',
            pertanyaan: 'Bagaimana cara menghadapi ujian yang sulit? Saya merasa gelisah setiap kali ada ujian penting.',
            tanggal: '2026-04-12',
            answered: true,
            answer: 'Gelisah sebelum ujian adalah hal yang normal. Cobalah teknik breathing exercise 5 menit sebelumnya. Berlatih soal-soal sebelumnya juga bisa meningkatkan kepercayaan diri.',
            siswa_anonim: 'Siswa Anonim #1'
        },
        {
            id: 2,
            kategori: 'pribadi',
            pertanyaan: 'Saya merasa kurang percaya diri dengan penampilan fisik saya. Bagaimana cara menerimanya?',
            tanggal: '2026-04-11',
            answered: true,
            answer: 'Kepercayaan diri bukan hanya tentang penampilan fisik. Fokus pada hal-hal yang bisa kamu kontrol: kualitas karakter, kemampuan, dan prestasi. Ingat, setiap orang unik dan indah dengan cara mereka sendiri.',
            siswa_anonim: 'Siswa Anonim #2'
        },
        {
            id: 3,
            kategori: 'sosial',
            pertanyaan: 'Teman-teman saya sering mengasingkan saya. Apa yang harus saya lakukan?',
            tanggal: '2026-04-10',
            answered: false,
            answer: null,
            siswa_anonim: 'Siswa Anonim #3'
        },
        {
            id: 4,
            kategori: 'keluarga',
            pertanyaan: 'Orangtua saya sering bertengkar. Bagaimana cara saya menghadapinya?',
            tanggal: '2026-04-09',
            answered: true,
            answer: 'Hal ini sulit untuk diterima, tapi penting untuk diingat bahwa pertengkaran orangtua bukan kesalahmu. Cari ruang aman untuk diri sendiri, dan jangan ragu untuk berbicara dengan mereka atau orang dewasa terpercaya tentang perasaanmu.',
            siswa_anonim: 'Siswa Anonim #4'
        },
        {
            id: 5,
            kategori: 'kesehatan',
            pertanyaan: 'Saya sering sulit tidur karena stres. Apa yang bisa saya coba?',
            tanggal: '2026-04-08',
            answered: false,
            answer: null,
            siswa_anonim: 'Siswa Anonim #5'
        },
        {
            id: 6,
            kategori: 'pribadi',
            pertanyaan: 'Saya takut tidak bisa lulus semester ini karena nilai-nilai saya menurun.',
            tanggal: '2026-04-07',
            answered: false,
            answer: null,
            siswa_anonim: 'Siswa Anonim #6'
        },
        {
            id: 7,
            kategori: 'akademik',
            pertanyaan: 'Bagaimana cara memilih jurusan yang tepat untuk masa depan?',
            tanggal: '2026-04-06',
            answered: true,
            answer: 'Pikirkan apa yang kamu sukai, kuat dalam, dan apa yang ingin kamu capai. Bicarakan dengan orang tua, guru, dan cari informasi tentang berbagai pilihan jurusan. Jadwalkan sesi konseling dengan saya untuk diskusi lebih lanjut.',
            siswa_anonim: 'Siswa Anonim #7'
        },
        {
            id: 8,
            kategori: 'sosial',
            pertanyaan: 'Saya baru di sekolah ini dan merasa sendirian. Bagaimana cara membuat teman?',
            tanggal: '2026-04-05',
            answered: false,
            answer: null,
            siswa_anonim: 'Siswa Anonim #8'
        }
    ];

    let currentWishId = null;

    // Init - Load wishes on page load
    window.addEventListener('DOMContentLoaded', function() {
        displayWishes('all');
    });

    // Display Wishes Grid
    function displayWishes(filter = 'all') {
        let filtered = allQuestions;

        if (filter === 'belum') {
            filtered = allQuestions.filter(q => !q.answered);
        } else if (filter === 'sudah') {
            filtered = allQuestions.filter(q => q.answered);
        }

        let html = '';

        if (filtered.length === 0) {
            html = `
                <div class="empty-wishes-guru">
                    <div style="font-size: 3em; margin-bottom: 20px;">🏮</div>
                    <p>Tidak ada harapan untuk ditampilkan</p>
                </div>
            `;
        } else {
            filtered.forEach((q, index) => {
                const categoryEmoji = {
                    'akademik': '📚',
                    'pribadi': '💭',
                    'sosial': '👥',
                    'keluarga': '👨‍👩‍👧‍👦',
                    'kesehatan': '🏥',
                    'lainnya': '🌈'
                }[q.kategori];

                const categoryName = {
                    'akademik': 'Akademik',
                    'pribadi': 'Pribadi',
                    'sosial': 'Sosial',
                    'keluarga': 'Keluarga',
                    'kesehatan': 'Kesehatan',
                    'lainnya': 'Lainnya'
                }[q.kategori];

                const tanggal = new Date(q.tanggal).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });

                const colors = ['wish-blue', 'wish-pink', 'wish-yellow', 'wish-green', 'wish-purple', 'wish-orange'];
                const colorClass = colors[index % colors.length];

                const shortText = q.pertanyaan.length > 60 ? q.pertanyaan.substring(0, 60) + '...' : q.pertanyaan;

                const statusBadge = q.answered 
                    ? '<span class="guru-status-badge answered"><i class="fas fa-check-circle"></i> Sudah Dijawab</span>' 
                    : '<span class="guru-status-badge unanswered"><i class="fas fa-hourglass"></i> Belum Dijawab</span>';

                html += `
                    <div class="guru-wish-card ${colorClass}" onclick="openAnswerModal(${q.id})" style="animation-delay: ${index * 0.05}s">
                        <div class="guru-wish-header">
                            <span class="guru-wish-emoji">${categoryEmoji}</span>
                            <span class="guru-wish-category">${categoryName}</span>
                            ${statusBadge}
                        </div>
                        <p class="guru-wish-text">${shortText}</p>
                        <div class="guru-wish-footer">
                            <span class="guru-wish-date">${tanggal}</span>
                            <span class="guru-wish-action"><i class="fas fa-pen"></i> Jawab</span>
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('wishesGrid').innerHTML = html;
    }

    // Filter Wishes
    function filterWishes(filter) {
        document.querySelectorAll('.guru-filter-btn').forEach(el => el.classList.remove('active'));
        event.target.classList.add('active');
        displayWishes(filter);
    }

    // Open Answer Modal
    function openAnswerModal(id) {
        currentWishId = id;
        const wish = allQuestions.find(q => q.id === id);
        
        const categoryEmoji = {
            'akademik': '📚',
            'pribadi': '💭',
            'sosial': '👥',
            'keluarga': '👨‍👩‍👧‍👦',
            'kesehatan': '🏥',
            'lainnya': '🌈'
        }[wish.kategori];

        const categoryName = {
            'akademik': 'Akademik',
            'pribadi': 'Pribadi',
            'sosial': 'Sosial',
            'keluarga': 'Keluarga',
            'kesehatan': 'Kesehatan',
            'lainnya': 'Lainnya'
        }[wish.kategori];

        const tanggal = new Date(wish.tanggal).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        let detailContent = `
            <div class="guru-wish-detail-header">
                <span class="guru-detail-category">${categoryEmoji} ${categoryName}</span>
                <span class="guru-detail-date">${tanggal}</span>
            </div>
            <div class="guru-wish-detail-text">
                <p>${wish.pertanyaan}</p>
            </div>
        `;

        if (wish.answered) {
            detailContent += `
                <div class="guru-existing-answer">
                    <h4><i class="fas fa-check-circle"></i> Jawaban Anda sebelumnya:</h4>
                    <p>${wish.answer}</p>
                </div>
            `;
            document.getElementById('answerText').value = wish.answer;
        } else {
            document.getElementById('answerText').value = '';
        }

        document.getElementById('wishDetail').innerHTML = detailContent;
        document.getElementById('answerModal').style.display = 'flex';
    }

    // Close Answer Modal
    function closeAnswerModal() {
        document.getElementById('answerModal').style.display = 'none';
    }

    // Submit Answer
    document.getElementById('answerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const answer = document.getElementById('answerText').value;
        
        if (!answer.trim()) {
            alert('Jawaban tidak boleh kosong');
            return;
        }

        const wish = allQuestions.find(q => q.id === currentWishId);
        wish.answered = true;
        wish.answer = answer;

        alert('✨ Jawaban berhasil disimpan! Siswa akan melihat jawaban Anda.');
        closeAnswerModal();
        displayWishes('all');
    });

    // Close modal with Escape key
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAnswerModal();
        }
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('answerModal');
        if (e.target === modal) {
            closeAnswerModal();
        }
    });
</script>

</div>

</div>

</body>
</html>