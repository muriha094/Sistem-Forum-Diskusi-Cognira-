<?php
require_once "../config.php";
require_once "../template/navbar-user.php";

// Pastikan sesi hanya dimulai satu kali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Hanya pengguna dengan role "User" yang dapat mengakses
if (!isset($_SESSION["ssLogin"]) || $_SESSION["role"] !== "User") {
    header("location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            color: #333;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar a {
            color: white;
        }

        .content {
            padding: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    
    <!-- Content -->
    <div class="container content">
        <h1 class="text-center">Selamat Datang, <?php echo $_SESSION["nama_pengguna"]; ?>!</h1>
        <p class="text-center">Ini adalah dashboard pengguna Anda. Kelola semua pertanyaan, jawaban, dan komentar yang pernah anda buat disini !</p>

        <!-- Cards Section -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Pertanyaan Saya</h5>
                        <p class="card-text">Lihat dan kelola semua pertanyaan yang pernah Anda buat.</p>
                        <a href="my-questions.php" class="btn btn-primary">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Jawaban Saya</h5>
                        <p class="card-text">Kelola semua jawaban yang telah Anda berikan di forum.</p>
                        <a href="my-answers.php" class="btn btn-primary">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Komentar Saya</h5>
                        <p class="card-text">Kelola semua komentar yang telah anda berikan di forum.</p>
                        <a href="my-comments.php" class="btn btn-primary">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
