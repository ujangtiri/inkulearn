<?php require_once 'admin_guard.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beranda Admin</title>
    <link rel="stylesheet" href="adminn.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">Dashboard</div>
            <div class="nav-links">
                <a href="dbberanda.php" class="active">Beranda</a>
                <a href="dbadmin.php">Data Admin</a>
                <a href="dbuser.php">Data User</a>
                <a href="dbfeedback.php">Feedback</a>
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
            <section class="hero-section">
                <div class="hero-content">
                    <h1 class="hero-title">Selamat Datang, Admin!</h1>
                    <p class="hero-subtitle">Kelola data admin, feedback, dan berbagai fitur lainnya dari panel ini.</p>
                    <a href="dbadmin.php" class="cta-button">Kelola Data Admin</a>
                    <a href="dbuser.php" class="cta-button">Kelola Data User</a>
                    <a href="dbbacaketik.php" class="cta-button">Kelola Soal Baca & Ketik</a>
                    <a href="dbfeedback.php" class="cta-button">Feedback</a>

                </div>
                <div class="hero-image">
                    <div class="image-placeholder">📊</div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
