<?php
require_once "../config.php";

// Pastikan sesi hanya dimulai satu kali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Hanya pengguna dengan role "User" yang dapat mengakses
if (!isset($_SESSION["ssLogin"]) || $_SESSION["role"] !== "User") {
    echo "<script>
        alert('Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        window.location.href = '../question/question-detail.php';
    </script>";
    exit();
}

// Validasi Input
$tipe = $_GET['tipe'] ?? null;
$id = $_GET['id'] ?? null;
$question_id = $_GET['question_id'] ?? null;
$pelapor_id = $_SESSION['ssLogin'] ?? null;

// Validasi parameter
if (!$tipe || !$id || !$pelapor_id || !$question_id || !in_array($tipe, ['Question', 'Answer', 'Comment']) || !is_numeric($id) || !is_numeric($question_id)) {
    echo "<script>
        alert('Data laporan tidak valid. Periksa tipe, ID konten, atau ID pertanyaan.');
        window.location.href = '../question/question-detail.php?id={$question_id}';
    </script>";
    exit();
}

// Proses Laporan
try {
    $tersangka_id = null;

    switch ($tipe) {
        case 'Question':
            $query = $koneksi->prepare("SELECT pengguna_id FROM questions WHERE question_id = ?");
            break;
        case 'Answer':
            $query = $koneksi->prepare("SELECT pengguna_id FROM answers WHERE answer_id = ?");
            break;
        case 'Comment':
            $query = $koneksi->prepare("SELECT pengguna_id FROM comments WHERE comment_id = ?");
            break;
    }

    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $tersangka_id = $row['pengguna_id'];
    } else {
        echo "<script>
            alert('Konten tidak ditemukan.');
            window.location.href = '../question/question-detail.php?id={$question_id}';
        </script>";
        exit();
    }

    // Cek apakah laporan sudah ada sebelumnya
    $cekLaporan = $koneksi->prepare("
        SELECT laporan_id FROM laporan 
        WHERE pelapor_id = ? AND konten_id = ? AND konten_tipe = ?
    ");
    $cekLaporan->bind_param('sis', $pelapor_id, $id, $tipe);
    $cekLaporan->execute();
    $cekResult = $cekLaporan->get_result();

    if ($cekResult->num_rows > 0) {
        echo "<script>
            alert('Anda sudah melaporkan konten ini sebelumnya.');
            window.location.href = '../question/question-detail.php?id={$question_id}';
        </script>";
        exit();
    }

    // Masukkan laporan ke dalam tabel `laporan`
    $insertQuery = $koneksi->prepare("
        INSERT INTO laporan (pelapor_id, tersangka_id, konten_id, konten_tipe, waktu_laporan)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $insertQuery->bind_param('ssis', $pelapor_id, $tersangka_id, $id, $tipe);
    $insertQuery->execute();

    if ($insertQuery->affected_rows > 0) {
        echo "<script>
            alert('Laporan berhasil dikirim.');
            window.location.href = '../question/question-detail.php?id={$question_id}';
        </script>";
    } else {
        echo "<script>
            alert('Gagal mengirim laporan.');
            window.location.href = '../question/question-detail.php?id={$question_id}';
        </script>";
    }

} catch (Exception $e) {
    echo "<script>
        alert('Terjadi kesalahan server: " . addslashes($e->getMessage()) . "');
        window.location.href = '../question/question-detail.php?id={$question_id}';
    </script>";
}
?>
