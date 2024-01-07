const newAboutInput = document.getElementById("new-about");
const newAboutBtn = document.getElementById("save-new-about");

newAboutBtn.addEventListener("click", () => {
  var newAbout = newAboutInput.value;

  if (newAbout.trim().length > 0) {
    $.ajax({
      type: "post",
      url: "../chatbot/functions/chatbot_functions.php?function_name=create_bio_about",
      data: {
        student_id: parseInt(student_on_profile.id),
        content: newAbout.trim(),
        type: "bio",
      },
      success: function (res) {
        var response = JSON.parse(res);

        if (response) {
          location.reload();
        }
      },
    });
  }
});

/*---------------------- Achievements ----------------*/

const achivementFiles = document.getElementById("formFileMultiple");
const saveAchievements = document.getElementById("add-achievement-photos");

var file_list = [];

achivementFiles.addEventListener("change", (event) => {
  const files = event.target.files;

  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    save_file(file, "img");
  }
});

function save_file(file, file_type) {
  var formdata = new FormData();
  formdata.append("file", file);
  formdata.append("file_type", file_type);

  $.ajax({
    type: "POST",
    url: "functions/user_profile_functions.php?function_name=save_file",
    data: formdata,
    dataType: "json",
    processData: false,
    contentType: false,
    success: function (response) {
      if (response) {
        file_list.push({ file_name: response, file_type: "img" });
      }
    },
  });
}

saveAchievements.addEventListener("click", () => {
  file_list.forEach((file) => {
    $.ajax({
      type: "POST",
      url: "functions/user_profile_functions.php?function_name=save_achievement",
      data: {
        student_id: student_on_profile.id,
        file_name: file.file_name,
        file_type: file.file_type,
      },
      success: function (res) {
        var response = JSON.parse(res);

        if (response) {
          window.location.href = "index.php#achievements";
        }
      },
    });
  });
});
