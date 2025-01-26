<?php
require_once "../config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] !== "Admin") {
    header("location: ../auth/login.php");
    exit();
}

// Periksa apakah ID pengguna dikirim
if (isset($_POST['pengguna_id'])) {
    $pengguna_id = $_POST['pengguna_id'];

    try {
        // Nonaktifkan autocommit untuk transaksi
        mysqli_autocommit($koneksi, false);

        // Hapus komentar pengguna
        $queryDeleteComments = "DELETE FROM comments WHERE pengguna_id = ?";
        $stmt = mysqli_prepare($koneksi, $queryDeleteComments);
        mysqli_stmt_bind_param($stmt, "s", $pengguna_id);
        mysqli_stmt_execute($stmt);

        // Hapus jawaban pengguna
        $queryDeleteAnswers = "DELETE FROM answers WHERE pengguna_id = ?";
        $stmt = mysqli_prepare($koneksi, $queryDeleteAnswers);
        mysqli_stmt_bind_param($stmt, "s", $pengguna_id);
        mysqli_stmt_execute($stmt);

        // Hapus pertanyaan pengguna
        $queryDeleteQuestions = "DELETE FROM questions WHERE pengguna_id = ?";
        $stmt = mysqli_prepare($koneksi, $queryDeleteQuestions);
        mysqli_stmt_bind_param($stmt, "s", $pengguna_id);
        mysqli_stmt_execute($stmt);

        // Hapus pengguna
        $queryDeleteUser = "DELETE FROM pengguna_cognira WHERE pengguna_id = ?";
        $stmt = mysqli_prepare($koneksi, $queryDeleteUser);
        mysqli_stmt_bind_param($stmt, "s", $pengguna_id);
        mysqli_stmt_execute($stmt);

        // Commit transaksi
        mysqli_commit($koneksi);

        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Pengguna berhasil dihapus.'
        ];
    } catch (mysqli_sql_exception $e) {
        // Rollback transaksi jika ada kesalahan
        mysqli_rollback($koneksi);
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Gagal menghapus pengguna: ' . $e->getMessage()
        ];
    } finally {
        // Aktifkan autocommit kembali
        mysqli_autocommit($koneksi, true);
        header("Location: ../admin/kelola-pengguna.php");
        exit();
    }
} else {
    $_SESSION['alert'] = [
        'type' => 'warning',
        'message' => 'ID pengguna tidak ditemukan.'
    ];
    header("Location: ../admin/kelola-pengguna.php");
    exit();
}
?>
