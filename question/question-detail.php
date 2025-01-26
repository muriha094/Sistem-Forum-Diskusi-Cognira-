<?php
require_once "../config.php";
require_once "../template/navbar-user.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman
if (!isset($_SESSION["ssLogin"]) || $_SESSION["role"] !== "User") {
    header("location: ../auth/login.php");
    exit();
}

// Validasi ID Pertanyaan
$question_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
if (!$question_id) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>ID Pertanyaan tidak valid.</div></div>";
    exit();
}

// Ambil Detail Pertanyaan
$query = $koneksi->prepare("
    SELECT q.*, u.nama_pengguna, u.foto 
    FROM questions q 
    JOIN pengguna_cognira u ON q.pengguna_id = u.pengguna_id 
    WHERE q.question_id = ?
");
$query->bind_param('i', $question_id);
$query->execute();
$question = $query->get_result()->fetch_assoc();

if (!$question) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Pertanyaan tidak ditemukan.</div></div>";
    exit();
}

$answer_id = isset($_GET['answer_id']) ? (int)$_GET['answer_id'] : null;
$comment_id = isset($_GET['comment_id']) ? (int)$_GET['comment_id'] : null;

function getProfilePhoto($photo) {
    return (!empty($photo) && file_exists('../asset/uploads/' . $photo)) 
        ? '../asset/uploads/' . htmlspecialchars($photo) 
        : '../asset/uploads/default.png';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pertanyaan</title>
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .profile-img { width: 50px; height: 50px; object-fit: cover; border-radius: 50%; }
        .comment-img { width: 35px; height: 35px; object-fit: cover; border-radius: 50%; }
        .comment-container { margin-left: 50px; }
        .btn-laporkan { margin-top: 5px; }
        .highlight { background-color: #ffffcc; border: 2px solid #ffeb3b; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Detail Pertanyaan -->
        <div class="card mb-4">
            <div class="card-header"><h5><?= htmlspecialchars($question['title']); ?></h5></div>
            <div class="card-body">
                <p><?= nl2br(htmlspecialchars($question['content'])); ?></p>
                <div class="d-flex align-items-center">
                    <img src="<?= getProfilePhoto($question['foto']); ?>" alt="Foto Profil" class="profile-img me-2">
                    <small>Ditanyakan oleh: <strong><?= htmlspecialchars($question['nama_pengguna']); ?></strong></small>
                </div>
                <a href="javascript:void(0);" 
                   onclick="konfirmasiLaporan('Question', <?= (int)$question['question_id']; ?>)" 
                   class="btn btn-danger btn-laporkan mt-3">
                    Laporkan Pertanyaan
                </a>
            </div>
        </div>

        <!-- Form Tambah Jawaban -->
        <div class="card mb-4">
            <div class="card-header"><h5>Tambah Jawaban</h5></div>
            <div class="card-body">
                <form action="../actions/add-answer.php" method="POST">
                    <input type="hidden" name="question_id" value="<?= (int)$question_id ?>">
                    <textarea name="content" class="form-control mb-2" placeholder="Tulis jawaban Anda..." required></textarea>
                    <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                </form>
            </div>
        </div>

        <!-- Daftar Jawaban -->
        <?php
        $answers_query = $koneksi->prepare("
            SELECT a.*, u.nama_pengguna, u.foto 
            FROM answers a 
            JOIN pengguna_cognira u ON a.pengguna_id = u.pengguna_id 
            WHERE a.question_id = ?
        ");
        $answers_query->bind_param('i', $question_id);
        $answers_query->execute();
        $answers_result = $answers_query->get_result();
        ?>

        <h5>Jawaban:</h5>
        <?php while ($answer = $answers_result->fetch_assoc()) : ?>
            <div class="card mb-3 <?= ($answer_id == $answer['answer_id']) ? 'highlight' : ''; ?>"
                id="answer-<?= $answer['answer_id']; ?>">
                <div class="card-body">
                   <div class="d-flex align-items-start">
                        <img src="<?= getProfilePhoto($answer['foto']); ?>" alt="Foto Profil" class="profile-img me-3">
                   <div>
                    <h6><?= htmlspecialchars($answer['nama_pengguna']); ?></h6>
                    <p><?= nl2br(htmlspecialchars($answer['content'])); ?></p>
                    <small><?= $answer['answer_created_at']; ?></small>
                </div>
            </div>
            <a href="javascript:void(0);" 
                       onclick="konfirmasiLaporan('Answer', <?= (int)$answer['answer_id']; ?>)" 
                       class="btn btn-danger btn-sm btn-laporkan mt-2">
                        Laporkan Jawaban
                    </a>
                    <!-- Form Tambah Komentar -->
                    <form action="../actions/add-comment.php" method="POST" class="mt-3">
                        <input type="hidden" name="answer_id" value="<?= (int)$answer['answer_id'] ?>">
                        <input type="hidden" name="question_id" value="<?= (int)$question_id ?>">
                        <textarea name="content" class="form-control mb-2" placeholder="Tambahkan komentar Anda..." required></textarea>
                        <button type="submit" class="btn btn-secondary btn-sm">Kirim Komentar</button>
                    </form>

		    <!--Daftar Komentar-->
                    <?php
                    $comments_query = $koneksi->prepare("SELECT c.*, u.nama_pengguna, u.foto FROM comments c JOIN pengguna_cognira u ON c.pengguna_id = u.pengguna_id WHERE c.answer_id = ?");
                    $comments_query->bind_param('i', $answer['answer_id']);
                    $comments_query->execute();
                    $comments_result = $comments_query->get_result();
                    ?>

                    <?php while ($comment = $comments_result->fetch_assoc()) : ?>
                        <div class="card mb-3 comment-container <?= ($comment_id == $comment['comment_id']) ? 'highlight' : ''; ?>"
                            id="comment-<?= $comment['comment_id']; ?>">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <img src="<?= getProfilePhoto($comment['foto']); ?>" alt="Foto Profil" class="comment-img me-3">
                                    <div>
                                        <h6><?= htmlspecialchars($comment['nama_pengguna']); ?></h6>
                                        <p><?= nl2br(htmlspecialchars($comment['content'])); ?></p>
                                        <small><?= $comment['comment_created_at']; ?></small>
                                    </div>
                                </div>
                                <a href="javascript:void(0);" 
                                   onclick="konfirmasiLaporan('Comment', <?= (int)$comment['comment_id']; ?>)" 
                                   class="btn btn-danger btn-sm btn-laporkan mt-2">
                                    Laporkan Komentar
                                </a>
                            </div>
                        </div>
                     <?php endwhile; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <script>
    function konfirmasiLaporan(tipe, id) {
        if (confirm('Apakah Anda yakin ingin melaporkan konten ini?')) {
            const questionId = new URLSearchParams(window.location.search).get('id');
            window.location.href = `../actions/aksi-lapor.php?tipe=${tipe}&id=${id}&question_id=${questionId}`;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const answerId = '<?= $answer_id ?>';
        const commentId = '<?= $comment_id ?>';
        if (answerId) document.getElementById(`answer-${answerId}`)?.scrollIntoView({ behavior: 'smooth' });
        if (commentId) document.getElementById(`comment-${commentId}`)?.scrollIntoView({ behavior: 'smooth' });
    });
    </script>
</body>
</html>
