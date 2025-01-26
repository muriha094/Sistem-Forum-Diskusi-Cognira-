<?php
// Mulai sesi
if (session_status() === PHP_SESSION_NONE) {
    // Kode untuk memulai sesi di sini
}
require_once "../config.php"; // Pastikan koneksi database benar
require_once "../template/navbar-user.php"; // Navbar jika diperlukan

// Ambil query dari URL
$query = '';
$results = [];

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']); // Amankan input user

    // Query ke database
    $sql = "SELECT * FROM questions WHERE title LIKE ? OR content LIKE ?";
    $stmt = $koneksi->prepare($sql);
    $likeQuery = "%{$query}%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    // Simpan hasil pencarian ke array
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - Cognira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .search-container {
            margin-top: 30px;
        }

        .search-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .result-card {
            margin-bottom: 20px;
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            transition: box-shadow 0.3s ease-in-out;
        }

        .result-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .result-card h5 {
            margin: 0;
            font-size: 1.2rem;
        }

        .result-card p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .no-results {
            text-align: center;
            font-size: 1.2rem;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container search-container">
        <h1 class="text-center search-title">Hasil Pencarian</h1>

        <?php if (!empty($query)): ?>
            <h4 class="mb-4">Menampilkan hasil untuk: <strong><?php echo $query; ?></strong></h4>

            <?php if (count($results) > 0): ?>
                <div class="row">
                    <?php foreach ($results as $row): ?>
                        <div class="col-md-6">
                            <div class="card result-card p-3">
                                <h5>
                                    <a href="../question/question-detail.php?id=<?php echo $row['question_id']; ?>" class="text-primary text-decoration-none">
                                        <?php echo htmlspecialchars($row['title']); ?>
                                    </a>
                                </h5>
                                <p><?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 100))); ?>...</p>
                                <a href="../question/question-detail.php?id=<?php echo $row['question_id']; ?>" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-results">Tidak ada hasil untuk: <strong><?php echo $query; ?></strong></p>
            <?php endif; ?>
        <?php else: ?>
            <p class="no-results">Silakan masukkan kata kunci untuk mencari.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
