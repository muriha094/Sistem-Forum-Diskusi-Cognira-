<?php
// Header untuk halaman Kebijakan Privasi
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kebijakan Privasi - Cognira Forum Diskusi</title>
    <link rel="icon" type="image/png" href="/app_cognira/asset/logo.png">

    <!-- CSS untuk Styling -->
    <style>
        /* Reset beberapa gaya dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Mengatur font umum untuk halaman */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
            padding: 0;
        }

        /* Navbar */
        nav {
            background-color: #007bff;
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            color: #fff;
            font-size: 1.8em;
            text-decoration: none;
            padding-left: 20px;
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        nav .container a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-size: 1.1em;
        }

        nav .container a:hover {
            text-decoration: underline;
        }

        /* Header halaman - Menambahkan jarak antara navbar dan judul */
        header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-top: 8px; /* Menambahkan jarak */
        }

        header h1 {
            font-size: 2.5em;
        }

        /* Section utama */
        section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Subheading */
        h2 {
            color: #007bff;
            font-size: 1.8em;
            margin-top: 20px;
        }

        /* Paragraf */
        p {
            font-size: 1.1em;
            margin-bottom: 15px;
        }

        /* Daftar */
        ul {
            list-style-type: none;
            padding-left: 20px;
        }

        ul li {
            font-size: 1.1em;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 30px;
            background-color: #006BFF;
            color: white;
            margin-top: 30px;
        }

        footer .footer-links {
            margin-bottom: 20px;
        }

        footer .footer-links a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.1em;
        }

        footer .footer-links a:hover {
            text-decoration: underline;
        }

        footer p {
            font-size: 1em;
            margin-bottom: 10px;
        }

        /* Responsif: Mengatur agar halaman lebih ramah perangkat mobile */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            header h1 {
                font-size: 2em;
            }

            section {
                padding: 15px;
            }

            h2 {
                font-size: 1.5em;
            }

            p {
                font-size: 1em;
            }

            ul li {
                font-size: 1em;
            }

            nav .container {
                flex-direction: column;
                align-items: flex-start;
            }

            nav .container a {
                margin-left: 0;
                margin-top: 10px;
            }
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

    <header>
        <h1>Kebijakan Privasi Cognira</h1>
    </header>

    <section>
        <h2>Pendahuluan</h2>
        <p>Selamat datang di <strong>Cognira</strong>! Kami menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda. Halaman ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi yang Anda berikan saat menggunakan layanan forum diskusi kami.</p>

        <h2>Informasi yang Kami Kumpulkan</h2>
        <p>Ketika Anda mengunjungi, mendaftar, atau berinteraksi dengan forum kami, kami dapat mengumpulkan informasi berikut:</p>
        <ul>
            <li><strong>Informasi Pribadi:</strong> Nama, alamat email, dan informasi lain yang Anda berikan saat mendaftar atau memperbarui akun.</li>
            <li><strong>Informasi Aktivitas Pengguna:</strong> Data tentang aktivitas Anda di forum, termasuk post, komentar, dan interaksi lainnya.</li>
            <li><strong>Informasi Teknis:</strong> Alamat IP, jenis browser, sistem operasi, dan data lain yang dikumpulkan secara otomatis saat Anda mengakses forum.</li>
        </ul>

        <h2>Bagaimana Kami Menggunakan Informasi Anda</h2>
        <p>Informasi yang kami kumpulkan digunakan untuk:</p>
        <ul>
            <li>Menyediakan dan mengelola forum diskusi.</li>
            <li>Meningkatkan pengalaman pengguna dan fungsionalitas situs.</li>
            <li>Melakukan komunikasi terkait dengan akun dan aktivitas di forum.</li>
            <li>Mengamankan akun Anda dan mencegah penyalahgunaan platform.</li>
            <li>Menawarkan dukungan pelanggan dan memperbaiki masalah teknis.</li>
        </ul>

        <h2>Bagaimana Kami Melindungi Informasi Anda</h2>
        <p>Kami menggunakan langkah-langkah teknis dan administratif untuk melindungi data pribadi Anda. Kami mengenkripsi informasi sensitif, seperti kata sandi, dan hanya memberikan akses terbatas ke data pribadi berdasarkan kebutuhan operasional.</p>
        <p>Namun, harap diingat bahwa tidak ada metode pengiriman data melalui internet yang 100% aman. Meskipun kami berusaha keras untuk melindungi informasi Anda, kami tidak dapat menjamin keamanan penuh.</p>

        <h2>Berbagi Informasi dengan Pihak Ketiga</h2>
        <p>Kami tidak menjual, menyewa, atau membagikan informasi pribadi Anda dengan pihak ketiga tanpa izin Anda, kecuali untuk tujuan yang telah dijelaskan dalam kebijakan ini atau jika diperlukan oleh hukum.</p>
        <p>Namun, kami dapat bekerja dengan penyedia layanan pihak ketiga yang membantu kami menjalankan forum, seperti layanan hosting dan analitik. Penyedia ini hanya diberikan akses terbatas ke data Anda dan diwajibkan untuk menjaga kerahasiaannya.</p>

        <h2>Kebijakan Cookies</h2>
        <p>Forum ini menggunakan cookies untuk meningkatkan pengalaman pengguna. Cookies adalah file kecil yang disimpan di perangkat Anda yang membantu kami mengingat preferensi Anda dan mengumpulkan data statistik penggunaan.</p>
        <p>Anda dapat menonaktifkan cookies di pengaturan browser Anda, tetapi harap diperhatikan bahwa beberapa fitur forum mungkin tidak berfungsi dengan baik jika cookies dinonaktifkan.</p>

        <h2>Hak Anda terkait Data Pribadi</h2>
        <p>Anda memiliki hak untuk mengakses, memperbarui, atau menghapus informasi pribadi Anda yang kami simpan. Anda juga dapat menonaktifkan akun Anda kapan saja dengan menghubungi kami melalui halaman kontak.</p>
        <p>Jika Anda memiliki pertanyaan atau kekhawatiran terkait kebijakan privasi ini, Anda dapat menghubungi tim kami melalui alamat email yang tersedia di halaman kontak.</p>

        <h2>Perubahan pada Kebijakan Privasi</h2>
        <p>Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Setiap perubahan akan diumumkan di halaman ini dengan tanggal pembaruan yang tercantum di bawah ini.</p>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-links">
            <a href="/app_cognira/index.php">Home</a>
            <a href="/app_cognira/halamanlain/about-cognira.php">Tentang Kami</a>
            <a href="mailto:support@cognira.com?subject=Pertanyaan tentang layanan&body=Halo, saya ingin bertanya tentang...">Kontak</a>
            <a href="/app_cognira/halamanlain/kebijakan-privasi.php">Kebijakan Privasi</a>
        </div>
        <p>Copyright &copy; Cognira <?= date("Y") ?></p>
    </footer>
</body>
</html>
