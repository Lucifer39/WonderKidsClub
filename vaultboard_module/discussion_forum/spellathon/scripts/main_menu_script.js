const liveQuizBtn = document.getElementById("live-quiz-btn");

liveQuizBtn.addEventListener("click", () => {
  $.ajax({
    type: "post",
    url: "functions/waiting_room_functions.php?function_name=checkRoom",
    data: {
      class_group: classGroup,
    },
    success: function (res) {
      var response = JSON.parse(res);

      if (response !== "") {
        window.location.href = "index.php?page=waiting_room_page";
      } else {
        alert("No rooms present!");
      }
    },
  });
});
