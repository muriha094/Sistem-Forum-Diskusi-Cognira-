<?php
require_once "../config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #007bff;
            color: white;
            height: 100vh;
        }

        .card {
            background: #ffffff;
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #ff9800;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e68900;
        }

        .preview-img {
            max-width: 100px;
            max-height: 100px;
            margin-bottom: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center text-dark">Registrasi ke Cognira</h3>

                        <!-- Alert Success -->
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">
                                <?php echo htmlspecialchars($_GET['success']); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Alert Error -->
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="proses-register.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nama" class="form-label text-dark">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-dark">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label text-dark">Kata Sandi</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label text-dark">Upload Foto</label>
                                <div>
                                    <img src="../asset/default.png" id="fotoPreview" class="preview-img" alt="Preview">
                                </div>
                                <input type="file" name="foto" id="foto" class="form-control" accept="image/png, image/jpeg, image/jpg" onchange="previewImage()">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </form>
                        <p class="text-center mt-3 text-dark">
                            Sudah punya akun? <a href="../auth/login.php" class="text-primary">Login di sini</a>
                        </p>
                        <div class="text-muted small text-center">Copyright &copy; Cognira <?= date("Y") ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const foto = document.getElementById("foto").files[0];
            const fotoPreview = document.getElementById("fotoPreview");

            if (foto) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fotoPreview.src = e.target.result;
                };
                reader.readAsDataURL(foto);
            } else {
                fotoPreview.src = "../asset/default.png";
            }
        }
    </script>
</body>
</html>
