const startScreen = document.getElementById("start-screen");
const gameScreen = document.getElementById("game-screen");
const gameOverScreen = document.getElementById("game-over-screen");
const colorPicker = document.getElementById("color-picker");
const startButton = document.getElementById("start-button");
const restartButton = document.getElementById("restart-button");
const unoButton = document.getElementById("uno-button");
const callUnoButton = document.getElementById("call-uno-button");
const deckElement = document.getElementById("deck");
const playerHandElement = document.getElementById("player-hand");
const botHandElement = document.getElementById("bot-hand");
const discardPileElement = document.getElementById("discard-pile");
const balanceDisplay = document.getElementById("balance-display");
const playerBalanceIngame = document.getElementById("player-balance-ingame");
const botCardCount = document.getElementById("bot-card-count");
const passButton = document.getElementById("pass-button");

const turnIndicatorContainer = document.getElementById("turn-indicator-container");
const turnIndicator = document.getElementById("turn-indicator");
const turnIndicatorText = document.getElementById("turn-indicator-text");

const errorPopup = document.getElementById("error-popup");
const errorTitle = document.getElementById("error-title");
const errorMessage = document.getElementById("error-message");
const errorOkButton = document.getElementById("error-ok-button");

let deck = [], playerHand = [], botHand = [], discardPile = [];
let playerBalance = 5000, currentBet = 0, isPlayerTurn = true;
let unoPenaltyTimeout, botUnoChallengeTimeout;
let playerHasDrawn = false;


// FUNGSI UTAMA GAME


function createDeck() {
  const colors = ["Red", "Green", "Blue", "Yellow"];
  const values = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "Skip", "Reverse", "Draw Two"];
  deck = [];

  colors.forEach(color => {
    values.forEach(value => {
      let filename = value.toLowerCase().replace(" ", "");
      if (value === "Draw Two") filename = "plus2";
      const card = { color, value, image: `asset/${color.toLowerCase()}_${filename}.png` };
      deck.push(card);
    });
  });

  for (let i = 0; i < 4; i++) {
    deck.push({ color: "Wild", value: "Wild", image: "asset/wild.png" });
    deck.push({ color: "Wild", value: "Wild Draw Four", image: "asset/plus_4.png" });
  }
}

function shuffleDeck() {
  for (let i = deck.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [deck[i], deck[j]] = [deck[j], deck[i]];
  }
}

function showPopupMessage(title, message) {
  errorTitle.textContent = title;
  errorMessage.textContent = message;
  errorPopup.classList.remove("hidden");
}

function startGame() {
  const betAmount = parseInt(document.getElementById("bet-input").value);
  if (isNaN(betAmount) || betAmount < 100 || betAmount > playerBalance) {
    showPopupMessage("TARUHAN TIDAK VALID", "Taruhan harus di antara $100 dan saldo yang Anda miliki.");
    return;
  }
  
  currentBet = betAmount;
  playerBalance -= currentBet;
  
  createDeck();
  shuffleDeck();
  
  playerHand = [];
  botHand = [];
  for (let i = 0; i < 7; i++) {
    if (deck.length > 0) playerHand.push(deck.pop());
    if (deck.length > 0) botHand.push(deck.pop());
  }
  
  discardPile = [];
  let firstCard = deck.pop();
  while (firstCard.color === "Wild") {
    deck.push(firstCard);
    shuffleDeck();
    firstCard = deck.pop();
  }
  discardPile.push(firstCard);
  
  startScreen.classList.add("hidden");
  gameOverScreen.classList.add("hidden");
  gameScreen.classList.remove("hidden");
  
  isPlayerTurn = true;
  playerHasDrawn = false;
  renderGame();
  setTimeout(showTurnIndicator, 1000);
}


// UNTUK TAMPILAN 


function renderGame() {
  renderPlayerHand();
  renderBotHand();
  renderDiscardPile();
  updateHUD();
}

function renderPlayerHand() {
  playerHandElement.innerHTML = "";
  const totalCards = playerHand.length;
  const cardSpacing = 40; 
  const totalWidthOfCards = (totalCards - 1) * cardSpacing + 112; 
  const startLeft = (playerHandElement.clientWidth - totalWidthOfCards) / 2;

  playerHand.forEach((card, i) => {
    const cardElement = createCardElement(card);
    cardElement.style.left = `${startLeft + i * cardSpacing}px`;
    cardElement.style.bottom = "20px";
    const rotation = (i - Math.floor(totalCards / 2)) * 4;
    cardElement.style.transform = `rotate(${rotation}deg)`;
    cardElement.addEventListener("click", () => playCard(i));
    playerHandElement.appendChild(cardElement);
  });
}

function renderBotHand() {
  botHandElement.innerHTML = "";
  botCardCount.textContent = botHand.length;
  const totalCards = botHand.length;
  const cardSpacing = 40;
  const totalWidthOfCards = (totalCards - 1) * cardSpacing + 112;
  const startLeft = (botHandElement.clientWidth - totalWidthOfCards) / 2;

  botHand.forEach((_, i) => {
    const cardElement = createCardElement({ back: true });
    cardElement.style.left = `${startLeft + i * cardSpacing}px`;
    cardElement.style.top = "20px";
    const rotation = (i - Math.floor(totalCards / 2)) * 4;
    cardElement.style.transform = `rotate(${rotation}deg)`;
    botHandElement.appendChild(cardElement);
  });
}

function createCardElement(card) {
  const cardImg = document.createElement("img");
  cardImg.className = "card";
  cardImg.src = card.back ? "asset/card_back.png" : card.image;
  cardImg.alt = card.back ? "Kartu Belakang" : `${card.color} ${card.value}`;
  return cardImg;
}

function renderDiscardPile() {
  discardPileElement.innerHTML = "";
  const topCard = discardPile[discardPile.length - 1];
  if (topCard) {
    const cardElement = createCardElement(topCard);
    discardPileElement.appendChild(cardElement);
    const colorMap = { "Red": "#ff0000", "Green": "#00ff00", "Blue": "#0088ff", "Yellow": "#ffff00" };
    discardPileElement.style.boxShadow = topCard.color !== "Wild" ? `0 0 25px 5px ${colorMap[topCard.color]}` : "none";
  }
}

function updateHUD() {
  balanceDisplay.textContent = `$${playerBalance + currentBet}`;
  playerBalanceIngame.textContent = `$${playerBalance}`;
}

function showTurnIndicator() {
  turnIndicatorText.textContent = isPlayerTurn ? "YOUR TURN" : "RIVAL'S TURN";
  
  turnIndicatorContainer.classList.remove("hidden");
  turnIndicator.classList.add("animate-turn-slide");

  setTimeout(() => {
    turnIndicatorContainer.classList.add("hidden");
    turnIndicator.classList.remove("animate-turn-slide");
  }, 1500);
}


// LOGIKA UTAMA PERMAINAN & GILIRAN


function switchTurn(nextTurnIsPlayer) {
  isPlayerTurn = nextTurnIsPlayer;
  playerHasDrawn = false;
  passButton.classList.add("hidden");
  showTurnIndicator();
  if (!isPlayerTurn) {
    setTimeout(botTurn, 2000);
  }
}

function playCard(cardIndex) {
  if (!isPlayerTurn) return;
  const card = playerHand[cardIndex];
  const topCard = discardPile[discardPile.length - 1];

  if (isValidMove(card, topCard)) {
    playerHasDrawn = false;
    passButton.classList.add("hidden");
    clearTimeout(unoPenaltyTimeout);
    clearTimeout(botUnoChallengeTimeout);
    unoButton.classList.add("hidden");
    callUnoButton.classList.add("hidden");
    
    discardPile.push(playerHand.splice(cardIndex, 1)[0]);
    renderGame();
    
    if (playerHand.length === 0) {
      endRound("player");
      return;
    }
    if (playerHand.length === 1) {
      showUnoButton();
    }
    handleCardEffect(card, "player");
  } else {
    const cardElement = playerHandElement.children[cardIndex];
    if(cardElement) {
        cardElement.classList.add("animate-shake");
        setTimeout(() => cardElement.classList.remove("animate-shake"), 500);
    }
  }
}

function isValidMove(card, topCard) {
  if (card.color === "Wild" || card.color === topCard.color || card.value === topCard.value) {
    if (card.value === "Wild Draw Four") {
      const handToCheck = isPlayerTurn ? playerHand : botHand;
      const hasPlayableCard = handToCheck.some(c => 
        c.value !== "Wild Draw Four" && 
        (c.color === topCard.color || c.value === topCard.value || c.value === "Wild")
      );
      return !hasPlayableCard;
    }
    return true;
  }
  return false;
}

function botTurn() {
  const topCard = discardPile[discardPile.length - 1];
  let cardToPlayIndex = -1;

  for (let i = 0; i < botHand.length; i++) {
    if (isValidMove(botHand[i], topCard)) {
      cardToPlayIndex = i;
      break;
    }
  }

  if (cardToPlayIndex !== -1) {
    const card = botHand.splice(cardToPlayIndex, 1)[0];
    discardPile.push(card);
    renderGame();
    if (botHand.length === 0) {
      endRound("bot");
      return;
    }
    
    if (botHand.length === 1) {
      const randomDelay = Math.floor(Math.random() * 2001) + 1000;
      
      callUnoButton.classList.remove("hidden");
      botUnoChallengeTimeout = setTimeout(() => {
        callUnoButton.classList.add("hidden");
      }, randomDelay);
    }
    handleCardEffect(card, "bot");
  } else {
    if (deck.length > 0) botHand.push(deck.pop());
    renderGame();
    switchTurn(true);
  }
}

function handleCardEffect(card, player) {
  const isPlayer = player === "player";

  const applyDraw = (amount) => {
    const targetHand = isPlayer ? botHand : playerHand;
    for (let i = 0; i < amount; i++) {
      if (deck.length > 0) targetHand.push(deck.pop());
    }
  };

  const handleWildChoice = () => {
    if (isPlayer) {
      colorPicker.classList.remove("hidden");
    } else {
      const colors = ["Red", "Green", "Blue", "Yellow"];
      const randomColor = colors[Math.floor(Math.random() * 4)];
      discardPile[discardPile.length - 1].color = randomColor;
      renderGame();
      switchTurn(true);
    }
  };

  switch (card.value) {
    case "Skip":
    case "Reverse":
      isPlayer ? switchTurn(true) : setTimeout(botTurn, 1500);
      break;
    case "Draw Two":
      applyDraw(2);
      isPlayer ? switchTurn(true) : setTimeout(botTurn, 1500);
      break;
    case "Wild Draw Four":
      applyDraw(4);
      handleWildChoice();
      break;
    case "Wild":
      handleWildChoice();
      break;
    default:
      switchTurn(!isPlayer);
      break;
  }
}


// UNTUK AKSI PEMAIN


deckElement.addEventListener("click", () => {
  if (!isPlayerTurn || playerHasDrawn) return;

  clearTimeout(botUnoChallengeTimeout);
  callUnoButton.classList.add("hidden");

  if (deck.length === 0) { return; }
  
  const drawnCard = deck.pop();
  playerHand.push(drawnCard);
  playerHasDrawn = true;
  renderGame();

  const topCard = discardPile[discardPile.length - 1];
  if (!isValidMove(drawnCard, topCard)) {
    setTimeout(() => switchTurn(false), 1000);
  } else {
    passButton.classList.remove("hidden");
  }
});

passButton.addEventListener("click", () => {
  if (isPlayerTurn && playerHasDrawn) {
    switchTurn(false);
  }
});

document.querySelectorAll(".color-choice").forEach(button => {
  button.addEventListener("click", () => {
    const newColor = button.getAttribute("data-color");
    discardPile[discardPile.length - 1].color = newColor;
    colorPicker.classList.add("hidden");
    renderGame();
    switchTurn(false);
  });
});

unoButton.addEventListener("click", () => {
  clearTimeout(unoPenaltyTimeout);
  unoButton.classList.add("hidden");
});

callUnoButton.addEventListener("click", () => {
  clearTimeout(botUnoChallengeTimeout);
  callUnoButton.classList.add("hidden");
  showPopupMessage("BERHASIL!", "Anda berhasil menangkap lawan! Lawan mengambil 2 kartu penalti.");

  if (deck.length > 1) {
    botHand.push(deck.pop(), deck.pop());
  } else if (deck.length === 1) {
    botHand.push(deck.pop());
  }
  renderGame();
});

function showUnoButton() {
  unoButton.classList.remove("hidden");
  unoPenaltyTimeout = setTimeout(() => {
    showPopupMessage("PENALTI UNO!", "Anda terlambat menekan UNO! Ambil 2 kartu penalti.");
    
    if (deck.length > 1) {
      playerHand.push(deck.pop(), deck.pop());
    } else if (deck.length === 1) {
      playerHand.push(deck.pop());
    }
    
    unoButton.classList.add("hidden");
    renderGame();
  }, 5000);
}


// AKHIR PERMAINAN (ENDGAME)


function endRound(winner) {
  const roundOverPopup = document.getElementById("round-over-popup");
  const popupTitle = document.getElementById("popup-title");
  const popupMessage = document.getElementById("popup-message");
  const continueButton = document.getElementById("popup-continue-button");

  if (winner === "player") {
    popupTitle.textContent = "YOU WIN!";
    popupTitle.style.color = "#00ff00";
    popupMessage.textContent = `You won $${currentBet * 2}`;
    playerBalance += currentBet * 2;
  } else {
    popupTitle.textContent = "YOU LOSE";
    popupTitle.style.color = "#ff0000";
    popupMessage.textContent = "Better luck next time...";
  }

  roundOverPopup.classList.remove("hidden");

  continueButton.onclick = () => {
    roundOverPopup.classList.add("hidden");
    if (playerBalance <= 0) {
      gameScreen.classList.add("hidden");
      gameOverScreen.classList.remove("hidden");
    } else {
      gameScreen.classList.add("hidden");
      startScreen.classList.remove("hidden");
      balanceDisplay.textContent = `$${playerBalance}`;
    }
  };
}

function restartGame() {
  playerBalance = 5000;
  gameOverScreen.classList.add("hidden");
  startScreen.classList.remove("hidden");
  balanceDisplay.textContent = `$${playerBalance}`;
}

errorOkButton.addEventListener("click", () => {
  errorPopup.classList.add("hidden");
});

startButton.addEventListener("click", startGame);
restartButton.addEventListener("click", restartGame);