<?php
require_once "../config.php";
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

// Ambil ID Pertanyaan
$question_id = $_GET['id'];

// Mulai transaksi
$koneksi->begin_transaction();

try {
    // Hapus terlebih dahulu entri terkait di tabel question_tags
    $deleteTagsQuery = $koneksi->prepare("DELETE FROM question_tags WHERE question_id = ?");
    $deleteTagsQuery->bind_param('i', $question_id);
    $deleteTagsQuery->execute();

    // Hapus jawaban terkait dengan pertanyaan
    $deleteAnswersQuery = $koneksi->prepare("DELETE FROM answers WHERE question_id = ?");
    $deleteAnswersQuery->bind_param('i', $question_id);
    $deleteAnswersQuery->execute();

    // Hapus pertanyaan dari tabel questions
    $deleteQuestionQuery = $koneksi->prepare("DELETE FROM questions WHERE question_id = ?");
    $deleteQuestionQuery->bind_param('i', $question_id);
    $deleteQuestionQuery->execute();

    // Jika semua berhasil, commit transaksi
    $koneksi->commit();
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Pertanyaan berhasil dihapus.'];
} catch (mysqli_sql_exception $e) {
    // Jika ada kesalahan, rollback transaksi
    $koneksi->rollback();
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Gagal menghapus pertanyaan. Error: ' . $e->getMessage()];
}

// Redirect kembali ke halaman my-questions.php
header("Location: ../user/my-questions.php");
exit();
?>
