<?php
require_once "../config.php";
require_once "../template/navbar-admin.php";

// Proteksi halaman: Hanya admin yang dapat mengakses
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["ssLogin"]) || $_SESSION["role"] !== "Admin") {
    header("location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            color: #333;
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
        <h1 class="text-center">Selamat Datang, Admin!</h1>
        <p class="text-center">Kelola semua aktivitas pada platform ini, mulai dari pertanyaan, jawaban, hingga komentar pengguna.</p>

        <!-- Cards Section -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Pertanyaan</h5>
                        <p class="card-text">Lihat dan kelola semua pertanyaan pengguna.</p>
                        <a href="manage-questions.php" class="btn btn-primary">Kelola</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Jawaban</h5>
                        <p class="card-text">Lihat dan kelola semua jawaban yang telah diberikan oleh pengguna.</p>
                        <a href="manage-answers.php" class="btn btn-primary">Kelola</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Komentar</h5>
                        <p class="card-text">Lihat dan kelola semua komentar pengguna.</p>
                        <a href="manage-comments.php" class="btn btn-primary">Kelola</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
