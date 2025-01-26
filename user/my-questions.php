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

// Ambil data pertanyaan pengguna dari database
$pengguna_id = $_SESSION["ssLogin"];
$query = "SELECT question_id, title, content, question_created_at FROM questions WHERE pengguna_id = '$pengguna_id'";
$result = $koneksi->query($query);

// Cek jika ada alert dari sesi
$alert = isset($_SESSION['alert']) ? $_SESSION['alert'] : null;
unset($_SESSION['alert']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertanyaan Saya - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Pertanyaan Saya</h1>
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
                        <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                        <small class="text-muted">Dibuat pada: <?php echo $row['question_created_at']; ?></small>
                        <div class="mt-2">
                            <!-- Tombol Edit (Pakai Modal) -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editQuestionModal" 
                                data-question-id="<?php echo $row['question_id']; ?>"
                                data-question-title="<?php echo htmlspecialchars($row['title']); ?>"
                                data-question-content="<?php echo htmlspecialchars($row['content']); ?>">
                                Edit
                            </button>
                            
                            <!-- Tombol Hapus dengan Konfirmasi -->
                            <a href="../actions/delete-question.php?id=<?php echo $row['question_id']; ?>" 
                               onclick="return confirm('Yakin untuk menghapus pertanyaan ini?');" 
                               class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-center">Anda belum membuat pertanyaan.</p>
        <?php endif; ?>
    </div>

    <!-- Modal Edit Pertanyaan -->
    <?php include '../template/modal-edit-question.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mengisi data modal saat tombol edit diklik
        const editModal = document.getElementById('editQuestionModal');
        editModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const questionId = button.getAttribute('data-question-id');
            const questionTitle = button.getAttribute('data-question-title');
            const questionContent = button.getAttribute('data-question-content');

            document.getElementById('editQuestionId').value = questionId;
            document.getElementById('editQuestionTitle').value = questionTitle;
            document.getElementById('editQuestionContent').value = questionContent;
        });
    </script>
</body>
</html>
