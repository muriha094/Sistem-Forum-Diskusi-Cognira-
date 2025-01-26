<?php
require_once "../config.php";

// Pastikan sesi hanya dimulai satu kali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Hanya Admin/Moderator yang dapat mengakses
if (!isset($_SESSION['ssLogin']) || ($_SESSION['role'] !== "Admin" && $_SESSION['role'] !== "Moderator")) {
    header("location: ../auth/login.php");
    exit();
}


// Tampilkan alert jika ada
if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['alert']['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php 
    unset($_SESSION['alert']); // Hapus alert setelah ditampilkan
endif; 


// Ambil ID pengguna dari sesi
$pengguna_id = $_SESSION['ssLogin'];

// Tangani permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];
    $foto_nama = null;

    // Validasi Nama dan Email
    if (empty($nama) || empty($email)) {
        $errors[] = "Nama dan Email wajib diisi.";
    }

    // Proses Foto (jika diunggah)
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto'];
        $foto_nama = uniqid() . '-' . $foto['name'];
        $foto_path = "../asset/uploads/" . $foto_nama;

        // Validasi file foto
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_extensions)) {
            $errors[] = "Format foto hanya diperbolehkan jpg, jpeg, atau png.";
        }

        if ($foto['size'] > 2 * 1024 * 1024) { // Maksimal 2MB
            $errors[] = "Ukuran foto maksimal 2MB.";
        }

        if (empty($errors)) {
            move_uploaded_file($foto['tmp_name'], $foto_path);
        }
    }

    // Validasi Kata Sandi (jika ada perubahan)
    if (!empty($old_password) || !empty($new_password) || !empty($confirm_password)) {
        if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
            $errors[] = "Semua kolom kata sandi wajib diisi jika ingin mengubah kata sandi.";
        } else {
            $query = $koneksi->prepare("SELECT kata_sandi FROM admin_moderator WHERE pengguna_id = ?");
            $query->bind_param('s', $pengguna_id);
            $query->execute();
            $result = $query->get_result();
            $user = $result->fetch_assoc();

            if (!password_verify($old_password, $user['kata_sandi'])) {
                $errors[] = "Kata sandi lama salah.";
            }

            if ($new_password !== $confirm_password) {
                $errors[] = "Konfirmasi kata sandi baru tidak cocok.";
            }
        }
    }

    // Jika tidak ada kesalahan, lakukan pembaruan
    if (empty($errors)) {
        $update_query = "UPDATE admin_moderator SET nama = ?, email = ?";
        $types = "ss";
        $params = [$nama, $email];

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query .= ", kata_sandi = ?";
            $types .= "s";
            $params[] = $hashed_password;
        }

        if (!empty($foto_nama)) {
            $update_query .= ", foto = ?";
            $types .= "s";
            $params[] = $foto_nama;
        }

        $update_query .= " WHERE pengguna_id = ?";
        $types .= "s";
        $params[] = $pengguna_id;

        $stmt = $koneksi->prepare($update_query);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Profil berhasil diperbarui.'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Terjadi kesalahan saat memperbarui profil.'];
        }
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => implode(' ', $errors)];
    }

    header("Location: ../admin/profile-admin.php");
    exit();
}
?>
