<?php
require_once "../config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengguna_id = $_SESSION['ssLogin'];
    $nama_pengguna = htmlspecialchars($_POST['nama_pengguna']);
    $email = htmlspecialchars($_POST['email']);

    $query = $koneksi->prepare("UPDATE pengguna_cognira SET nama_pengguna = ?, email = ? WHERE pengguna_id = ?");
    $query->bind_param('sss', $nama_pengguna, $email, $pengguna_id);
    $query->execute();

    header("Location: ../user/profile-user.php?status=success");
    exit();
}
?>
