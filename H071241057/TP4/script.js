document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const screens = {
        start: document.getElementById('start-menu'),
        betting: document.getElementById('betting-screen'),
        game: document.getElementById('game-screen'),
        gameOver: document.getElementById('game-over-screen'),
    };
    const startBtn = document.getElementById('start-btn');
    const placeBetBtn = document.getElementById('place-bet-btn');
    const restartBtn = document.getElementById('restart-btn');
    const deckCard = document.getElementById('deck-card');
    const unoBtn = document.getElementById('uno-btn');
    const colorPickerModal = document.getElementById('color-picker-modal');

    // DOM untuk Notifikasi dan Modal BARU
    const toastContainer = document.getElementById('toast-container');
    const resultModal = document.getElementById('result-modal');
    const resultTitle = document.getElementById('result-title');
    const resultMessage = document.getElementById('result-message');
    const resultContinueBtn = document.getElementById('result-continue-btn');
    const decisionModal = document.getElementById('decision-modal');
    const decisionMessage = document.getElementById('decision-message');
    const decisionCardPreview = document.getElementById('decision-card-preview');
    const playCardBtn = document.getElementById('play-card-btn');
    const keepCardBtn = document.getElementById('keep-card-btn');

    const balanceDisplay = document.getElementById('balance-display');
    const gameBalance = document.getElementById('game-balance');
    const gameBet = document.getElementById('game-bet');
    const betAmountInput = document.getElementById('bet-amount');
    const betError = document.getElementById('bet-error');

    const playerHandDiv = document.getElementById('player-hand');
    const botHandDiv = document.getElementById('bot-hand');
    const discardPileDiv = document.getElementById('discard-pile');
    const turnIndicator = document.getElementById('turn-indicator');
    // ... elemen lainnya
    const playerArea = document.getElementById('player-area');
    const botArea = document.getElementById('bot-area');
    
    // Game State
    let playerBalance = 5000;
    let currentBet = 0;
    let deck = [];
    let playerHand = [];
    let botHand = [];
    let discardPile = [];
    let currentPlayer = 'player';
    let wildColor = null;
    let unoTimer = null;

    const showToast = (message, duration = 3000) => {
        const toast = document.createElement('div');
        toast.className = 'toast-message';
        toast.textContent = message;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, duration);
    };

    const showResultModal = (title, message) => {
        resultTitle.textContent = title;
        resultMessage.textContent = message;
        resultModal.style.display = 'flex';
    };

    /** Menanyakan pemain untuk memainkan kartu yang ditarik */
    const askToPlayDrawnCard = (card) => {
        return new Promise((resolve) => {
            decisionMessage.textContent = `Anda mengambil kartu ini. Apakah Anda ingin memainkannya?`;
            decisionCardPreview.innerHTML = '';
            decisionCardPreview.appendChild(renderCard(card));
            decisionModal.style.display = 'flex';

            const onPlay = () => {
                decisionModal.style.display = 'none';
                playCardBtn.removeEventListener('click', onPlay);
                keepCardBtn.removeEventListener('click', onKeep);
                resolve(true);
            };
            const onKeep = () => {
                decisionModal.style.display = 'none';
                playCardBtn.removeEventListener('click', onPlay);
                keepCardBtn.removeEventListener('click', onKeep);
                resolve(false);
            };

            playCardBtn.addEventListener('click', onPlay);
            keepCardBtn.addEventListener('click', onKeep);
        });
    };

    resultContinueBtn.addEventListener('click', () => {
        resultModal.style.display = 'none';
        if (playerBalance <= 0) {
            showScreen('gameOver');
        } else {
            updateBalanceDisplay();
            betAmountInput.max = playerBalance;
            betAmountInput.value = 100;
            showScreen('betting');
        }
    });

    const showScreen = (screenName) => {
        for (const screen in screens) {
            screens[screen].classList.remove('active');
        }
        screens[screenName].classList.add('active');
    };
    
    const updateBalanceDisplay = () => {
        balanceDisplay.textContent = playerBalance;
        gameBalance.textContent = playerBalance;
    };

    const createDeck = () => {
        const colors = ['red', 'green', 'blue', 'yellow'];
        const values = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'skip', 'reverse', 'draw2'];
        deck = [];

        // Bagian ini tetap sama, membuat setiap kartu berwarna unik
        for (const color of colors) {
            for (const value of values) {
                deck.push({ color, value });
            }
        }

        for (let i = 0; i < 2; i++) {
            deck.push({ color: 'wild', value: 'wild' });
            deck.push({ color: 'wild', value: 'draw4' });
        }
    };

    const shuffleDeck = () => {
        for (let i = deck.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [deck[i], deck[j]] = [deck[j], deck[i]];
        }
    };

    const drawCards = (player, num) => {
        const drawnCards = [];
        for (let i = 0; i < num; i++) {
            if (deck.length === 0) {
                if (discardPile.length <= 1) {
                    showToast("Deck dan tumpukan habis! Ronde berakhir seri.");
                    endRound('draw');
                    return [];
                }
                const topCard = discardPile.pop();
                deck = [...discardPile];
                shuffleDeck();
                discardPile = [topCard];
            }
            const card = deck.pop();
            if (player === 'player') playerHand.push(card);
            else botHand.push(card);
            drawnCards.push(card);
        }
        return drawnCards;
    };
    
    // --- RENDERING ---
    const renderCard = (card, isBot = false) => {
        const cardImg = document.createElement('img');
        cardImg.classList.add('card');
        if (isBot) {
            cardImg.src = 'img/back.png';
        } else {
            const valueForImage = card.value === 'wild' ? 'wild' : card.value;
            const cardName = card.color === 'wild' ? valueForImage : `${card.color}_${valueForImage}`;
            cardImg.src = `img/${cardName}.png`;
            cardImg.dataset.color = card.color;
            cardImg.dataset.value = card.value;
        }
        return cardImg;
    };
    
    const renderHands = () => {
        playerHandDiv.innerHTML = '';
        botHandDiv.innerHTML = '';
        
        playerHand.forEach(card => {
            const cardEl = renderCard(card);
            cardEl.addEventListener('click', () => playerPlayCard(card));
            playerHandDiv.appendChild(cardEl);
        });

        botHand.forEach(() => {
            botHandDiv.appendChild(renderCard(null, true));
        });
        
        if(playerHand.length <= 2 && unoBtn.disabled){
            unoBtn.disabled = false;
        }

        if(playerHand.length === 1 && !unoBtn.disabled){
             unoBtn.style.display = 'block';
             startUnoTimer();
        } else {
             unoBtn.style.display = 'none';
             clearTimeout(unoTimer);
        }
    };

    const renderDiscardPile = () => {
        discardPileDiv.innerHTML = '';
        const topCard = discardPile[discardPile.length - 1];
        if (topCard) {
            const cardEl = renderCard(topCard);
            if ((topCard.value === 'wild' || topCard.value === 'draw4') && wildColor) {
                cardEl.style.border = `4px solid ${wildColor}`;
                cardEl.style.boxSizing = 'border-box';
            }
            discardPileDiv.appendChild(cardEl);
        }
    };


    startBtn.addEventListener('click', () => {
        updateBalanceDisplay();
        showScreen('betting');
    });

    placeBetBtn.addEventListener('click', () => {
        const bet = parseInt(betAmountInput.value);
        betError.textContent = '';
        if (isNaN(bet) || bet < 100) {
            betError.textContent = 'Taruhan minimal adalah $100.';
        } else if (bet > playerBalance) {
            betError.textContent = 'Saldo Anda tidak mencukupi.';
        } else {
            currentBet = bet;
            playerBalance -= currentBet;
            updateBalanceDisplay();
            gameBet.textContent = currentBet;
            startRound();
        }
    });

    restartBtn.addEventListener('click', () => {
        playerBalance = 5000;
        betAmountInput.value = 100;
        updateBalanceDisplay();
        showScreen('betting');
    });

    const startRound = () => {
        playerHand = [];
        botHand = [];
        discardPile = [];
        wildColor = null;
        unoBtn.disabled = true;
        createDeck();
        shuffleDeck();
        
        drawCards('player', 7);
        drawCards('bot', 7);

        let firstCard;
        do {
            firstCard = deck.pop();
            if (firstCard.value === 'draw4') {
                deck.push(firstCard);
                shuffleDeck();
            }
        } while (firstCard.value === 'draw4');
        discardPile.push(firstCard);
        
        if (firstCard.color === 'wild') {
            wildColor = ['red', 'green', 'blue', 'yellow'][Math.floor(Math.random() * 4)];
        }

        currentPlayer = 'player';
        turnIndicator.textContent = "Giliran Anda";
        
        renderHands();
        renderDiscardPile();
        showScreen('game');
        updateTurnIndicatorVisuals();
    };

    const endRound = (winner) => {
        clearTimeout(unoTimer);
        setTimeout(() => {
            if (winner === 'player') {
                playerBalance += currentBet * 2;
                showResultModal('Anda Menang!', `Selamat, Anda memenangkan $${currentBet * 2}.`);
            } else if (winner === 'bot') {
                showResultModal('Anda Kalah', `Sayang sekali, Anda kehilangan taruhan $${currentBet}.`);
            } else {
                playerBalance += currentBet;
                showResultModal('Seri', 'Ronde berakhir seri dan taruhan Anda dikembalikan.');
            }
        }, 1000);
    };

    const isCardPlayable = (card, topCard, hand) => {
        const activeColor = wildColor || topCard.color;
        if (card.color === 'wild') {
            if (card.value === 'draw4') {
                const hasMatchingColorCard = hand.some(c => c.color === activeColor && c.color !== 'wild');
                return !hasMatchingColorCard;
            }
            return true;
        }
        return card.color === activeColor || card.value === topCard.value;
    };
    
    function playerPlayCard(card) {
        if (currentPlayer !== 'player') return;
        const topCard = discardPile[discardPile.length - 1];

        if (isCardPlayable(card, topCard, playerHand)) {
            playerHand = playerHand.filter(c => c !== card);
            discardPile.push(card);
            wildColor = null;
            
            renderHands();
            
            if (playerHand.length === 0) {
                renderDiscardPile();
                endRound('player');
                return;
            }

            if (card.color === 'wild') {
                showColorPicker(card, 'player');
            } else {
                renderDiscardPile();
                processTurn(card, 'player');
            }
        } else {
            showToast(`Kartu tidak bisa dimainkan!`, 2000);
        }
    }
    
    deckCard.addEventListener('click', async () => {
        if (currentPlayer !== 'player') return;
        
        const [drawnCard] = drawCards('player', 1);
        renderHands();
        
        if (!drawnCard) return;

        const topCard = discardPile[discardPile.length - 1];
        
        if(isCardPlayable(drawnCard, topCard, playerHand)) {
              const wantsToPlay = await askToPlayDrawnCard(drawnCard);
              if (wantsToPlay) {
                   playerPlayCard(drawnCard);
              } else {
                   switchTurn();
              }
        } else {
            showToast('Kartu yang diambil tidak bisa dimainkan.', 2000);
            setTimeout(switchTurn, 1000);
        }
    });

    const startUnoTimer = () => {
        clearTimeout(unoTimer);
        unoTimer = setTimeout(() => {
            showToast("Anda lupa menekan UNO! Ambil 2 kartu penalti.", 4000);
            drawCards('player', 2);
            renderHands();
            unoBtn.style.display = 'none';
            unoBtn.disabled = true;
        }, 3000);
    };

    unoBtn.addEventListener('click', () => {
        showToast("UNO!", 1500);
        clearTimeout(unoTimer);
        unoBtn.style.display = 'none';
        unoBtn.disabled = true;
    });

    const botTurn = () => {
        turnIndicator.textContent = "Giliran Bot...";
        setTimeout(() => {
            const topCard = discardPile[discardPile.length - 1];
            const playableCards = botHand.filter(card => isCardPlayable(card, topCard, botHand));
            
            if (playableCards.length > 0) {
                let cardToPlay = playableCards.find(c => c.color !== 'wild') || playableCards[0];
                botHand = botHand.filter(c => c !== cardToPlay);
                discardPile.push(cardToPlay);
                wildColor = null;
                renderHands();

                if (botHand.length === 0) {
                    renderDiscardPile();
                    endRound('bot');
                    return;
                }

                if (botHand.length === 1) {
                    showToast("Bot: UNO!", 1500);
                }
                
                if (cardToPlay.color === 'wild') {
                    const colorCount = botHand.reduce((acc, c) => {
                        if (c.color !== 'wild') acc[c.color] = (acc[c.color] || 0) + 1;
                        return acc;
                    }, {});
                    const chosenColor = Object.keys(colorCount).reduce((a, b) => colorCount[a] > colorCount[b] ? a : b, 'red');
                    wildColor = chosenColor;
                    showToast(`Bot memilih warna ${chosenColor}.`, 2000);
                    renderDiscardPile();
                    processTurn(cardToPlay, 'bot');
                } else {
                    renderDiscardPile();
                    processTurn(cardToPlay, 'bot');
                }

            } else {
                showToast('Bot mengambil kartu.', 2000);
                const [drawnCard] = drawCards('bot', 1);
                renderHands();

                if (drawnCard && isCardPlayable(drawnCard, topCard, botHand)) {
                    setTimeout(() => {
                        showToast(`Bot langsung memainkan kartu yang baru diambil!`, 2500);
                        botTurn();
                    }, 1000);
                } else {
                    switchTurn();
                }
            }
        }, 1500);
    };
    
    // --- CARD EFFECTS and TURN MANAGEMENT ---
    const processTurn = (card, playerWhoPlayed) => {
        const target = playerWhoPlayed === 'player' ? 'bot' : 'player';
        let skipTurn = false;

        switch (card.value) {
            case 'skip':
            case 'reverse':
                showToast(`${target.charAt(0).toUpperCase() + target.slice(1)} dilewati!`, 2000);
                skipTurn = true;
                break;
            case 'draw2':
                showToast(`${target.charAt(0).toUpperCase() + target.slice(1)} mengambil 2 kartu!`, 2000);
                drawCards(target, 2);
                renderHands();
                skipTurn = true;
                break;
            case 'draw4':
                showToast(`${target.charAt(0).toUpperCase() + target.slice(1)} mengambil 4 kartu!`, 2000);
                drawCards(target, 4);
                renderHands();
                skipTurn = true;
                break;
        }

        // ...
        if (skipTurn) {
            if (playerWhoPlayed === 'bot') {
                setTimeout(botTurn, 1000);
            } else {
                turnIndicator.textContent = "Giliran Anda lagi!";
            }
            updateTurnIndicatorVisuals(); 
        } else {
            switchTurn();
        }
    };

    const updateTurnIndicatorVisuals = () => {
        if (currentPlayer === 'player') {
            playerArea.classList.add('active-turn');
            botArea.classList.remove('active-turn');
        } else {
            botArea.classList.add('active-turn');
            playerArea.classList.remove('active-turn');
        }
    };


    const switchTurn = () => {
        currentPlayer = (currentPlayer === 'player') ? 'bot' : 'player';
        if (currentPlayer === 'bot') {
            botTurn();
        } else {
            turnIndicator.textContent = "Giliran Anda";
        }
        updateTurnIndicatorVisuals();
    };
    
    const showColorPicker = (card, player) => {
        colorPickerModal.style.display = 'flex';
        
        const colorPickerHandler = (event) => {
            if (event.target.classList.contains('color-box')) {
                wildColor = event.target.dataset.color;
                colorPickerModal.style.display = 'none';
                renderDiscardPile();
                processTurn(card, player);
                colorPickerModal.removeEventListener('click', colorPickerHandler);
            }
        };
        colorPickerModal.addEventListener('click', colorPickerHandler);
    };

    showScreen('start');
});