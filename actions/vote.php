<?php
include '../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['ssLogin']) || !is_array($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

// Validasi Input
$answer_id = isset($_POST['answer_id']) ? intval($_POST['answer_id']) : null;
$vote_type = isset($_POST['vote_type']) ? $_POST['vote_type'] : null;
$pengguna_id = isset($_SESSION['ssLogin']['pengguna_id']) ? $_SESSION['ssLogin']['pengguna_id'] : null;

if (!$answer_id || !in_array($vote_type, ['U', 'D']) || !$pengguna_id) {
    header("location: ../question/question-detail.php?id=" . $_POST['question_id']);
    exit();
}

// Cek apakah pengguna sudah memberikan vote sebelumnya
$check_query = $koneksi->prepare("SELECT votes_type FROM votes WHERE answer_id = ? AND pengguna_id = ?");
$check_query->bind_param('is', $answer_id, $pengguna_id);
$check_query->execute();
$vote_result = $check_query->get_result();

if ($vote_result->num_rows > 0) {
    $existing_vote = $vote_result->fetch_assoc();

    // Jika vote sama, hapus vote
    if ($existing_vote['votes_type'] === $vote_type) {
        $delete_query = $koneksi->prepare("DELETE FROM votes WHERE answer_id = ? AND pengguna_id = ?");
        $delete_query->bind_param('is', $answer_id, $pengguna_id);
        $delete_query->execute();
    } else {
        // Jika vote berbeda, perbarui vote
        $update_query = $koneksi->prepare("UPDATE votes SET votes_type = ?, vote_created_at = NOW() WHERE answer_id = ? AND pengguna_id = ?");
        $update_query->bind_param('sis', $vote_type, $answer_id, $pengguna_id);
        $update_query->execute();
    }
} else {
    // Jika belum pernah vote, tambahkan vote baru
    $insert_query = $koneksi->prepare("INSERT INTO votes (answer_id, pengguna_id, votes_type, vote_created_at) 
                                       VALUES (?, ?, ?, NOW())");
    $insert_query->bind_param('iss', $answer_id, $pengguna_id, $vote_type);
    $insert_query->execute();
}

// Redirect kembali ke halaman pertanyaan
header("location: ../question/question-detail.php?id=" . $_POST['question_id']);
exit();
?>
