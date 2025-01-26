<?php
require_once "../config.php";
require_once "../template/navbar-admin.php";

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Query untuk mengambil data pertanyaan
$sql = "SELECT q.question_id, q.title, q.content, u.nama_pengguna 
        FROM questions q 
        JOIN pengguna_cognira u ON q.pengguna_id = u.pengguna_id 
        WHERE q.title LIKE ? OR q.content LIKE ? 
        ORDER BY q.question_id DESC";
$stmt = $koneksi->prepare($sql);

if ($stmt) {
    $searchTerm = "%$search%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $questions = $result->fetch_all(MYSQLI_ASSOC); // Ambil semua data pertanyaan
} else {
    $questions = []; // Jika query gagal, set $questions sebagai array kosong
}

// Inisialisasi variabel pagination
$totalQuestions = count($questions);
$perPage = 10; // Jumlah pertanyaan per halaman
$totalPages = ceil($totalQuestions / $perPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Ambil data pertanyaan untuk halaman saat ini
$questions = array_slice($questions, $offset, $perPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pertanyaan - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center">Kelola Pertanyaan</h1>

        <!-- Form Pencarian -->
        <form method="GET" class="my-3">
            <input type="text" name="search" placeholder="Cari ID atau Judul..." value="<?= htmlspecialchars($search) ?>" class="form-control">
        </form>

        <!-- Tabel Pertanyaan -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pertanyaan</th>
                    <th>Nama Pembuat</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($questions) > 0): ?>
                    <?php foreach ($questions as $q): ?>
                        <tr>
                            <td><?= htmlspecialchars($q['question_id']) ?></td>
                            <td><?= htmlspecialchars($q['nama_pengguna']) ?></td>
                            <td><?= htmlspecialchars($q['title']) ?></td>
                            <td><?= htmlspecialchars($q['content']) ?></td>
                            <td>
                                <form action="../actions/delete-question-admin.php" method="POST" class="d-inline" onsubmit="return confirmDelete(event)">
                                    <input type="hidden" name="question_id" value="<?= htmlspecialchars($q['question_id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada pertanyaan yang ditemukan.</td>
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

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi untuk konfirmasi penghapusan
        function confirmDelete(event) {
            event.preventDefault(); // Mencegah form dari pengiriman otomatis
            const form = event.target; // Ambil form yang dipicu

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus pertanyaan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika pengguna mengkonfirmasi
                }
            });
        }

        // Menampilkan alert sukses/gagal berdasarkan parameter URL
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Pertanyaan berhasil dihapus.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else if (urlParams.has('error')) {
                let errorMessage = 'Terjadi kesalahan. ';
                switch (urlParams.get('error')) {
                    case 'invalid_id':
                        errorMessage += 'ID pertanyaan tidak valid.';
                        break;
                    case 'not_found':
                        errorMessage += 'Pertanyaan tidak ditemukan.';
                        break;
                    case 'delete_failed':
                        errorMessage += 'Gagal menghapus pertanyaan.';
                        break;
                    default:
                        errorMessage += 'Silakan coba lagi.';
                }
                Swal.fire({
                    title: 'Gagal!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    </script>
</body>
</html>
