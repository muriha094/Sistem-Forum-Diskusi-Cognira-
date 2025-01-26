<?php
// Konfigurasi Database
$host = "localhost"; // Server database
$user = "root";      // Username database
$password = "";      // Password database
$db_name = "app_cognira"; // Nama database

// Koneksi ke Database
$koneksi = new mysqli($host, $user, $password, $db_name);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// URL Induk
$base_url = "http://localhost/app_cognira"; // Sesuaikan dengan URL proyek Anda

// Pastikan koneksi berhasil
// echo "Koneksi berhasil dan URL induk disiapkan.";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tambahkan Favicon -->
    <link rel="icon" type="image/png" href="/app_cognira/asset/logo.png">
</head>
</html>

