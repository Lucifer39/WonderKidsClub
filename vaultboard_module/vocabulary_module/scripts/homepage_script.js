populateLeaderboard(leaderboard);
console.log(current_student);
console.log(leaderboard);

function populateLeaderboard(data, hasFilter) {
  var leaderboard = document.querySelector("#leaderboard tbody");
  leaderboard.innerHTML = "";

  data.forEach(function (obj, index) {
    if (obj.time_taken > 0) {
      var tr = document.createElement("tr");
      var rankTd = document.createElement("td");
      var nameTd = document.createElement("td");
      var scoreTd = document.createElement("td");
      var timeTd = document.createElement("td");

      nameTd.className = "name-td";
      var nameHeadDiv = document.createElement("div");
      nameHeadDiv.className = "name-head-div";
      var nameBodyDiv = document.createElement("div");
      nameBodyDiv.className = "name-body-div";

      num_time = parseInt(obj.time_taken);
      var mins = parseInt(num_time / 60);
      var secs = num_time % 60;

      // nameTd.textContent = obj.name;
      rankTd.textContent = obj.rank;
      var leaderboard_name = current_student.id == obj.id ? "(You)" : "";
      nameHeadDiv.textContent = obj.name + leaderboard_name;
      nameBodyDiv.textContent = obj.school + " | " + obj.class;
      scoreTd.textContent = obj.last_week_score;
      timeTd.textContent = (mins >= 1 ? mins + " mins " : "") + secs + " secs ";

      obj.id == current_student.id && tr.classList.add("user-row-leaderboard");

      if (hasFilter || obj.rank <= 3 || obj.id == current_student.id) {
        nameTd.appendChild(nameHeadDiv);
        nameTd.appendChild(nameBodyDiv);
        tr.appendChild(rankTd);
        tr.appendChild(nameTd);
        tr.appendChild(scoreTd);
        tr.appendChild(timeTd);
        leaderboard.appendChild(tr);
      }
    }
  });
}

// function filterByClass(data, filter) {
//   var filteredData;
//   if (filter === "same-class-same-school") {
//     filteredData = data.filter((obj) => obj.school == current_student.school);
//   } else if (filter === "same-class-all-schools") {
//     filteredData = data.filter((obj) => obj.class == current_student.class);
//   }

//   return filteredData;
// }

var searchInput = document.querySelector("#search");
// var filterSelect = document.querySelector("#filter");
var everyoneBtn = document.getElementById("all-button");
var sameSchoolBtn = document.getElementById("same-school-button");

searchInput.addEventListener("input", function () {
  var searchText = searchInput.value.toLowerCase();
  var filteredData = leaderboard.filter(function (obj) {
    return obj.name.toLowerCase().indexOf(searchText) !== -1;
  });
  populateLeaderboard(filteredData, searchText !== "");
});

// filterSelect.addEventListener("change", function () {
//   var filter = filterSelect.value;
//   if (filter === "all") {
//     populateLeaderboard(leaderboard, false);
//   } else {
//     var filteredData = filterByClass(leaderboard, filter);
//     populateLeaderboard(filteredData, true);
//   }
// });

everyoneBtn.addEventListener("click", () => {
  populateLeaderboard(leaderboard, false);
});

sameSchoolBtn.addEventListener("click", () => {
  var filteredData = leaderboard.filter((obj) => obj.school == current_student.school);
  populateLeaderboard(filteredData, true);
});
