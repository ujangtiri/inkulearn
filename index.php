<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InkuLearn - Belajar & Bermain</title>
    <!--three js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- OpenDyslexic Font -->
    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/open-dyslexic">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php">
                    <img src="logo_oren.png" alt="InkuLearn Logo" class="logo-img">
                </a>
            </div>
            <div class="nav-links" id="navLinks">
                <a href="index.php" class="active">Beranda</a>
                <a href="informasi.php" class="nav-link">Informasi</a>
                <a href="main.php" class="nav-link">Fitur</a>
            </div>
            <div class="auth-buttons">
                <?php if(isset($_SESSION['logged_in'])): ?>
                        <div class="user-info">
                            <img src="avatar.png" alt="User Avatar" class="user-avatar">
                            <span class="user-name">Halo, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                            <a href="logout.php" class="logout-btn">Logout</a>
                        </a>
                        </div>

                <?php else: ?>
                    <a href="signup.php" class="signup-btn">Sign up</a>
                    <a href="login.php" class="login-btn">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <style>/* User Info Styles */
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.04);
            padding: 6px 8px;
            border-radius: 28px;
        }

        /* Avatar: add a clear contrasting ring and subtle backdrop so it stands out on colored headers */
        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            background: #ffffff; /* ensure a white background for image containers */
            padding: 2px; /* small padding to create separation from ring */
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25), inset 0 1px 0 rgba(255,255,255,0.6);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            border: 3px solid #ffffff; /* bright ring to contrast with header */
        }

        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.28), inset 0 1px 0 rgba(255,255,255,0.7);
        }

        .user-name {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff; /* keep high contrast */
            text-shadow: 0 1px 0 rgba(0,0,0,0.35);
            margin-right: 6px;
        }
        .logout-btn {
            background-color: #ff9a00;
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: linear-gradient(45deg, #ff9a00, #ff9a00);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .team-list a {
            text-decoration: none;
            color: inherit;
        }


   </style>

    <main>
        <section class="hero">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 text-center">
                        <div class="hero-content">
                            <p class="welcome-text">Selamat datang di InkuLearn</p>
                            <h1>Mari Belajar & Bermain!</h1>
                            <p class="description">Sebuah website interaktif yang dirancang khusus untuk membantu anak-anak dengan disleksia   
                            dalam proses belajar melalui pendekatan yang menyenangkan, mudah dipahami, dan disesuaikan dengan kebutuhan mereka.
                            </p>
                            <a href="<?php echo isset($_SESSION['logged_in']) ? 'main.php' : 'login.php'; ?>" class="btn cta-button">Mulai Sekarang</a>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section Penjelasan Mengenai InkuLearn -->
        <section class="about-disleksia">
            <div class="container">
                <h2 class="section-title">Apa itu Disleksia?</h2>
                <p class="section-description">
                    Disleksia adalah gangguan belajar spesifik 
                    yang memengaruhi kemampuan seseorang dalam membaca, menulis, dan mengeja. 
                    Orang dengan disleksia biasanya memiliki kecerdasan normal atau di atas rata-rata, 
                    tetapi kesulitan dalam menghubungkan huruf dengan bunyi dan menyusun kata dengan benar.
                    Terdapat 2 mode fitur utama yang dapat membantu anak-anak dengan disleksia belajar diantaranya:
                </p>
                <div class="features-list">
                    <div class="feature-item">
                        <i class="fas fa-book feature-icon"></i>
                        <h3>Video pembelajaran</h3>
                        <p>Video pembelajaran yang dirancang untuk meningkatkan pemahaman anak-anak dengan cara yang menarik.</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-gamepad feature-icon"></i>
                        <h3>Permainan Edukatif</h3>
                        <p>Permainan yang dirancang untuk membantu anak-anak belajar sambil bermain.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team section removed from homepage; moved to Informasi.php -->
    </main>
        <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>InkuLearn</h3>
                <p>Platform pembelajaran interaktif untuk anak-anak dengan disleksia. Belajar dengan cara yang menyenangkan dan efektif.</p>
            </div>
            <div class="footer-section">
                <h3>Tautan</h3>
                <ul class="footer-links">
                    <li><a href="index.php"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><a href="informasi.php"><i class="fas fa-info-circle"></i> Informasi</a></li>
                    <li><a href="main.php"><i class="fas fa-graduation-cap"></i> Fitur</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Kontak</h3>
                <ul class="footer-links">
                    <li><a href="mailto:info@example.com"><i class="fas fa-envelope"></i> info@example.com</a></li>
                    <li><a href="tel:+6281779217006"><i class="fas fa-phone"></i> +6281779217006</a></li>
                    <li><a href="#"><i class="fas fa-map-marker-alt"></i> Bandung, Indonesia</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; InkuLearn | Universitas Pendidikan Indonesia</p>
        </div>
    </footer>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="index.js"></script>
</body>
</html>