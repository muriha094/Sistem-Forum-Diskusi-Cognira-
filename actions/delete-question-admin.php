<?php
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validasi apakah question_id valid
    if (!isset($_POST['question_id']) || !is_numeric($_POST['question_id'])) {
        header("Location: ../admin/manage-questions.php?error=invalid_id");
        exit();
    }

    $question_id = (int)$_POST['question_id'];

    // Ambil pengguna_id dan title dari pertanyaan yang akan dihapus
    $stmt = $koneksi->prepare("SELECT pengguna_id, title FROM questions WHERE question_id = ?");
    if (!$stmt) {
        header("Location: ../admin/manage-questions.php?error=db_error");
        exit();
    }

    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $question = $result->fetch_assoc();

    if ($question) {
        $pengguna_id = $question['pengguna_id'];
        $title = $question['title']; // Ambil judul pertanyaan

        // Kirim notifikasi kepada pembuat pertanyaan
        $pesan = "Pertanyaan Anda dengan judul *'$title'* telah dihapus karena melanggar aturan.";
        $pengirim_id = "system";

        $insertNotifStmt = $koneksi->prepare("
            INSERT INTO notifikasi (penerima_id, pengirim_id, pesan, target_id, target_type, question_id) 
            VALUES (?, ?, ?, ?, 'question', ?)
        ");
        if (!$insertNotifStmt) {
            die("Error preparing notification statement: " . $koneksi->error);
        }

        $insertNotifStmt->bind_param("ssssi", $pengguna_id, $pengirim_id, $pesan, $question_id, $question_id);

        if (!$insertNotifStmt->execute()) {
            die("Error executing notification statement: " . $insertNotifStmt->error);
        }

        // Hapus data terkait di tabel question_tags
        $deleteTagsStmt = $koneksi->prepare("DELETE FROM question_tags WHERE question_id = ?");
        if (!$deleteTagsStmt) {
            die("Error preparing delete tags statement: " . $koneksi->error);
        }
        $deleteTagsStmt->bind_param("i", $question_id);
        $deleteTagsStmt->execute();

        // Hapus tag yang tidak digunakan lagi
        $checkUnusedTagsStmt = $koneksi->prepare("DELETE FROM tags WHERE tag_id NOT IN (SELECT DISTINCT tag_id FROM question_tags)");
        if (!$checkUnusedTagsStmt) {
            die("Error preparing delete unused tags statement: " . $koneksi->error);
        }
        $checkUnusedTagsStmt->execute();

        // Hapus jawaban terkait secara manual (jika cascade tidak aktif)
        $deleteAnswersStmt = $koneksi->prepare("DELETE FROM answers WHERE question_id = ?");
        if (!$deleteAnswersStmt) {
            die("Error preparing delete answers statement: " . $koneksi->error);
        }
        $deleteAnswersStmt->bind_param("i", $question_id);
        $deleteAnswersStmt->execute();

        // Hapus pertanyaan dari database
        $deleteStmt = $koneksi->prepare("DELETE FROM questions WHERE question_id = ?");
        if (!$deleteStmt) {
            die("Error preparing delete question statement: " . $koneksi->error);
        }
        $deleteStmt->bind_param("i", $question_id);

        if ($deleteStmt->execute()) {
            header("Location: ../admin/manage-questions.php?success=1");
            exit();
        } else {
            header("Location: ../admin/manage-questions.php?error=delete_failed");
            exit();
        }
    } else {
        header("Location: ../admin/manage-questions.php?error=not_found");
        exit();
    }
} else {
    header("Location: ../admin/manage-questions.php");
    exit();
}
