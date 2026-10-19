let player;

// Konfigurasi video - Ganti dengan URL YouTube yang diinginkan
const VIDEO_CONFIG = {
    videoId: '1ujUCIGPV1o', 
};

// Fungsi yang dipanggil ketika YouTube API siap
function onYouTubeIframeAPIReady() {
    initializePlayer();
}

// Inisialisasi player
function initializePlayer() {
    player = new YT.Player('player', {
        videoId: VIDEO_CONFIG.videoId,
        playerVars: {
            'playsinline': 1,
            'rel': 0,
            'controls': 1,
            'modestbranding': 1,
            'fs': 1
        },
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

// Ketika player siap
function onPlayerReady(event) {
    console.log('Player siap digunakan');
    // Video akan otomatis siap diputar
}

// Handle perubahan state player
function onPlayerStateChange(event) {
    const playPauseBtn = document.getElementById('playPauseBtn');
    
    if (event.data === YT.PlayerState.PLAYING) {
        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
    } else if (event.data === YT.PlayerState.PAUSED) {
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
    } else if (event.data === YT.PlayerState.ENDED) {
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
    }
}

// Event listeners setelah DOM loaded
document.addEventListener('DOMContentLoaded', function() {
    const playPauseBtn = document.getElementById('playPauseBtn');
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const backBtn = document.getElementById('backBtn');
    const modal = document.getElementById('confirmModal');
    const yesBtn = document.getElementById('yesBtn');
    const noBtn = document.getElementById('noBtn');

    // Jika YouTube API belum ready, inisialisasi player
    if (typeof YT !== 'undefined' && YT.Player) {
        initializePlayer();
    }

    // Play/Pause button
    playPauseBtn.addEventListener('click', function() {
        if (player && player.getPlayerState) {
            const state = player.getPlayerState();
            if (state === YT.PlayerState.PLAYING) {
                player.pauseVideo();
            } else {
                player.playVideo();
            }
        }
    });

    // Fullscreen button
    fullscreenBtn.addEventListener('click', function() {
        const iframe = document.querySelector('#player iframe') || document.querySelector('#player');
        if (iframe) {
            if (iframe.requestFullscreen) {
                iframe.requestFullscreen();
            } else if (iframe.webkitRequestFullscreen) {
                iframe.webkitRequestFullscreen();
            } else if (iframe.msRequestFullscreen) {
                iframe.msRequestFullscreen();
            }
        }
    });

    // Back button - tampilkan modal konfirmasi
    backBtn.addEventListener('click', function() {
        modal.style.display = 'flex';
    });

    // Tombol Ya - kembali ke halaman sebelumnya
    yesBtn.addEventListener('click', function() {
        // Pause video sebelum keluar
        if (player && player.pauseVideo) {
            player.pauseVideo();
        }
        window.location.href = 'mode-belajar.php';
    });

    // Tombol Tidak - tutup modal
    noBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Tutup modal ketika klik di luar modal
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(event) {
        if (player && player.getPlayerState) {
            switch(event.code) {
                case 'Space':
                    event.preventDefault();
                    const state = player.getPlayerState();
                    if (state === YT.PlayerState.PLAYING) {
                        player.pauseVideo();
                    } else {
                        player.playVideo();
                    }
                    break;
                case 'Escape':
                    modal.style.display = 'flex';
                    break;
            }
        }
    });
});

// Fungsi utility untuk mengganti video (opsional)
function changeVideo(videoId) {
    if (player && player.loadVideoById) {
        player.loadVideoById(videoId);
    }
}

// Fungsi untuk extract video ID dari URL (jika diperlukan)
function extractVideoID(url) {
    const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    const match = url.match(regExp);
    return (match && match[7].length === 11) ? match[7] : false;
}