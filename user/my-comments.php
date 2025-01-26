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

// Ambil data komentar pengguna dari database
$pengguna_id = $_SESSION["ssLogin"];
$query = "SELECT c.comment_id, c.content AS comment_content, q.title AS question_title, a.content AS answer_content, c.comment_created_at 
          FROM comments c
          JOIN answers a ON c.answer_id = a.answer_id
          JOIN questions q ON a.question_id = q.question_id
          WHERE c.pengguna_id = '$pengguna_id'";
$result = $koneksi->query($query);

// Cek apakah ada alert yang dikirim dari aksi
$alert = isset($_SESSION['alert']) ? $_SESSION['alert'] : null;
unset($_SESSION['alert']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar Saya - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Komentar Saya</h1>
        <a href="dashboard-user.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

        <!-- Alert -->
        <?php if ($alert): ?>
            <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $alert['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong>Pertanyaan: <?php echo htmlspecialchars($row['question_title']); ?></strong>
                        <p><strong>Jawaban:</strong> <?php echo htmlspecialchars($row['answer_content']); ?></p>
                        <p><strong>Komentar Anda:</strong> <?php echo htmlspecialchars($row['comment_content']); ?></p>
                        <small>Dikomentari pada: <?php echo $row['comment_created_at']; ?></small>
                        <div class="mt-2">
                            <!-- Tombol Edit (Pakai Modal) -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCommentModal" 
                                data-comment-id="<?php echo $row['comment_id']; ?>"
                                data-comment-content="<?php echo htmlspecialchars($row['comment_content']); ?>">
                                Edit
                            </button>
                            
                            <!-- Tombol Hapus dengan Konfirmasi -->
                            <a href="../actions/delete-comment.php?id=<?php echo $row['comment_id']; ?>" 
                               onclick="return confirm('Yakin untuk menghapus komentar ini?');" 
                               class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-center">Anda belum memberikan komentar.</p>
        <?php endif; ?>
    </div>

    <!-- Modal Edit Komentar -->
    <?php include '../template/modal-edit-comment.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mengisi data modal saat tombol edit diklik
        const editModal = document.getElementById('editCommentModal');
        editModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const commentId = button.getAttribute('data-comment-id');
            const commentContent = button.getAttribute('data-comment-content');

            document.getElementById('editCommentId').value = commentId;
            document.getElementById('editCommentContent').value = commentContent;
        });
    </script>
</body>
</html>
