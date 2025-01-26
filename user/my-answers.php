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

// Ambil data jawaban pengguna dari database
$pengguna_id = $_SESSION["ssLogin"];
$query = "SELECT a.answer_id, a.content AS answer_content, q.title AS question_title, a.answer_created_at 
          FROM answers a
          JOIN questions q ON a.question_id = q.question_id
          WHERE a.pengguna_id = '$pengguna_id'";
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
    <title>Jawaban Saya - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Jawaban Saya</h1>
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
                        <p>Jawaban: <?php echo htmlspecialchars($row['answer_content']); ?></p>
                        <small class="text-muted">Dijawab pada: <?php echo $row['answer_created_at']; ?></small>
                        <div class="mt-2">
                            <!-- Tombol Edit (Pakai Modal) -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAnswerModal" 
                                data-answer-id="<?php echo $row['answer_id']; ?>"
                                data-answer-content="<?php echo htmlspecialchars($row['answer_content']); ?>">
                                Edit
                            </button>
                            
                            <!-- Tombol Hapus dengan Konfirmasi -->
                            <a href="../actions/delete-answer.php?id=<?php echo $row['answer_id']; ?>" 
                               onclick="return confirm('Yakin untuk menghapus jawaban ini?');" 
                               class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-center">Anda belum memberikan jawaban.</p>
        <?php endif; ?>
    </div>

    <!-- Modal Edit Jawaban -->
    <?php include '../template/modal-edit-answer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mengisi data modal saat tombol edit diklik
        const editModal = document.getElementById('editAnswerModal');
        editModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const answerId = button.getAttribute('data-answer-id');
            const answerContent = button.getAttribute('data-answer-content');

            document.getElementById('editAnswerId').value = answerId;
            document.getElementById('editAnswerContent').value = answerContent;
        });
    </script>
</body>
</html>
