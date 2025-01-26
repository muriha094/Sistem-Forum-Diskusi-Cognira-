<?php
require_once "../config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pengguna_id = $_POST['pengguna_id'];

    $query = $koneksi->prepare("UPDATE pengguna_cognira SET statusblock = 0 WHERE pengguna_id = ?");
    $query->bind_param("s", $pengguna_id);
    $query->execute();

    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Blokir pengguna berhasil dibatalkan.'];
    header("location: ../admin/kelola-pengguna.php");
    exit();
}
?>
