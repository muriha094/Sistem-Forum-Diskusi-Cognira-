<?php
require_once "../config.php";
session_start();

// Proteksi halaman
if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

// Ambil data dari form
$pengguna_id = $_POST['pengguna_id'];
$title = htmlspecialchars($_POST['title']);
$content = htmlspecialchars($_POST['content']);
$tags = htmlspecialchars($_POST['tags']);

// Validasi data
if (empty($title) || empty($content)) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Judul dan Isi Pertanyaan wajib diisi.'];
    header("Location: ../user/add-question.php");
    exit();
}

// Simpan pertanyaan ke database
$query = $koneksi->prepare("INSERT INTO questions (pengguna_id, title, content, question_created_at) VALUES (?, ?, ?, NOW())");
$query->bind_param('iss', $pengguna_id, $title, $content);

if ($query->execute()) {
    // Ambil ID pertanyaan terakhir
    $question_id = $query->insert_id;

    // Simpan tag (jika ada)
    if (!empty($tags)) {
        $tagArray = explode(',', $tags);
        foreach ($tagArray as $tag) {
            $tag = trim($tag);

            // Cek jika tag sudah ada
            $checkTag = $koneksi->prepare("SELECT tag_id FROM tags WHERE tag_name = ?");
            $checkTag->bind_param('s', $tag);
            $checkTag->execute();
            $result = $checkTag->get_result();

            if ($result->num_rows > 0) {
                $tagData = $result->fetch_assoc();
                $tag_id = $tagData['tag_id'];
            } else {
                // Jika tag belum ada, tambahkan tag baru
                $insertTag = $koneksi->prepare("INSERT INTO tags (tag_name) VALUES (?)");
                $insertTag->bind_param('s', $tag);
                $insertTag->execute();
                $tag_id = $insertTag->insert_id;
            }

            // Hubungkan tag dengan pertanyaan
            $insertQuestionTag = $koneksi->prepare("INSERT INTO question_tags (question_id, tag_id) VALUES (?, ?)");
            $insertQuestionTag->bind_param('ii', $question_id, $tag_id);
            $insertQuestionTag->execute();
        }
    }

    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Pertanyaan berhasil ditambahkan!'];
    header("Location: ../user/add-question.php");
} else {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Gagal menambahkan pertanyaan. Silakan coba lagi.'];
    header("Location: ../user/add-question.php");
}
exit();
?>
