<?php
require_once "../config.php";
session_start();

// Ambil alert dari session
$alert = $_SESSION['alert'] ?? null;
$alert_type = $_SESSION['alert_type'] ?? null;
$blocked_until = $_SESSION['blocked_until'] ?? null;

// Hapus session alert setelah ditampilkan
unset($_SESSION['alert']);
unset($_SESSION['alert_type']);
unset($_SESSION['blocked_until']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #007bff;
            color: white;
            height: 100vh;
        }
        .card {
            background: #ffffff;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #ff9800;
            border: none;
        }
        .btn-primary:hover {
            background-color: #e68900;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center text-dark">Login ke Cognira</h3>

                        <!-- Alert Section -->
                        <?php if ($alert): ?>
                            <div class="alert alert-<?= htmlspecialchars($alert_type) ?> text-center">
                                <?= htmlspecialchars($alert) ?>
                                <?php if ($alert_type === 'warning' && $blocked_until): ?>
                                    <div id="countdown" class="mt-2 fw-bold text-danger"></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Form Login -->
                        <form action="proses-login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label text-dark">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label text-dark">Kata Sandi</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                        <i class="bi bi-eye" id="icon-password"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <p class="text-center mt-3 text-dark">
                            Belum punya akun? <a href="../registrasi/register.php" class="text-primary">Daftar di sini</a>
                        </p>
                        <div class="text-muted small text-center">Copyright &copy; Cognira <?= date("Y") ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Countdown Script -->
    <?php if ($blocked_until): ?>
    <script>
        const countdownElement = document.getElementById('countdown');
        const blockedUntil = new Date("<?= $blocked_until ?>").getTime();

        const countdownInterval = setInterval(() => {
            const now = new Date().getTime();
            const distance = blockedUntil - now;

            if (distance <= 0) {
                clearInterval(countdownInterval);
                countdownElement.innerHTML = "Waktu blokir telah berakhir. Silakan coba login kembali.";
            } else {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownElement.innerHTML = `Akun Anda akan dibuka dalam: ${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik`;
            }
        }, 1000);
    </script>
    <?php endif; ?>

    <script>
        const togglePassword = document.getElementById("toggle-password");
        const passwordField = document.getElementById("password");
        const iconPassword = document.getElementById("icon-password");

        togglePassword.addEventListener("click", () => {
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
            iconPassword.classList.toggle("bi-eye");
            iconPassword.classList.toggle("bi-eye-slash");
        });
    </script>
</body>
</html>
