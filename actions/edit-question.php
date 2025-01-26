<?php
require_once "../config.php";
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

$question_id = $_POST['question_id'];
$title = htmlspecialchars($_POST['title']);
$content = htmlspecialchars($_POST['content']);


$query = $koneksi->prepare("UPDATE questions SET title = ?, content = ? WHERE question_id = ?");
$query->bind_param('ssi', $title, $content, $question_id);

$_SESSION['alert'] = $query->execute()
    ? ['type' => 'success', 'message' => 'Pertanyaan berhasil diperbarui.']
    : ['type' => 'danger', 'message' => 'Gagal memperbarui pertanyaan.'];

header("Location: ../user/my-questions.php");
exit();
?>
