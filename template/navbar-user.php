<?php
ob_start(); // Menghindari output sebelum header
require_once "../config.php";
session_start();

// Proteksi halaman: Hanya pengguna yang login dapat mengakses
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil data pengguna
$pengguna_id = $_SESSION['ssLogin'];

// Ambil foto profil pengguna
$query = $koneksi->prepare("SELECT foto FROM pengguna_cognira WHERE pengguna_id = ?");
$query->bind_param('s', $pengguna_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$foto_profil = (!empty($user['foto']) && file_exists("../asset/uploads/" . $user['foto'])) 
    ? "../asset/uploads/" . htmlspecialchars($user['foto']) 
    : "../asset/uploads/default.png";

// Hitung jumlah notifikasi belum dibaca
$notif_query = $koneksi->prepare("SELECT COUNT(*) AS jumlah_baru FROM notifikasi WHERE penerima_id = ? AND status_dibaca = 0");
$notif_query->bind_param('s', $pengguna_id);
$notif_query->execute();
$notif_result = $notif_query->get_result();
$notif_data = $notif_result->fetch_assoc();
$jumlah_notifikasi_baru = isset($notif_data['jumlah_baru']) ? (int)$notif_data['jumlah_baru'] : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cognira</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .nav-link i {
            color: #007bff;
            font-size: 1.5rem;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link i:hover {
            color: #FCC737;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: #ff0000;
            color: #fff;
            font-size: 0.7rem;
            font-weight: bold;
            border-radius: 50%;
            padding: 2px 6px;
            line-height: 1;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="../user/dashboard-user.php">Cognira</a>

            <!-- Icons Navigation -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/app_cognira/user/dashboard-user.php">
                        <i class="fa-solid fa-house"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/app_cognira/question/forum.php">
                        <i class="fas fa-list"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/app_cognira/question/forum-without-answer.php">
                        <i class="fas fa-pen-to-square"></i>
                    </a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link" href="/app_cognira/user/notifikasi.php">
                        <i class="fas fa-bell"></i>
                        <?php if ($jumlah_notifikasi_baru > 0): ?>
                            <span class="notification-badge"><?= $jumlah_notifikasi_baru ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>

            <!-- Search Bar -->
            <form class="d-flex me-3" action="../template/search.php" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Cari pertanyaan" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>

            <!-- Profile and Add Question -->
            <div class="d-flex align-items-center">
                <a href="../user/profile-user.php">
                    <img src="<?= $foto_profil; ?>" alt="Foto Profil" class="rounded-circle me-3" width="40" height="40">
                </a>

                <a href="../user/add-question.php" class="btn btn-primary me-2">Tambah Pertanyaan</a>
                
                <a href="../auth/logout.php" class="btn btn-danger" onclick="return confirmLogout();">Logout</a>
            </div>

            <script>
                function confirmLogout() {
                    return confirm('Yakin ingin keluar dari akun ini?');
                }
            </script>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>
