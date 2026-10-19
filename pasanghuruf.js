// Word list dengan gambar
const WORD_LIST = [
  { word: "pensil", image: "gambar/pensil.png" },
  { word: "buku", image: "gambar/buku.png" },
  { word: "meja", image: "gambar/meja.png" },
  { word: "kursi", image: "gambar/kursi.png" },
  { word: "tas", image: "gambar/tas.png" },
  { word: "bola", image: "gambar/bola.png" },
  { word: "lampu", image: "gambar/lampu.png" },
  { word: "jam", image: "gambar/jam.png" },
  { word: "topi", image: "gambar/topi.png" },
  { word: "sepatu", image: "gambar/sepatu.png" }
];

let currentWord = "";
let currentImage = "";
let score = 0;
let timeLeft = 300; // 5 minutes in seconds
let timerInterval = null;
let placedLetters = [];
let isGameActive = false;
let currentQuestionIndex = 0;
let wrongCount = 0;

const targetWordEl = document.getElementById("target-word");
const letterBankEl = document.getElementById("letter-bank");
const scoreDisplay = document.getElementById("score-display");
const timerDisplay = document.getElementById("timer-display");
const feedbackEl = document.getElementById("feedback");
const btnStart = document.getElementById("btn-start");
const instructionsEl = document.getElementById("instructions");
const clueImageEl = document.getElementById("clue-image");
const clueImg = document.getElementById("clue-img");

// Audio context for better sound control
let audioContext;
let correctBuffer;
let wrongBuffer;

function initAudio() {
  try {
    audioContext = new (window.AudioContext || window.webkitAudioContext)();
    
    // Create correct sound
    correctBuffer = createToneBuffer(880, 0.3, 'sine');
    
    // Create wrong sound  
    wrongBuffer = createToneBuffer(220, 0.4, 'sawtooth');
  } catch (e) {
    console.log("Audio not supported");
  }
}

function createToneBuffer(frequency, duration, type) {
  const sampleRate = audioContext.sampleRate;
  const length = sampleRate * duration;
  const buffer = audioContext.createBuffer(1, length, sampleRate);
  const data = buffer.getChannelData(0);
  
  for (let i = 0; i < length; i++) {
    const t = i / sampleRate;
    if (type === 'sine') {
      data[i] = Math.sin(2 * Math.PI * frequency * t) * Math.exp(-3 * t);
    } else if (type === 'sawtooth') {
      data[i] = (2 * (t * frequency - Math.floor(0.5 + t * frequency))) * Math.exp(-2 * t);
    }
  }
  
  return buffer;
}

function playSound(type) {
  if (!audioContext) return;
  
  try {
    const source = audioContext.createBufferSource();
    source.buffer = type === 'correct' ? correctBuffer : wrongBuffer;
    source.connect(audioContext.destination);
    source.start();
  } catch (e) {
    console.log("Sound play failed:", e);
  }
}

// Synthetic applause using short noise bursts
function playApplause() {
  if (!audioContext) return;
  const now = audioContext.currentTime;
  const clapCount = 4;
  
  for (let i = 0; i < clapCount; i++) {
    const length = 0.18 + Math.random() * 0.06;
    const buffer = audioContext.createBuffer(1, Math.floor(audioContext.sampleRate * length), audioContext.sampleRate);
    const data = buffer.getChannelData(0);
    
    for (let j = 0; j < data.length; j++) {
      const t = j / data.length;
      data[j] = (Math.random() * 2 - 1) * Math.exp(-6 * t) * (1 - t);
    }

    const src = audioContext.createBufferSource();
    src.buffer = buffer;

    const bp = audioContext.createBiquadFilter();
    bp.type = 'bandpass';
    bp.frequency.value = 2000 + Math.random() * 400;
    bp.Q.value = 0.7;

    const lp = audioContext.createBiquadFilter();
    lp.type = 'lowpass';
    lp.frequency.value = 6000;

    const gain = audioContext.createGain();
    const startTime = now + i * 0.12;
    gain.gain.setValueAtTime(0.0001, startTime);
    gain.gain.exponentialRampToValueAtTime(0.9 - i * 0.12, startTime + 0.005);
    gain.gain.exponentialRampToValueAtTime(0.0001, startTime + length);

    src.connect(bp);
    bp.connect(lp);
    lp.connect(gain);
    gain.connect(audioContext.destination);

    src.start(startTime);
  }
}

function initGame() {
  initAudio();
  resetGame();
  setupEventListeners();
}

/* Modal helper functions */
const modalRoot = document.getElementById('modal-root');
const modalTitle = () => document.getElementById('modal-title');
const modalBody = () => document.getElementById('modal-body');
const modalFooter = () => document.getElementById('modal-footer');

function openModal({title = '', html = '', buttons = []} = {}) {
  if (!modalRoot) {
    if (buttons.length >= 2) {
      const ok = window.confirm(html || title || 'Continue?');
      return Promise.resolve(ok ? buttons[0].value : buttons[1].value);
    }
    const okOnly = window.confirm(html || title || 'OK?');
    return Promise.resolve(okOnly ? (buttons[0] ? buttons[0].value : true) : null);
  }
  
  modalRoot.classList.add('open');
  modalRoot.setAttribute('aria-hidden', 'false');
  modalTitle().textContent = title;
  modalBody().innerHTML = html;
  modalFooter().innerHTML = '';

  return new Promise(resolve => {
    buttons.forEach(btn => {
      const b = document.createElement('button');
      b.className = `modal-btn ${btn.class || ''}`.trim();
      b.textContent = btn.label;
      b.addEventListener('click', () => {
        closeModal();
        resolve(btn.value);
      });
      modalFooter().appendChild(b);
    });

    const closeBtn = document.querySelector('.modal-close');
    if (closeBtn) closeBtn.onclick = () => { closeModal(); resolve(null); };

    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) backdrop.onclick = () => { closeModal(); resolve(null); };
  });
}

function closeModal() {
  if (!modalRoot) return;
  modalRoot.classList.remove('open');
  modalRoot.setAttribute('aria-hidden', 'true');
}

function setupEventListeners() {
  btnStart.addEventListener("click", startGame);
  
  const backBtn = document.querySelector(".btn-back");
  if (backBtn) {
    backBtn.addEventListener('click', async (e) => {
      e.preventDefault();
      e.stopPropagation();
      
      // Jika game belum aktif, langsung kembali
      if (!isGameActive) {
        window.location.href = 'mini-game.php';
        return;
      }
      // Jika game aktif, tampilkan konfirmasi
      const result = await openModal({
        title: 'Konfirmasi',
        html: 'Yakin ingin keluar dari Pasang Kata?',
        buttons: [
          { label: 'Ya', value: true, class: 'primary' },
          { label: 'Tidak', value: false, class: 'secondary' }
        ]
      });

      if (result === true) {
        resetGame();
        window.location.href = 'mini-game.php';
      }
    });
  }
  
  const menuBtn = document.querySelector(".btn-menu");
  if (menuBtn) {
    menuBtn.addEventListener("click", () => {
      alert("🌟 Fitur ini dirancang khusus untuk membantu anak dengan disleksia!\n\nTips untuk orang tua:\n• Beri waktu yang cukup\n• Rayakan setiap keberhasilan\n• Fokus pada proses, bukan kecepatan");
    });
  }
}

function startGame() {
  if (isGameActive) return;
  isGameActive = true;
  btnStart.style.display = "none";
  instructionsEl.style.display = "none";
  loadNextWord();
  startTimer();
}

function loadNextWord() {
  if (currentQuestionIndex >= WORD_LIST.length) {
    endGame();
    return;
  }

  const wordObj = WORD_LIST[currentQuestionIndex];
  currentWord = wordObj.word;
  currentImage = wordObj.image;
  placedLetters = Array(currentWord.length).fill(null);

  clueImg.src = currentImage;
  clueImg.alt = `Gambar ${currentWord}`;
  clueImageEl.classList.add("active");

  targetWordEl.classList.add("active");
  targetWordEl.innerHTML = "";
  
  for (let i = 0; i < currentWord.length; i++) {
    const slot = document.createElement("div");
    slot.className = "target-slot";
    slot.dataset.index = i;
    slot.setAttribute("data-placeholder", currentWord[i]);
    slot.setAttribute("aria-label", `Slot huruf ${i + 1} untuk kata ${currentWord}`);
    
    slot.addEventListener("dragover", handleDragOver);
    slot.addEventListener("drop", handleDrop);
    slot.addEventListener("dragenter", handleDragEnter);
    slot.addEventListener("dragleave", handleDragLeave);
    
    targetWordEl.appendChild(slot);
  }

  letterBankEl.classList.add("active");
  letterBankEl.innerHTML = "";
  const shuffledLetters = shuffleArray(currentWord.split(""));
  
  shuffledLetters.forEach(letter => {
    const letterEl = document.createElement("div");
    letterEl.className = "letter";
    letterEl.textContent = letter;
    letterEl.draggable = true;
    letterEl.setAttribute("data-letter", letter);
    letterEl.setAttribute("aria-label", `Huruf ${letter}`);
    
    letterEl.addEventListener("dragstart", handleDragStart);
    letterEl.addEventListener("dragend", handleDragEnd);
    
    letterBankEl.appendChild(letterEl);
  });
}

function shuffleArray(array) {
  const arr = [...array];
  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [arr[i], arr[j]] = [arr[j], arr[i]];
  }
  return arr;
}

function handleDragStart(e) {
  e.dataTransfer.setData("text/plain", e.target.dataset.letter);
  e.dataTransfer.effectAllowed = "move";
  e.target.style.opacity = "0.6";
  e.target.style.transform = "scale(1.15) rotate(8deg)";
}

function handleDragEnd(e) {
  e.target.style.opacity = "1";
  e.target.style.transform = "";
}

function handleDragOver(e) {
  e.preventDefault();
  e.dataTransfer.dropEffect = "move";
}

function handleDragEnter(e) {
  e.preventDefault();
  e.target.style.backgroundColor = "#F0F0F0";
  e.target.style.transform = "scale(1.05)";
}

function handleDragLeave(e) {
  e.target.style.backgroundColor = "";
  e.target.style.transform = "";
}

function handleDrop(e) {
  e.preventDefault();
  e.target.style.backgroundColor = "";
  e.target.style.transform = "";
  
  const letter = e.dataTransfer.getData("text/plain");
  const slot = e.target.closest(".target-slot");
  if (!slot) return;
  
  const index = parseInt(slot.dataset.index);

  if (placedLetters[index] !== null) {
    showFeedback("Slot ini sudah terisi! Coba slot lain ya! 😊", "incorrect");
    playSound("wrong");
    return;
  }

  if (letter === currentWord[index]) {
    placedLetters[index] = letter;
    slot.textContent = letter;
    slot.classList.add("filled");
    playSound("correct");
    showFeedback("Hebat! Kamu benar! 🎉", "correct");

    const letterEl = Array.from(letterBankEl.children).find(el => el.dataset.letter === letter);
    if (letterEl) letterEl.remove();

    if (placedLetters.every(l => l !== null)) {
      score += 1;
      updateScore();
      showFeedback("Kamu hebat sekali! 👏", "correct");
      
      if (audioContext && audioContext.state === 'suspended') audioContext.resume();
      playApplause();
      
      setTimeout(() => {
        currentQuestionIndex++;
        celebrateAndNext();
      }, 1800);
    }
  } else {
    wrongCount++;
    slot.classList.add("incorrect");
    setTimeout(() => slot.classList.remove("incorrect"), 500);
    showFeedback("Hampir benar! Coba lagi ya! 💪", "incorrect");
    playSound("wrong");
  }
}

function showFeedback(message, type) {
  feedbackEl.textContent = message;
  feedbackEl.className = `feedback ${type}`;
  setTimeout(() => {
    feedbackEl.textContent = "";
    feedbackEl.className = "feedback";
  }, 2000);
}

function updateScore() {
  scoreDisplay.textContent = score;
}

function startTimer() {
  clearInterval(timerInterval);
  timerInterval = setInterval(() => {
    if (!isGameActive) return;
    
    if (timeLeft <= 0) {
      clearInterval(timerInterval);
      endGame();
      return;
    }
    timeLeft--;
    const mins = String(Math.floor(timeLeft / 60)).padStart(2, "0");
    const secs = String(timeLeft % 60).padStart(2, "0");
    timerDisplay.textContent = `${mins}:${secs}`;
  }, 1000);
}

function celebrateAndNext() {
  if (currentQuestionIndex < WORD_LIST.length) {
    clueImageEl.classList.remove("active");
    targetWordEl.classList.remove("active");
    letterBankEl.classList.remove("active");
    setTimeout(() => {
      loadNextWord();
    }, 1000);
  } else {
    endGame();
  }
}

function endGame() {
  clearInterval(timerInterval);
  isGameActive = false;

  const finalMessage = score === WORD_LIST.length 
    ? `🎉 LUAR BIASA! Kamu menyelesaikan semua ${WORD_LIST.length} tantangan! Skor sempurna: ${score}/${WORD_LIST.length}!`
    : `🌟 KEREN! Kamu berhasil menyelesaikan ${score} dari ${WORD_LIST.length} tantangan! Setiap usaha itu berharga!`;

  const endModal = document.getElementById('end-modal');
  if (endModal) {
    const sub = endModal.querySelector('.end-sub');
    if (sub) sub.textContent = finalMessage;
    endModal.classList.add('open');
    endModal.setAttribute('aria-hidden', 'false');

    const restartBtn = document.getElementById('btn-restart');
    const backBtn = document.getElementById('btn-back-home');
    const closeModal = () => {
      endModal.classList.remove('open');
      endModal.setAttribute('aria-hidden', 'true');
    };
    
    if (restartBtn) restartBtn.onclick = () => { closeModal(); resetGame(); startGame(); };
    if (backBtn) backBtn.onclick = () => { closeModal(); resetGame(); };
  } else {
    alert(finalMessage);
    resetGame();
  }
}

function resetGame() {
  clearInterval(timerInterval);
  score = 0;
  timeLeft = 300;
  placedLetters = [];
  wrongCount = 0;
  isGameActive = false;
  currentQuestionIndex = 0;
  updateScore();
  timerDisplay.textContent = "05:00";
  targetWordEl.innerHTML = "";
  letterBankEl.innerHTML = "";
  targetWordEl.classList.remove("active");
  letterBankEl.classList.remove("active");
  clueImageEl.classList.remove("active");
  feedbackEl.textContent = "";
  instructionsEl.style.display = "block";
  btnStart.style.display = "block";
}

window.addEventListener("DOMContentLoaded", initGame);

// Handle audio context resume on user interaction
document.addEventListener('click', () => {
  if (audioContext && audioContext.state === 'suspended') {
    audioContext.resume();
  }
}, { once: true });