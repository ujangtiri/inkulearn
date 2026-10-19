<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'db.php';

// Redirect jika sudah login
if (isset($_SESSION['logged_in'])) {
    redirectBasedOnRole();
    exit();
}

// Proses login
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Email dan password harus diisi";
    } else {
        $query = "SELECT id, nama, email, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($id, $nama, $email_db, $password_db, $role);
                $stmt->fetch();

                if (password_verify($password, $password_db)) {
                    // Set session
                    $_SESSION['user_id']   = $id;
                    $_SESSION['user_name'] = $nama;
                    $_SESSION['user_email']= $email_db;
                    $_SESSION['user_role'] = $role;
                    $_SESSION['logged_in'] = true;

                    // Redirect berdasarkan role
                    redirectBasedOnRole();
                    exit();
                } else {
                    $error = "Password salah";
                }
            } else {
                $error = "Email tidak ditemukan";
            }
            $stmt->close();
        } else {
            $error = "Terjadi kesalahan sistem (Query gagal disiapkan)";
        }
    }
}

// Fungsi redirect berdasarkan role
function redirectBasedOnRole() {
    if ($_SESSION['user_role'] === 'admin') {
        header("Location: dbberanda.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/open-dyslexic">
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h1>Welcome Back</h1>
            <p class="subtitle">Silakan login ke akun Anda</p>
            
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form id="loginForm" class="login-form" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">
                    <span class="btn-text">Login</span>
                    <div class="loading-spinner" id="loadingSpinner"></div>
                </button>
            </form>
            
            <div class="signup-link">
                <p>Belum punya akun? <a href="signup.php" id="signupLink">Daftar di sini</a></p>
            </div>
        </div>
    </div>
    
    <div class="success-message" id="successMessage">
        <div class="success-content">
            <div class="success-icon">✓</div>
            <h3>Login Berhasil!</h3>
            <p>Selamat datang kembali</p>
        </div>
    </div>
</body>
</html>
