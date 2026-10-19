<?php
require_once 'admin_guard.php';
require_once 'db.php';

// Ambil semua feedback terbaru
$query = "SELECT nama, email, message, created_at FROM feedback ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Pengguna</title>
    <link rel="stylesheet" href="adminn.css">
</head>
<body>
<header class="header">
    <div class="container">
        <div class="logo">Feedback</div>
        <div class="nav-links">
            <a href="dbberanda.php">Beranda</a>
            <a href="dbadmin.php">Data Admin</a>
            <a href="dbuser.php">Data User</a>
            <a href="dbfeedback.php" class="active">Feedback</a>
            <a href="dbbacaketik.php">Soal Baca & Ketik</a>
        </div>
        <div class="profile-section">
            <span class="username">Admin</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</header>

<main class="main-content">
    <div class="container">
        <h1 class="page-title">Feedback dari Pengguna</h1>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="feedback-item">
                    <div class="user-info">
                        <span><?= htmlspecialchars($row['nama']) ?> (<?= htmlspecialchars($row['email']) ?>)</span>
                        <small><?= date("d M Y, H:i", strtotime($row['created_at'])) ?></small>
                    </div>
                    <div class="feedback-content">
                        <p class="feedback-message"><?= nl2br(htmlspecialchars($row['message'])) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada feedback ditemukan.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
