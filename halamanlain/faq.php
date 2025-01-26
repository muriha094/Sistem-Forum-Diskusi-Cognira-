<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Cognira</title>
    <link rel="icon" type="image/png" href="/app_cognira/asset/logo.png">
    <style>
        /* Navbar */
        nav {
            background-color: #007bff;
            padding: 13px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            font-size: 16px;
        }
        nav a:hover {
            background-color: #0056b3;
            border-radius: 5px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <!-- Navbar -->
<nav>
    <div class="container">
        <a href="#" class="navbar-brand text-white"><b>Cognira</b></a>
        <div>
            <a href="/app_cognira/index.php">Home</a>
            <a href="/app_cognira/halamanlain/about-cognira.php">Tentang</a>
            <a href="/app_cognira/auth/login.php">Login</a>
            <a href="/app_cognira/registrasi/register.php">Daftar</a>
            

        
        </div>
    </div>
</nav>

    <div class="container my-5">
        <h1 class="text-center mb-4">FAQ - Cognira</h1>

        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <strong>Apa itu Cognira?</strong>
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Cognira adalah platform diskusi online yang dirancang untuk memfasilitasi pertukaran ide, informasi, dan solusi di antara penggunanya.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <strong>Bagaimana cara mendaftar di Cognira?</strong>
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Anda dapat mendaftar dengan mengunjungi halaman pendaftaran dan mengisi informasi seperti nama pengguna, email, dan kata sandi.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <strong>Apa saja fitur utama Cognira?</strong>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Fitur utama termasuk forum diskusi, sistem moderasi, notifikasi, sistem voting, dan proteksi keamanan untuk pengguna.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <strong>Bagaimana cara melaporkan konten yang tidak sesuai?</strong>
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Anda dapat melaporkan konten dengan mengklik tombol "Laporkan" pada konten yang bersangkutan. Laporan Anda akan diteruskan ke moderator untuk ditinjau.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        <strong>Bagaimana cara mendapatkan notifikasi?</strong>
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Notifikasi akan muncul secara otomatis di akun Anda ketika ada aktivitas baru terkait pertanyaan atau jawaban yang Anda buat. Dan anda dapat mengecek notifikasi di simbol lonceng yang ada di navbar
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

