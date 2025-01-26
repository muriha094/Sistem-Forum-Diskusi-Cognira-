<?php
// File: pages/forum.php
include '../config.php';
include '../template/navbar-user.php';

// Pastikan sesi hanya dimulai satu kali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Hanya pengguna yang login dapat mengakses
if (!isset($_SESSION["ssLogin"])) {
    header("location: ../auth/login.php");
    exit();
}

// Ambil pertanyaan yang sudah memiliki jawaban dari database
$query = $koneksi->prepare("
    SELECT q.question_id, q.title, q.content, q.question_created_at, u.nama_pengguna, u.foto, COUNT(a.answer_id) AS total_answers
    FROM questions q
    JOIN pengguna_cognira u ON q.pengguna_id = u.pengguna_id
    JOIN answers a ON q.question_id = a.question_id
    GROUP BY q.question_id
    HAVING total_answers > 0
    ORDER BY q.question_created_at DESC
");
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - Pertanyaan Terjawab</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Forum Diskusi - Pertanyaan Terjawab</h1>
        <p class="text-center">Lihat pertanyaan yang telah memiliki jawaban dari komunitas Cognira.</p>

        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <img src="../asset/uploads/<?php echo htmlspecialchars($row['foto']); ?>" 
                                         alt="Foto Profil" 
                                         class="rounded-circle me-3" 
                                         width="50" 
                                         height="50">
                                    <div>
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                        <p class="card-text"><?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 100))); ?>...</p>
                                        <small class="text-muted">
                                            Dibuat oleh: <strong><?php echo htmlspecialchars($row['nama_pengguna']); ?></strong> 
                                            pada <?php echo $row['question_created_at']; ?>
                                        </small>
                                        <p class="text-success mt-1">Jumlah Jawaban: <?php echo $row['total_answers']; ?></p>
                                        <div class="mt-3">
                                            <a href="question-detail.php?id=<?php echo $row['question_id']; ?>" class="btn btn-primary btn-sm">Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Belum ada pertanyaan yang memiliki jawaban di forum.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
