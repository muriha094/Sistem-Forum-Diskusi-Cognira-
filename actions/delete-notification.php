<?php
require_once '../config.php';
require_once '../template/navbar-user.php';

// Pastikan sesi hanya dimulai satu kali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Hanya pengguna yang login dapat mengakses
if (!isset($_SESSION["ssLogin"])) {
    header("location: ../auth/login.php");
    exit();
}

// Proses hapus notifikasi
if (isset($_GET['id'])) {
    $notif_id = $_GET['id'];
    $user_id = $_SESSION['ssLogin'];

    // Hapus notifikasi milik pengguna yang login
    $query = "DELETE FROM notifikasi WHERE notifikasi_id = ? AND penerima_id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('is', $notif_id, $user_id);
    $stmt->execute();
}

header('Location: ../user/notifikasi.php');
exit();
?>
