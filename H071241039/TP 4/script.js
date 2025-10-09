let deck = [];
let playerHand = [];
let botHand = [];
let discardPile = [];
let currentColor = '';
let currentValue = '';
let isPlayerTurn = true;
let direction = 1;
let gameStarted = false;
let playerBalance = 5000;
let currentBet = 0;
let unoTimer = null;
let unoTimeLeft = 5;
let canCallUno = false;

const startButton = document.getElementById('btn-start-game');
const unoButton = document.getElementById('btn-uno');
const callUnoButton = document.getElementById('btn-call-uno');
const resetButton = document.getElementById('btn-reset');
const drawPile = document.getElementById('draw-pile');
const resultElement = document.getElementById('result');
const colorSelector = document.getElementById('color-selector');
const gameOverScreen = document.getElementById('game-over-screen');
const bettingScreen = document.getElementById('betting-screen');
const balanceDisplay = document.getElementById('balance-display');
const betDisplay = document.getElementById('bet-display');
const currentBalance = document.getElementById('current-balance');
const betAmountInput = document.getElementById('bet-amount');
const placeBetButton = document.getElementById('btn-place-bet');
const restartButton = document.getElementById('btn-restart-game');
const unoTimerElement = document.getElementById('uno-timer');
const timerCountElement = document.getElementById('timer-count');

// Inisialisasi deck UNO
function initializeDeck() {
  deck = [];
  const colors = ['red', 'blue', 'green', 'yellow'];
  const values = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'skip', 'reverse', 'plus2'];
  
  colors.forEach(color => {
    deck.push(`${color}_0`);
    for (let i = 0; i < 2; i++) {
      values.slice(1).forEach(value => {
        deck.push(`${color}_${value}`);
      });
    }
  });
  
  for (let i = 0; i < 4; i++) {
    deck.push('wild');
    deck.push('plus_4');
  }
  
  shuffleDeck();
}

function shuffleDeck() {
  for (let i = deck.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [deck[i], deck[j]] = [deck[j], deck[i]];
  }
}

function drawCard(hand, count = 1) {
  for (let i = 0; i < count; i++) {
    if (deck.length === 0) {
      const topCard = discardPile.pop();
      deck = [...discardPile];
      discardPile = [topCard];
      shuffleDeck();
    }
    if (deck.length > 0) {
      hand.push(deck.pop());
    }
  }
}

// Fungsi untuk highlight kartu yang bisa dimainkan
function highlightPlayableCards() {
  const playerCards = document.querySelectorAll('#player-cards img');
  playerCards.forEach((img, index) => {
    const card = playerHand[index];
    if (canPlayCard(card) && isValidWildFour(card, playerHand)) {
      img.classList.add('playable');
    } else {
      img.classList.remove('playable');
    }
  });
}

function displayPlayerCards() {
  const playerCardsElement = document.getElementById('player-cards');
  playerCardsElement.innerHTML = '';
  
  playerHand.forEach((card, index) => {
    const img = document.createElement('img');
    img.src = `assets/${card}.png`;
    img.alt = card;
    img.dataset.index = index;
    img.onclick = () => playCard(index);
    
    if (canPlayCard(card) && isValidWildFour(card, playerHand)) {
      img.classList.add('playable');
    }
    
    playerCardsElement.appendChild(img);
  });
  
  document.getElementById('player-card-count').textContent = playerHand.length;
  
  if (playerHand.length === 1 && isPlayerTurn) {
    startUnoTimer();
    unoButton.disabled = false;
  } else {
    stopUnoTimer();
    unoButton.disabled = true;
  }
  
  if (botHand.length === 1 && !isPlayerTurn) {
    canCallUno = true;
    callUnoButton.disabled = false;
    resultElement.innerHTML = '⚠️ Bot tinggal 1 kartu! Tekan "PANGGIL UNO!" jika bot lupa!';
  } else {
    canCallUno = false;
    callUnoButton.disabled = true;
  }
}

function displayBotCards() {
  const botCardsElement = document.getElementById('bot-cards');
  botCardsElement.innerHTML = '';
  
  botHand.forEach(() => {
    const img = document.createElement('img');
    img.src = 'assets/card_back.png';
    img.alt = 'Kartu tersembunyi';
    botCardsElement.appendChild(img);
  });
  
  document.getElementById('bot-card-count').textContent = botHand.length;
}

function updateTopCard() {
  const topCard = discardPile[discardPile.length - 1];
  document.getElementById('top-card').src = `assets/${topCard}.png`;
  
  const colorDisplay = document.getElementById('current-color');
  colorDisplay.textContent = currentColor.toUpperCase();
  colorDisplay.style.color = getColorHex(currentColor);
}

function getColorHex(color) {
  const colors = {
    red: '#E74C3C',
    blue: '#3498DB',
    green: '#2ECC71',
    yellow: '#F1C40F'
  };
  return colors[color] || 'white';
}

function canPlayCard(card) {
  if (card === 'wild' || card === 'plus_4') return true;
  
  const [cardColor, cardValue] = card.split('_');
  return cardColor === currentColor || cardValue === currentValue;
}

function isValidWildFour(card, hand) {
  if (card !== 'plus_4') return true;
  
  for (let i = 0; i < hand.length; i++) {
    if (hand[i] !== 'plus_4' && canPlayCard(hand[i])) {
      return false;
    }
  }
  return true;
}

function playCard(index) {
  if (!gameStarted || !isPlayerTurn) return;
  
  const card = playerHand[index];
  
  if (!canPlayCard(card)) {
    resultElement.textContent = '❌ Tidak dapat memainkan kartu ini!';
    setTimeout(() => resultElement.textContent = '', 2000);
    return;
  }
  
  if (card === 'plus_4' && !isValidWildFour(card, playerHand)) {
    resultElement.textContent = '❌ Wild +4 hanya bisa dimainkan jika tidak ada kartu lain!';
    setTimeout(() => resultElement.textContent = '', 2000);
    return;
  }
  
  playerHand.splice(index, 1);
  discardPile.push(card);
  
  processCardEffect(card, false);
  
  displayPlayerCards();
  updateTopCard();
  
  if (playerHand.length === 0) {
    endGame(true);
    return;
  }
  
  highlightPlayableCards();
  
  if (!colorSelector.style.display || colorSelector.style.display === 'none') {
    setTimeout(botTurn, 1000);
  }
}

function processCardEffect(card, isBot) {
  const [cardColor, cardValue] = card.split('_');
  
  if (card === 'wild' || card === 'plus_4') {
    if (isBot) {
      currentColor = chooseBestColor(botHand);
      colorSelector.style.display = 'none';
    } else {
      colorSelector.style.display = 'flex';
      return;
    }
  } else {
    currentColor = cardColor;
    currentValue = cardValue;
  }

  if (cardValue === 'skip') {
    resultElement.textContent = '⏭️ Giliran Dilewati!';
    setTimeout(() => resultElement.textContent = '', 1500);
  } else if (cardValue === 'reverse') {
    direction *= -1;
    resultElement.textContent = '🔄 Arah Dibalik!';
    setTimeout(() => resultElement.textContent = '', 1500);
  } else if (cardValue === 'plus2') {
    if (isBot) {
      drawCard(playerHand, 2);
      displayPlayerCards();
    } else {
      drawCard(botHand, 2);
      displayBotCards();
    }
    resultElement.textContent = '➕2 Ambil 2 kartu!';
    setTimeout(() => resultElement.textContent = '', 1500);
  } 
  // ✅ Perbaikan efek kartu +4
  else if (card === 'plus_4') {
    if (isBot) {
      drawCard(playerHand, 4);
      displayPlayerCards();
    } else {
      drawCard(botHand, 4);
      displayBotCards();
    }
    resultElement.textContent = '➕4 Ambil 4 kartu!';
    isPlayerTurn = !isBot;
    document.getElementById('current-turn').textContent = isPlayerTurn ? 'Pemain' : 'Bot';
  }
  
  if (cardValue !== 'skip') {
    isPlayerTurn = !isPlayerTurn;
  } else {
    isPlayerTurn = !isPlayerTurn;
    isPlayerTurn = !isPlayerTurn;
  }
  
  document.getElementById('current-turn').textContent = isPlayerTurn ? 'Pemain' : 'Bot';
}

function chooseBestColor(hand) {
  const colorCount = { red: 0, blue: 0, green: 0, yellow: 0 };
  hand.forEach(card => {
    const color = card.split('_')[0];
    if (colorCount[color] !== undefined) {
      colorCount[color]++;
    }
  });
  return Object.keys(colorCount).reduce((a, b) => 
    colorCount[a] > colorCount[b] ? a : b
  );
}

function startUnoTimer() {
  unoTimeLeft = 5;
  unoTimerElement.style.display = 'block';
  timerCountElement.textContent = unoTimeLeft;
  unoButton.disabled = false;
  
  unoTimer = setInterval(() => {
    unoTimeLeft--;
    timerCountElement.textContent = unoTimeLeft;
    
    if (unoTimeLeft <= 0) {
      drawCard(playerHand, 2);
      displayPlayerCards();
      resultElement.textContent = '➕2 Penalti lupa UNO!';
      stopUnoTimer();
      setTimeout(() => {
        isPlayerTurn = false;
        document.getElementById('current-turn').textContent = 'Bot';
        botTurn();
      }, 1500);
    }
  }, 1000);
}

function stopUnoTimer() {
  if (unoTimer) {
    clearInterval(unoTimer);
    unoTimer = null;
  }
  unoTimerElement.style.display = 'none';
}

function botTurn() {
  if (!isPlayerTurn && gameStarted) {
    resultElement.textContent = '🤖 Bot sedang berpikir...';
    
    setTimeout(() => {
      if (botHand.length === 1) {
        resultElement.textContent = '🤖 Bot bilang UNO!';
        setTimeout(() => {
          continueBotTurn();
        }, 1000);
      } else {
        continueBotTurn();
      }
    }, 1500);
  }
}

function continueBotTurn() {
  let playableIndex = -1;
  for (let i = 0; i < botHand.length; i++) {
    if (canPlayCard(botHand[i]) && isValidWildFour(botHand[i], botHand)) {
      playableIndex = i;
      break;
    }
  }
  
  if (playableIndex !== -1) {
    const card = botHand.splice(playableIndex, 1)[0];
    discardPile.push(card);
    processCardEffect(card, true);
    displayBotCards();
    updateTopCard();
    
    if (botHand.length === 0) {
      endGame(false);
      return;
    }
    
    resultElement.textContent = '🤖 Bot memainkan kartu';
    setTimeout(() => {
      resultElement.textContent = '';
      if (!isPlayerTurn) {
        botTurn();
      }
    }, 1000);
  } else {
    drawCard(botHand, 1);
    displayBotCards();
    resultElement.textContent = '🤖 Bot mengambil kartu';
    
    const newCard = botHand[botHand.length - 1];
    if (canPlayCard(newCard) && isValidWildFour(newCard, botHand)) {
      setTimeout(() => {
        botHand.pop();
        discardPile.push(newCard);
        processCardEffect(newCard, true);
        displayBotCards();
        updateTopCard();
        
        if (botHand.length === 0) {
          endGame(false);
          return;
        }
        
        resultElement.textContent = '🤖 Bot memainkan kartu yang diambil';
        setTimeout(() => {
          resultElement.textContent = '';
        }, 1000);
      }, 1500);
    } else {
      isPlayerTurn = true;
      document.getElementById('current-turn').textContent = 'Pemain';
      highlightPlayableCards();
      setTimeout(() => {
        resultElement.textContent = '';
      }, 1500);
    }
  }
}

function endGame(playerWon) {
  gameStarted = false;
  stopUnoTimer();
  
  if (playerWon) {
    playerBalance += currentBet;
    resultElement.textContent = '🎉 ANDA MENANG! 🎉 +$' + currentBet;
  } else {
    playerBalance -= currentBet;
    resultElement.textContent = '😢 BOT MENANG! 😢 -$' + currentBet;
  }
  
  updateBalanceDisplay();
  
  startButton.textContent = 'MAIN LAGI';
  startButton.disabled = false;
  unoButton.disabled = true;
  callUnoButton.disabled = true;
  
  if (playerBalance <= 0) {
    setTimeout(() => {
      gameOverScreen.style.display = 'flex';
    }, 2000);
  }
}

function updateBalanceDisplay() {
  balanceDisplay.textContent = playerBalance;
  currentBalance.textContent = playerBalance;
  betDisplay.textContent = currentBet;
}

function startBetting() {
  bettingScreen.style.display = 'flex';
  betAmountInput.max = playerBalance;
  betAmountInput.value = Math.min(100, playerBalance);
}

startButton.addEventListener('click', () => {
  if (playerBalance <= 0) {
    playerBalance = 5000;
    updateBalanceDisplay();
  }
  startBetting();
});

placeBetButton.addEventListener('click', () => {
  const betAmount = parseInt(betAmountInput.value);
  
  if (betAmount < 100 || betAmount > playerBalance) {
    resultElement.textContent = '❌ Taruhan tidak valid!';
    setTimeout(() => resultElement.textContent = '', 2000);
    return;
  }
  
  currentBet = betAmount;
  bettingScreen.style.display = 'none';
  
  initializeDeck();
  playerHand = [];
  botHand = [];
  discardPile = [];
  isPlayerTurn = true;
  direction = 1;
  gameStarted = true;
  resultElement.textContent = '';
  
  drawCard(playerHand, 7);
  drawCard(botHand, 7);
  
  do {
    drawCard(discardPile, 1);
  } while (discardPile[0].includes('skip') || discardPile[0].includes('reverse') || 
           discardPile[0].includes('plus') || discardPile[0].includes('wild'));
  
  const [color, value] = discardPile[0].split('_');
  currentColor = color;
  currentValue = value;
  
  displayPlayerCards();
  displayBotCards();
  updateTopCard();
  updateBalanceDisplay();
  
  startButton.disabled = true;
  document.getElementById('current-turn').textContent = 'Pemain';
});

drawPile.addEventListener('click', () => {
  if (gameStarted && isPlayerTurn) {
    drawCard(playerHand, 1);
    displayPlayerCards();
    resultElement.textContent = '📥 Anda mengambil kartu';
    
    const drawnCard = playerHand[playerHand.length - 1];
    if (canPlayCard(drawnCard)) {
      resultElement.textContent += ' - Anda bisa memainkannya!';
      highlightPlayableCards();
    } else {
      setTimeout(() => {
        isPlayerTurn = false;
        document.getElementById('current-turn').textContent = 'Bot';
        resultElement.textContent = '';
        botTurn();
      }, 1500);
    }
  }
});

unoButton.addEventListener('click', () => {
  resultElement.textContent = '🎯 UNO! Tinggal satu kartu!';
  setTimeout(() => resultElement.textContent = '', 2000);
  unoButton.disabled = true;
  stopUnoTimer();
});

callUnoButton.addEventListener('click', () => {
  if (canCallUno && botHand.length === 1 && !isPlayerTurn) {
    drawCard(botHand, 2);
    displayBotCards();
    resultElement.textContent = '🎯 Bot kena penalti UNO! +2 kartu';
    callUnoButton.disabled = true;
    canCallUno = false;
    
    setTimeout(() => {
      botTurn();
    }, 1500);
  }
});

document.querySelectorAll('.color-selector button').forEach(button => {
  button.addEventListener('click', () => {
    currentColor = button.dataset.color;
    colorSelector.style.display = 'none';
    updateTopCard();
    
    setTimeout(() => {
      isPlayerTurn = false;
      document.getElementById('current-turn').textContent = 'Bot';
      botTurn();
    }, 1000);
  });
});

document.querySelectorAll('.bet-quick').forEach(button => {
  button.addEventListener('click', () => {
    betAmountInput.value = button.dataset.amount;
  });
});

restartButton.addEventListener('click', () => {
  playerBalance = 5000;
  currentBet = 0;
  gameOverScreen.style.display = 'none';
  updateBalanceDisplay();
  startButton.disabled = false;
});

resetButton.addEventListener('click', () => {
  location.reload();
});

window.onload = () => {
  startButton.disabled = false;
  unoButton.disabled = true;
  callUnoButton.disabled = true;
  updateBalanceDisplay();
};