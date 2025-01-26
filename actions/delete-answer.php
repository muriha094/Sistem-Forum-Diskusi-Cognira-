<?php
require_once "../config.php";
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

// Ambil ID Jawaban
$answer_id = $_GET['id'];

// Mulai transaksi
$koneksi->begin_transaction();

try {
    // Hapus komentar terkait dengan jawaban
    $deleteCommentsQuery = $koneksi->prepare("DELETE FROM comments WHERE answer_id = ?");
    $deleteCommentsQuery->bind_param('i', $answer_id);
    $deleteCommentsQuery->execute();

    // Hapus jawaban dari tabel answers
    $deleteAnswerQuery = $koneksi->prepare("DELETE FROM answers WHERE answer_id = ?");
    $deleteAnswerQuery->bind_param('i', $answer_id);
    $deleteAnswerQuery->execute();

    // Jika semua berhasil, commit transaksi
    $koneksi->commit();
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Jawaban berhasil dihapus.'];
} catch (mysqli_sql_exception $e) {
    // Jika ada kesalahan, rollback transaksi
    $koneksi->rollback();
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Gagal menghapus jawaban. Error: ' . $e->getMessage()];
}

// Redirect kembali ke halaman my-answers.php
header("Location: ../user/my-answers.php");
exit();
?>
