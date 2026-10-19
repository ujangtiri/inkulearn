<?php
session_start();
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InkuLearn - Mode Mini Game</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="mini-game.css">
    <link rel="stylesheet" href="styles.css">
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
            background: linear-gradient(45deg, #ff9a00, #ff9a00);
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



   </style>
       <main>
        <section class="main-content">
            <div class="mode-game-header">
                <h1 class="main-title">Mode Mini Game</h1>
                <p>Mari explore berbagai fitur pada mode ini!</p>
            </div>

            <div class="game-cards">
                <div class="game-card">
                    <div class="card-image">
                        <img src="gambar/cokgamta.jpg" alt="Cocok Kata & Gambar">
                    </div>
                    <div class="card-content">
                        <h3>Cocok Kata & Gambar</h3>
                        <a href="cocokkatagambar.html" class="mulai-btn">Mulai</a>
                    </div>
                </div>

                <div class="game-card">
                    <div class="card-image">
                        <img src="pasanghuruf.jpg" alt="Pasang Huruf">
                    </div>
                    <div class="card-content">
                        <h3>Pasang Huruf</h3>
                        <a href="pasanghuruf.html" class="mulai-btn">Mulai</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>

</html>