<?php
require_once "../config.php";
require_once "../template/navbar-user.php";

// Pastikan sesi hanya dimulai satu kali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Hanya Pengguna yang dapat mengakses
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] !== "User") {
    header("location: ../auth/login.php");
    exit();
}

// Ambil ID pengguna dari sesi
$pengguna_id = $_SESSION['ssLogin'];

// Ambil data pengguna dari database
$query = $koneksi->prepare("SELECT nama_pengguna, email, foto FROM pengguna_cognira WHERE pengguna_id = ?");
$query->bind_param('s', $pengguna_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Data pengguna tidak ditemukan.'];
    header("Location: ../auth/login.php");
    exit();
}

// Tampilkan alert jika ada
if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['alert']['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php 
    unset($_SESSION['alert']);
endif;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .profile-photo {
            text-align: center;
        }

        .profile-photo img {
            width: 150px;
            height: 150px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #dee2e6;
        }

        .profile-photo input[type="file"] {
            margin-top: 10px;
        }

        .profile-photo small {
            font-size: 0.9em;
            color: #6c757d;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 15px;
        }

        hr {
            margin: 30px 0;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Profil Pengguna</h2>
        <form action="../actions/update-user-profile.php" method="POST" enctype="multipart/form-data">
            <div class="profile-section">
                <!-- Foto Profil di Kiri -->
                <div class="profile-photo">
                    <img id="previewFoto" src="../asset/uploads/<?php echo !empty($user['foto']) ? htmlspecialchars($user['foto']) : 'default.png'; ?>" 
                         alt="Foto Profil">
                    <input type="file" name="foto" id="fotoInput" class="form-control mt-2" accept="image/*">
                    <small>Format: jpg, jpeg, png. Max: 2MB.</small>
                </div>

                <!-- Detail Profil -->
                <div class="profile-details w-100">
                    <div class="mb-3">
                        <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
                        <input type="text" name="nama_pengguna" id="nama_pengguna" 
                               class="form-control" value="<?php echo htmlspecialchars($user['nama_pengguna']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" 
                               class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Ubah Kata Sandi (Opsional)</h5>
            <div class="mb-3">
                <label for="old_password" class="form-label">Kata Sandi Lama</label>
                <input type="password" name="old_password" id="old_password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Kata Sandi Baru</label>
                <input type="password" name="new_password" id="new_password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="dashboard-user.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS & Preview Foto Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const fotoInput = document.getElementById('fotoInput');
        const previewFoto = document.getElementById('previewFoto');

        fotoInput.addEventListener('change', function() {
            const file = fotoInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFoto.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
