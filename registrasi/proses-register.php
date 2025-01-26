<?php
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Tangkap data dari form registrasi
    $nama = $koneksi->real_escape_string($_POST["nama"]);
    $email = $koneksi->real_escape_string($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password

    // Default Foto
    $foto = "default.png";

    // Proses Upload Foto
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        $allowed_types = ["image/png", "image/jpeg", "image/jpg"];
        $file_type = $_FILES["foto"]["type"];

        if (in_array($file_type, $allowed_types)) {
            $file_name = uniqid() . "_" . basename($_FILES["foto"]["name"]);
            $target_file = "../asset/uploads/" . $file_name;

            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $foto = $file_name; // Ganti foto default dengan nama file baru
            }
        } else {
            header("location: register.php?error=File harus berupa gambar (png, jpg, jpeg).");
            exit();
        }
    }

    // Dapatkan ID unik dari fungsi generate_user_id
    $result = $koneksi->query("SELECT generate_user_id('User') AS new_id");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pengguna_id = $row['new_id'];
    } else {
        header("location: register.php?error=Gagal menghasilkan ID pengguna.");
        exit();
    }

    // Default Statusblock
    $statusblock = 0; // 'Active' status (sesuai dengan tipe TINYINT 0 = Active)
    $blokir_hingga = NULL;

    // Simpan Data ke Database
    $query = "INSERT INTO pengguna_cognira 
              (pengguna_id, nama_pengguna, email, kata_sandi, foto, created_at, statusblock, blokir_hingga) 
              VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)";

    $stmt = $koneksi->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssssis", $pengguna_id, $nama, $email, $password, $foto, $statusblock, $blokir_hingga);
        if ($stmt->execute()) {
            header("location: register.php?success=Registrasi berhasil. Silakan login.");
            exit();
        } else {
            header("location: register.php?error=Terjadi kesalahan saat menyimpan data.");
            exit();
        }
    } else {
        header("location: register.php?error=Gagal menyiapkan query SQL.");
        exit();
    }
} else {
    header("location: register.php");
    exit();
}
?>
