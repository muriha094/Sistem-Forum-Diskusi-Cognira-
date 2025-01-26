<?php
require_once "../config.php";
session_start();

// Proteksi halaman: Pastikan pengguna sudah login dan memiliki peran Admin
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Validasi parameter ID Pertanyaan
$question_id = $_GET['id'] ?? null;
if (!$question_id || !is_numeric($question_id)) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'ID pertanyaan tidak valid.'];
    header("Location: ../admin/admin-questions.php");
    exit();
}

try {
    // Mulai transaksi
    $koneksi->begin_transaction();

    // Ambil pengguna_id dari pertanyaan untuk notifikasi
    $getUserQuery = $koneksi->prepare("SELECT pengguna_id FROM questions WHERE question_id = ?");
    $getUserQuery->bind_param('i', $question_id);
    $getUserQuery->execute();
    $userResult = $getUserQuery->get_result();

    if ($userResult->num_rows === 0) {
        throw new Exception('Pertanyaan tidak ditemukan.');
    }

    $userRow = $userResult->fetch_assoc();
    $pengguna_id = $userRow['pengguna_id'];

    // Hapus entri terkait di tabel question_tags
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

    // Kirim notifikasi ke pemilik pertanyaan
    $notifMessage = "Pertanyaan Anda dengan ID #$question_id telah dihapus oleh Admin.";
    $insertNotifQuery = $koneksi->prepare("INSERT INTO notifications (pengguna_id, message) VALUES (?, ?)");
    $insertNotifQuery->bind_param('is', $pengguna_id, $notifMessage);
    $insertNotifQuery->execute();

    // Commit transaksi jika semuanya berhasil
    $koneksi->commit();
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Pertanyaan berhasil dihapus, dan notifikasi telah dikirim ke pemilik pertanyaan.'];
} catch (Exception $e) {
    // Rollback transaksi jika ada kesalahan
    $koneksi->rollback();
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Gagal menghapus pertanyaan. Error: ' . $e->getMessage()];
}

// Redirect kembali ke halaman admin-questions.php
header("Location: ../admin/admin-questions.php");
exit();
?>
