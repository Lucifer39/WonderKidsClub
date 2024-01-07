let guestList = document.getElementById("guest-list");
console.log(room_code);
let refresh_data = true;

if (room_join_res == "leaderboard") setInterval(populate_multiplayer_leaderboard, 1000);

function populate_multiplayer_leaderboard() {
  console.log("This is a checkpoint");
  document.getElementById("score-container-multiplayer").style.display = "flex";
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

function populateGuestList() {
  $(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "functions/waiting_room_function.php?function_name=get_waiting_players",
      data: {
        room_id: room_code,
      },
      success: function (res) {
        let response = JSON.parse(res);
        guestList.innerHTML = "";
        let room_owner = 0;

        response.forEach((element) => {
          var divs = document.getElementsByClassName("guest-list-name");
          // for (var i = 0; i < divs.length; i++) {
          //   if (divs[i].textContent === element.student_name) {
          //     return;
          //   }
          // }

          var div_ele = document.createElement("div");
          div_ele.classList.add("guest-list-name");
          var nameDivGuest = document.createElement("div");
          var avatarDivGuest = document.createElement("div");
          var ownerDivGuest = document.createElement("div");
          var avatarImgGuest = document.createElement("img");
          var ownerImgGuest = document.createElement("img");
          nameDivGuest.textContent = element.student_name;
          avatarImgGuest.src = `assets/avatars/${element?.avatar || "default-icon.svg"}`;
          avatarDivGuest.className = "avatar-div-guest";
          nameDivGuest.className = "name-div-guest";
          ownerDivGuest.className = "owner-div-guest";

          if (element.student_id == student.id) {
            nameDivGuest.textContent = nameDivGuest.textContent + " (you)";
          }

          avatarDivGuest.appendChild(avatarImgGuest);
          div_ele.appendChild(avatarDivGuest);
          div_ele.appendChild(nameDivGuest);

          if (element.room_owner == "1") {
            ownerImgGuest.src = "assets/owner-icon.svg";
            ownerDivGuest.appendChild(ownerImgGuest);
            div_ele.appendChild(ownerDivGuest);
          }

          guestList.appendChild(div_ele);
        });
      },
    });
  });
}

function startGame() {
  $(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "functions/waiting_room_function.php?function_name=get_start_room_status",
      data: {
        room_id: room_code,
      },
      success: function (res) {
        var response = JSON.parse(res);
        console.log(res);
        if (response.started == 1) {
          refresh_data = false;
          window.removeEventListener("beforeunload", handleBeforeUnload);
          window.location.href = `index.php?page=multiplayer_room_page&rc=${room_code}`;
        }
      },
    });
  });
}

populateGuestList();
setInterval(populateGuestList, 1000);

if (room_join_res === "New record created successfully") {
  setInterval(startGame, 1000);
}

let inpCode = document.getElementById("room-code-copy");
document.getElementById("copy-code").addEventListener("click", () => {
  var code = inpCode.value;
  inpCode.select();
  navigator.clipboard.writeText(code);

  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied!";
  tooltip.style.visibility = "visible";
  setTimeout(function () {
    tooltip.innerHTML = "";
    tooltip.style.visibility = "hidden";
  }, 2000);
});

// document.getElementById("copy-url").addEventListener("click", () => {
//   var code = inpCode.value;
//   inpCode.select();
//   navigator.clipboard.writeText(
//     `${global_url}type_master/waiting_room_page.php?rc=${code}&ro=0&rt=${type}`
//   );

//   var tooltip = document.getElementById("myTooltip");
//   tooltip.innerHTML = "Copied!";
//   tooltip.style.visibility = "visible";
//   setTimeout(function () {
//     tooltip.innerHTML = "";
//     tooltip.style.visibility = "hidden";
//   }, 2000);
// });

if (document.getElementById("start-game-btn") !== null) {
  document.getElementById("start-game-btn").addEventListener("click", () => {
    $(document).ready(function () {
      $.ajax({
        type: "POST",
        url: "functions/waiting_room_function.php?function_name=start_room_game",
        data: {
          room_id: room_code,
        },
      });
    });
  });

  setInterval(showStartBtn, 1000);

  function showStartBtn() {
    $.ajax({
      type: "post",
      url: "functions/waiting_room_function.php?function_name=get_room_owner",
      data: {
        room_id: room_code,
      },
      success: function (res) {
        var response = JSON.parse(res);

        if (response.student_id == student.id) {
          document.getElementById("start-game-btn").style.display = "flex";
        }
      },
    });
  }
}

if (refresh_data) {
  window.addEventListener("beforeunload", handleBeforeUnload);
} else {
  window.onbeforeunload = null;
}

function disconnect() {
  if (refresh_data) {
    $(document).ready(function () {
      $.ajax({
        type: "POST",
        url: "functions/multiplayer_type_racer.php?function_name=leave_room",
        data: {
          room_id: room_code,
          student_id: student.id,
        },
        success: function (res) {
          window.location.href = `index.php?play_with_friends&rt=${type}`;
        },
      });
    });
  }
}

function handleBeforeUnload(event) {
  event.preventDefault();
  disconnect();
  event.returnValue = "Are you sure you want to leave the room?";
  return;
}

var filter = false;
var filter_data = "";

function populateInviteeList(data) {
  var invitation_board = document.querySelector("#invitation tbody");
  invitation_board.innerHTML = "";
  data.forEach(function (obj) {
    var tr = document.createElement("tr");
    var nameTd = document.createElement("td");
    var schoolTd = document.createElement("td");
    var inviteTd = document.createElement("td");

    var inviteBtn = document.createElement("button");
    inviteBtn.textContent = "Invite";
    inviteBtn.classList.add("invite-btn");

    inviteBtn.addEventListener("click", () => {
      var currentDate = new Date();
      var formattedDate = moment(currentDate).format("YYYY-MM-DD HH:mm:ss");

      $.ajax({
        type: "POST",
        url: "functions/handle_invitations.php?function_name=createInvite",
        data: {
          sender: student.id,
          receiver: obj.id,
          room_id: room_code,
          module: "type_master",
          created_at: formattedDate,
          room_type,
        },
      });
    });

    nameTd.textContent = obj.name;
    schoolTd.textContent = obj.school;
    inviteTd.appendChild(inviteBtn);

    tr.appendChild(nameTd);
    tr.appendChild(schoolTd);
    tr.appendChild(inviteTd);

    invitation_board.appendChild(tr);
  });
}

function handleInviteeData(data) {
  //this function to implement filters in the future
  if (!filter) {
    populateInviteeList(data);
  }
}

setInterval(() => {
  $(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "functions/handle_invitations.php?function_name=getInvitees",
      data: {
        room_id: room_code,
        user_id: student.id,
      },
      success: function (res) {
        handleInviteeData(JSON.parse(res));
      },
    });
  });
}, 1000);
