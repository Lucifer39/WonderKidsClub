let actionContainer = document.getElementById("action");
let progress = [];
console.log("room_code");

function getPlayerProgress(flag) {
  $(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "functions/multiplayer_type_racer.php?function_name=get_player_progress",
      data: {
        room_id: room_code,
        user_id: current_student.id,
      },
      success: function (res) {
        progress = JSON.parse(res);

        if (!flag) {
          console.log("true");
          populateActors();
        }
      },
    });
  });
}

getPlayerProgress(false);

function populateActors() {
  console.log(progress);
  progress.forEach((user) => {
    let actorsDiv = document.createElement("div");
    let trackDiv = document.createElement("div");
    let rocketDiv = document.createElement("div");
    let zorgonDiv = document.createElement("div");
    let spanEle = document.createElement("span");
    let rocketImg = document.createElement("img");
    let zorgonImg = document.createElement("img");

    actorsDiv.classList.add("actors");
    trackDiv.classList.add("track");
    rocketDiv.classList.add("rocket-multi");
    zorgonDiv.classList.add("zorgon");
    rocketImg.classList.add("rocket-ship");
    zorgonImg.classList.add("zorgon-monster");

    actorsDiv.setAttribute("id", `actors-${user.student_id}`);
    trackDiv.setAttribute("id", `track-${user.student_id}`);
    rocketDiv.setAttribute("id", `rocket-${user.student_id}`);
    zorgonDiv.setAttribute("id", `zorgon-${user.student_id}`);
    rocketImg.setAttribute("src", `assets/avatars/${user?.student_avatar || "default-icon.svg"}`);
    rocketImg.setAttribute("alt", "rocket");
    rocketImg.setAttribute("id", "rocket-ship");
    zorgonImg.setAttribute("src", "assets/zorgon_svg.svg");
    zorgonImg.setAttribute("alt", "zorgon");
    zorgonImg.setAttribute("id", "zorgon-monster");

    spanEle.textContent = user.student_name;

    if (user.student_id == student.id) {
      spanEle.textContent = spanEle.textContent + " (you)";
    }

    rocketDiv.appendChild(spanEle);
    rocketDiv.appendChild(rocketImg);
    zorgonDiv.appendChild(zorgonImg);
    actorsDiv.appendChild(rocketDiv);
    actorsDiv.appendChild(zorgonDiv);
    actionContainer.appendChild(actorsDiv);
    actionContainer.appendChild(trackDiv, game());
  });
}

// console.log(texts);

//Game itself
let eval_text = "";
let currentTextIndex = 0;
let startTime,
  endTime,
  wpmTime,
  score = 0,
  wpm = 0,
  accuracy = 0,
  incorrect_chars = 0,
  count = 1;

function game() {
  //   console.log(texts);
  // Elements
  const textElement = document.getElementById("text");
  const inputElement = document.getElementById("input");
  const timerElement = document.getElementById("timer");
  const scoreElement = document.getElementById("score");
  // const rocketElement = document.getElementById("rocket");
  // const zorgonElement = document.getElementById("zorgon");
  // const trackElement = document.getElementById("actors");
  // const rocket = document.getElementById("rocket");
  // const zorgon = document.getElementById("zorgon-monster");
  const wpmContainer = document.getElementById("wpm");
  const scoreContainer = document.getElementById("score-container");

  textElement.addEventListener("copy", (event) => {
    event.preventDefault();
  });

  let trackSegment = parseInt(
    getDistanceBetweenDivs(
      document.getElementById(`rocket-${progress[0].student_id}`),
      document.getElementById(`zorgon-${progress[0].student_id}`)
    ) / textArrayLength("words")
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

  // Set initial text
  textElement.innerText = texts[currentTextIndex].sentence;

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
    console.log(typedText);

    if (evalutaion(currentText, eval_text + typedText)) {
      const typingSound = document.getElementById("typing-sound");
      typingSound.currentTime = 1.7;
      sound && typingSound.play();
      already_correct = eval_text + typedText;
      if (typedText.endsWith(" ")) {
        inputElement.value = "";
        eval_text += typedText;
        ++currentSegment;
        moveRocket(`rocket-${student["id"]}`, currentSegment);
        sendProgress(0);
      }
    } else {
      const typingSound = document.getElementById("mistyped-sound");
      typingSound.currentTime = 1.2;
      sound && typingSound.play();
    }
  });

  function sendProgress(completed) {
    let eTime = new Date();
    const elapsedTime = (eTime - startTime) / 1000;

    $(document).ready(function () {
      $.ajax({
        type: "POST",
        url: "functions/multiplayer_type_racer.php?function_name=set_player_progress",
        data: {
          room_id: room_code,
          student_id: student.id,
          progress: {
            rocket_progress: currentSegment,
            completed,
            wpm,
            points: score,
            accuracy,
            time_taken: elapsedTime,
          },
        },
      });
    });

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

  function getPeriodicProgress() {
    getPlayerProgress(true);
    progress.forEach((user) => {
      if (user.student_id !== student.id) {
        if (!user.completed || user.completed == 0) {
          moveRocket(`rocket-${user.student_id}`, user.rocket_progress);
        } else {
          let zorgonUser = document.getElementById(`zorgon-${user.student_id}`);
          let rocketUser = document.getElementById(`rocket-${user.student_id}`);

          zorgonUser.src = "assets/explosion.svg";
          rocketUser.style.display = "none";
          rocketUser.style.justifyContent = "space-around";
        }
      }
    });
  }

  setInterval(getPeriodicProgress, 1000);

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
          //   zorgon.src = "assets/explosion.svg";
          //   rocket.style.display = "none";
          //   rocket.style.justifyContent = "space-around";
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
    console.log(texts);
    const text_array = texts.map((obj) => obj.sentence);
    if (option === "characters") return text_array.join(" ").length;
    else if (option === "words") return text_array.join(" ").split(" ").length;
  }

  function moveRocket(rocketId, currentSegment_ts) {
    const rocket = document.getElementById(rocketId);
    if (currentSegment < textArrayLength("words") - 1) {
      let newPosition = currentSegment_ts * trackSegment;
      rocket.style.marginLeft = `${newPosition}px`;
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

    sendProgress(1);
    game_over_display();
  }

  function game_over_display() {
    actionContainer.style.display = "none";
    document.getElementById("dynamic-status").style.display = "none";
    textElement.style.display = "none";
    document.getElementById("input-container").style.display = "none";
    document.getElementById("score-container-multiplayer").style.display = "flex";
  }

  function populate_multiplayer_leaderboard() {
    let data = [];
    $(document).ready(function () {
      $.ajax({
        type: "POST",
        url: "functions/multiplayer_type_racer.php?function_name=room_leaderboard",
        data: {
          room_id: room_code,
        },
        success: function (res) {
          data = JSON.parse(res);
          var leaderboard = document.querySelector("#leaderboard-multiplayer tbody");
          leaderboard.innerHTML = "";
          let rank = 1;
          data.forEach(function (obj) {
            var tr = document.createElement("tr");
            var nameTd = document.createElement("td");
            var classTd = document.createElement("td");
            var schoolTd = document.createElement("td");
            var wpmTd = document.createElement("td");
            var accuracyTd = document.createElement("td");
            var scoreTd = document.createElement("td");
            var rankTd = document.createElement("td");
            var timeTd = document.createElement("td");

            num_time = parseInt(obj.time_taken);
            var mins = parseInt(num_time / 60);
            var secs = num_time % 60;

            nameTd.textContent = obj.student_name;
            classTd.textContent = obj.student_class;
            schoolTd.textContent = obj.student_school;
            wpmTd.textContent = obj.wpm;
            accuracyTd.textContent = obj.accuracy;
            scoreTd.textContent = obj.points;
            rankTd.textContent = rank++;
            timeTd.textContent = `${mins > 0 ? mins + "mins " : ""} ${secs} secs`;

            tr.appendChild(rankTd);
            tr.appendChild(nameTd);
            tr.appendChild(classTd);
            tr.appendChild(schoolTd);
            tr.appendChild(wpmTd);
            tr.appendChild(accuracyTd);
            tr.appendChild(scoreTd);
            tr.appendChild(timeTd);
            leaderboard.appendChild(tr);
          });
        },
      });
    });
  }

  setInterval(populate_multiplayer_leaderboard, 1000);

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
  //   document.getElementById("start-button").style.display = "none";
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
      setTimeout(() => {
        document.getElementById("countdown").style.display = "none";
        startTime = new Date();
        wpmTime = new Date();
        textElement.style.display = "block";
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

  document.getElementById("leave-room").addEventListener("click", disconnect);

  window.addEventListener("beforeunload", (event) => {
    event.preventDefault();
    disconnect();
    event.returnValue = "Are you sure you want to leave the room?";
    return;
  });

  function disconnect() {
    $(document).ready(function () {
      $.ajax({
        type: "POST",
        url: "functions/multiplayer_type_racer.php?function_name=leave_room",
        data: {
          room_id: room_code,
          student_id: student.id,
        },
        success: function (res) {
          window.location.href = "index.php";
        },
      });
    });
  }
}
