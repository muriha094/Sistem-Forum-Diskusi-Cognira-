<?php
require_once "../config.php";

// Ambil jumlah laporan baru (Pending)
$query_laporan = $koneksi->query("SELECT COUNT(*) AS jumlah FROM laporan WHERE status_laporan = 'Pending'");
$laporan_baru = $query_laporan->fetch_assoc()['jumlah'];

echo $laporan_baru;
?>