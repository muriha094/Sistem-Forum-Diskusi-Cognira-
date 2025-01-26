<?php
require_once '../config.php';

if (!isset($_GET['id'])) {
    header("Location: laporan-admin.php");
    exit();
}

$laporan_id = intval($_GET['id']);

$query = $koneksi->prepare("DELETE FROM laporan WHERE laporan_id = ?");
$query->bind_param('i', $laporan_id);

if ($query->execute()) {
    echo "<script>alert('Laporan berhasil dihapus'); window.location='laporan-admin.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus laporan'); window.location='laporan-admin.php';</script>";
}
?>
