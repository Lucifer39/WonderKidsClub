var discNotif = document.getElementById("notification-disc");
// var typeNotif = document.getElementById("notification-type");

function get_discussion_notifications() {
  $.ajax({
    type: "post",
    url: `${global_url}global/notification_function.php?function_name=get_discussion_notifications`,
    data: {
      user_id: current_student.id,
    },
    success: function (res) {
      var response = parseInt(JSON.parse(res));

      if (response > 0) {
        discNotif.style.display = "flex";
        discNotif.textContent = response;
      }
    },
  });
}

function get_typing_notifications() {
  $.ajax({
    type: "post",
    url: `${global_url}global/notification_function.php?function_name=get_typing_notifications`,
    data: {
      user_id: current_student.id,
    },
    success: function (res) {
      var response = parseInt(JSON.parse(res));

      if (response > 0) {
        typeNotif.style.display = "flex";
        typeNotif.textContent = response;
      }
    },
  });
}

// setInterval(get_typing_notifications, 1000);
setInterval(get_discussion_notifications, 5000);
