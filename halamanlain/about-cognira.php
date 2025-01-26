<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Cognira</title>
    <link rel="icon" type="image/png" href="/app_cognira/asset/logo.png">
    <style>
        /* Reset some basic styles */
        body, h1, h2, h3, h4, p, ul, li {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        body {
            background-color: #f4f7fa;
            color: #333;
            line-height: 1.6;
            padding-top: 50px;
        }

        /* Navbar */
        nav {
            background-color: #007bff;
            padding: 10px 0;
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

        /* Container */
        .container {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
        }

        /* Card */
        .card {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
        }
        .card-header h3 {
            margin: 0;
        }
        .card-body {
            padding: 20px;
        }
        .card-body p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* List Group */
        .list-group {
            list-style-type: none;
            padding-left: 0;
        }
        .list-group-item {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .list-group-item:hover {
            background-color: #f1f3f5;
        }

        /* Headings */
        h4 {
            margin-top: 20px;
            font-size: 20px;
            color: #007bff;
        }
        h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
        }

         /* Footer */
         footer {
            background-color: #007bff;
            color: #fff;
            text-align: left;
            padding: 15px;
            bottom: 0;
            width: 100%;
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }  

    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="container">
        <a href="#" class="navbar-brand"><b>Cognira</b></a>
        <div>
            <a href="/app_cognira/index.php">Home</a>
            <a href="/app_cognira/halamanlain/about-cognira.php">Tentang</a>
            <a href="/app_cognira/auth/login.php">Login</a>
            <a href="/app_cognira/registrasi/register.php">Daftar</a>
            

        
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Tentang Cognira</h3>
        </div>
        <div class="card-body">
            <p>Cognira adalah sebuah platform diskusi online berbasis web yang dirancang untuk memfasilitasi pertukaran ide, informasi, dan solusi di antara pengguna dari berbagai latar belakang. Dengan desain yang mirip Quora, Cognira bertujuan untuk menciptakan komunitas yang produktif, interaktif, dan informatif.</p>

            <h4><strong>Visi</strong></h4>
            <p>"Membangun komunitas global yang terhubung melalui diskusi dan kolaborasi untuk menciptakan solusi bagi berbagai tantangan dunia."</p>

            <h4><strong>Misi</strong></h4>
            <ul class="list-group">
                <li class="list-group-item">Menyediakan platform yang mudah diakses untuk berdiskusi dan berbagi pengetahuan.</li>
                <li class="list-group-item">Mendorong partisipasi aktif pengguna dalam membagikan ide, pengalaman, dan solusi.</li>
                <li class="list-group-item">Membangun lingkungan yang aman, ramah, dan bebas dari diskriminasi.</li>
                <li class="list-group-item">Mendukung moderasi komunitas melalui fitur moderasi yang transparan.</li>
            </ul>

            <h4><strong>Fitur Utama Cognira</strong></h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Forum Diskusi</strong>
                    <ul>
                        <li>Pengguna dapat membuat pertanyaan, menjawab pertanyaan, serta mengomentari jawaban.</li>
                        <li>Sistem tagging untuk mengorganisir topik diskusi.</li>
                    </ul>
                </li>
                <li class="list-group-item"><strong>Moderasi dan Laporan</strong>
                    <ul>
                        <li>Pengguna dapat melaporkan konten yang tidak sesuai.</li>
                        <li>Admin dan moderator memiliki alat moderasi untuk menjaga kualitas diskusi.</li>
                    </ul>
                </li>
                <li class="list-group-item"><strong>Notifikasi</strong>
                    <ul>
                        <li>Memberikan pemberitahuan real-time kepada pengguna untuk aktivitas penting, seperti jawaban baru, komentar, atau tindakan moderasi.</li>
                    </ul>
                </li>
                <li class="list-group-item"><strong>Sistem Voting</strong>
                    <ul>
                        <li>Pengguna dapat memberikan suara positif (upvote) atau negatif (downvote) pada jawaban untuk menentukan relevansi.</li>
                    </ul>
                </li>
                <li class="list-group-item"><strong>Proteksi Keamanan</strong>
                    <ul>
                        <li>Sistem login dan proteksi halaman untuk menjaga privasi dan keamanan data pengguna.</li>
                    </ul>
                </li>
            </ul>

            <h4><strong>Manfaat Penggunaan Cognira</strong></h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Pembelajaran Interaktif</strong>: Mendapatkan wawasan baru dari berbagai sudut pandang.</li>
                <li class="list-group-item"><strong>Kolaborasi</strong>: Menemukan rekan diskusi yang berbagi minat atau tujuan serupa.</li>
                <li class="list-group-item"><strong>Peningkatan Reputasi</strong>: Kesempatan untuk diakui atas kontribusi positif di komunitas.</li>
            </ul>

            <h4><strong>Komunitas yang Beragam</strong></h4>
            <p>Cognira membuka pintu untuk semua orang tanpa memandang latar belakang. Baik profesional, pelajar, atau siapa pun yang ingin berbagi atau mencari solusi, semua diterima dengan tangan terbuka.</p>

            <h4><strong>Pengembangan ke Depan</strong></h4>
            <p>Cognira terus berkomitmen untuk berinovasi, menambahkan fitur-fitur baru, dan memastikan platform tetap relevan dengan kebutuhan penggunanya. Dengan dukungan komunitas, Cognira bercita-cita menjadi forum diskusi online yang terkemuka.</p>

            <h4><strong>Hubungi Kami</strong></h4>
            <p>Untuk informasi lebih lanjut atau masukan, silakan hubungi tim Cognira melalui email: <a href="mailto:support@cognira.com">support@cognira.com</a></p>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include "../template/footer.php"; ?>

</body>
</html>
