var question_obj = ["dictation", "jumble"];

var data = [];
var current_question_index = 0;
const MAX_QUESTION_NUMBER = 10;

const questionContainer = document.getElementById("question-container");
const answerContainer = document.getElementById("answer-input");
const submitBtn = document.getElementById("submit-btn");
const nextBtn = document.getElementById("next-btn");
const messageContainer = document.getElementById("message-container");
const correct_message = document.getElementById("correct-answer");

$.ajax({
  type: "post",
  url: "functions/practice_page_functions.php?function_name=get_questions",
  success: function (res) {
    data = JSON.parse(res);
    populateQuestion();
  },
});

function populateQuestion() {
  console.log("Question");
  correct_message.textContent = "";
  questionContainer.innerHTML = "";
  messageContainer.style.display = "none";
  document.getElementById("input-group").style.display = "flex";
  answerContainer.value = "";

  var set_question = question_obj[Math.floor(Math.random() * question_obj.length)];

  // if (set_question == "dictation") {
  //   var word = data[current_question_index];
  //   populateDictation(word.content);
  // } else if (set_question == "jumble") {
  //   var word = data[current_question_index];
  //   populateJumble(word.content.toLowerCase());
  // } else if (set_question == "guess") {
  //   var word = data[current_question_index];
  //   populateGuess(word);
  // }

  if (data[current_question_index].question_type == "guess") {
    var word = data[current_question_index];
    populateGuess(word);
  } else {
    if (set_question == "dictation") {
      var word = data[current_question_index];
      populateDictation(word.content);
    } else if (set_question == "jumble") {
      var word = data[current_question_index];
      populateJumble(word.content.toLowerCase());
    }
  }
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

nextBtn.addEventListener("click", () => {
  current_question_index++;

  if (current_question_index < MAX_QUESTION_NUMBER) {
    populateQuestion();
  } else {
    nextBtn.textContent = "Main Menu";
  }
});

submitBtn.addEventListener("click", () => {
  var answer = answerContainer.value;
  messageContainer.innerHTML = "";
  messageContainer.className = "message-container";

  if (answer !== "") {
    document.getElementById("input-group").style.display = "none";

    if (answer.toLowerCase() == data[current_question_index].content.toLowerCase()) {
      messageContainer.classList.add("correct-message");
      const iTag = document.createElement("i");
      iTag.className = "bi bi-check-circle";
      messageContainer.appendChild(iTag);

      messageContainer.style.display = "flex";
    } else {
      messageContainer.classList.add("incorrect-message");
      const iTag = document.createElement("i");
      iTag.className = "bi bi-x";
      messageContainer.appendChild(iTag);

      correct_message.textContent = `The answer is: ${data[current_question_index].content}`;

      messageContainer.style.display = "flex";
      correct_message.style.display = "block";
    }
  }
});
