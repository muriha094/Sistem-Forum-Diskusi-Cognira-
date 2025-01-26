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

// Ambil parameter pencarian dan pagination
$search = $_GET['search'] ?? '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Query untuk mendapatkan data komentar
$query = "
    SELECT c.comment_id, u.nama_pengguna, c.content, a.answer_id 
    FROM comments c
    JOIN pengguna_cognira u ON c.pengguna_id = u.pengguna_id
    JOIN answers a ON c.answer_id = a.answer_id
    WHERE c.content LIKE ? OR c.comment_id LIKE ?
    LIMIT ? OFFSET ?
";
$stmt = $koneksi->prepare($query);
$searchParam = "%$search%";
$stmt->bind_param("ssii", $searchParam, $searchParam, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
$comments = $result->fetch_all(MYSQLI_ASSOC);

// Query untuk menghitung total data
$countQuery = "
    SELECT COUNT(*) as total 
    FROM comments c
    JOIN pengguna_cognira u ON c.pengguna_id = u.pengguna_id
    WHERE c.content LIKE ? OR c.comment_id LIKE ?
";
$countStmt = $koneksi->prepare($countQuery);
$countStmt->bind_param("ss", $searchParam, $searchParam);
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Komentar - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center">Kelola Komentar</h1>

        <!-- Form Pencarian -->
        <form method="GET" class="my-3">
            <input type="text" name="search" placeholder="Cari ID atau Isi Komentar..." value="<?= htmlspecialchars($search) ?>" class="form-control">
        </form>

        <!-- Tabel Komentar -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID Komentar</th>
                    <th>Nama Pembuat</th>
                    <th>Isi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($comments) > 0): ?>
                    <?php foreach ($comments as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['comment_id']) ?></td>
                            <td><?= htmlspecialchars($c['nama_pengguna']) ?></td>
                            <td><?= htmlspecialchars($c['content']) ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $c['comment_id'] ?>)">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada komentar yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <script>
        function confirmDelete(commentId) {
            Swal.fire({
                title: 'Yakin ingin menghapus komentar ini?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `../actions/delete-comment-admin.php?comment_id=${commentId}`;
                }
            });
        }

        <?php if (isset($_GET['success'])): ?>
        Swal.fire({
            title: 'Berhasil!',
            text: 'Komentar berhasil dihapus.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        <?php elseif (isset($_GET['error'])): ?>
        Swal.fire({
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menghapus komentar.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        <?php endif; ?>
    </script>
</body>
</html>
