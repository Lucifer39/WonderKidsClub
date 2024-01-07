<?php
    // $dir = __DIR__;
    // $parentdir = dirname($dir);

    // require_once($parentdir ."/connection/dependencies.php");
    // require_once("navigation.php");

    $student = getCurrentStudent();
    $student = json_encode($student);
?>

<script>
    var student = <?php echo $student; ?>;
    var global_url = <?php echo json_encode(GLOBAL_URL); ?>;
</script>

<style>
    .notification-btn {
        position: relative;
        background-color: #fff;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 5px 15px;
    }

    .notification-btn .badge {
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(50%, -50%);
        background-color: red;
        color: #fff;
        border-radius: 50%;
        font-size: 12px;
        padding: 3px 6px;
    }

    .notification-content{
        position:absolute;
        z-index: 999;
        display: none;
        background-color: #fff;
        width: 300px;
        height: 500px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        padding: 1rem;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        margin-left: -8rem;
    }

    .notification-content div a{
        color: black;
    }

    .notification-content div{
        border-bottom: 1px solid gray;
    }

    .notification-content div:hover{
       background-color: #eee;
    }

    .notif-unseen{
      background-color: #efefef;
    }

</style>

<body>
    <div class="notification-container">
        <div class="notification-btn" id="notification-btn">
            <i class="fa fa-bell"></i>
            <span class="badge" id="badge"></span>
        </div>

        <div class="notification-content" id="notification-content"></div>
    </div>
</body>

<!-- <script src="<?php echo $parentdir; ?>/global/notification_tab_script.js"></script> -->
<script>
    var notif_cont = document.getElementById("notification-content");

function populateNotifications() {
  $.ajax({
    type: "POST",
    url: "../type_master/functions/handle_invitations.php?function_name=getNotifications",
    data: {
      student_id: student.id,
    },
    success: function (res) {
      var notifs = JSON.parse(res);
      notif_cont.innerHTML = "";

      var notif_count = 0;
      notifs.forEach((element) => {
        var anchor = document.createElement("a");
        var div = document.createElement("div");
        anchor.href = `../type_master/waiting_room_page.php?rc=${element.room_id}&ro=0&rt=${element.room_type}`;
        anchor.textContent = `${element.sender} has invited you to a typing race room.`;

        div.appendChild(anchor);
        

        if (element.seen_notification == 0) {
          notif_count++;
          div.classList.add("notif-unseen");
        }
        else{
          div.classList.add("notif-seen");
        }

        notif_cont.appendChild(div);
      });

      document.getElementById("badge").innerText = notif_count;
    },
  });
}

setInterval(populateNotifications, 1000);

document.getElementById("notification-btn").addEventListener("mouseover", () => {
    notif_cont.style.display = "flex";

    $.ajax({
      type: "POST",
      url: "../type_master/functions/handle_invitations.php?function_name=seenNotification",
      data: {
        user_id: student.id
      }
    })
});

notif_cont.addEventListener("mouseover", () => {
    notif_cont.style.display = "flex";
});

document.getElementById("notification-btn").addEventListener("mouseout", () => {
    notif_cont.style.display = "none";
});

notif_cont.addEventListener("mouseout", () => {
    notif_cont.style.display = "none";
});

</script>