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

// Proses tambah jawaban
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = $_POST['question_id'] ?? null;
    $user_id = $_SESSION['ssLogin'];
    $content = $_POST['content'] ?? null;

    if (!$question_id || !$content) {
        die("Error: Data tidak lengkap. Pastikan question_id dan content dikirim.");
    }

    // Validasi question_id
    $validateQuestion = $koneksi->prepare("SELECT question_id, pengguna_id FROM questions WHERE question_id = ?");
    $validateQuestion->bind_param('i', $question_id);
    $validateQuestion->execute();
    $result = $validateQuestion->get_result();

    if ($result->num_rows === 0) {
        die("Error: ID Pertanyaan ($question_id) tidak valid.");
    }

    $questionData = $result->fetch_assoc();
    $questionOwner = $questionData['pengguna_id'];

    // Tambahkan jawaban ke database
    $query = "INSERT INTO answers (question_id, pengguna_id, content, answer_created_at) 
              VALUES (?, ?, ?, NOW())";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('iss', $question_id, $user_id, $content);
    $stmt->execute();

    $answer_id = $stmt->insert_id;

    // Kirim notifikasi ke pemilik pertanyaan
    $notifMessage = "telah menjawab pertanyaan Anda.";
    $queryNotif = "INSERT INTO notifikasi (penerima_id, pengirim_id, pesan, target_id, target_type, question_id, waktu_notifikasi) 
                   VALUES (?, ?, ?, ?, 'answer', ?, NOW())";
    $stmtNotif = $koneksi->prepare($queryNotif);
    $stmtNotif->bind_param('sssii', $questionOwner, $user_id, $notifMessage, $answer_id, $question_id);
    $stmtNotif->execute();

    // Redirect ke halaman detail pertanyaan
    header('Location: ../question/question-detail.php?id=' . $question_id . '&answer_id=' . $answer_id);
    exit();
}
?>
