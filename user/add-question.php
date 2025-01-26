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

// Ambil ID pengguna yang login
$pengguna_id = $_SESSION["ssLogin"];

// Cek jika ada alert dari sesi
$alert = isset($_SESSION['alert']) ? $_SESSION['alert'] : null;
unset($_SESSION['alert']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pertanyaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Pertanyaan Baru</h1>
        <a href="dashboard-user.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        
        <!-- Alert -->
        <?php if ($alert): ?>
            <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $alert['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Form Tambah Pertanyaan -->
        <div class="card">
            <div class="card-body">
                <form action="../actions/add-question.php" method="POST">
                    <input type="hidden" name="pengguna_id" value="<?php echo $pengguna_id; ?>">

                    <!-- Judul Pertanyaan -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Pertanyaan</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul pertanyaan" required>
                    </div>

                    <!-- Isi Pertanyaan -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Pertanyaan</label>
                        <textarea name="content" id="content" class="form-control" rows="5" placeholder="Tuliskan pertanyaan Anda di sini" required></textarea>
                    </div>

                    <!-- Tag Pertanyaan -->
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tag</label>
                        <input type="text" name="tags" id="tags" class="form-control" placeholder="Contoh: SQL, Database, PHP">
                        <small class="text-muted">Pisahkan tag dengan koma (,)</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Pertanyaan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
