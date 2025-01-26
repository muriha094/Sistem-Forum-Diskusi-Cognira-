<?php
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $answer_id = $_GET['answer_id'];

    // Ambil pengguna_id, question_id, dan content terkait jawaban yang akan dihapus
    $stmt = $koneksi->prepare("SELECT pengguna_id, question_id, content FROM answers WHERE answer_id = ?");
    $stmt->bind_param("i", $answer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $answer = $result->fetch_assoc();

    if ($answer) {
        $pengguna_id = $answer['pengguna_id'];
        $question_id = $answer['question_id'];
        $content = $answer['content']; // Ambil konten jawaban

        // Hapus jawaban dari database
        $deleteStmt = $koneksi->prepare("DELETE FROM answers WHERE answer_id = ?");
        $deleteStmt->bind_param("i", $answer_id);

        if ($deleteStmt->execute()) {
            // Kirim notifikasi kepada pembuat jawaban dengan menampilkan konten
            $pesan = "Jawaban Anda: \"$content\" telah dihapus karena melanggar aturan.";
            $insertNotifStmt = $koneksi->prepare("
                INSERT INTO notifikasi (penerima_id, pengirim_id, pesan, target_id, target_type, question_id) 
                VALUES (?, 'system', ?, ?, 'answer', ?)
            ");
            $insertNotifStmt->bind_param("ssii", $pengguna_id, $pesan, $answer_id, $question_id);
            $insertNotifStmt->execute();

            header("Location: ../admin/manage-answers.php?success=1");
            exit();
        } else {
            header("Location: ../admin/manage-answers.php?error=delete_failed");
            exit();
        }
    } else {
        header("Location: ../admin/manage-answers.php?error=not_found");
        exit();
    }
} else {
    header("Location: ../admin/manage-answers.php");
    exit();
}
?>