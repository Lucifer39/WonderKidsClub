// Congratulating Quotes Array
const congratulatingQuotes = [
  "You did it! Congratulations!",
  "Amazing job! Keep it up!",
  "Well done! You're a superstar!",
  "Hooray! You nailed it!",
  "Fantastic work! Keep practicing!",
  "Excellent! You're making progress!",
  "Bravo! You're getting better and better!",
  "Great job! You should be proud of yourself!",
  "Incredible! You're on fire!",
  "Awesome work! You're a champ!",
];

// Try Again Quotes Array
const tryAgainQuotes = [
  "Don't give up! Keep trying!",
  "Mistakes happen. Try again!",
  "Take a deep breath and try again!",
  "It's okay to fail. Try again!",
  "Believe in yourself and try again!",
  "Never give up! Keep trying!",
  "Keep going! You got this!",
  "Failure is a part of learning. Try again!",
  "You can do it! Try again!",
  "Try again and show yourself what you're capable of!",
];

// Get HTML elements
const errorTextElement = document.getElementById("dtext");
const groupNameElement = document.getElementById("group-name");
const skillNameElement = document.getElementById("skill-name");
const motivationalTextElement = document.getElementById("motivational-text");
const combinationsElement = document.getElementById("combinations");
const inputBoxElement = document.getElementById("input-box");

let currentTextIndex = 0;
let startTime,
  endTime,
  accuracy = 0,
  incorrect_chars = 0,
  count_stats = 1,
  wpm = 0,
  wpmTime;

// Set data to HTML elements
// groupNameElement.textContent = data.group_name;
skillNameElement.classList.add("fw-bold");
skillNameElement.textContent = data.skill_name;
// motivationalTextElement.textContent = data.p_text;

// Split the combinations string by spaces
var combinationsArray = data.combinations
  .split(" ")
  .filter((word) => word !== "")
  .join(" ")
  .split(" ");
shuffleArray(combinationsArray);
var shuffledCombinations = combinationsArray.join(" ");

// Function to shuffle an array using the Fisher-Yates algorithm
function shuffleArray(array) {
  for (var i = array.length - 1; i > 0; i--) {
    var j = Math.floor(Math.random() * (i + 1));
    var temp = array[i];
    array[i] = array[j];
    array[j] = temp;
  }
}

var displayedCharacters = shuffledCombinations;

if (group_name == "Record Level") {
  // Get the first 32 characters from shuffledCombinations
  displayedCharacters = shuffledCombinations.substring(0, 32);

  // Check if the last character is not a space
  if (displayedCharacters.charAt(31) !== " ") {
    // Find the last space in the displayedCharacters
    var lastSpaceIndex = displayedCharacters.lastIndexOf(" ");
    // Trim the displayedCharacters to end at the last space
    displayedCharacters = displayedCharacters.substring(0, lastSpaceIndex);
  }
}

combinationsElement.textContent = displayedCharacters;

// Initialize game
let currentPosition = 0;
let eval_t = "";

let sound = true;
let soundIcon = document.getElementById("sound-icon");
let already_correct = "";

soundIcon.addEventListener("change", () => {
  sound = soundIcon.checked;
});

inputBoxElement.addEventListener("input", (e) => {
  var inputValue = e.target.value;
  console.log(eval_text);

  var eval_text = eval_t + inputValue;
  evalutaion(displayedCharacters, eval_text);

  if (eval_text[currentPosition] === displayedCharacters[currentPosition]) {
    if (inputValue.slice(-1) == " ") {
      inputBoxElement.value = "";
      eval_t = eval_t + inputValue;
      inputValue = "";
    }

    currentPosition++;
    e.target.style.borderColor = "";

    const typingSound = document.getElementById("typing-sound");
    typingSound.currentTime = 1.7;
    sound && typingSound.play();
    already_correct = eval_text;

    if (currentPosition === displayedCharacters.length && isGetIDEmpty == true) {
      e.target.disabled = true;
      combinationsElement.style.backgroundColor = "#4caf50";
      login_modal(randomElement(congratulatingQuotes));
    } else if (currentPosition === displayedCharacters.length) {
      e.target.disabled = true;
      combinationsElement.style.backgroundColor = "#4caf50";
      populate_modal(randomElement(congratulatingQuotes), true);
    }
  } else {
    e.target.style.borderColor = "red";
    const typingSound = document.getElementById("mistyped-sound");
    typingSound.currentTime = 1.2;
    sound && typingSound.play();
  }
});

function randomElement(arr) {
  const randomIndex = Math.floor(Math.random() * arr.length);
  const randomElement = arr[randomIndex];

  return randomElement;
}

function login_modal(header) {
  const modal_header = document.getElementById("modal-header");
  modal_header.classList.add("h4");
  const modal_buttons = document.getElementById("modal-buttons");
  document.getElementById("modal").style.display = "flex";

  modal_header.textContent = header;

  const additionalText = document.createElement("h5");
  additionalText.classList.add("text-center", "text-success");
  additionalText.textContent = "If You want to Continue please Login!";
  modal_header.appendChild(additionalText);

  const metricsText = document.createElement("h4");
  metricsText.classList.add("text-center", "text-danger", "mt-2");
  metricsText.setAttribute("id", "speed");
  metricsText.textContent = "Your speed: " + wpm + " WPM";
  // additionalText.textContent = "If You want to Continue please Login!";
  modal_header.appendChild(metricsText);

  const anchorMainMenu = document.createElement("a");
  const mainMenuBtn = document.createElement("button");
  mainMenuBtn.classList.add("levelmodalbutton", "me-4");
  anchorMainMenu.href = "index.php";
  mainMenuBtn.textContent = "Main Menu";
  anchorMainMenu.appendChild(mainMenuBtn);
  modal_buttons.appendChild(anchorMainMenu);

  const anchorLogin = document.createElement("a");
  const loginbtn = document.createElement("button");
  loginbtn.classList.add("levelmodalbutton");
  loginbtn.textContent = "Login To Continue";
  anchorLogin.appendChild(loginbtn);
  modal_buttons.appendChild(anchorLogin);

  loginbtn.addEventListener("click", function () {
    $("#loginModal").modal("show");
  });
}

function populate_modal(header, success) {
  const modal_header = document.getElementById("modal-header");
  modal_header.classList.add("h4");
  const modal_buttons = document.getElementById("modal-buttons");
  document.getElementById("modal").style.display = "flex";

  modal_header.textContent = header;

  if (group_name == "Record Level") {
    const additionalText = document.createElement("h4");
    additionalText.classList.add("text-center", "text-success", "mt-2");
    additionalText.setAttribute("id", "speed");
    additionalText.textContent = "Your speed: " + wpm + " WPM";
    // additionalText.textContent = "If You want to Continue please Login!";
    modal_header.appendChild(additionalText);
  }

  const anchorMainMenu = document.createElement("a");
  const mainMenuBtn = document.createElement("button");
  mainMenuBtn.classList.add("levelmodalbutton", "me-3");
  anchorMainMenu.href = "index.php";
  mainMenuBtn.textContent = "Main Menu";
  anchorMainMenu.appendChild(mainMenuBtn);
  modal_buttons.appendChild(anchorMainMenu);

  const anchorRestart = document.createElement("a");
  const restartbtn = document.createElement("button");
  restartbtn.classList.add("levelmodalbutton", "me-3");
  anchorRestart.href = `index.php?page=play&group_id=${group_id}`;
  restartbtn.textContent = "Restart";
  anchorRestart.appendChild(restartbtn);
  modal_buttons.appendChild(anchorRestart);

  if (success) {
    $.ajax({
      type: "POST",
      url: "functions/play_functions.php?function_name=make_complete",
      data: {
        student_id: student.id,
        group_id,
      },
      success: function (res) {
        var response = JSON.parse(res);

        $.ajax({
          type: "POST",
          url: "functions/play_functions.php?function_name=make_ongoing",
          data: {
            student_id: student.id,
            group_id: response,
          },
        });

        if (res !== "not success" && res !== "") {
          const anchorNext = document.createElement("a");
          const nextbtn = document.createElement("button");
          nextbtn.classList.add("levelmodalbutton");
          anchorNext.href = `index.php?page=play&group_id=${response}`;
          nextbtn.textContent = "Next";
          anchorNext.appendChild(nextbtn);
          modal_buttons.appendChild(anchorNext);
        }
      },
    });
  }
}

let counter = 0;

// Check sessionStorage for counter value
const storedCounter = sessionStorage.getItem("counter");
if (storedCounter) {
  counter = parseInt(storedCounter);
}

// Update sessionStorage with counter value
function updateCounter() {
  sessionStorage.setItem("counter", counter.toString());
}

// Display error message and remove after a few seconds
function showError() {
  errorTextElement.innerHTML =
    '<i class="bi bi-x-circle-fill text-white align-middle"></i> Check for the wrong character';
  errorTextElement.style.display = "block";
  errorTextElement.classList.add("show");

  setTimeout(function () {
    errorTextElement.classList.remove("show");
    setTimeout(function () {
      errorTextElement.style.display = "none";
    }, 500);
  }, 2000);
}

function evalutaion(currentText, typedText) {
  if (currentText.startsWith(typedText)) {
    combinationsElement.innerHTML = `<span class="correct">${currentText.substring(
      0,
      typedText.length
    )}</span>${currentText.substring(typedText.length)}`;

    if ((currentText = typedText)) new Date();
    gameover();

    return true;
  } else {
    // Highlight incorrect text
    combinationsElement.innerHTML = `<span class="correct">${already_correct}</span><span class="incorrect">${currentText.substr(
      already_correct.length,
      typedText.length - already_correct.length
    )}</span>${currentText.substr(typedText.length)}`;

    if (!errorTextElement.classList.contains("show")) {
      showError();
      counter++;
      updateCounter();
    }
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
  const text_array = data.combinations;
  if (option === "characters") return text_array.length;
}

function gameover() {
  wpm = calcWpm(textArrayLength("characters"), startTime);
  accuracy = ((textArrayLength("characters") - counter) / textArrayLength("characters")) * 100;
  // console.log("acc: "+accuracy);
  console.log("wpm: " + wpm);
  // const speedElement = document.getElementById("speed");
  // if (speedElement) {
  //   speedElement.textContent = "Your speed: " + wpm + " WPM";
  // }
}

let countdown = 2;

// Start timer
// setInterval(() => {
//   if (startTime) {
//     const elapsedTime = (new Date() - startTime) / 1000; // in seconds
//     const minutes = Math.floor(elapsedTime / 60);
//     const seconds = Math.floor(elapsedTime % 60);
//     const secondsString = seconds < 10 ? `0${seconds}` : seconds;
//   }
// }, 1000);

setInterval(() => {
  countdown--;
  if (countdown >= 0) {
    // countdownEl.innerHTML = countdown;
  }
  if (countdown === 0) {
    setTimeout(() => {
      // document.getElementById("countdown").style.display = "none";
      startTime = new Date();
      wpmTime = new Date();
    }, 1000);
  }
}, 1000);

// Check sessionStorage on page load
window.addEventListener("DOMContentLoaded", () => {
  const storedCounter = sessionStorage.getItem("counter");
  if (storedCounter && parseInt(storedCounter) > 0) {
    errorTextElement.style.display = "block";
    counter = 0; // Reset counter to 0
    updateCounter(); // Update sessionStorage with counter value
  } else {
    errorTextElement.style.display = "none";
    counter = 0; // Reset counter to 0
    updateCounter(); // Update sessionStorage with counter value
  }
});
