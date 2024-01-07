let guestList = document.getElementById("guest-list");
console.log(room_code);
let refresh_data = true;
let min_player_count = 2;
let set_start = false;

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

        response.forEach((element) => {
          var div_ele = document.createElement("div");
          div_ele.classList.add("d-flex");

          var div_ele_icon = document.createElement("img");
          div_ele_icon.classList.add("guest-list-name");
          div_ele_icon.src = "assets/avatars/" + element?.avatar || "default-icon.svg";
          div_ele_icon.style.width = "35px";

          var div_ele_name = document.createElement("h6");
          div_ele_name.classList.add("mt-2");
          div_ele_name.textContent = element.student_name;

          if (element.student_id == student.id) {
            div_ele_name.textContent = div_ele_name.textContent + " (you)";
          }

          div_ele.appendChild(div_ele_icon);
          div_ele.appendChild(div_ele_name);

          guestList.appendChild(div_ele);

          if (element.time_keeper == 1) {
            $.ajax({
              type: "POST",
              url: "functions/typing_race_waiting_room.php?function_name=set_room_time",
              data: {
                room_id: room_code,
              },
            });
          }
        });
      },
    });
  });
}

function get_room_timer() {
  $.ajax({
    type: "POST",
    url: "functions/typing_race_waiting_room.php?function_name=get_room_time",
    data: {
      room_id: room_code,
    },
    success: function (res) {
      let response = JSON.parse(res);
      let room_timer = document.getElementById("room-start-timer");

      room_timer.innerText = response;

      if (response <= 0) {
        room_timer.style.display = "none";
        automated_start_game();
      }
    },
  });
}

setInterval(get_room_timer, 1000);

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
setInterval(startGame, 1000);

// let inpCode = document.getElementById("room-code-copy");
// document.getElementById("copy-code").addEventListener("click", () => {
//   var code = inpCode.value;
//   inpCode.select();
//   navigator.clipboard.writeText(code);

//   var tooltip = document.getElementById("myTooltip");
//   tooltip.innerHTML = "Copied!";
//   tooltip.style.visibility = "visible";
//   setTimeout(function () {
//     tooltip.innerHTML = "";
//     tooltip.style.visibility = "hidden";
//   }, 2000);
// });

function automated_start_game() {
  $(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "functions/typing_race_waiting_room.php?function_name=get_player_count",
      data: {
        room_id: room_code,
      },
      success: function (res) {
        // console.log(res);
        if (res >= min_player_count) {
          game_start();
        } else {
          document.getElementById("room-message").innerText =
            "Couldn't find players to compete. Closing room!";
          setTimeout(() => {
            disconnect();
            window.location.href = "index.php";
          }, 2000);
        }
      },
    });
  });
}

// function startCountdown(targetTimestamp_get) {
//   // Get the timestamp for the target time
//   // Set the target timestamp to countdown to (in milliseconds)
//   var targetTimestamp = targetTimestamp_get.getTime();
//   console.log(targetTimestamp);
//   // Update the countdown every second
//   var countdownInterval = setInterval(function () {
//     // Get the current timestamp
//     var currentTimestamp = new Date().getTime();

//     // Calculate the time remaining until the target timestamp
//     var timeRemaining = targetTimestamp - currentTimestamp;
//     console.log(timeRemaining);

//     // If the target timestamp has passed, stop the countdown
//     if (timeRemaining < 0) {
//       clearInterval(countdownInterval);
//       document.getElementById("countdown").innerText = "Countdown complete!";
//     } else {
//       // Convert the time remaining into hours, minutes, and seconds
//       var hours = Math.floor(timeRemaining / (60 * 60 * 1000));
//       var minutes = Math.floor((timeRemaining % (60 * 60 * 1000)) / (60 * 1000));
//       var seconds = Math.floor((timeRemaining % (60 * 1000)) / 1000);

//       // Display the countdown in the console
//       document.getElementById("countdown").innerText =
//         hours + " hours " + minutes + " minutes " + seconds + " seconds";
//     }
//   }, 1000);
// }

// let intervalId = setInterval(automated_start_game, 1000);

function game_start() {
  $(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "functions/waiting_room_function.php?function_name=start_room_game",
      data: {
        room_id: room_code,
      },
      success: function (res) {
        $(document).ready(function () {
          $.ajax({
            type: "POST",
            url: "functions/typing_race_waiting_room.php?function_name=delete_start_time",
            data: {
              room_id: room_code,
            },
          });
        });
      },
    });
  });
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
          window.location.href = "index.php";
        },
      });
    });
  }
}

function handleBeforeUnload(event) {
  event.preventDefault();
  event.returnValue = "Are you sure you want to leave the room?";
  disconnect();

  return;
}
