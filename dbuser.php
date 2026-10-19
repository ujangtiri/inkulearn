<?php
require_once 'admin_guard.php';
require_once 'db.php'; // koneksi database dari file db.php

// Ambil semua data user dari database
$query = "SELECT id, nama, email, role, created_at FROM users WHERE role = 'user' ORDER BY id ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data User</title>
    <link rel="stylesheet" href="adminn.css">
</head>
<body>
<header class="header">
    <div class="container">
        <div class="logo">User Panel</div>
        <div class="nav-links">
            <a href="dbberanda.php">Beranda</a>
            <a href="dbadmin.php">Data Admin</a>
            <a href="dbuser.php" class="active">Data User</a>
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
        <h1 class="page-title">Data Pengguna</h1>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= $row['role'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td>
                            <a href="update.php?id=<?= $row['id'] ?>" class="aksi-btn update">Update</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="aksi-btn delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Tidak ada data pengguna.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
