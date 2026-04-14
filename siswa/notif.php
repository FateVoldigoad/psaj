<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Jawaban Guru BK</title>
    <link rel="stylesheet" href="css/notif.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <div class="notifications-container" id="notificationsContainer">
                <!-- Notifikasi jawaban akan ditampilkan di sini -->
            </div>
        </div>

        <a href="curhat.php" class="back-to-curhat">
            <i class="fas fa-arrow-left"></i> Kembali ke Curhat
        </a>
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
            }
        ];

        // Tampilkan notifikasi jawaban dari guru
        function displayNotifications() {
            const answeredQuestions = allQuestions.filter(q => q.answered);
            let html = '';

            if (answeredQuestions.length === 0) {
                html = `
                    <div class="empty-notifications">
                        <div class="empty-icon">📬</div>
                        <p>Belum ada jawaban dari Guru BK</p>
                        <small>Jawaban akan muncul di sini ketika Guru BK membalas pertanyaanmu</small>
                    </div>
                `;
            } else {
                answeredQuestions.forEach((q, index) => {
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

                    html += `
                        <div class="notification-item" style="animation-delay: ${index * 0.1}s">
                            <div class="notification-header">
                                <span class="notification-category">
                                    ${categoryEmoji} ${categoryName}
                                </span>
                                <span class="notification-date">${tanggal}</span>
                            </div>
                            <div class="notification-question">
                                <p><strong>Pertanyaanmu:</strong> ${q.pertanyaan}</p>
                            </div>
                            <div class="notification-answer">
                                <p><strong>💌 Jawaban dari Guru BK:</strong></p>
                                <p>${q.answer}</p>
                                <div class="notification-teacher">
                                    <i class="fas fa-heart"></i> ${q.answerBy}
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            document.getElementById('notificationsContainer').innerHTML = html;
        }

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

        // Load saat halaman dibuka
        window.addEventListener('DOMContentLoaded', function() {
            displayNotifications();
            createFloatingStars();
        });
    </script>
</body>
</html>