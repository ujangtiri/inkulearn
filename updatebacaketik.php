<?php
require_once 'admin_guard.php';
require_once 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    // Jika id tidak valid, redirect atau tampilkan error
    header("Location: dbbacaketik.php");
    exit;
}

$query = "SELECT * FROM soal WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    // Jika data soal tidak ditemukan
    echo "Soal tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teks_soal = trim($_POST['teks_soal']);

    if ($teks_soal !== '') {
        $update = "UPDATE soal SET teks_soal = ? WHERE id = ?";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("si", $teks_soal, $id);
        if ($stmt->execute()) {
            header("Location: dbbacaketik.php");
            exit;
        } else {
            echo "Update gagal: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Teks soal tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Soal</title>
    <link rel="stylesheet" href="adminn.css">
</head>
<body>
<div class="container">
    <h1 class="page-title">Update Soal</h1>
    <form method="POST" class="form-wrapper">
        <label>Soal:</label><br>
        <input type="text" name="teks_soal" value="<?= htmlspecialchars($data['teks_soal']) ?>" required><br><br>
        <button type="submit" class="button">Simpan</button>
    </form>
</div>
</body>
</html>
