<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InkuLearn - Informasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- OpenDyslexic Font -->
    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/open-dyslexic">
    <!-- Google Fonts (optional fallback) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="informasi.css">
    <style>
        /* User Info Styles (synced with index.php) */
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
        .feedback-section {
            background: #3a3f8b;
            padding: 60px 5%;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            margin: 80px auto 100px; 
        }
        .feedback-title {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            background: #ffffffff;
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
        }
        .feedback-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .feedback-textarea {
            resize: vertical;
            min-height: 120px;
            padding: 15px;
            border-radius: 15px;
            border: 2px solid #ccc;
            font-size: 16px;
            font-family: 'Open-Dyslexic', sans-serif;
            transition: border-color 0.3s ease;
        }
        .feedback-textarea:focus {
            border-color: #667eea;
            outline: none;
        }
        .btn-feedback {
            align-self: flex-end;
            background: #ff9a00;
            color: white;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            text-decoration: none;
        }
        .btn-feedback:hover {
            background: #ff9a00;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }
    </style>
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
                <a href="index.php" class="nav-link">Beranda</a>
                <a href="informasi.php" class="active">Informasi</a>
                <a href="main.php" class="nav-link">Fitur</a>
            </div>
            <div class="auth-buttons">
                <?php if(isset($_SESSION['logged_in'])): ?>
                    <div class="user-info">
                        <img src="avatar.png" alt="User Avatar" class="user-avatar">
                        <span class="user-name">Halo, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                        <a href="logout.php" class="logout-btn">Logout</a>
                    </div>
                <?php else: ?>
                    <a href="signup.php" class="signup-btn">Sign up</a>
                    <a href="login.php" class="login-btn">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
        <section class="info-content">
            <div class="container">
                <!-- Header Section -->
                <div class="info-header" data-aos="fade-down">
                    <h1>Tentang InkuLearn</h1>
                    <p>Mengenal lebih dekat platform pembelajaran interaktif untuk anak-anak dengan disleksia</p>
                </div>
                <!-- Info Sections -->
                <div class="info-grid">
                    <!-- About Section -->
                    <div class="info-card" data-aos="fade-up">
                        <div class="card-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h2>Apa itu InkuLearn?</h2>
                        <p>Platform pembelajaran interaktif yang dirancang khusus untuk membantu anak-anak dengan disleksia dalam mengembangkan kemampuan membaca dan menulis dengan cara yang menyenangkan.</p>
                    </div>
                    <!-- Features Section -->
                    <div class="info-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h2>Fitur Unggulan</h2>
                        <ul>
                            <li><i class="fas fa-book-reader"></i> Mode Belajar Interaktif</li>
                            <li><i class="fas fa-gamepad"></i> Mini Games Edukatif</li>
                            <li><i class="fas fa-palette"></i> Antarmuka Ramah Anak</li>
                        </ul>
                    </div>
                    <!-- Users Section -->
                    <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h2>Pengguna Kami</h2>
                        <ul>
                            <li><i class="fas fa-child"></i> Anak dengan Disleksia</li>
                            <li><i class="fas fa-heart"></i> Orang Tua</li>
                            <li><i class="fas fa-chalkboard-teacher"></i> Guru</li>
                        </ul>
                    </div>
                    <!-- Benefits Section -->
                    <div class="info-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h2>Manfaat</h2>
                        <ul>
                            <li><i class="fas fa-brain"></i> Meningkatkan Konsentrasi</li>
                            <li><i class="fas fa-smile"></i> Pembelajaran Menyenangkan</li>
                            <li><i class="fas fa-clock"></i> Fleksibilitas Waktu</li>
                        </ul>
                    </div>
                    <!-- Technology Section -->
                    <div class="info-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="card-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h2>Teknologi</h2>
                        <ul>
                            <li><i class="fas fa-mobile-alt"></i> Responsif</li>
                            <li><i class="fas fa-eye"></i> Visual Learning</li>
                        </ul>
                    </div>
                    <!-- Contact Section -->
                    <div class="info-card" data-aos="fade-up" data-aos-delay="500">
                        <div class="card-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h2>Hubungi Kami</h2>
                        <ul>
                            <li class="contact-item" data-text="info@example.com">
                                <i class="fas fa-envelope"></i> info@example.com
                            </li>
                            <li class="contact-item" data-text="+62 812 3456 7890">
                                <i class="fas fa-phone"></i> +62 812 3456 7890
                            </li>
                            <li class="contact-item" data-text="Jakarta, Indonesia">
                                <i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section Tim Pengembang (moved here: below feedback, above footer) -->
        <section class="team-section" data-aos="fade-up">
            <div class="container">
                <h2 class="section-title">Tim Pengembang</h2>
                <p class="section-description">
                    Kami adalah tim yang berdedikasi untuk menciptakan solusi pembelajaran terbaik bagi anak-anak dengan disleksia.
                </p>
                <div class="team-list">
                    <a href="#">
                    <div class="team-member">
                        <img src="avatar.png" alt="Tim Pengembang 1" class="team-photo">
                        <h3>Nabila Aulia Lailita</h3>
                        <p>UI/UX Designer</p>
                    </div>
                    </a>
                    <a href="#">
                    <div class="team-member">
                        <img src="avatar.png" alt="Tim Pengembang 2" class="team-photo">
                        <h3>Muhamad Davin A.F</h3>
                        <p>Frontend Developer</p>
                    </div>
                    </a>
                    <a href="#">
                    <div class="team-member">
                        <img src="avatar.png" alt="Tim Pengembang 3" class="team-photo">
                        <h3>Gavel Rizky Atallah</h3>
                        <p>Backend Developer</p>
                    </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="feedback-section" data-aos="fade-up">
            <div class="container">
                <h2 class="feedback-title">Berikan Masukan Anda</h2>
                <form action="proses_feedback.php" method="POST" class="feedback-form">
                    <textarea name="pesan" class="feedback-textarea" placeholder="Tulis feedback Anda di sini..." required></textarea>
                    <?php if (isset($_SESSION['logged_in'])): ?>
                        <button type="submit" class="btn-feedback">Submit</button>
                    <?php else: ?>
                        <a href="login.php" class="btn-feedback">Submit</a>
                    <?php endif; ?>
                </form>
            </div>
        </section>
    </main>

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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="informasi.js"></script>
</body>
</html>
