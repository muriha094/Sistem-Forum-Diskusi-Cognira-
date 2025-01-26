<?php
require_once '../config.php';
require_once '../template/navbar-admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi Admin
if (!isset($_SESSION["ssLogin"]) || $_SESSION["role"] !== "Admin") {
    header("Location: ../auth/login.php");
    exit();
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil Data Laporan
$query = $koneksi->prepare("
    SELECT l.*, 
           p.nama_pengguna AS pelapor,
           t.nama_pengguna AS tersangka
    FROM laporan l
    JOIN pengguna_cognira p ON l.pelapor_id = p.pengguna_id
    JOIN pengguna_cognira t ON l.tersangka_id = t.pengguna_id
    ORDER BY l.waktu_laporan DESC
    LIMIT ? OFFSET ?
");
$query->bind_param('ii', $limit, $offset);
$query->execute();
$result = $query->get_result();

// Hitung Total Data
$total_query = $koneksi->query("SELECT COUNT(*) AS total FROM laporan");
$total_data = $total_query->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Periksa Tersangka yang Dilaporkan ≥3x
$reportedUsers = [];
$query_check = $koneksi->query("
    SELECT l.tersangka_id, t.nama_pengguna, COUNT(*) AS jumlah
    FROM laporan l
    JOIN pengguna_cognira t ON l.tersangka_id = t.pengguna_id
    GROUP BY l.tersangka_id
    HAVING jumlah >= 3
");
while ($row = $query_check->fetch_assoc()) {
    $reportedUsers[] = [ 
        'id' => $row['tersangka_id'],
        'nama' => $row['nama_pengguna']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Kelola Laporan Pengguna</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Pelapor</th>
                <th>Tersangka</th>
                <th>Tipe Konten</th>
                <th>ID Konten</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = $offset + 1; // Mulai nomor dari offset halaman
            while ($row = $result->fetch_assoc()) : 
            ?>
                <tr>
                    <td><?= $no++ ?></td> <!-- Nomor urut berdasarkan halaman -->
                    <td><?= htmlspecialchars($row['pelapor']) ?></td>
                    <td><?= htmlspecialchars($row['tersangka']) ?></td>
                    <td><?= htmlspecialchars($row['konten_tipe']) ?></td>
                    <td><?= htmlspecialchars($row['konten_id']) ?></td>
                    <td>
                        <?php if ($row['status_laporan'] === 'Pending') : ?>
                            <a href="update-status-report.php?id=<?= $row['laporan_id'] ?>" 
                            class="btn btn-sm btn-warning">
                            Tandai Selesai
                            </a>
                        <?php else : ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="delete-report-admin.php?id=<?= $row['laporan_id'] ?>" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')"
                        class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<!-- Modal Blokir -->
<div class="modal fade" id="modalBlokir" tabindex="-1" aria-labelledby="modalBlokirLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Peringatan Blokir Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Pengguna yang bernama <strong id="userId"></strong> telah dilaporkan lebih dari 3 kali. 
                Segera lakukan tindakan yang diperlukan!
            </div>
            <div class="modal-footer">
                <a href="#" id="blockUserBtn" class="btn btn-danger">Kelola Pengguna</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Ambil data pengguna yang dilaporkan
    const reportedUsers = <?= json_encode($reportedUsers) ?>;

    // Inisialisasi array pengguna yang telah ditangani
    const handledUsers = JSON.parse(localStorage.getItem('handledUsers')) || [];

    document.addEventListener('DOMContentLoaded', function () {
        // Filter pengguna yang belum ditangani
        const usersToBlock = reportedUsers.filter(user => !handledUsers.includes(user.id));

        if (usersToBlock.length > 0) {
            // Ambil pengguna pertama untuk ditampilkan di modal
            const user = usersToBlock[0];
            const modal = new bootstrap.Modal(document.getElementById('modalBlokir'));

            // Tampilkan nama dan URL tindakan
            document.getElementById('userId').innerText = user.nama;
            document.getElementById('blockUserBtn').href = `kelola-pengguna.php?id=${user.id}`;

            // Tambahkan event listener untuk tombol Kelola Pengguna
            document.getElementById('blockUserBtn').addEventListener('click', function () {
                handleUser(user.id);
            });

            // Tampilkan modal
            modal.show();
        }
    });

    function handleUser(userId) {
        // Tambahkan ID pengguna ke dalam array pengguna yang telah ditangani
        handledUsers.push(userId);

        // Simpan ke localStorage
        localStorage.setItem('handledUsers', JSON.stringify(handledUsers));

        // Sembunyikan modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalBlokir'));
        modal.hide();
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
