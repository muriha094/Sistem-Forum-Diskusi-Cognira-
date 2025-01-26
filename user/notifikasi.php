<?php
require_once '../config.php';
require_once '../template/navbar-user.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Hanya pengguna yang login dapat mengakses
if (!isset($_SESSION['ssLogin'])) {
    header('Location: ../auth/login.php');
    exit();
}

$user_id = $_SESSION['ssLogin'];

// Menandai notifikasi sebagai dibaca
$update_query = $koneksi->prepare("UPDATE notifikasi SET status_dibaca = 1 WHERE penerima_id = ?");
$update_query->bind_param('s', $user_id);
$update_query->execute();

// Ambil daftar notifikasi pengguna
$query = "SELECT n.*, 
                 u.nama_pengguna, 
                 u.foto, 
                 q.title AS question_title 
          FROM notifikasi n
          LEFT JOIN pengguna_cognira u ON n.pengirim_id = u.pengguna_id
          LEFT JOIN questions q ON n.question_id = q.question_id
          WHERE n.penerima_id = ?
          ORDER BY n.waktu_notifikasi DESC";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .notification-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 8px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            transition: background-color 0.3s ease;
        }

        .notification-item:hover {
            background-color: #e2e6ea;
        }

        .notification-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .notification-item .content {
            flex: 1;
        }

        .notification-item p {
            margin: 0;
            font-size: 0.9rem;
        }

        .notification-item small {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .notification-item .actions {
            display: flex;
            gap: 5px;
        }

        .notification-item .btn-sm {
            padding: 2px 6px;
            font-size: 0.8rem;
        }

        .notification-header {
            margin-bottom: 20px;
        }

        .empty-notification {
            text-align: center;
            color: #6c757d;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h3 class="notification-header">📬 Notifikasi Anda</h3>
        <div class="notification-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="notification-item">
                        <img src="<?= !empty($row['foto']) && file_exists('../asset/uploads/' . $row['foto']) 
                            ? '../asset/uploads/' . htmlspecialchars($row['foto']) 
                            : '../asset/uploads/default.png'; ?>" 
                            alt="Foto Pengguna">
                        <div class="content">
                            <p>
                                <strong><?= $row['pengirim_id'] === 'system' ? '<span style="color: #dc3545;">⚠️ Sistem</span>' : htmlspecialchars($row['nama_pengguna']); ?></strong>: 
                                <?= htmlspecialchars($row['pesan']); ?>
                            </p>
                            <small><?= date('d M Y, H:i', strtotime($row['waktu_notifikasi'])); ?></small>
                        </div>
                        <div class="actions">
                            <?php if ($row['target_type'] === 'answer'): ?>
                                <a href="../question/question-detail.php?id=<?= $row['question_id']; ?>&answer_id=<?= $row['target_id']; ?>" 
                                   class="btn btn-info btn-sm">Lihat</a>
                            <?php elseif ($row['target_type'] === 'comment'): ?>
                                <a href="../question/question-detail.php?id=<?= $row['question_id']; ?>&comment_id=<?= $row['target_id']; ?>" 
                                   class="btn btn-info btn-sm">Lihat</a>
                            <?php elseif ($row['target_type'] === 'question'): ?>
                                <a href="../question/question-detail.php?id=<?= $row['target_id']; ?>" 
                                   class="btn btn-info btn-sm">Lihat</a>
                            <?php endif; ?>
                            <button onclick="confirmDelete(<?= $row['notifikasi_id']; ?>)" 
                                    class="btn btn-danger btn-sm">Hapus</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="empty-notification">Belum ada notifikasi.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function confirmDelete(notificationId) {
            if (confirm('Yakin ingin menghapus notifikasi ini?')) {
                window.location.href = '../actions/delete-notification.php?id=' + notificationId;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
