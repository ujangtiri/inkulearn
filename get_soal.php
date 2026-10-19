<?php
header('Content-Type: application/json');
require 'db.php';

$sql = "SELECT teks_soal FROM soal";
$result = $conn->query($sql);

$soal = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $soal[] = $row['teks_soal'];
    }
}

echo json_encode($soal);
$conn->close();
?>
