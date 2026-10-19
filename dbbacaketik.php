<?php
require_once 'admin_guard.php';
require_once 'db.php';
$infoMessage = '';

// Proses hapus soal (tetap di halaman ini)
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $conn->query("DELETE FROM soal WHERE id = $id");
    header("Location: dbbacaketik.php");
    exit;
}

// Proses tambah soal (tetap di halaman ini)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_soal'])) {
    $teks_soal = trim($_POST['teks_soal']);
    if ($teks_soal !== '') {
        $stmt = $conn->prepare("INSERT INTO soal (teks_soal) VALUES (?)");
        $stmt->bind_param("s", $teks_soal);
        if ($stmt->execute()) {
            $infoMessage = "✅ Soal berhasil ditambahkan.";
        } else {
            $infoMessage = "❌ Gagal menambahkan soal.";
        }
        $stmt->close();
    }
}

// Ambil semua soal
$soalResult = $conn->query("SELECT * FROM soal ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Soal - Baca dan Ketik</title>
    <link rel="stylesheet" href="adminn.css">
</head>
<body>
<header class="header">
    <div class="container">
        <div class="logo">Manajemen Soal</div>
        <div class="nav-links">
            <a href="dbberanda.php">Beranda</a>
            <a href="dbadmin.php">Data Admin</a>
            <a href="dbuser.php">Data User</a>
            <a href="dbfeedback.php">Feedback</a>
            <a href="dbbacaketik.php" class="active">Soal Baca & Ketik</a>
        </div>
        <div class="profile-section">
            <span class="username">Admin</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</header>

<main class="main-content">
    <div class="container">
        <div class="bacaketik-container">
            <h1 class="page-title">Kelola Soal “Baca dan Ketik”</h1>

            <!-- Form tambah soal -->
            <div class="form-wrapper">
                <h2 class="section-title">Tambah Soal Baru</h2>
                <?php if ($infoMessage): ?>
                    <p class="bacaketik-feedback<?= strpos($infoMessage, '❌') !== false ? ' error' : '' ?>">
                        <?= htmlspecialchars($infoMessage) ?>
                    </p>
                <?php endif; ?>
                <form method="POST">
                    <textarea name="teks_soal" placeholder="Contoh: Kucing berdasi naik sepeda..." required class="bacaketik-input"></textarea>
                    <button type="submit" name="tambah_soal" class="bacaketik-submit-btn">Tambah Soal</button>
                </form>
            </div>
        </div>

        <!-- Daftar soal -->
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Soal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($soalResult->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $soalResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['teks_soal']) ?></td>
                                <td>
                                    <a href="updatebacaketik.php?id=<?= $row['id'] ?>" class="aksi-btn update">Update</a>
                                    <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus soal ini?')" class="aksi-btn delete">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3">Belum ada soal.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
