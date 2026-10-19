<?php
require_once 'admin_guard.php';
require_once 'db.php';

$id = (int) ($_GET['id'] ?? 0);
$delete = "DELETE FROM users WHERE id=$id";

if ($conn->query($delete)) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "Gagal menghapus data: " . $conn->error;
}
?>
