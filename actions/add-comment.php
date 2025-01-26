<?php
require_once '../config.php';
require_once '../template/navbar-user.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Hanya pengguna yang login dapat mengakses
if (!isset($_SESSION["ssLogin"])) {
    header("location: ../auth/login.php");
    exit();
}

// Proses tambah komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answer_id = $_POST['answer_id'] ?? null;
    $user_id = $_SESSION['ssLogin'];
    $content = $_POST['content'] ?? null;
    $question_id = $_POST['question_id'] ?? null;

    if (!$answer_id || !$question_id || !$content) {
        die("Error: Data tidak lengkap. Pastikan answer_id, question_id, dan content dikirim.");
    }

    // Validasi answer_id
    $validateAnswer = $koneksi->prepare("SELECT answer_id, pengguna_id FROM answers WHERE answer_id = ?");
    $validateAnswer->bind_param('i', $answer_id);
    $validateAnswer->execute();
    $result = $validateAnswer->get_result();

    if ($result->num_rows === 0) {
        die("Error: ID Jawaban ($answer_id) tidak valid.");
    }

    $answerData = $result->fetch_assoc();
    $answerOwner = $answerData['pengguna_id'];

    // Tambahkan komentar ke database
    $query = "INSERT INTO comments (answer_id, pengguna_id, content, comment_created_at) 
              VALUES (?, ?, ?, NOW())";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('iss', $answer_id, $user_id, $content);
    $stmt->execute();

    $comment_id = $stmt->insert_id;

    // Kirim notifikasi ke pemilik jawaban
    $notifMessage = "mengomentari jawaban Anda.";
    $queryNotif = "INSERT INTO notifikasi (penerima_id, pengirim_id, pesan, target_id, target_type, question_id, waktu_notifikasi) 
                   VALUES (?, ?, ?, ?, 'comment', ?, NOW())";
    $stmtNotif = $koneksi->prepare($queryNotif);
    $stmtNotif->bind_param('sssii', $answerOwner, $user_id, $notifMessage, $comment_id, $question_id);
    $stmtNotif->execute();

    // Redirect ke halaman detail pertanyaan
    header('Location: ../question/question-detail.php?id=' . $question_id . '&comment_id=' . $comment_id);
    exit();
}
?>
