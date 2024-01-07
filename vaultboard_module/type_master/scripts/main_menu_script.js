// Define user details to display
let userDetails = `Name: ${user_det?.name || "Guest"}\nClass: ${user_det?.class || ""}\nSchool: ${
  user_det?.school || "N/A"
}\nAvg WPM: ${user_det?.wpm || 0}\nBest Accuracy: ${user_det?.accuracy || 0}%\nBest Score: ${
  user_det?.points || 0
}\n`;

// Define hacker codes to display before user details
const hackerCodes = [
  // "Accessing secure server...",
  // "Decrypting user data...",
  // "Hacking into the mainframe...",
  // "User data found...",
];

// Define delay time for each character to be typed (in milliseconds)
const typeDelay = 100;

// Get the loader element and user details element
const loader = document.getElementById("loader");
const userDetailsElem = document.getElementById("user-details");

// Create function to type text
function typeText(text, elem) {
  let index = 0;
  elem.innerHTML = "";
  const intervalId = setInterval(() => {
    loader.style.display = "none";

    if (index >= text.length) {
      clearInterval(intervalId);
      return;
    }
    if (text[index] === "\n") {
      elem.innerHTML += "<br>";
    } else {
      elem.innerHTML += text[index];
    }
    index++;
  }, typeDelay);
}

// Display hacker codes before user details
let index = 0;
const hackerIntervalId = setInterval(() => {
  if (index >= hackerCodes.length) {
    clearInterval(hackerIntervalId);
    setTimeout(() => {
      typeText(userDetails, userDetailsElem);
    }, 1000);
    return;
  }
  const hackerCode = hackerCodes[index];
  typeText(hackerCode, userDetailsElem);
  index++;
}, 3000);

/*----Leaderboard-----*/

function populateLeaderboard(data, hasFilter) {
  var leaderboard = document.querySelector("#leaderboard tbody");
  leaderboard.innerHTML = "";
  data.forEach(function (obj) {
    if (hasFilter || obj.rank <= 3 || obj.id == current_student.id) {
      var tr = document.createElement("tr");
      var nameTd = document.createElement("td");
      var classTd = document.createElement("td");
      var schoolTd = document.createElement("td");
      var wpmTd = document.createElement("td");
      var accuracyTd = document.createElement("td");
      var scoreTd = document.createElement("td");
      var rankTd = document.createElement("td");

      num_time = parseInt(obj.time_taken);
      var mins = parseInt(num_time / 60);
      var secs = num_time % 60;

      nameTd.textContent = obj.name + (current_student.id == obj.id ? " (you)" : "");
      classTd.textContent = obj.class;
      schoolTd.textContent = obj.school;
      wpmTd.textContent = obj.wpm;
      accuracyTd.textContent = obj.accuracy;
      scoreTd.textContent = obj.points;
      rankTd.textContent = obj.rank;

      obj.id == current_student.id && tr.classList.add("user-row-leaderboard");

      tr.appendChild(rankTd);
      tr.appendChild(nameTd);
      tr.appendChild(classTd);
      tr.appendChild(schoolTd);
      tr.appendChild(wpmTd);
      tr.appendChild(accuracyTd);
      tr.appendChild(scoreTd);
      leaderboard.appendChild(tr);
    }
  });
}

populateLeaderboard(leaderboard);

const everyoneButton = document.getElementById("everyone-button");
// const batchmateButton = document.getElementById("same-class-button");
const classmateButton = document.getElementById("same-class-same-school-button");
const searchBar = document.getElementById("search-username");

everyoneButton?.addEventListener("click", () => {
  populateLeaderboard(leaderboard, false);
});

// batchmateButton.addEventListener("click", () => {
//   let filteredData = leaderboard.filter((obj) => obj.class == user_det["class"]);
//   populateLeaderboard(filteredData, true);
// });

classmateButton?.addEventListener("click", () => {
  let filteredData = leaderboard.filter((obj) => obj.school == user_det["school"]);

  populateLeaderboard(filteredData, true);
});

searchBar?.addEventListener("input", (event) => {
  let searchUser = event.target.value.toLowerCase();

  // console.table(leaderboard);
  let filteredData = leaderboard.filter((obj) => obj.name.toLowerCase().includes(searchUser));
  populateLeaderboard(filteredData, searchUser !== "");
});

/*-----typing race-----*/
document.getElementById("typing-race-btn").addEventListener("click", () => {
  $(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "functions/typing_race_waiting_room.php?function_name=assign_room",
      data: {
        user_id: parseInt(user_det["id"]),
      },
      success: function (res) {
        console.log(res);
        var room_code = JSON.parse(res);

        window.location.href = `index.php?page=typing_race_waiting_room_page&rc=${room_code}`;
      },
    });
  });
});
