<?php
require_once 'admin_guard.php';
require_once 'db.php';

$id = (int) ($_GET['id'] ?? 0);
$query = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $_POST['role'] === 'admin' ? 'admin' : 'user';

    $update = "UPDATE users SET nama='$nama', email='$email', role='$role' WHERE id=$id";
    if ($conn->query($update)) {
        header("Location: dbadmin.php");
        exit;
    } else {
        echo "Update gagal: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Data</title>
    <link rel="stylesheet" href="adminn.css">
</head>
<body>
<div class="container">
    <h1 class="page-title">Update Data</h1>
    <form method="POST" class="form-wrapper">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required><br><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= $data['role'] == 'user' ? 'selected' : '' ?>>User</option>
        </select><br><br>

        <button type="submit" class="button">Simpan</button>
    </form>
</div>
</body>
</html>
