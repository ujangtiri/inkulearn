<?php
session_start();
require 'db.php'; // Pastikan path ini benar dari lokasi file

// Pastikan user sudah login
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

// Ambil nama dan email dari session
$nama  = $_SESSION['user_nama'] ?? '';
$email = $_SESSION['user_email'] ?? '';
$pesan = trim($_POST['pesan'] ?? '');

if ($nama && $email && $pesan) {
    $stmt = $conn->prepare("INSERT INTO feedback (nama, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $email, $pesan);

    if ($stmt->execute()) {
        echo "<script>alert('Feedback berhasil dikirim!'); window.location.href='informasi.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan feedback.'); window.location.href='informasi.php';</script>";
    }
} else {
    echo "<script>alert('Data tidak lengkap.'); window.location.href='informasi.php';</script>";
}
?>
