<?php
session_start();
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InkuLearn - Mode Belajar</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="mode-belajar.css">
    <link rel="stylesheet" href="styles.css">
    <!-- OpenDyslexic font -->
    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/open-dyslexic">
</head>

<body>
    <div class="page-background"></div>

<header>
        <nav>
            <div class="logo">
                <a href="index.php">InkuLearn</a>
            </div>
            <div class="nav-links" id="navLinks">
                <a href="index.php" class="nav-link">Beranda</a>
                <a href="informasi.php" class="nav-link">Informasi</a>
                <a href="main.php" class="active">Fitur</a>
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
            background: #ff9a00 ;
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
            background: #ff9a00;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .main-title {
            font-size: 42px;
            font-weight: 800;
            background: #fff;
            background-clip: text;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-decorator {
            background: #3a3f8b !important;
        }

        .learning-card:hover {
            background: #ff9800;
            transform: translateY(-10px) scale(1.02);
        }

   </style>    
    <main>
        <div class="mode-belajar-wrapper">
        <section class="main-content">
            <div class="mode-belajar-header">
                <h1 class="main-title">Mode Belajar</h1>
                <p>Mari evaluasi berbagai fitur pada mode ini dengan tampilan yang lebih menarik dan interaktif!</p>
            </div>

            <div class="learning-cards">
                <div class="learning-card">
                    <div class="card-image">
                        <img src="silabus.jpg" alt="silabus">               
                    </div>
                    <div class="card-content">
                        <h3>Mengeja</h3>
                        <a href="silabus.html" class="mulai-btn">Mulai</a>
                    </div>
                </div>

                <div class="learning-card">
                    <div class="card-image">
                        <img src="videobelajar.jpg" alt="videobelajar">
                    </div>
                    <div class="card-content">
                        <h3>Video Belajar</h3>
                        <a href="videobelajar.html" class="mulai-btn">Mulai</a>
                    </div>
                </div>

                <div class="learning-card">
                    <div class="card-image">
                        <img src="gambar/belajarmenulis.jpg" alt="belajarmenulis">
                    </div>
                    <div class="card-content">
                        <h3>Belajar Menulis</h3>
                        <a href="menulis.php" class="mulai-btn">Mulai</a>
                    </div>
                </div>
            </div>
        </section>
        </div>
    </main>

    <script>
        // Add smooth interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover sound effect simulation
            const cards = document.querySelectorAll('.learning-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-15px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add click animation
            const buttons = document.querySelectorAll('.mulai-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: rgba(255, 255, 255, 0.6);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                    `;
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

</html>