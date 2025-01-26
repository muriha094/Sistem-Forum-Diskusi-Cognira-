<?php
require_once "../config.php";
require_once "../template/navbar-admin.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] !== "Admin") {
    header("location: ../auth/login.php");
    exit();
}

$pengguna_id = $_SESSION['ssLogin'];
$query = $koneksi->prepare("SELECT nama, email, peran, foto FROM admin_moderator WHERE pengguna_id = ?");
$query->bind_param('s', $pengguna_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

$foto_profil = "../asset/uploads/default.png";
if ($user && !empty($user['foto']) && file_exists("../asset/uploads/" . $user['foto'])) {
    $foto_profil = "../asset/uploads/" . htmlspecialchars($user['foto']);
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
    <title>Profil Admin - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        .profile-photo {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-photo img {
            width: 120px; /* Lebar foto lebih proporsional */
            height: 120px; /* Tinggi foto sama dengan lebar */
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #dee2e6;
        }

        .form-label {
            font-weight: bold;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .eye-icon {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .password-wrapper .eye-icon i {
            font-size: 1.2rem;
            color: #6c757d;
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h2>Profil Admin</h2>
        <form action="../actions/update-admin-profile.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-4">
                <div class="col-md-4 text-center">
                    <div class="profile-photo">
                        <img id="previewFoto" src="<?php echo $foto_profil; ?>" alt="Foto Profil">
                    </div>
                    <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
                    <small class="text-muted">Format: jpg, jpeg, png. Max: 2MB.</small>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" 
                               class="form-control" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
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
            <div class="mb-3 password-wrapper">
                <label for="old_password" class="form-label">Kata Sandi Lama</label>
                <input type="password" name="old_password" id="old_password" class="form-control">
                <span class="eye-icon" onclick="togglePassword('old_password')">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <div class="mb-3 password-wrapper">
                <label for="new_password" class="form-label">Kata Sandi Baru</label>
                <input type="password" name="new_password" id="new_password" class="form-control">
                <span class="eye-icon" onclick="togglePassword('new_password')">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <div class="mb-3 password-wrapper">
                <label for="confirm_password" class="form-label">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                <span class="eye-icon" onclick="togglePassword('confirm_password')">
                    <i class="fas fa-eye"></i>
                </span>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="dashboard-admin.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview Foto Dinamis
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

        // Toggle Password Visibility
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
