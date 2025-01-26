<?php
require_once "../config.php";

// Pastikan sesi hanya dimulai satu kali
if (session_status() === PHP_SESSION_NONE) {
    // Kode untuk memulai sesi di sini
}

// Proteksi halaman: Hanya pengguna yang login dapat mengakses
session_start();
if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

$pengguna_id = $_SESSION['ssLogin'];

// Periksa apakah file diunggah
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];
    $upload_dir = "../asset/uploads/";

    // Validasi file yang diunggah
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $foto_extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

    if (!in_array($foto_extension, $allowed_extensions)) {
        header("Location: ../user/profile-user.php?status=error&message=Format file tidak valid.");
        exit();
    }

    if ($foto['size'] > 2000000) { // Maksimal 2MB
        header("Location: ../user/profile-user.php?status=error&message=Ukuran file terlalu besar.");
        exit();
    }

    // Simpan foto dengan nama unik
    $foto_nama = time() . '_' . basename($foto['name']);
    $target_file = $upload_dir . $foto_nama;

    if (move_uploaded_file($foto['tmp_name'], $target_file)) {
        // Hapus foto lama jika bukan default
        $query = $koneksi->prepare("SELECT foto FROM pengguna_cognira WHERE pengguna_id = ?");
        $query->bind_param('s', $pengguna_id);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();

        if ($user && !empty($user['foto']) && $user['foto'] !== 'default.png') {
            unlink($upload_dir . $user['foto']);
        }

        // Simpan nama file baru di database
        $update_query = $koneksi->prepare("UPDATE pengguna_cognira SET foto = ? WHERE pengguna_id = ?");
        $update_query->bind_param('ss', $foto_nama, $pengguna_id);
        $update_query->execute();

        header("Location: ../user/profile-user.php?status=success&message=Foto berhasil diperbarui.");
        exit();
    } else {
        header("Location: ../user/profile-user.php?status=error&message=Gagal mengunggah foto.");
        exit();
    }
} else {
    header("Location: ../user/profile-user.php?status=error&message=Tidak ada file yang diunggah.");
    exit();
}
?>
