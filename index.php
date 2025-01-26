<?php require_once "./config.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cognira - Ruang Pengetahuan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
        }

        .hero {
            background: linear-gradient(to right, #007bff, #00bfff);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.2rem;
            margin: 20px 0;
        }

        .hero .btn-primary {
            background-color: #ff9800;
            border: none;
        }

        .features {
            padding: 50px 0;
        }

        .features h2 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 30px;
        }

        .features .feature-item {
            text-align: center;
        }

        .features .feature-item i {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Include Navbar -->
    <?php include './template/navbar-general.php'; ?>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1>Selamat Datang di Cognira</h1>
            <p>Ruang Pengetahuan untuk Semua. Temukan jawaban atas pertanyaan Anda atau bagikan wawasan Anda di komunitas kami.</p>
            <a href="registrasi/register.php" class="btn btn-primary btn-lg">Bergabung Sekarang</a>
        </div>
    </div>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2>Kenapa Memilih Cognira?</h2>
            <div class="row">
                <div class="col-md-4 feature-item">
                    <i class="bi bi-journal"></i>
                    <h5>Pertanyaan dan Jawaban</h5>
                    <p>Temukan berbagai diskusi yang membantu meningkatkan pengetahuan Anda.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <i class="bi bi-people"></i>
                    <h5>Komunitas Aktif</h5>
                    <p>Bergabung dengan komunitas yang antusias untuk berbagi dan belajar.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <i class="bi bi-lightbulb"></i>
                    <h5>Inspirasi dan Solusi</h5>
                    <p>Dapatkan inspirasi dari jawaban terbaik untuk setiap pertanyaan Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require_once "template/footer.php"; ?> 

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
