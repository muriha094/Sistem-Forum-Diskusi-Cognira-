<?php
require_once "../config.php";
session_start();

// Proteksi halaman
if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

// Ambil ID Komentar
$comment_id = $_GET['id'];

$query = $koneksi->prepare("DELETE FROM comments WHERE comment_id = ?");
$query->bind_param('i', $comment_id);

if ($query->execute()) {
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Komentar berhasil dihapus.'];
} else {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Gagal menghapus komentar.'];
}

header("Location: ../user/my-comments.php");
exit();
?>
