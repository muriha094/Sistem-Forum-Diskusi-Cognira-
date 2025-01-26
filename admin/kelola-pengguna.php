<?php
require_once "../config.php";
require_once "../template/navbar-admin.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] !== "Admin") {
    header("location: ../auth/login.php");
    exit();
}

// Pencarian Pengguna
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM pengguna_cognira";
if ($search) {
    $query .= " WHERE pengguna_id LIKE '%$search%' OR nama_pengguna LIKE '%$search%'";
}

$result = $koneksi->query($query);
$total_pengguna = $koneksi->query("SELECT COUNT(*) as total FROM pengguna_cognira")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafc;
        }
        .status-active { color: #28a745; font-weight: bold; }
        .status-blocked { color: #dc3545; font-weight: bold; }
        .card-summary {
            margin-top: 10px;
            background: #17a2b8;
            color: white;
            border-radius: 8px;
        }
        .countdown {
            font-size: 0.9em; 
            color: #fd7e14;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .search-section, .summary-section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Kelola Pengguna</h2>
        
        <!-- Alert Aksi -->
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?= $_SESSION['alert']['type'] ?>"><?= $_SESSION['alert']['message'] ?></div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>

        <div class="row align-items-center gap-3 mb-3">
            <!-- Search Bar -->
            <div class="col-md-8">
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari ID atau Nama Pengguna" value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
            <!-- Total Pengguna Card -->
            <div class="col-md-3">
                <div class="card text-center card-summary">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengguna</h5>
                        <p class="card-text fs-5"><?= $total_pengguna ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pengguna -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Pengguna</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Waktu Blokir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['nama_pengguna']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <?= $user['statusblock'] == 0 ? '<span class="status-active">Active</span>' : '<span class="status-blocked">Blocked</span>' ?>
                                </td>
                                <td>
                                    <?php if ($user['statusblock'] == 1 && !empty($user['blokir_hingga'])): ?>
                                        <?php 
                                            $waktu_sekarang = new DateTime();
                                            $waktu_blokir = new DateTime($user['blokir_hingga']);
                                            $interval = $waktu_sekarang->diff($waktu_blokir);
                                        ?>
                                        <span class="countdown">
                                            <?= $interval->format('%a hari tersisa (Berakhir pada %d-%m-%Y)') ?>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user['statusblock'] == 0): ?>
                                        <form method="POST" action="../actions/block-user.php" class="d-inline">
                                            <input type="hidden" name="pengguna_id" value="<?= $user['pengguna_id'] ?>">
                                            <button type="submit" class="btn btn-warning btn-sm">Blokir</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="../actions/unblock-user.php" class="d-inline">
                                            <input type="hidden" name="pengguna_id" value="<?= $user['pengguna_id'] ?>">
                                            <button type="submit" class="btn btn-success btn-sm">Batal Blokir</button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="POST" action="../actions/delete-user.php" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        <input type="hidden" name="pengguna_id" value="<?= $user['pengguna_id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
