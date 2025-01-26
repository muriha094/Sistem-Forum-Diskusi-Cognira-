<?php
require_once "../config.php";
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

$answer_id = $_POST['answer_id'];
$content = htmlspecialchars($_POST['content']);

$query = $koneksi->prepare("UPDATE answers SET content = ? WHERE answer_id = ?");
$query->bind_param('si', $content, $answer_id);

$_SESSION['alert'] = $query->execute()
    ? ['type' => 'success', 'message' => 'Jawaban berhasil diperbarui.']
    : ['type' => 'danger', 'message' => 'Gagal memperbarui jawaban.'];

header("Location: ../user/my-answers.php");
exit();
?>
