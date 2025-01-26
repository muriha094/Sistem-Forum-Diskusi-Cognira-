<?php
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Validasi dan sanitasi input
    if (!isset($_GET['comment_id']) || !is_numeric($_GET['comment_id'])) {
        header("Location: ../admin/manage-comments.php?error=invalid_input");
        exit();
    }

    $comment_id = intval($_GET['comment_id']);

    // Ambil pengguna_id, answer_id, dan content terkait komentar yang akan dihapus
    $stmt = $koneksi->prepare("SELECT pengguna_id, answer_id, content FROM comments WHERE comment_id = ?");
    if (!$stmt) {
        header("Location: ../admin/manage-comments.php?error=db_error");
        exit();
    }

    $stmt->bind_param("i", $comment_id);
    if (!$stmt->execute()) {
        header("Location: ../admin/manage-comments.php?error=db_error");
        exit();
    }

    $result = $stmt->get_result();
    $comment = $result->fetch_assoc();

    if ($comment) {
        $pengguna_id = $comment['pengguna_id'];
        $answer_id = $comment['answer_id'];
        $content = $comment['content']; // Ambil konten komentar

        // Ambil question_id dari answer_id
        $questionQuery = $koneksi->prepare("SELECT question_id FROM answers WHERE answer_id = ?");
        if (!$questionQuery) {
            header("Location: ../admin/manage-comments.php?error=db_error");
            exit();
        }

        $questionQuery->bind_param("i", $answer_id);
        if (!$questionQuery->execute()) {
            header("Location: ../admin/manage-comments.php?error=db_error");
            exit();
        }

        $questionResult = $questionQuery->get_result();
        $question = $questionResult->fetch_assoc();
        $question_id = $question ? $question['question_id'] : NULL;

        // Hapus komentar dari database
        $deleteStmt = $koneksi->prepare("DELETE FROM comments WHERE comment_id = ?");
        if (!$deleteStmt) {
            header("Location: ../admin/manage-comments.php?error=db_error");
            exit();
        }

        $deleteStmt->bind_param("i", $comment_id);
        if ($deleteStmt->execute()) {
            // Kirim notifikasi kepada pembuat komentar
            $pesan = "Komentar Anda: \"$content\" telah dihapus karena melanggar aturan.";
            $insertNotifStmt = $koneksi->prepare("
                INSERT INTO notifikasi (penerima_id, pengirim_id, pesan, target_id, target_type, question_id) 
                VALUES (?, 'system', ?, ?, 'comment', ?)
            ");
            if (!$insertNotifStmt) {
                header("Location: ../admin/manage-comments.php?error=db_error");
                exit();
            }

            $insertNotifStmt->bind_param("ssii", $pengguna_id, $pesan, $comment_id, $question_id);
            if (!$insertNotifStmt->execute()) {
                header("Location: ../admin/manage-comments.php?error=notif_failed");
                exit();
            }

            header("Location: ../admin/manage-comments.php?success=1");
            exit();
        } else {
            header("Location: ../admin/manage-comments.php?error=delete_failed");
            exit();
        }
    } else {
        header("Location: ../admin/manage-comments.php?error=not_found");
        exit();
    }
} else {
    header("Location: ../admin/manage-comments.php");
    exit();
}
?>