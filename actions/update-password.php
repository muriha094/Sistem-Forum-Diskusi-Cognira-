<?php
require_once "../config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengguna_id = $_SESSION['ssLogin'];
    $old_password = $_POST['old_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $query = $koneksi->prepare("UPDATE pengguna_cognira SET kata_sandi = ? WHERE pengguna_id = ?");
    $query->bind_param('ss', $new_password, $pengguna_id);
    $query->execute();
    header("Location: ../user/profile-user.php?status=success");
    exit();
}
?>
