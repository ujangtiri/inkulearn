<?php
// Koneksi database. Nilai dibaca dari config.php (salin dari config.example.php)
// atau dari environment variable INKULEARN_DB_HOST / _USER / _PASS / _NAME.
$config = file_exists(__DIR__ . '/config.php')
    ? require __DIR__ . '/config.php'
    : require __DIR__ . '/config.example.php';

$host   = getenv('INKULEARN_DB_HOST') ?: $config['host'];
$user   = getenv('INKULEARN_DB_USER') ?: $config['user'];
$pass   = getenv('INKULEARN_DB_PASS') !== false ? getenv('INKULEARN_DB_PASS') : $config['pass'];
$dbname = getenv('INKULEARN_DB_NAME') ?: $config['name'];

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
