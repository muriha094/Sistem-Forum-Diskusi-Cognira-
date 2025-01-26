<?php
require_once "../config.php";
session_start();

// Proteksi halaman: Hanya admin yang dapat mengakses
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] !== 'Admin') {
    header("location: ../auth/login.php");
    exit();
}

// Ambil data foto profil admin dari database menggunakan pengguna_id
$pengguna_id = $_SESSION['ssLogin'];
$query = $koneksi->prepare("SELECT foto FROM admin_moderator WHERE pengguna_id = ?");
$query->bind_param('s', $pengguna_id);
$query->execute();
$result = $query->get_result();
$admin = $result->fetch_assoc();

// Tentukan foto profil (default jika tidak ada)
$foto_profil = (!empty($admin['foto']) && file_exists("../asset/uploads/" . $admin['foto']))
    ? "../asset/uploads/" . htmlspecialchars($admin['foto']) 
    : "../asset/uploads/default.png";

// Ambil jumlah laporan baru (Pending)
$query_laporan = $koneksi->query("SELECT COUNT(*) AS jumlah FROM laporan WHERE status_laporan = 'Pending'");
$laporan_baru = $query_laporan->fetch_assoc()['jumlah'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Cognira</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="../admin/dashboard-admin.php">Cognira Admin</a>

            <!-- Icons Navigation -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../admin/dashboard-admin.php">
                        <i class="fa-solid fa-house" style="color: #007bff; font-size: 1.5rem; transition: color 0.3s ease;" 
                        onmouseover="this.style.color='#FCC737'" 
                        onmouseout="this.style.color='#007bff'"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/kelola-pengguna.php">
                        <i class="fas fa-users-cog" style="color: #007bff; font-size: 1.5rem; transition: color 0.3s ease;" 
                        onmouseover="this.style.color='#FCC737'" 
                        onmouseout="this.style.color='#007bff'"></i> Kelola Pengguna
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/laporan-admin.php">
                        <i class="fas fa-flag" style="color: #007bff; font-size: 1.5rem; transition: color 0.3s ease;" 
                        onmouseover="this.style.color='#FCC737'" 
                        onmouseout="this.style.color='#007bff'"></i> Laporan
                        <?php if ($laporan_baru > 0) : ?>
                            <span class="badge bg-danger"><?= $laporan_baru ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>

            <!-- Profile dan Logout -->
            <div class="d-flex align-items-center">
                <!-- Foto Profil Admin -->
                <a href="../admin/profile-admin.php">
                    <img src="<?php echo $foto_profil; ?>" alt="Foto Admin" class="rounded-circle me-3" width="40" height="40">
                </a>

                <!-- Tombol Logout -->
                <a href="../auth/logout.php" class="btn btn-danger" onclick="return confirmLogout();">Logout</a>

                <script>
                    function confirmLogout() {
                        return confirm('Yakin ingin keluar dari akun admin?');
 }
                </script>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>