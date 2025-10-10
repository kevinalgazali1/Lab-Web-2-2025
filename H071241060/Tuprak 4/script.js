document.addEventListener('DOMContentLoaded', () => {
    const $ = id => document.getElementById(id);
    const playerHandEl = $('player-hand'), botHandEl = $('bot-hand'), discardPileEl = $('discard-pile'),
            deckPileEl = $('deck-pile'), notificationEl = $('notification-area'), unoBtn = $('uno-btn'),
            colorPickerModal = $('color-picker-modal'), gameBoardEl = $('game-board');
    const playerBalanceEl = $('player-balance'), startBalanceEl = $('start-balance'),
            startScreenEl = $('start-screen'), gameOverScreenEl = $('game-over-screen'),
            currentBetEl = $('current-bet'), startGameBtn = $('start-game-btn'),
            restartGameBtn = $('restart-game-btn'), betAmountInput = $('bet-amount'),
            colorOptionsEl = document.querySelector('.color-options');

    const PLAYER = 'player', BOT = 'bot';
    const DELAY = { bot: 1000, afterDraw: 750, afterColor: 1000, chain: 800 };
    const COLORS = ['red','green','blue','yellow'], VALUES = ['0','1','2','3','4','5','6','7','8','9'], ACTIONS = ['skip','reverse','plus2'];
    
    let deck = [], playerHand = [], botHand = [], discardPile = [];
    let currentPlayer = PLAYER, playerBalance = parseInt(localStorage.getItem('unoPlayerBalance') || 5000, 10);
    let currentBet = 0, unoCallTimer = null, botUnoTimer = null, unoBtnMode = '', justDrewPlayable = false;
    // prevent taking more than one card from the deck per player's turn
    let hasDrawnThisTurn = false;
    
    const setNote = t => notificationEl.textContent = t;
    const topCard = () => discardPile[discardPile.length - 1];
    const randColor = () => COLORS[Math.floor(Math.random() * COLORS.length)];
    const matchTop = (c, tc) => c.color === tc.color || c.value === tc.value;

    function getCardImageSrc(card) {
        if (card.value === 'wild') return 'assets/wild.png';
        if (card.value === 'wild_plus4') return 'assets/plus_4.png';
        return `assets/${card.color}_${card.value}.png`;
    }

    function shuffleDeck(a) {
        for (let i = a.length - 1; i > 0; i--) { const j = Math.floor(Math.random() * (i + 1)); [a[i], a[j]] = [a[j], a[i]]; }
    }

    function ensureDeck() {
        if (deck.length) return;
        const keep = discardPile.pop();
        deck = [...discardPile];
        shuffleDeck(deck);
        discardPile = [keep];
    }

    function createDeck() {
        deck = [];
        COLORS.forEach(color => {
            VALUES.forEach(value => deck.push({ color, value }));
            ACTIONS.forEach(value => deck.push({ color, value }));
        });
        deck.push({ color: 'black', value: 'wild' }, { color: 'black', value: 'wild_plus4' });
    }

    function dealCards() {
        for (let i = 0; i < 7; i++) { playerHand.push(deck.pop()); botHand.push(deck.pop()); }
        let fc = deck.pop();
        while (fc.value.includes('wild')) { deck.push(fc); shuffleDeck(deck); fc = deck.pop(); }
        discardPile.push(fc);
    }

    function updateActiveColorIndicator() {
        gameBoardEl.classList.remove('active-color-red','active-color-green','active-color-blue','active-color-yellow');
        const tc = topCard();
        if (tc && tc.color !== 'black') gameBoardEl.classList.add(`active-color-${tc.color}`);
    }

    function renderHand(container, hand, faceUp) {
        const frag = document.createDocumentFragment();
        hand.forEach(card => {
            const img = document.createElement('img');
            img.src = faceUp ? getCardImageSrc(card) : 'assets/card_back.png';
            img.className = 'card';
            if (faceUp) {
                img.dataset.color = card.color; img.dataset.value = card.value;
                if (currentPlayer === PLAYER && !isCardPlayable(card)) img.classList.add('unplayable');
            }
            frag.appendChild(img);
        });
        container.replaceChildren(frag);

        if (hand.length > 13) container.classList.add('too-many');
        else container.classList.remove('too-many');
    }

    function renderGame() {
        renderHand(playerHandEl, playerHand, true);
        renderHand(botHandEl, botHand, false);
        const img = document.createElement('img');
        img.src = getCardImageSrc(topCard());
        img.className = 'card';
        discardPileEl.replaceChildren(img);
        updateActiveColorIndicator();
    }

    function isCardPlayable(card) {
        const tc = topCard();
        if (!tc) return true;
        if (card.color === 'black') {
            if (card.value === 'wild_plus4') {
                const hasColorMatch = playerHand.some(c => c.color && c.color !== 'black' && tc.color && c.color === tc.color);
                return !hasColorMatch;
            }
            return true; // other wilds always playable
        }
        return matchTop(card, tc);
    }

    function drawCard(player, amount = 1) {
        for (let i = 0; i < amount; i++) {
            ensureDeck();
            if (!deck.length) { setNote('Kartu di deck dan discard pile habis!'); return; }
            const d = deck.pop();
            if (player === PLAYER) playerHand.push(d); else botHand.push(d);
        }
    }

    function checkWinCondition() {
        if (!playerHand.length) { endRound(PLAYER); return true; }
        if (!botHand.length) { endRound(BOT); return true; }
        return false;
    }

    function handleCardAction(card, player) {
        if (checkWinCondition()) return;

        if (unoCallTimer) clearTimeout(unoCallTimer);
        if (botUnoTimer) clearTimeout(botUnoTimer);
        unoBtn.classList.add('hidden'); unoBtnMode = '';

        if (player === PLAYER && playerHand.length === 1) {
            unoBtn.textContent = 'UNO!';
            unoBtn.classList.remove('hidden');
            unoBtnMode = 'self';
            unoCallTimer = setTimeout(() => {
                setNote('Anda lupa tekan UNO! Ambil 2 kartu.');
                drawCard(PLAYER, 2);
                unoBtn.classList.add('hidden'); unoBtnMode = '';
                renderGame();
            }, 5000);
        }

        if (player === BOT && botHand.length === 1) {
            unoBtn.textContent = 'UNO LAWAN';
            unoBtn.classList.remove('hidden');
            unoBtnMode = 'callBot';
            botUnoTimer = setTimeout(() => { unoBtn.classList.add('hidden'); unoBtnMode = ''; }, 5000);
        }

        let switchTurns = true;
        const target = player === PLAYER ? BOT : PLAYER;

        switch (card.value) {
            case 'plus2':
                drawCard(target, 2);
                setNote('Lawan diskip.');
                switchTurns = false;
                break;
            case 'skip':
            case 'reverse':
                setNote('Lawan diskip.');
                switchTurns = false;
                break;
            case 'wild':
                if (player === PLAYER) { colorPickerModal.classList.add('active'); return; }
                card.color = randColor();
                setNote(`Bot memilih warna ${card.color}.`);
                break;
            case 'wild_plus4':
                drawCard(target, 4);
                if (player === PLAYER) { colorPickerModal.classList.add('active'); return; }
                card.color = randColor();
                setNote(`Bot memilih warna ${card.color} dan Anda ambil 4 kartu!`);
                switchTurns = false;
                break;
        }

        renderGame();
        if (switchTurns) switchTurn();
        else setTimeout(() => { currentPlayer === PLAYER ? (setNote('Giliran Anda lagi!'), renderGame()) : botTurn(); }, DELAY.chain);
    }

    function switchTurn() {
        currentPlayer = currentPlayer === PLAYER ? BOT : PLAYER;
        justDrewPlayable = false;
        hasDrawnThisTurn = false;
        renderGame();
        setNote(currentPlayer === PLAYER ? 'Giliran Anda!' : 'Giliran Bot...');
        if (currentPlayer === BOT) botTurn();
    }

    function playerPlayCard(e) {
        if (currentPlayer !== PLAYER) return;
        if (!e.target.classList.contains('card') || e.target.classList.contains('unplayable')) return;
        const { color, value } = e.target.dataset;
        const i = playerHand.findIndex(c => c.color === color && c.value === value);
        if (i < 0) return;
    justDrewPlayable = false;
        const played = playerHand.splice(i, 1)[0];
        discardPile.push(played);
        handleCardAction(played, PLAYER);
    }

    function findBotPlayable(tc) {
        let i = botHand.findIndex(c => matchTop(c, tc));
        if (i === -1) i = botHand.findIndex(c => c.color === 'black' && c.value === 'wild');
        const w4 = botHand.findIndex(c => c.value === 'wild_plus4');
        if (w4 !== -1 && !botHand.some(c => matchTop(c, tc))) i = w4;
        return i;
    }

    function botTurn() {
        setNote('Giliran Bot...');
        setTimeout(() => {
            const tc = topCard();
            const idx = findBotPlayable(tc);
            if (idx !== -1) {
                const played = botHand.splice(idx, 1)[0];
                discardPile.push(played);
                handleCardAction(played, BOT);
            } else {
                drawCard(BOT);
                setNote('Bot mengambil kartu.');
                switchTurn();
            }
        }, DELAY.bot);
    }

    function endRound(winner) {
        if (winner === PLAYER) { playerBalance += currentBet; alert(`Selamat! Anda memenangkan ronde ini dan mendapat $${currentBet}.`); }
        else { playerBalance -= currentBet; alert(`Sayang sekali! Anda kalah dan kehilangan $${currentBet}.`); }

        localStorage.setItem('unoPlayerBalance', playerBalance);
        playerBalanceEl.textContent = `$${playerBalance}`;
        if (playerBalance <= 0) gameOverScreenEl.classList.add('active');
        else { startBalanceEl.textContent = `$${playerBalance}`; startScreenEl.classList.add('active'); }
    }

    function startGame() {
        // robustly parse bet input so non-numeric strings are handled
        function parseBetInput(raw) {
            if (raw === null || raw === undefined) return NaN;
            if (typeof raw === 'number' && Number.isFinite(raw)) return Math.floor(raw);
            let s = String(raw).trim();
            if (s === '') return NaN;
            // remove common non-digit characters like currency symbols, spaces, and thousand separators
            s = s.replace(/[,\s]/g, '');
            s = s.replace(/[^0-9.-]/g, '');
            // if ends up empty, it's invalid
            if (s === '' || s === '-' || s === '.' || s === '-.' ) return NaN;
            // parse as number then floor to integer dollars
            const n = Number(s);
            if (!Number.isFinite(n)) return NaN;
            return Math.floor(n);
        }

        const betValue = parseBetInput(betAmountInput.value);

        if (!Number.isFinite(betValue) || betValue < 100) {
            alert('Nilai taruhan tidak valid. Masukkan angka minimal $100 (contoh: 100 atau $200).');
            betAmountInput.focus();
            return;
        }

        if (betValue > playerBalance) {
            alert('Taruhan melebihi saldo Anda. Kurangi nilai taruhan.');
            betAmountInput.focus();
            return;
        }

        currentBet = betValue;
        currentBetEl.textContent = `$${currentBet}`;
        // normalize the input field so the user sees the sanitized number
        betAmountInput.value = String(currentBet);
        startScreenEl.classList.remove('active');

        deck = []; playerHand = []; botHand = []; discardPile = [];
        currentPlayer = PLAYER; justDrewPlayable = false; unoBtnMode = ''; 
        hasDrawnThisTurn = false;
        if (unoCallTimer) clearTimeout(unoCallTimer); if (botUnoTimer) clearTimeout(botUnoTimer);
        createDeck(); shuffleDeck(deck); dealCards(); renderGame(); setNote('Giliran Anda!');
    }

    playerHandEl.addEventListener('click', playerPlayCard);

    deckPileEl.addEventListener('click', () => {
        if (currentPlayer !== PLAYER) return;
        // If player already drew once this turn and did not get a playable card, prevent another draw
        if (hasDrawnThisTurn && !justDrewPlayable) {
            setNote('Anda sudah mengambil kartu sekali; giliran akan berakhir.');
            return;
        }
        // If player drew and the drawn card is playable, clicking deck again acts as 'pass' (end turn)
        if (justDrewPlayable) { justDrewPlayable = false; hasDrawnThisTurn = false; setNote('Lewati giliran.'); switchTurn(); return; }

        // perform draw and mark that player has drawn this turn
        hasDrawnThisTurn = true;
        drawCard(PLAYER);
        const last = playerHand[playerHand.length - 1];
        renderGame();
        if (last && isCardPlayable(last)) { justDrewPlayable = true; setNote('Kartu yang diambil bisa dimainkan. Klik kartunya untuk main. Klik deck lagi untuk melewati.'); return; }
        setNote('Anda mengambil kartu.'); setTimeout(switchTurn, DELAY.afterDraw);
    });

    unoBtn.addEventListener('click', () => {
        if (unoBtnMode === 'callBot') {
            if (botUnoTimer) clearTimeout(botUnoTimer);
            botUnoTimer = null; unoBtnMode = ''; unoBtn.classList.add('hidden');
            drawCard(BOT, 2); setNote('UNO lawan dipanggil. Bot ambil 2 kartu.'); renderGame(); return;
        }
        if (!unoCallTimer) return;
        clearTimeout(unoCallTimer); unoCallTimer = null; unoBtnMode = ''; setNote('Anda berhasil memanggil UNO!'); unoBtn.classList.add('hidden');
    });

    colorOptionsEl.addEventListener('click', e => {
        if (!e.target.classList.contains('color-box')) return;
        topCard().color = e.target.dataset.color;
        colorPickerModal.classList.remove('active');
        setNote(`Anda memilih warna ${topCard().color}.`);
        renderGame();
        if (topCard().value === 'wild_plus4') setTimeout(() => { setNote('Giliran Anda lagi!'); renderGame(); }, DELAY.afterColor);
        else setTimeout(switchTurn, DELAY.afterColor);
    });  

    startGameBtn.addEventListener('click', startGame);

    restartGameBtn.addEventListener('click', () => {
        playerBalance = 5000; localStorage.setItem('unoPlayerBalance', playerBalance);
        playerBalanceEl.textContent = startBalanceEl.textContent = `$${playerBalance}`;
        gameOverScreenEl.classList.remove('active'); startScreenEl.classList.add('active');
    });

    playerBalanceEl.textContent = startBalanceEl.textContent = `$${playerBalance}`;
});