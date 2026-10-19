        document.addEventListener('DOMContentLoaded', function() {
            // Get DOM elements
            const imageContainer = document.getElementById('imageContainer');
            const questionImage = document.getElementById('questionImage');
            const wordHint = document.getElementById('wordHint');
            const optionsContainer = document.getElementById('optionsContainer');
            const nextBtn = document.getElementById('nextBtn');
            const backBtn = document.getElementById('backBtn');
            const exitModal = document.getElementById('exitModal');
            const warningModal = document.getElementById('warningModal');
            const completionModal = document.getElementById('completionModal');
            const scoreDisplay = document.getElementById('scoreDisplay');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            const audioToggle = document.getElementById('audioToggle');
            
            // Audio elements
            const selectSound = document.getElementById('selectSound');
            const correctSound = document.getElementById('correctSound');
            const incorrectSound = document.getElementById('incorrectSound');
            const completionSound = document.getElementById('completionSound');
            
            // Audio state
            let audioEnabled = true;

            // Game state
            let score = 0;
            let wrongAnswers = 0;
            let currentQuestionIndex = 0;
            let selectedOption = null;
            let answered = false;

            // Game questions
            const gameQuestions = [
                {
                    image: "gambar/celana.png",
                    hint: 'ce__na',
                    options: ['la', 'le', 'li', 'lo'],
                    correct: 'la',
                    fullWord: 'celana'
                },
                {
                    image: "gambar/meja.png",
                    hint: 'me__',
                    options: ['ja', 'ji', 'ju', 'je'],
                    correct: 'ja',
                    fullWord: 'meja'
                },
                {
                    image: "gambar/buku.png",
                    hint: 'bu__',
                    options: ['ku', 'ka', 'ki', 'ke'],
                    correct: 'ku',
                    fullWord: 'buku'
                },
                {
                    image: 'gambar/mata.png',
                    hint: 'ma__',
                    options: ['ta', 'ti', 'tu', 'te'],
                    correct: 'ta',
                    fullWord: 'mata'
                },
                {
                    image: "gambar/durian.png",
                    hint: 'du__an',
                    options: ['ro', 're', 'ri', 'ra'],
                    correct: 'ri',
                    fullWord: 'durian' 
                },
                {
                    image: "gambar/jeruk.png",
                    hint: '__ruk',
                    options: ['ja', 'ju', 'ji', 'je'],
                    correct: 'je',
                    fullWord: 'jeruk'
                },
                {
                    image: "gambar/roda.png",
                    hint: 'ro__',
                    options: ['da', 'di', 'du', 'de'],
                    correct: 'da',
                    fullWord: 'roda'
                },
                {
                    image: "gambar/pita.png",
                    hint: 'pi__',
                    options: ['ta', 'ti', 'tu', 'te'],
                    correct: 'ta',
                    fullWord: 'pita'
                },
                {
                    image: "gambar/bunga.png",
                    hint: 'bu___',
                    options: ['nga', 'ngi', 'ngu', 'nge'],
                    correct: 'nga',
                    fullWord: 'bunga'
                },
                {
                    image: "gambar/apel.png",
                    hint: 'a__l',
                    options: ['pe', 'pi', 'pu', 'pa'],
                    correct: 'pe',
                    fullWord: 'apel'
                }
            ];

            let questions = [...gameQuestions];

            // Toggle audio
            audioToggle.addEventListener('click', function() {
                audioEnabled = !audioEnabled;
                if (audioEnabled) {
                    audioToggle.innerHTML = '<i class="fas fa-volume-up"></i>';
                } else {
                    audioToggle.innerHTML = '<i class="fas fa-volume-mute"></i>';
                }
            });

            // Play sound function
            function playSound(soundElement) {
                if (!audioEnabled) return;
                try {
                    soundElement.currentTime = 0;
                    soundElement.play();
                } catch (e) {
                    console.log("Audio play failed:", e);
                }
            }

            // Shuffle questions
            function shuffleQuestions() {
                for (let i = questions.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [questions[i], questions[j]] = [questions[j], questions[i]];
                }
            }

            function updateProgress() {
                const progress = ((currentQuestionIndex + 1) / questions.length) * 100;
                progressBar.style.width = `${progress}%`;
                progressText.textContent = `Soal ${currentQuestionIndex + 1}/${questions.length}`;
            }

            function displayQuestion() {
                const question = questions[currentQuestionIndex];
                questionImage.src = question.image;
                // Some questions (like 'bunga') don't include an explicit hint string in the data,
                // or need slightly smaller images so the hint remains visible. Use fullWord if
                // hint is missing and toggle a smaller CSS class for tight layouts.
                wordHint.textContent = question.hint || question.fullWord || '';
                // Toggle small-image class for bunga (filename or fullWord)
                const isBunga = (question.fullWord && question.fullWord.toLowerCase() === 'bunga') || /bunga\.png$/i.test(question.image);
                if (isBunga) {
                    questionImage.classList.add('small-question-image');
                } else {
                    questionImage.classList.remove('small-question-image');
                }
                optionsContainer.innerHTML = '';
                answered = false;
                selectedOption = null;

                question.options.forEach((option, index) => {
                    const button = document.createElement('button');
                    button.className = 'option-btn';
                    button.textContent = option;
                    button.addEventListener('click', () => {
                        selectOption(button, option);
                        playSound(selectSound);
                    });
                    optionsContainer.appendChild(button);
                });

                updateProgress();
            }

            function selectOption(button, option) {
                if (answered) return;
                
                const buttons = document.querySelectorAll('.option-btn');
                buttons.forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
                selectedOption = option;
            }

            function showCompletionModal() {
                const accuracy = Math.round((score / questions.length) * 100);
                scoreDisplay.innerHTML = `
                    <div class="score-item">
                        <span>✅ Jawaban Benar:</span>
                        <strong>${score}</strong>
                    </div>
                    <div class="score-item">
                        <span>❌ Jawaban Salah:</span>
                        <strong>${wrongAnswers}</strong>
                    </div>
                    <div class="score-item">
                        <span>📈 Akurasi:</span>
                        <strong>${accuracy}%</strong>
                    </div>
                `;
                completionModal.style.display = 'flex';
                if (audioEnabled) {
                    playSound(completionSound);
                }
            }

            function resetGame() {
                score = 0;
                wrongAnswers = 0;
                currentQuestionIndex = 0;
                answered = false;
                shuffleQuestions();
                displayQuestion();
                completionModal.style.display = 'none';
            }

            // Event Listeners
            nextBtn.addEventListener('click', function() {
                if (!selectedOption) {
                    warningModal.style.display = 'flex';
                    return;
                }

                const question = questions[currentQuestionIndex];
                const isCorrect = selectedOption === question.correct;

                if (isCorrect) {
                    score++;
                    document.querySelector('.option-btn.selected').classList.add('correct');
                    playSound(correctSound);
                } else {
                    wrongAnswers++;
                    document.querySelector('.option-btn.selected').classList.add('incorrect');
                    playSound(incorrectSound);
                }

                answered = true;
                nextBtn.textContent = currentQuestionIndex + 1 >= questions.length ? 'Selesai' : 'Soal Berikutnya';

                setTimeout(() => {
                    currentQuestionIndex++;
                    if (currentQuestionIndex >= questions.length) {
                        showCompletionModal();
                        return;
                    }
                    displayQuestion();
                    nextBtn.textContent = 'Lanjut';
                }, 800);
            });

            backBtn.addEventListener('click', function() {
                exitModal.style.display = 'flex';
            });

            document.getElementById('yesBtn').addEventListener('click', function() {
                window.history.back();
            });

            document.getElementById('noBtn').addEventListener('click', function() {
                exitModal.style.display = 'none';
            });

            document.getElementById('okBtn').addEventListener('click', function() {
                warningModal.style.display = 'none';
            });

            document.getElementById('playAgainBtn').addEventListener('click', resetGame);

            document.getElementById('returnBtn').addEventListener('click', function() {
                window.history.back();
            });

            // Close modals when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === exitModal) {
                    exitModal.style.display = 'none';
                } else if (event.target === warningModal) {
                    warningModal.style.display = 'none';
                } else if (event.target === completionModal) {
                    completionModal.style.display = 'none';
                }
            });

            // Initialize game
            shuffleQuestions();
            displayQuestion();
        });
