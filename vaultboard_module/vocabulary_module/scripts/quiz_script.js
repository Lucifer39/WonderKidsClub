// array of quiz questions, options, and answers

let score = 0;
let currentQuestion = 0;
let response = [];
let opted_for = "";
let streak = 1;
let correct_answers_count = 0;
let wrong_answers_count = 0;
let longestStreak = 1;

const questionContainer = document.getElementById("question");
const optionsContainer = document.getElementById("options");
const submitButton = document.getElementById("submit");
const resultContainer = document.getElementById("result");
const quizContainer = document.getElementById("quiz");
const scoreContainer = document.getElementById("score");
const modalContainer = document.getElementById("modal");
const streakValue = document.getElementById("streak");
const scoreValue = document.getElementById("every-score");

let seconds = 0;
let minutes = 0;
let db_seconds = 0;
let timerInterval;
let timerElement = document.getElementById("timer");

function startTimer() {
  timerInterval = setInterval(() => {
    db_seconds++;
    seconds++;
    if (seconds == 60) {
      seconds = 0;
      minutes++;
    }
    timerElement.textContent = `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
  }, 1000);
}

function stopTimer() {
  clearInterval(timerInterval);
}

function loadQuestion() {
  opted_for = "";
  scoreContainer.style.display = "none";
  modalContainer.style.display = "none";

  // load question text
  questionContainer.innerText = quiz[currentQuestion].question;

  // clear previous options
  optionsContainer.innerHTML = "";

  // load options
  for (let i = 0; i < quiz[currentQuestion].options.length; i++) {
    const option = quiz[currentQuestion].options[i].trim();
    const div = document.createElement("div");
    div.classList.add("quiz-option");
    const radio = document.createElement("button");
    // radio.type = "radio";
    radio.name = "option";
    radio.value = option.charAt(0).toUpperCase() + option.slice(1);
    radio.className = "option-btn";
    radio.appendChild(document.createTextNode(option.charAt(0).toUpperCase() + option.slice(1)));
    div.appendChild(radio);
    // const label = document.createElement("label");
    // // label.appendChild(document.createTextNode(option.charAt(0).toUpperCase() + option.slice(1)));
    // label.appendChild(document.createTextNode(option.charAt(0).toUpperCase() + option.slice(1)));
    // label.for = "option";

    // div.appendChild(label);
    optionsContainer.appendChild(div);
  }

  const radios = document.querySelectorAll(".option-btn");
  var answer = quiz[currentQuestion].answer.trim();
  var correctAnswer = answer.charAt(0).toUpperCase() + answer.slice(1);

  //check answer
  radios.forEach((radio) => {
    radio.addEventListener("click", () => {
      let success;
      let increment;
      let timeoutId;

      if (radio.value === correctAnswer) {
        radio.parentElement.style.color = "white";
        radio.parentNode.style.backgroundColor = "green"; // highlight correct answer

        correct_answers_count++;
        increment = 900 * streak;
        score += increment;
        streak++;
        longestStreak = longestStreak < streak ? streak : longestStreak;
        success = true;
      } else {
        radio.parentElement.style.color = "white";
        radio.parentElement.style.backgroundColor = "red"; // highlight wrong answer

        wrong_answers_count++;
        radios.forEach((clicked_radio) => {
          if (clicked_radio.value === correctAnswer) {
            clicked_radio.parentElement.style.color = "white";
            clicked_radio.parentNode.style.backgroundColor = "green"; // highlight correct answer
          }
        });

        streak = 1;
        success = false;
        increment = 0;
      }

      opted_for = radio.value;
      radios.forEach((radio) => (radio.disabled = true)); // disable all radios

      streakValue.textContent = "" + streak;
      scoreValue.textContent = "" + score;

      clearTimeout(timeoutId);
      timeoutId = setTimeout(showModal(success, "" + increment), 5000);
    });
  });
}

function nextQuestion() {
  currentQuestion++;
  response.push(opted_for);

  if (currentQuestion < quiz.length) {
    loadQuestion();
  } else {
    stopTimer();
    showScore();
  }
}

function showModal(success, increment) {
  modalContainer.style.display = "flex";

  const success_message = [
    "Congratulations!! You answered correctly!",
    "Way to go, champ! Another correct Answer!",
  ];
  const failure_message = [
    "Oops looks like you answered incorrectly!Dont lose hope yet!!",
    "C'mon you gotta give it another try!",
  ];

  let chosen_message = "";
  // const modalTitle = document.getElementById("modal-title");
  const modalScoreName = document.getElementById("modal-score-name");
  const modalScoreCurrent = document.getElementById("modal-score-current");
  const modalScoreInc = document.getElementById("modal-score-increment");
  const modalIcon = document.getElementById("modal-icon");

  if (success) {
    const randomIndex = Math.floor(Math.random() * success_message.length);
    chosen_message = success_message[randomIndex];

    // modalTitle.style.color = "var(--green)";
    modalScoreInc.style.color = "var(--green)";

    modalIcon.src = "assets/correct-icon.svg";
    modalIcon.style.width = "5rem";
  } else {
    const randomIndex = Math.floor(Math.random() * failure_message.length);
    chosen_message = failure_message[randomIndex];

    // modalTitle.style.color = "var(--red)";
    modalScoreInc.style.color = "var(--red)";

    modalIcon.src = "assets/red-x-icon.svg";
  }

  // modalTitle.textContent = chosen_message;
  modalScoreName.textContent = student.name;
  modalScoreCurrent.textContent = score;
  modalScoreInc.textContent = "+" + increment;

  setTimeout(nextQuestion, 5000);
}

function showScore() {
  scoreContainer.style.display = "flex";
  modalContainer.style.display = "none";

  const accuracy = (correct_answers_count / quiz.length) * 100;
  const accuracyContainer = document.getElementById("accuracy");
  const correctContainer = document.getElementById("correct-answers-count");
  const incorrectContainer = document.getElementById("incorrect-answers-count");
  const resultScoreContainer = document.getElementById("result-score");
  const timeTakenContainer = document.getElementById("time-taken-count");
  const longestStreakContainer = document.getElementById("longest-streaks-count");

  accuracyContainer.textContent = "" + accuracy.toFixed(2) + "%";
  correctContainer.textContent = "" + correct_answers_count;
  incorrectContainer.textContent = "" + wrong_answers_count;
  resultScoreContainer.textContent = "" + score;
  longestStreakContainer.textContent = "" + longestStreak;

  var res_mins = parseInt(db_seconds / 60);
  var res_secs = db_seconds % 60;
  timeTakenContainer.textContent = (res_mins >= 1 ? res_mins + " mins " : "") + res_secs + " secs ";

  var result_table = document.querySelector("#result-table tbody");
  result_table.innerHTML = "";
  var i = 0;
  quiz.forEach(function (obj) {
    var tr = document.createElement("tr");
    var questionTd = document.createElement("td");
    var correctTd = document.createElement("td");
    var evaluationTd = document.createElement("td");

    var answer = obj.answer.trim();
    var correctAnswer = answer.charAt(0).toUpperCase() + answer.slice(1);

    questionTd.textContent = obj.question;
    correctTd.textContent = correctAnswer;
    evaluationTd.textContent = correctAnswer === response[i] ? "Correct" : "Incorrect";

    tr.appendChild(questionTd);
    tr.appendChild(correctTd);
    tr.appendChild(evaluationTd);

    result_table.appendChild(tr);

    i++;
  });

  quizContainer.style.display = "none";

  const data = { score, timer: db_seconds, universe };

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "functions/process_score.php");
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log(xhr.responseText);
    }
  };
  xhr.send(JSON.stringify(data));
}

function initQuiz() {
  loadQuestion();
  startTimer();

  // submitButton.addEventListener("click", function () {
  //   nextQuestion();
  // });
}

initQuiz();
// showScore();
