<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baca dan Ketik - InkuLearn</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="bacaketik.css">
    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/open-dyslexic">

</head>
<body>
    <div class="main-container">
        <div class="content-box">
            <h1 class="title">Baca dan Ketik</h1>
            <p class="subtitle">Baca kata dibawah ini, lalu tuliskan ulang kata-kata yang telah disediakan melalui kolom dibawah.</p>

            <div class="word-card">
                <div id="targetWord" class="target-word noselect">KATA-KATA</div>
                <div class="dot-separator noselect">...</div>
            </div>

        <div class="input-container">
            <input type="text" 
                id="userInput" 
                class="word-input" 
                placeholder="Ketik kata-kata yang kamu lihat" 
                autocomplete="off"
                spellcheck="false">
                <div id="feedback" class="feedback-message"></div>
            </div>

        <div class="button-group">
            <button id="selanjutnyaBtn" class="btn btn-selanjutnya" disabled>
                <i class="fas fa-arrow-right"></i>
                <span class="btn-text">Selanjutnya</span>
            </button>
        </div>
        </div>

        <button id="backBtn" class="back-btn">
            <img src="backbutton.png" alt="Kembali" class="back-icon">
        </button>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-question-circle modal-icon"></i>
                <h2>Konfirmasi</h2>
            </div>
            <p>Apakah anda ingin keluar dari Baca dan Ketik?</p>
            <div class="modal-buttons">
                <button id="noBtn" class="modal-btn cancel-btn">
                    <i class="fas fa-times"></i> Tidak
                </button>
                <a href="mode-belajar.php" id="yesBtn" style="text-decoration:none;" class="modal-btn confirm-btn">
                    <i class="fas fa-check"></i> Ya
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Selesai -->
    <div id="completionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-trophy modal-icon success"></i>
                <h2>Selamat!</h2>
            </div>
            <p>Anda telah menyelesaikan semua kata dengan baik!</p>
            <div class="modal-buttons">
                <button id="retryBtn" class="modal-btn confirm-btn">
                    <i class="fas fa-redo"></i> Coba Lagi
                </button>
                <button id="finishBtn" class="modal-btn success-btn">
                    <i class="fas fa-home"></i> Kembali ke Menu
                </button>
            </div>
        </div>
    </div>

    <script src="bacaketik.js"></script>
</body>
</html>