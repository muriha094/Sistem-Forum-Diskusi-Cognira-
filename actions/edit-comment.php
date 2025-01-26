<?php
require_once "../config.php";
session_start();

// Proteksi halaman
if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

// Ambil data dari form
$comment_id = $_POST['comment_id'];
$content = htmlspecialchars($_POST['content']);

$query = $koneksi->prepare("UPDATE comments SET content = ? WHERE comment_id = ?");
$query->bind_param('si', $content, $comment_id);

if ($query->execute()) {
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Komentar berhasil diperbarui.'];
} else {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Gagal memperbarui komentar.'];
}

header("Location: ../user/my-comments.php");
exit();
?>
