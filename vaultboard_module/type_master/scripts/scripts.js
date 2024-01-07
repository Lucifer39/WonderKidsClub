// Array of sample texts
// const texts = [
//   "The quick brown fox jumps over the lazy dog",
//   "Sphinx of black quartz, judge my vow",
//   "Pack my box with five dozen liquor jugs",
//   "The five boxing wizards jump quickly",
//   "How vexingly quick daft zebras jump",
//   "Jaded zombies acted quaintly but kept driving their oxen forward",
//   "A wizards job is to vex chumps quickly in fog",
//   "Watch Jeopardy!, Alex Trebeks fun TV quiz game",
// ];

// Elements
const textElement = document.getElementById("text");
const inputElement = document.getElementById("input");
const timerElement = document.getElementById("timer");
const scoreElement = document.getElementById("score");
const rocketElement = document.getElementById("rocket");
const zorgonElement = document.getElementById("zorgon");
const trackElement = document.getElementById("actors");
const rocket = document.getElementById("rocket");
const zorgon = document.getElementById("zorgon-monster");
const wpmContainer = document.getElementById("wpm");
const scoreContainer = document.getElementById("score-container");

textElement.addEventListener("copy", (event) => {
  event.preventDefault();
});

let trackSegment = parseInt(
  getDistanceBetweenDivs(rocketElement, zorgonElement) / textArrayLength("words")
);
let currentSegment = 0;
console.log(trackSegment);

textElement.addEventListener("selectstart", (event) => {
  event.preventDefault();
});

inputElement.addEventListener("paste", (event) => {
  event.preventDefault();
});

function getDistanceBetweenDivs(div1, div2) {
  const rect1 = div1.getBoundingClientRect();
  const rect2 = div2.getBoundingClientRect();

  const xDistance = Math.abs(rect1.left - rect2.left);
  const yDistance = Math.abs(rect1.top - rect2.top);

  return Math.sqrt(Math.pow(xDistance, 2) + Math.pow(yDistance, 2));
}

// Variables
let currentTextIndex = 0;
let startTime,
  endTime,
  wpmTime,
  score = 0,
  wpm = 0,
  accuracy = 0,
  incorrect_chars = 0,
  count = 1;

// Set initial text
textElement.innerText = texts[currentTextIndex].sentence;

let eval_text = "";
let sound = true;
let soundIcon = document.getElementById("sound-icon");
let already_correct = "";

soundIcon.addEventListener("change", () => {
  sound = soundIcon.checked;
});

// Event listener for input element
inputElement.addEventListener("input", () => {
  const currentText = texts[currentTextIndex].sentence;

  typedText = inputElement.value;

  if (evalutaion(currentText, eval_text + typedText)) {
    const typingSound = document.getElementById("typing-sound");
    typingSound.currentTime = 1.7;
    sound && typingSound.play();
    already_correct = eval_text + typedText;

    if (typedText.endsWith(" ")) {
      inputElement.value = "";
      eval_text += typedText;
      moveRocket();
    }
  } else {
    const typingSound = document.getElementById("mistyped-sound");
    typingSound.currentTime = 1.2;
    sound && typingSound.play();
  }
});

function evalutaion(currentText, typedText) {
  if (currentText.startsWith(typedText)) {
    let wpm = calcWpm(typedText.length, wpmTime);
    wpmContainer.innerText = wpm;

    // Highlight correct text
    textElement.innerHTML = `<span class="correct">${currentText.substring(
      0,
      typedText.length
    )}</span>${currentText.substring(typedText.length)}`;

    // If typed text matches entire current text, move to next text
    if (currentText === typedText) {
      currentTextIndex++;
      if (currentTextIndex < texts.length) {
        updateSentencesLeft(++count);
        // Set new text
        textElement.innerText = texts[currentTextIndex].sentence;

        // Clear input
        inputElement.value = "";
        typedText = "";
        eval_text = "";
        wpmTime = new Date();
      } else {
        // Game over
        gameOver();
        zorgon.src = "assets/explosion.svg";
        rocket.style.display = "none";
        rocket.style.justifyContent = "space-around";
      }
    }

    return true;
  } else {
    // Highlight incorrect text

    textElement.innerHTML = `<span class="correct">${already_correct}</span><span class="incorrect">${currentText.substr(
      already_correct.length,
      typedText.length - already_correct.length
    )}</span>${currentText.substr(typedText.length)}`;

    incorrect_chars++;

    return false;
  }
}

function calcWpm(len, sTime) {
  endTime = new Date();
  const elapsedTime = (endTime - sTime) / 1000; // in seconds

  const wpm = Math.round(len / (elapsedTime / 60) / 5);

  return wpm;
}

function textArrayLength(option) {
  const text_array = texts.map((obj) => obj.sentence);
  if (option === "characters") return text_array.join(" ").length;
  else if (option === "words") return text_array.join(" ").split(" ").length;
}

function moveRocket() {
  if (currentSegment < textArrayLength("words") - 1) {
    let newPosition = ++currentSegment * trackSegment;
    rocket.style.marginLeft = `${newPosition}px`;
  } else {
  }
}

function gameOver() {
  wpm = calcWpm(textArrayLength("characters"), startTime);

  endTime = new Date();
  const elapsedTime = (endTime - startTime) / 1000;

  accuracy =
    ((textArrayLength("characters") - incorrect_chars) / textArrayLength("characters")) * 100;
  console.log(incorrect_chars);
  score = parseInt(accuracy - (elapsedTime - 100));

  document.getElementById("restart-button").disabled = false;
  document.getElementById("main-menu-button-end").disabled = false;
  startTime = null;
  scoreContainer.style.display = "block";
  textElement.style.display = "none";
  document.getElementById("input-container").style.display = "none";

  document.getElementById("time").textContent =
    `${elapsedTime / 60 > 0 ? parseInt(elapsedTime / 60) + " mins " : ""}` +
    `${parseInt(elapsedTime % 60)} secs`;
  document.getElementById("wpm-score").textContent = wpm + " wpm";
  document.getElementById("accuracy").textContent = accuracy.toFixed(2) + "%";
  document.getElementById("points").textContent = score;

  document.getElementById("restart-button").style.display = "flex";
  document.getElementById("main-menu-button-end").style.display = "flex";

  //send scores to php
  const data = { points: score, wpm, accuracy, timer: elapsedTime };

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "functions/process_score_solo.php");
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log(xhr.responseText);
    }
  };
  xhr.send(JSON.stringify(data));
}

// Event listener for restart button
document.getElementById("restart-button").addEventListener("click", () => {
  location.reload();
});

document.getElementById("main-menu-button-end").addEventListener("click", () => {
  window.location.href = "index.php";
});

// Start timer
setInterval(() => {
  if (startTime) {
    const elapsedTime = (new Date() - startTime) / 1000; // in seconds
    const minutes = Math.floor(elapsedTime / 60);
    const seconds = Math.floor(elapsedTime % 60);
    const secondsString = seconds < 10 ? `0${seconds}` : seconds;
    timerElement.innerText = `${minutes}:${secondsString}`;
  }
}, 1000);

// Start game
// document.getElementById("start-button").addEventListener("click", () => {
//   startTime = new Date();
//   wpmTime = new Date();
//   inputElement.disabled = false;
//   inputElement.focus();
// });

const countdownEl = document.getElementById("countdown-timer");

let countdown = 5;

setInterval(() => {
  countdown--;
  if (countdown >= 0) {
    countdownEl.innerHTML = countdown;
  }
  if (countdown === 0) {
    document.getElementById("countdown-timer").textContent = "Go";
    textElement.style.display = "block";
    setTimeout(() => {
      document.getElementById("countdown").style.display = "none";
      startTime = new Date();
      wpmTime = new Date();
      inputElement.disabled = false;
      inputElement.focus();
      document.getElementById("sentences-left-container").style.display = "flex";
    }, 1000);
  }
}, 1000);

function updateSentencesLeft(count_sent) {
  console.log("checkpoint");
  document.getElementById("sentences-left").textContent = `${count_sent} of ${texts.length}`;
}

updateSentencesLeft(1);
