<?php
require_once "../config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Query pengguna biasa
    $query_user = $koneksi->prepare("SELECT * FROM pengguna_cognira WHERE email = ?");
    $query_user->bind_param("s", $email);
    $query_user->execute();
    $result_user = $query_user->get_result();

    if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();

        // Periksa apakah akun diblokir
        if ($user["statusblock"] == 1) {
            $blokir_hingga = strtotime($user["blokir_hingga"]);
            $sekarang = time();

            if ($sekarang < $blokir_hingga) {
                $selisih = $blokir_hingga - $sekarang;
                $hari = floor($selisih / (60 * 60 * 24));
                $jam = floor(($selisih % (60 * 60 * 24)) / (60 * 60));
                $menit = floor(($selisih % (60 * 60)) / 60);

                $_SESSION["alert"] = "Akun Anda diblokir hingga " . date('d-m-Y H:i:s', $blokir_hingga) . ". Waktu tersisa: $hari hari, $jam jam, $menit menit.";
                $_SESSION["alert_type"] = "danger";
                header("Location: login.php");
                exit();
            } else {
                // Jika waktu blokir habis, buka blokir akun
                $query_unblock = $koneksi->prepare("UPDATE pengguna_cognira SET statusblock = 0, blokir_hingga = NULL WHERE pengguna_id = ?");
                $query_unblock->bind_param("i", $user["pengguna_id"]);
                $query_unblock->execute();
            }
        }

        // Verifikasi kata sandi
        if (password_verify($password, $user["kata_sandi"])) {
            $_SESSION["ssLogin"] = $user["pengguna_id"];
            $_SESSION["nama_pengguna"] = $user["nama_pengguna"];
            $_SESSION["role"] = "User";
            $_SESSION["foto_profil"] = $user["foto"] ?? "default.png";
            header("Location: ../user/dashboard-user.php");
            exit();
        } else {
            $_SESSION["alert"] = "Kata sandi salah.";
            $_SESSION["alert_type"] = "danger";
            header("Location: login.php");
            exit();
        }
    }

    // Query admin/moderator
    $query_admin_mod = $koneksi->prepare("SELECT * FROM admin_moderator WHERE email = ?");
    $query_admin_mod->bind_param("s", $email);
    $query_admin_mod->execute();
    $result_admin_mod = $query_admin_mod->get_result();

    if ($result_admin_mod->num_rows > 0) {
        $admin_mod = $result_admin_mod->fetch_assoc();

        if (password_verify($password, $admin_mod["kata_sandi"])) {
            $_SESSION["ssLogin"] = $admin_mod["pengguna_id"];
            $_SESSION["nama_pengguna"] = $admin_mod["nama_pengguna"];
            $_SESSION["role"] = $admin_mod["peran"];
            $_SESSION["foto_profil"] = $admin_mod["foto"] ?? "default-profile.png";

            if ($admin_mod["peran"] === "Admin") {
                header("Location: ../admin/dashboard-admin.php");
            } elseif ($admin_mod["peran"] === "Moderator") {
                header("Location: ../moderator/dashboard-moderator.php");
            }
            exit();
        } else {
            $_SESSION["alert"] = "Kata sandi salah.";
            $_SESSION["alert_type"] = "danger";
            header("Location: login.php");
            exit();
        }
    }

    // Jika tidak ditemukan di kedua tabel
    $_SESSION["alert"] = "Email tidak terdaftar.";
    $_SESSION["alert_type"] = "danger";
    header("Location: login.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
