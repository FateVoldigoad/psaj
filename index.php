<!DOCTYPE html>
<html>
<head>
    <title>Login PSAJ</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 50px 40px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-section h1 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .logo-section p {
            color: #666;
            font-size: 14px;
        }

        .role-selection {
            display: flex;
            gap: 15px;
            margin-bottom: 35px;
            justify-content: center;
        }

        .role-btn {
            flex: 1;
            padding: 14px 20px;
            font-size: 15px;
            font-weight: 600;
            border: 2px solid #e0e0e0;
            background-color: white;
            color: #333;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .role-btn:hover {
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
        }

        .role-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            transform: translateY(-2px);
        }

        .form-container {
            display: none;
            animation: fadeIn 0.4s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container.active {
            display: block;
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .form-title i {
            color: #667eea;
            font-size: 28px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .input-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background-color: #f8f9ff;
        }

        .input-group input::placeholder {
            color: #999;
        }

        form button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        form button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- LOGO SECTION -->
    <div class="logo-section">
        <h1>Layanan Pengaduan</h1>
        <p>SMK Negeri 10 Surabaya</p>
    </div>

    <!-- PILIHAN ROLE -->
    <div class="role-selection">
        <button type="button" class="role-btn active" onclick="showLoginForm('guru')">
            <i class="fas fa-chalkboard-user"></i>
            Guru
        </button>
        <button type="button" class="role-btn" onclick="showLoginForm('siswa')">
            <i class="fas fa-user-graduate"></i>
            Siswa
        </button>
    </div>

    <!-- FORM LOGIN GURU -->
    <div id="guru-form" class="form-container active">
        <h2 class="form-title">
            <i class="fas fa-lock"></i>
            Login Guru
        </h2>
        <form action="dashboard.php" method="POST">
            <input type="hidden" name="role" value="guru">
            <div class="input-group">
                <label for="guru-username">Username</label>
                <input type="text" id="guru-username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="input-group">
                <label for="guru-password">Password</label>
                <input type="password" id="guru-password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </button>
        </form>
    </div>

    <!-- FORM LOGIN SISWA -->
    <div id="siswa-form" class="form-container">
        <h2 class="form-title">
            <i class="fas fa-lock"></i>
            Login Siswa
        </h2>
        <form action="siswa/dashboard.php" method="POST">
            <input type="hidden" name="role" value="siswa">
            <div class="input-group">
                <label for="siswa-username">Username</label>
                <input type="text" id="siswa-username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="input-group">
                <label for="siswa-password">Password</label>
                <input type="password" id="siswa-password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </button>
        </form>
    </div>
</div>

<script>
    function showLoginForm(role) {
        // Sembunyikan semua form
        document.getElementById('guru-form').classList.remove('active');
        document.getElementById('siswa-form').classList.remove('active');

        // Clear semua input fields (refresh username dan password)
        document.getElementById('guru-username').value = '';
        document.getElementById('guru-password').value = '';
        document.getElementById('siswa-username').value = '';
        document.getElementById('siswa-password').value = '';

        // Hapus active dari semua tombol
        document.querySelectorAll('.role-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Tampilkan form yang dipilih
        if (role === 'guru') {
            document.getElementById('guru-form').classList.add('active');
            document.querySelectorAll('.role-btn')[0].classList.add('active');
            document.getElementById('guru-username').focus();
        } else if (role === 'siswa') {
            document.getElementById('siswa-form').classList.add('active');
            document.querySelectorAll('.role-btn')[1].classList.add('active');
            document.getElementById('siswa-username').focus();
        }
    }
</script>

</body>
</html>