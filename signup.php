<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Koneksi database (konfigurasi di config.php)
require 'db.php';

// Proses form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');

    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = 'user';

    // Validasi sederhana
    if (empty($nama) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'error' => 'Semua field harus diisi']);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Query gagal dipersiapkan']);
        exit();
    }

    $stmt->bind_param("ssss", $nama, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        // Cek apakah duplikat email
        if (strpos($stmt->error, 'Duplicate') !== false) {
            echo json_encode(['success' => false, 'error' => 'Email sudah terdaftar']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Registrasi gagal']);
        }
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up/Login</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/open-dyslexic">
    <!-- <link rel="stylesheet" href="cursor.css"> -->
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h1>Sign Up/Login</h1>
            <p class="subtitle">Lakukan sign up terlebih dahulu</p>
            
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="success-message" style="display: flex;">
                    <div class="success-content">
                        <div class="success-icon">✓</div>
                        <h3>Berhasil!</h3>
                        <p>Akun Anda telah berhasil dibuat</p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form id="signupForm" class="signup-form" method="POST" action="signup.php">
                <div class="input-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                </div>
                
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Buat Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                
                <button type="submit" class="submit-btn">
                    <span class="btn-text">Submit</span>
                    <div class="loading-spinner" id="loadingSpinner"></div>
                </button>
            </form>
            
            <div class="login-link">
                <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
            </div>
        </div>
    </div>
    
    <script src="signup.js"></script>
    <!-- <script src="cursor.js"></script> -->
    
    <script>
document.getElementById('signupForm').addEventListener('submit', function(e) {
    e.preventDefault();

    document.getElementById('loadingSpinner').style.display = 'block';

    fetch('signup.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'login.php';
        } else {
            alert('Registrasi gagal: ' + (data.error || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan pada server');
    })
    .finally(() => {
        document.getElementById('loadingSpinner').style.display = 'none';
    });
});
</script>

</body>
</html>