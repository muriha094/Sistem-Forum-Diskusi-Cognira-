<?php
require_once "../config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pengguna_id = $_POST['pengguna_id'];

    // Hitung waktu blokir 6 bulan ke depan
    $blokir_hingga = date('Y-m-d H:i:s', strtotime('+6 months'));

    // Update statusblock dan blokir_hingga
    $query = $koneksi->prepare("UPDATE pengguna_cognira SET statusblock = 1, blokir_hingga = ?, created_at = NOW() WHERE pengguna_id = ?");
    $query->bind_param("ss", $blokir_hingga, $pengguna_id);

    if ($query->execute()) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Pengguna berhasil diblokir hingga ' . date('d-m-Y H:i:s', strtotime($blokir_hingga)) . '.'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Terjadi kesalahan saat memblokir pengguna.'
        ];
    }

    header("location: ../admin/kelola-pengguna.php");
    exit();
}
?>
