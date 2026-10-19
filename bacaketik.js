document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const elements = {
        userInput: document.getElementById('userInput'),
        targetWord: document.getElementById('targetWord'),
        feedback: document.getElementById('feedback'),
        selanjutnyaBtn: document.getElementById('selanjutnyaBtn'),
        backBtn: document.getElementById('backBtn'),
        confirmModal: document.getElementById('confirmModal'),
        completionModal: document.getElementById('completionModal'),
        yesBtn: document.getElementById('yesBtn'),
        noBtn: document.getElementById('noBtn'),
        retryBtn: document.getElementById('retryBtn'),
        finishBtn: document.getElementById('finishBtn')
    };

    // Game Configuration
    const gameConfig = {
        words: [
            'Aku suka bunga',
            'Ibu pergi ke pasar',
            'Adik bermain bola',
            'Ayah membaca koran',
            'Udin pergi ke sekolah',
            'Saya belajar membaca',
            'Kakak menulis surat',
            'Nenek memasak nasi',
            'Kucing makan ikan',
            'Dia membeli buku'
        ],
        animationDuration: 300,
        modalShowDelay: 10
    };

    // Game State
    const gameState = {
        shuffledWords: [],
        currentWordIndex: 0,
        isAnswerCorrect: false,
        isModalVisible: false,
        lastCorrectAnswer: ''
    };

    // Utility Functions
    const utils = {
        shuffleArray(array) {
            const shuffled = [...array];
            for (let i = shuffled.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
            }
            return shuffled;
        }
    };

    // Game Functions
    const game = {
        initialize() {
            gameState.currentWordIndex = 0;
            gameState.isAnswerCorrect = false;
            gameState.lastCorrectAnswer = '';
            gameState.shuffledWords = utils.shuffleArray(gameConfig.words);
            
            this.resetUI();
            this.setupEventListeners();
        },

        resetUI() {
            const { targetWord, userInput, feedback, selanjutnyaBtn } = elements;
            
            targetWord.textContent = gameState.shuffledWords[gameState.currentWordIndex];
            userInput.value = '';
            userInput.className = 'word-input';
            feedback.textContent = '';
            feedback.className = 'feedback-message';
            selanjutnyaBtn.disabled = true;
            userInput.focus();
        },

        checkAnswer(userText) {
            const targetText = gameState.shuffledWords[gameState.currentWordIndex];
            
            if (!userText) {
                this.updateUIState('', false);
                return;
            }

            gameState.isAnswerCorrect = userText === targetText;
            
            if (gameState.isAnswerCorrect) {
                gameState.lastCorrectAnswer = userText;
            }

            this.updateUIState(userText, gameState.isAnswerCorrect);
        },

        updateUIState(userText, isCorrect) {
            const { userInput, feedback, selanjutnyaBtn } = elements;

            userInput.className = `word-input ${userText ? (isCorrect ? 'correct' : 'wrong') : ''}`;
            
            feedback.textContent = userText ? 
                (isCorrect ? 'Benar! Klik Selanjutnya untuk melanjutkan.' : 'Belum tepat! Silakan coba lagi.') : 
                '';
            
            feedback.className = `feedback-message ${userText ? (isCorrect ? 'correct' : 'wrong') : ''}`;
            selanjutnyaBtn.disabled = !isCorrect;
        },

        nextWord() {
            if (!gameState.isAnswerCorrect) return;

            gameState.currentWordIndex++;
            gameState.isAnswerCorrect = false;
            gameState.lastCorrectAnswer = '';
            
            if (gameState.currentWordIndex >= gameState.shuffledWords.length) {
                this.showModal(elements.completionModal);
                return;
            }

            const { targetWord, userInput, feedback, selanjutnyaBtn } = elements;
            
            targetWord.textContent = gameState.shuffledWords[gameState.currentWordIndex];
            userInput.value = '';
            userInput.className = 'word-input';
            feedback.textContent = '';
            feedback.className = 'feedback-message';
            selanjutnyaBtn.disabled = true;
            userInput.focus();
        },

        showModal(modal) {
            if (gameState.isModalVisible) return;
            
            modal.style.display = 'flex';
            gameState.isModalVisible = true;
            setTimeout(() => modal.classList.add('show'), gameConfig.modalShowDelay);
        },

        hideModal(modal) {
            if (!gameState.isModalVisible) return;

            modal.classList.remove('show');
            gameState.isModalVisible = false;
            setTimeout(() => modal.style.display = 'none', gameConfig.animationDuration);
        },

        setupEventListeners() {
            const {
                userInput, selanjutnyaBtn, backBtn,
                yesBtn, noBtn, retryBtn, finishBtn, confirmModal
            } = elements;

            // Real-time input validation
            userInput.addEventListener('input', (e) => {
                const userText = e.target.value.trim();
                this.checkAnswer(userText);
            });

            // Prevent copy-paste
            userInput.addEventListener('copy', e => e.preventDefault());
            userInput.addEventListener('paste', e => e.preventDefault());
            userInput.addEventListener('contextmenu', e => e.preventDefault());

            // Navigation buttons
            selanjutnyaBtn.addEventListener('click', () => this.nextWord());
            backBtn.addEventListener('click', () => this.showModal(confirmModal));

            // Modal controls
            yesBtn.addEventListener('click', () => window.location.href = 'mode-belajar.php');
            noBtn.addEventListener('click', () => this.hideModal(confirmModal));
            retryBtn.addEventListener('click', () => {
                this.hideModal(elements.completionModal);
                this.initialize();
            });
            finishBtn.addEventListener('click', () => window.location.href = 'mode-belajar.php');

            // Keyboard support
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' && gameState.isAnswerCorrect) {
                    selanjutnyaBtn.click();
                } else if (event.key === 'Escape' && gameState.isModalVisible) {
                    const visibleModal = document.querySelector('.modal.show');
                    if (visibleModal) this.hideModal(visibleModal);
                }
            });

            // Click outside modal to close
            window.addEventListener('click', (event) => {
                if (event.target.classList.contains('modal')) {
                    this.hideModal(event.target);
                }
            });
        }
    };

    // Start the game
    game.initialize();
});