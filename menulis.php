<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belajar Menulis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(to bottom, #87CEEB 0%, #B0E0E6 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Clouds */
        .cloud {
            position: absolute;
            background: white;
            border-radius: 100px;
            opacity: 0.8;
            animation: float 20s infinite ease-in-out;
        }

        .cloud1 { 
            width: 100px; 
            height: 40px; 
            top: 30px; 
            left: 8%; 
            animation-delay: 0s;
        }
        
        .cloud2 { 
            width: 120px; 
            height: 50px; 
            top: 70px; 
            right: 12%; 
            animation-delay: 5s;
        }

        @keyframes float {
            0%, 100% { transform: translateX(0) translateY(0); }
            50% { transform: translateX(20px) translateY(-10px); }
        }

        /* Header */
        .header {
            background: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
            position: relative;
            z-index: 10;
            flex-wrap: wrap;
            gap: 10px;
        }

        .nav-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
            transition: all 0.2s;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn:hover {
            transform: scale(1.08);
        }

        .btn:active {
            transform: scale(0.95);
        }

        .btn-back {
            background: #FFA500;
            color: white;
        }

        .btn-arrow {
            background: #FFB347;
            color: white;
            font-size: 40px;
            line-height: 1;
        }

        .btn-erase {
            background: white;
            border: 3px solid #4A9EFF;
            font-size: 32px;
        }

        .btn-refresh {
            background: #4A9EFF;
            color: white;
            font-size: 32px;
        }

        .item-display {
            display: flex;
            align-items: center;
            gap: 20px;
            background: white;
            padding: 12px 35px;
            border-radius: 50px;
            border: 4px solid #FFA500;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .item-image {
            width: 70px;
            height: 70px;
            font-size: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-word {
            font-size: 42px;
            font-weight: bold;
            color: #4A9EFF;
            min-width: 160px;
            text-align: center;
            letter-spacing: 1px;
        }

        /* Main Canvas Area */
        .canvas-wrapper {
            margin: 20px auto;
            max-width: 1050px;
            padding: 0 20px;
        }

        .canvas-container {
            background: white;
            border-top: 8px solid #FFD700;
            border-bottom: 8px solid #FFD700;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
        }

        #drawingCanvas {
            display: block;
            cursor: crosshair;
            background: white;
            width: 100%;
            height: auto;
        }

        /* Bottom grass */
        .grass {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(to bottom, #90EE90 0%, #32CD32 100%);
            z-index: 1;
        }

        /* Success message */
        .success-msg {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: white;
            padding: 50px 80px;
            border-radius: 30px;
            font-size: 42px;
            font-weight: bold;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            z-index: 1000;
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border: 6px solid white;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .success-msg.show {
            transform: translate(-50%, -50%) scale(1);
            animation: celebrate 0.6s ease-in-out;
        }

        @keyframes celebrate {
            0%, 100% { transform: translate(-50%, -50%) scale(1) rotate(0deg); }
            25% { transform: translate(-50%, -50%) scale(1.1) rotate(-5deg); }
            75% { transform: translate(-50%, -50%) scale(1.1) rotate(5deg); }
        }

        .success-emoji {
            font-size: 60px;
            display: block;
            margin-bottom: 15px;
            animation: bounce 0.6s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .success-text {
            display: block;
            font-size: 38px;
            margin-top: 10px;
        }

        /* Confetti effect */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: #FFD700;
            position: absolute;
            animation: confetti-fall 3s linear forwards;
            z-index: 999;
        }

        @keyframes confetti-fall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Instructions */
        .instructions {
            display: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 10px 15px;
            }

            .btn {
                width: 50px;
                height: 50px;
                font-size: 24px;
            }

            .btn-arrow {
                font-size: 32px;
            }

            .btn-erase,
            .btn-refresh {
                font-size: 26px;
            }

            .item-display {
                padding: 10px 25px;
                gap: 15px;
            }

            .item-image {
                width: 50px;
                height: 50px;
                font-size: 38px;
            }

            .item-word {
                font-size: 32px;
                min-width: 120px;
            }

            .canvas-wrapper {
                margin: 15px auto;
                padding: 0 15px;
            }

            .success-msg {
                padding: 35px 50px;
                font-size: 32px;
            }

            .success-emoji {
                font-size: 45px;
            }

            .success-text {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 8px 10px;
            }

            .btn {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }

            .btn-arrow {
                font-size: 28px;
            }

            .btn-erase,
            .btn-refresh {
                font-size: 22px;
            }

            .nav-section {
                gap: 8px;
            }

            .item-display {
                padding: 8px 20px;
                gap: 12px;
                border: 3px solid #FFA500;
            }

            .item-image {
                width: 40px;
                height: 40px;
                font-size: 32px;
            }

            .item-word {
                font-size: 26px;
                min-width: 100px;
            }

            .canvas-wrapper {
                margin: 10px auto;
                padding: 0 10px;
            }

            .canvas-container {
                border-top: 5px solid #FFD700;
                border-bottom: 5px solid #FFD700;
            }

            .grass {
                height: 60px;
            }

            .success-msg {
                padding: 25px 35px;
                font-size: 26px;
                border-radius: 20px;
                border: 4px solid white;
            }

            .success-emoji {
                font-size: 38px;
                margin-bottom: 10px;
            }

            .success-text {
                font-size: 22px;
            }

            .cloud1,
            .cloud2 {
                width: 80px;
                height: 30px;
            }
        }

        @media (max-width: 360px) {
            .btn {
                width: 35px;
                height: 35px;
                font-size: 18px;
            }

            .btn-arrow {
                font-size: 24px;
            }

            .item-word {
                font-size: 22px;
                min-width: 80px;
            }

            .item-image {
                width: 35px;
                height: 35px;
                font-size: 28px;
            }

            .success-msg {
                padding: 20px 30px;
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="cloud cloud1"></div>
    <div class="cloud cloud2"></div>

    <div class="header">
        <div class="nav-section">
            <button class="btn btn-back" onclick="goBack()" title="Kembali">←</button>
            <button class="btn btn-arrow" onclick="prevWord()" title="Sebelumnya">‹</button>
        </div>

        <div class="item-display">
            <div class="item-image" id="itemImage">👔</div>
            <div class="item-word" id="itemWord">baju</div>
        </div>

        <div class="nav-section">
            <button class="btn btn-arrow" onclick="nextWord()" title="Berikutnya">›</button>
            <button class="btn btn-erase" onclick="clearCanvas()" title="Hapus">🧹</button>
        </div>
    </div>

    <div class="canvas-wrapper">
        <div class="canvas-container">
            <canvas id="drawingCanvas"></canvas>
        </div>
    </div>

    <div class="grass"></div>

    <div class="success-msg" id="successMsg">🎉 Bagus Sekali! 🎉</div>

    <script>
const words = [
    { word: 'baju', emoji: '👔' },
    { word: 'meja', emoji: '🪑' },
    { word: 'buku', emoji: '📚' },
    { word: 'apel', emoji: '🍎' },
    { word: 'kucing', emoji: '🐱' },
    { word: 'rumah', emoji: '🏠' }
];

let currentWordIndex = 0;
const canvas = document.getElementById('drawingCanvas');
const ctx = canvas.getContext('2d');
let isDrawing = false;
let coveredDots = new Set();
let allDots = [];
let hasShownSuccess = false;
let brushTrail = [];
let textImageData = null;

// Set canvas size - TETAP 1000x350 untuk menjaga kepadatan titik yang sama
canvas.width = 1000;
canvas.height = 350;

// CSS akan membuat canvas responsive, tapi internal resolution tetap sama
window.addEventListener('resize', () => {
    // Tidak perlu resize canvas, biar titiknya tetap sama
    updateWord();
});

function generateDottedText(text) {
    allDots = [];
    coveredDots.clear();
    hasShownSuccess = false;
    brushTrail = [];
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const fontSize = 200; // Ukuran font tetap 200px
    ctx.font = `bold ${fontSize}px Arial`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';

    const x = canvas.width / 2;
    const y = canvas.height / 2;

    ctx.strokeStyle = '#999999';
    ctx.lineWidth = 4;
    ctx.setLineDash([15, 10]);
    ctx.strokeText(text, x, y);
    ctx.setLineDash([]);

    const tempCanvas = document.createElement('canvas');
    tempCanvas.width = canvas.width;
    tempCanvas.height = canvas.height;
    const tempCtx = tempCanvas.getContext('2d');

    tempCtx.font = ctx.font;
    tempCtx.textAlign = 'center';
    tempCtx.textBaseline = 'middle';
    tempCtx.fillStyle = 'black';
    tempCtx.fillText(text, x, y);

    const imageData = tempCtx.getImageData(0, 0, tempCanvas.width, tempCanvas.height);
    textImageData = imageData;

    // Tetap gunakan spacing yang sama untuk semua ukuran layar
    const dotSpacing = 8;
    const margin = 6;

    for (let j = 0; j < canvas.height; j += dotSpacing) {
        for (let i = 0; i < canvas.width; i += dotSpacing) {
            const index = (j * canvas.width + i) * 4;
            if (imageData.data[index + 3] > 200) {
                if (isWellInsideText(imageData, i, j, margin)) {
                    allDots.push({ x: i, y: j });
                }
            }
        }
    }
    drawAllDots();
}

function isWellInsideText(imageData, x, y, margin) {
    const checkPoints = [
        [margin, 0], [-margin, 0], [0, margin], [0, -margin],
        [margin, margin], [-margin, -margin], [margin, -margin], [-margin, margin]
    ];
    for (let [dx, dy] of checkPoints) {
        const newX = x + dx;
        const newY = y + dy;
        if (newX >= 0 && newX < canvas.width && newY >= 0 && newY < canvas.height) {
            const index = (newY * canvas.width + newX) * 4;
            if (imageData.data[index + 3] < 100) return false;
        } else {
            return false;
        }
    }
    return true;
}

function isPointInsideText(x, y) {
    if (!textImageData) return false;
    const ix = Math.round(x);
    const iy = Math.round(y);
    if (ix < 0 || ix >= canvas.width || iy < 0 || iy >= canvas.height) return false;
    const index = (iy * canvas.width + ix) * 4;
    return textImageData.data[index + 3] > 100;
}

function drawAllDots() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const fontSize = 200; // Ukuran font tetap 200px
    ctx.font = `bold ${fontSize}px Arial`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.strokeStyle = '#999999';
    ctx.lineWidth = 4;
    ctx.setLineDash([15, 10]);
    ctx.strokeText(words[currentWordIndex].word, canvas.width / 2, canvas.height / 2);
    ctx.setLineDash([]);

    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.strokeStyle = '#FFA500';
    ctx.lineWidth = 18;

    for (let segment of brushTrail) {
        let pathStarted = false;
        ctx.beginPath();
        for (let i = 0; i < segment.length; i++) {
            const p = segment[i];
            if (isPointInsideText(p.x, p.y)) {
                if (!pathStarted) {
                    ctx.moveTo(p.x, p.y);
                    pathStarted = true;
                } else {
                    ctx.lineTo(p.x, p.y);
                }
            } else {
                if (pathStarted) {
                    ctx.stroke();
                    ctx.beginPath();
                    pathStarted = false;
                }
            }
        }
        if (pathStarted) ctx.stroke();
    }

    // Ukuran titik tetap 4px untuk semua layar
    allDots.forEach((dot, index) => {
        ctx.beginPath();
        ctx.fillStyle = coveredDots.has(index) ? '#32CD32' : '#333333';
        ctx.arc(dot.x, dot.y, 4, 0, Math.PI * 2);
        ctx.fill();
    });

    if (coveredDots.size === allDots.length && !hasShownSuccess) {
        hasShownSuccess = true;
        showSuccess();
    }
}

function updateCoveredDots(x, y) {
    const radius = 14;
    allDots.forEach((dot, index) => {
        const dist = Math.hypot(dot.x - x, dot.y - y);
        if (dist < radius) coveredDots.add(index);
    });
}

canvas.addEventListener('mousedown', (e) => {
    const pos = getMousePos(e);
    if (!isPointInsideText(pos.x, pos.y)) return;
    isDrawing = true;
    brushTrail.push([]);
    brushTrail[brushTrail.length - 1].push(pos);
    updateCoveredDots(pos.x, pos.y);
    drawAllDots();
});

canvas.addEventListener('mousemove', (e) => {
    if (!isDrawing) return;
    const pos = getMousePos(e);
    if (!isPointInsideText(pos.x, pos.y)) return;
    brushTrail[brushTrail.length - 1].push(pos);
    updateCoveredDots(pos.x, pos.y);
    drawAllDots();
});

canvas.addEventListener('mouseup', () => isDrawing = false);
canvas.addEventListener('mouseleave', () => isDrawing = false);

canvas.addEventListener('touchstart', (e) => {
    e.preventDefault();
    const touch = e.touches[0];
    const pos = getTouchPos(touch);
    if (!isPointInsideText(pos.x, pos.y)) return;
    isDrawing = true;
    brushTrail.push([]);
    brushTrail[brushTrail.length - 1].push(pos);
    updateCoveredDots(pos.x, pos.y);
    drawAllDots();
});

canvas.addEventListener('touchmove', (e) => {
    e.preventDefault();
    if (!isDrawing) return;
    const touch = e.touches[0];
    const pos = getTouchPos(touch);
    if (!isPointInsideText(pos.x, pos.y)) return;
    brushTrail[brushTrail.length - 1].push(pos);
    updateCoveredDots(pos.x, pos.y);
    drawAllDots();
});

canvas.addEventListener('touchend', () => isDrawing = false);

function getMousePos(e) {
    const rect = canvas.getBoundingClientRect();
    const scaleX = canvas.width / rect.width;
    const scaleY = canvas.height / rect.height;
    return { x: (e.clientX - rect.left) * scaleX, y: (e.clientY - rect.top) * scaleY };
}

function getTouchPos(touch) {
    const rect = canvas.getBoundingClientRect();
    const scaleX = canvas.width / rect.width;
    const scaleY = canvas.height / rect.height;
    return { x: (touch.clientX - rect.left) * scaleX, y: (touch.clientY - rect.top) * scaleY };
}

function showSuccess() {
    const msg = document.getElementById('successMsg');
    msg.classList.add('show');
    setTimeout(() => msg.classList.remove('show'), 2500);
}

function updateWord() {
    const currentWord = words[currentWordIndex];
    document.getElementById('itemWord').textContent = currentWord.word;
    document.getElementById('itemImage').textContent = currentWord.emoji;
    generateDottedText(currentWord.word);
}

function nextWord() {
    currentWordIndex = (currentWordIndex + 1) % words.length;
    updateWord();
}

function prevWord() {
    currentWordIndex = (currentWordIndex - 1 + words.length) % words.length;
    updateWord();
}

function clearCanvas() {
    coveredDots.clear();
    hasShownSuccess = false;
    brushTrail = [];
    drawAllDots();
}

function goBack() {
    alert('Kembali ke menu utama');
    window.location.href = 'main.php';
}


updateWord();
    </script>
</body>
</html>