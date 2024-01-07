var notificationList = document.getElementById("notification-list");
var notificationCount = document.getElementById("notification-count");

let count = 0;
let has_media = false;
let file_name = "";
let fileType = "";

setInterval(get_notifications, 3000);

function get_notifications() {
  $.ajax({
    type: "POST",
    url: "../functions/newsfeed_functions.php?function_name=get_notifications",
    data: {
      user_id: student.id,
    },
    success: function (res) {
      var response = JSON.parse(res);
      populate_notifications(response);
    },
  });
}

function populate_notifications(datalist) {
  notificationList.innerText = "";
  count = 0;

  datalist.forEach((notification) => {
    const notificationDetailsBox = document.createElement("div");
    notificationDetailsBox.className = "notification-details-box";

    const notificationAvatar = document.createElement("div");
    notificationAvatar.className = "notification-avatar";

    const avatarImg = document.createElement("img");
    avatarImg.src = `../../type_master/assets/avatars/${
      notification?.student_avatar || "default-icon.svg"
    }`;
    avatarImg.alt = "";
    notificationAvatar.appendChild(avatarImg);

    const notificationContent = document.createElement("div");
    notificationContent.className = "notification-content-discussion";
    notificationContent.innerText = `${notification.student_name} has commented on your post`;

    notificationDetailsBox.appendChild(notificationAvatar);
    notificationDetailsBox.appendChild(notificationContent);

    const notificationPostBox = document.createElement("div");
    notificationPostBox.className = "notification-post-box";

    const postImg = document.createElement("div");
    postImg.className = "post-img";

    // const img = document.createElement("img");
    // img.src = "#";
    // img.alt = "#";

    // if(notification.post_img)
    // postImg.appendChild(img);

    const postContent = document.createElement("div");
    postContent.className = "post-content";
    postContent.innerText = notification.post_content;

    notificationPostBox.appendChild(postImg);
    notificationPostBox.appendChild(postContent);

    var notificationBox = document.createElement("div");
    notificationBox.className = "notification-box";

    notificationBox.appendChild(notificationDetailsBox);
    notificationBox.appendChild(notificationPostBox);

    if (notification.seen_comment == 0) {
      notificationBox.classList.add("unseen-notification");
      count++;
    }

    if (count == 0) {
      notificationCount.style.display = "none";
    }

    notificationBox.addEventListener("click", () => {
      $.ajax({
        type: "POST",
        url: "../functions/setter_functions.php?function_name=set_seen_notification",
        data: {
          notification_id: notification.notification_id,
        },
        success: function () {
          window.location.href = `post_page.php?pt=post_page&post_id=${notification.post_id}`;
        },
      });
    });

    notificationList.appendChild(notificationBox);

    notificationCount.innerText = count;
    notificationCount.style.backgroundColor = "var(--notification-red)";
  });
}

const postModal = document.getElementById("modal-post");

document.getElementById("start-post-btn").addEventListener("click", () => {
  postModal.style.display = "flex";
});

if (postModal) {
  document.getElementById("modal-close-btn").addEventListener("click", () => {
    // postModal.style.display = "none";
    location.reload();
  });

  document.getElementById("post-button").addEventListener("click", () => {
    if (has_media) {
      create_post(file_name);
    } else {
      create_post(null);
    }
  });
}
function create_post(media_url) {
  $.ajax({
    type: "POST",
    url: "../functions/post_handler.php?function_name=create_post",
    data: {
      user_id: student.id,
      content: document.getElementById("post-textarea").value,
      media_url,
      file_type: fileType,
    },
    success: function (res) {
      let response = JSON.parse(res);

      if (response == "ok") {
        window.location.href = "newsfeed.php";
      }
    },
  });
}

document.getElementById("imageInput")?.addEventListener("change", (event) => {
  const file = event.target.files[0];
  has_media = true;
  save_file(file, "img");
});

document.getElementById("videoInput")?.addEventListener("change", (event) => {
  const file = event.target.files[0];
  has_media = true;
  save_file(file, "vid");
});

document.getElementById("pdfInput")?.addEventListener("change", (event) => {
  const file = event.target.files[0];
  has_media = true;
  save_file(file, "pdf");
});

function save_file(file, file_type) {
  var formdata = new FormData();
  formdata.append("file", file);
  formdata.append("file_type", file_type);

  $.ajax({
    type: "POST",
    url: "../functions/post_handler.php?function_name=save_file",
    data: formdata,
    dataType: "json",
    processData: false,
    contentType: false,
    xhr: function () {
      var xhr = new window.XMLHttpRequest();

      // Progress event listener
      xhr.upload.addEventListener(
        "progress",
        function (event) {
          if (event.lengthComputable) {
            document.getElementById("progess-bar-discussion").style.display = "block";
            var percentComplete = (event.loaded / event.total) * 100;
            console.log("Upload progress: " + percentComplete.toFixed(2) + "%");
            document.getElementById("progress-bar-fill-discussion").style.width =
              percentComplete.toFixed(2) + "%";
          }
        },
        false
      );

      return xhr;
    },
    success: function (response) {
      console.log(response);

      if (response) {
        console.log("checkpoint");
        file_name = response;
        fileType = file_type;

        let tag = "";

        if (file_type == "img") {
          tag = "img";
        } else if (file_type == "vid") {
          tag = "video";
        } else if (file_type == "pdf") {
          tag = "embed";
        }

        const mediaDiv = document.createElement(tag);
        if (file_type == "vid") {
          mediaDiv.control = true;
        }

        mediaDiv.src = `../media_bucket/posts/${file_type}/${response}`;
        mediaDiv.className = "post-media-display";

        document.getElementById("modal-media").appendChild(mediaDiv);
        document.getElementById("modal-options").style.display = "none";
      } else {
        showPopup("Error", "File upload failed. Try uploading files under 1mb.");
      }
    },
    error: function (xhr, status, error) {
      console.log("AJAX Error:", error);
    },
  });
}
