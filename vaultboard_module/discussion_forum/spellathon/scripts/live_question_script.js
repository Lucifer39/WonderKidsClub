// var question_obj = ["dictation", "jumble", "guess"];

var current_question_index = 0;
const MAX_QUESTION_NUMBER = 10;
var start_timer = 5;
var question_timer = 30;
let intervalId;
let questionIntervalId;
let score = 0;
const MIN_STEP_SCORE = 5;

const questionContainer = document.getElementById("question-container");
const answerContainer = document.getElementById("answer-input");
const submitBtn = document.getElementById("submit-btn");
const nextBtn = document.getElementById("next-btn");
const messageContainer = document.getElementById("message-container");
const modalTitle = document.getElementById("modal-title-live-quiz");
const modalBody = document.getElementById("modal-body-live-quiz");
const modalContainer = document.getElementById("modal-container");
const timerDiv = document.getElementById("timer");

function populateQuestion() {
  questionContainer.innerHTML = "";
  messageContainer.style.display = "none";
  document.getElementById("input-group").style.display = "flex";
  answerContainer.value = "";
  modalContainer.style.display = "none";
  question_timer = 30;

  questionIntervalId = setInterval(setQuestionTimer, 1000);

  if (data[current_question_index].question_type == "dictation") {
    var word = data[current_question_index];
    populateDictation(word.content);
  } else if (data[current_question_index].question_type == "jumble") {
    var word = data[current_question_index];
    populateJumble(word.content.toLowerCase());
  } else if (data[current_question_index].question_type == "guess") {
    var word = data[current_question_index];
    populateGuess(word);
  }
}

function setQuestionTimer() {
  if (question_timer >= 0) {
    timerDiv.textContent = `00 : ${(question_timer + "").padStart(2, "0")}`;
    question_timer--;
  } else {
    current_question_index++;
    clearInterval(questionIntervalId);

    if (current_question_index < MAX_QUESTION_NUMBER) {
      populateQuestion();
    } else {
      $.ajax({
        type: "post",
        url: "functions/live_quiz_functions.php?function_name=set_score",
        data: {
          room_id,
          student_id: current_student.id,
          score,
        },
        success: function (res) {
          window.onbeforeunload = null;
          window.location.href = `index.php?page=leaderboard_page&ri=${room_id}`;
        },
      });
    }
  }
}

function gameStart() {
  if (start_timer >= 0) {
    populateModal("Game starting in", start_timer);
    start_timer--;
  } else {
    clearInterval(intervalId);
    populateQuestion();
  }
}

intervalId = setInterval(gameStart, 1000);

function populateModal(modalTitleContent, modalBodyContent) {
  modalContainer.style.display = "flex";
  modalBody.textContent = modalBodyContent;
  modalTitle.textContent = modalTitleContent;
}

function populateGuess(word) {
  const topicQuestion = document.createElement("div");
  const guessQuestion = document.createElement("div");
  const hintQuestion = document.createElement("div");

  topicQuestion.textContent = "Guess the word from the given clue";
  topicQuestion.className = "question-text";

  guessQuestion.textContent = word.meaning;
  guessQuestion.className = "content-text";

  hintQuestion.textContent = `Hint: The word contains ${word.content.length} letters.`;
  hintQuestion.className = "hint-text";

  questionContainer.appendChild(topicQuestion);
  questionContainer.appendChild(guessQuestion);
  questionContainer.appendChild(hintQuestion);
}

function populateJumble(word) {
  const topicQuestion = document.createElement("div");
  const jumbledQuestion = document.createElement("div");

  jumbledQuestion.textContent = scrambleWord(word);
  jumbledQuestion.className = "content-text";
  topicQuestion.textContent = "Unscramble the given letters";
  topicQuestion.className = "question-text";

  questionContainer.appendChild(topicQuestion);
  questionContainer.appendChild(jumbledQuestion);
}

function scrambleWord(word) {
  // Convert the word into an array of characters
  const characters = word.split("");

  // Function to shuffle an array using Fisher-Yates (Knuth) algorithm
  function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
    }
  }

  // Shuffle the array of characters
  let scrambledWord = characters.join("");
  while (scrambledWord === word) {
    shuffleArray(characters);
    scrambledWord = characters.join("");
  }

  return scrambledWord;
}

function populateDictation(word) {
  console.log("dictation");
  const imgSpeak = document.createElement("i");
  const buttonSpeak = document.createElement("button");

  imgSpeak.className = "bi bi-volume-up";
  buttonSpeak.appendChild(imgSpeak);
  buttonSpeak.addEventListener("click", () => speak(word));

  buttonSpeak.className = "speak-text";

  questionContainer.appendChild(buttonSpeak);
}

function speak(question) {
  if ("speechSynthesis" in window) {
    const utterance = new SpeechSynthesisUtterance(question);

    // Set additional properties (optional)
    utterance.lang = "en-US"; // Language code for English (United States)
    utterance.pitch = 1.0; // Speech pitch (0 to 2, 1.0 is normal)
    utterance.rate = 1.0; // Speaking rate (0.1 to 10, 1.0 is normal)
    utterance.volume = 1.0; // Volume (0 to 1, 1.0 is full volume)

    // Event listeners (optional)
    utterance.onstart = function (event) {
      console.log("Speech started");
    };

    utterance.onend = function (event) {
      console.log("Speech ended");
    };

    utterance.onerror = function (event) {
      console.error("Speech error occurred:", event.error);
    };

    // Start speaking
    speechSynthesis.speak(utterance);
  } else {
    alert(
      "Text-to-speech is not supported in this browser. Please use a modern browser that supports the Web Speech API."
    );
  }
}

// nextBtn.addEventListener("click", () => {
//   current_question_index++;

//   if (current_question_index < MAX_QUESTION_NUMBER) {
//     populateQuestion();
//   } else {
//     nextBtn.textContent = "Main Menu";
//   }
// });

submitBtn.addEventListener("click", () => {
  var answer = answerContainer.value;
  messageContainer.innerHTML = "";
  messageContainer.className = "message-container";

  if (answer !== "") {
    if (answer.toLowerCase() == data[current_question_index].content.toLowerCase()) {
      var time_left = 30 - question_timer;
      var multiplier = 1;

      if (time_left >= 0 && time_left <= 10) {
        multiplier = 5;
      } else if (time_left > 10 && time_left <= 20) {
        multiplier = 3;
      } else if (time_left > 20 && time_left <= 30) {
        multiplier = 2;
      }

      score += multiplier * MIN_STEP_SCORE;
    }

    populateModal("Waiting for other players...", "");
  }
});

// window.addEventListener("beforeunload", (event) => {
//   event.preventDefault();
//   $.ajax({
//     type: "post",
//     url: "functions/waiting_room_functions.php?function_name=leave_room",
//     data: {
//       student_id: current_student.id,
//       room_id,
//     },
//     success: function () {
//       window.location.href = "index.php";
//     },
//   });
//   return;
// });
