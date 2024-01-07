const waitingList = document.getElementById("waiting-players-list");
const timeLeft = document.getElementById("time-left");
let along_flow = false;

function populateGuestList(data) {
  waitingList.innerHTML = "";

  data.forEach((element) => {
    const player_div = document.createElement("div");
    const player_avatar = document.createElement("div");
    const player_details = document.createElement("div");
    const player_name = document.createElement("div");
    const player_school = document.createElement("div");

    player_avatar.className = "player-avatar";
    player_details.className = "player-details";
    player_name.className = "player-name";
    player_school.className = "player-school";
    player_div.className = "player-div";

    player_name.textContent = element.name;
    player_school.textContent = element.school + " | " + element.class;

    const player_avatar_img = document.createElement("img");
    player_avatar_img.src = `../type_master/assets/avatars/${
      element?.avatar || "default-icon.svg"
    }`;

    player_avatar.appendChild(player_avatar_img);

    player_details.appendChild(player_name);
    player_details.appendChild(player_school);
    player_div.appendChild(player_avatar);
    player_div.appendChild(player_details);

    waitingList.appendChild(player_div);
  });
}

function ajaxToPopulateGuestList() {
  $.ajax({
    type: "post",
    url: "functions/waiting_room_functions.php?function_name=get_waiting_room_players",
    data: {
      room_id,
    },
    success: function (res) {
      var response = JSON.parse(res);

      populateGuestList(response);
    },
  });
}

setInterval(ajaxToPopulateGuestList, 1000);

if (isTimeKeeper) {
  function setTimeLeft() {
    $.ajax({
      type: "post",
      url: "functions/waiting_room_functions.php?function_name=time_keeper_action",
      data: {
        room_id,
      },
    });
  }

  setInterval(setTimeLeft, 1000);
}

function showTimeLeft() {
  $.ajax({
    type: "post",
    url: "functions/waiting_room_functions.php?function_name=get_time_to_start",
    data: {
      room_id,
    },
    success: function (res) {
      var response = JSON.parse(res);

      console.log(response);
      timeLeft.textContent = formatTimeFromSeconds(response);
      if (response == 0) {
        console.log("Zero");
        if (isTimeKeeper) {
          $.ajax({
            type: "post",
            url: "functions/waiting_room_functions.php?function_name=start_room",
            data: {
              room_id,
            },
            success: function (res1) {
              window.onbeforeunload = null;
              along_flow = true;
              window.location.href = `index.php?page=live_quiz_page&ri=${room_id}`;
            },
          });
        } else {
          checkStartRoom();
        }
      }
    },
  });
}

function checkStartRoom() {
  $.ajax({
    type: "post",
    url: "functions/waiting_room_functions.php?function_name=check_start_room",
    data: {
      room_id,
    },
    success: function (res1) {
      var response_sub = JSON.parse(res1);

      if (response_sub == 1) {
        window.onbeforeunload = null;
        along_flow = true;
        window.location.href = `index.php?page=live_quiz_page&ri=${room_id}`;
      }
    },
  });
}

if (!isTimeKeeper) {
  setInterval(checkStartRoom, 1000);
}

function formatTimeFromSeconds(seconds) {
  if (isNaN(seconds) || seconds < 0) {
    throw new Error("Input must be a non-negative number");
  }

  const mins = Math.floor(seconds / 60);
  const remainingSeconds = seconds % 60;

  const formattedTime = `${mins} mins ${remainingSeconds} seconds`;
  return formattedTime;
}

setInterval(showTimeLeft, 1000);

// if (!along_flow) {
//   window.addEventListener("beforeunload", (event) => {
//     event.preventDefault();
//     $.ajax({
//       type: "post",
//       url: "functions/waiting_room_functions.php?function_name=leave_room",
//       data: {
//         student_id: current_student.id,
//         room_id,
//       },
//       success: function () {
//         window.location.href = "index.php";
//       },
//     });
//     return;
//   });
// } else {
//   window.onbeforeunload = null;
// }
