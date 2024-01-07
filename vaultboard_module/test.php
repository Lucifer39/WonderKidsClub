<!DOCTYPE html>
<html>
<head>

  <?php 
    include("global/head.php");
    include("global/navigation.php");
    include("global/popup.php");
  ?>
  
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }
    
    .modal-content {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    h4 {
      font-size: 20px;
      color: #333333;
      margin-top: 0;
      margin-bottom: 20px;
    }
    
    p {
      font-size: 16px;
      color: #666666;
      line-height: 1.5;
      margin-bottom: 20px;
    }
    
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    
    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .img-btn{
    width: 5rem;
    height: 5rem;
    border: 2px solid transparent;
    margin: 1rem;
    padding: 1rem;
}

.img-btn.selected {
    border-color: black;
}

.img-btn:hover{
    cursor: pointer;
}
  </style>
</head>
<body>

<div class="modal fade" id="registerModal" aria-hidden="true" aria-labelledby="registermodal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg flip">
    <div class="modal-content">
      <div class="modal-body">
        <h3 class="well text-center mt-2"><b>Wonderkids</b></h3>
        <div class="col-lg-12 well">
              <div class="row">
                  <form method="post" id="registration-form" class="p-4">
                      <div class="col-sm-12">
                          <label>Select Avatar*</label>
                          <input type="hidden" name="avatar" id="filename">
                          <div class="grid-container">
                              <?php
                                  $avatardir = ROOT_FOLDER . "type_master/assets/avatars";
                                  if ($handle = opendir($avatardir)) {
                                    while (($file = readdir($handle)) !== false) {
                                        $selected = "";
                                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                                        if (in_array($ext, array("jpg", "jpeg", "png", "gif", "svg"))) {
                                            $filename = pathinfo($file, PATHINFO_FILENAME);
                                            $avatarUrl = GLOBAL_URL . 'type_master/assets/avatars/' . $file;
                                            
                                            echo '<label>
                                                  <input type="radio" name="avatar" value="' . $filename . '.' . $ext . '" style="display:none">
                                                  <img src="' . $avatarUrl . '" alt="' . $filename . '" class="img-btn" id="' . $filename . '.' . $ext . '" onclick="handle_image_click(\'' . $filename . '.' . $ext . '\')">
                                                  </label>';
                          
                                        }
                                    }
                                    closedir($handle);
                                }
                              ?>
                          </div>

                          <div class="row">
                              <div class="col-sm-12 form-group">
                                  <label>Username*</label>
                                  <input type="text" id="username-registration" name="username" placeholder="Enter Username Here..." class="form-control shadow reginput" required>
                                  <span class="username-indicator" id="username-indicator"></span>
                              </div>
                             
                          </div><br/>
                          <div class="text-center mt-2">
                            <input type="submit" name="submit-btn" class="btn btn-success" value="Submit">
                          </div>

                      </div>
                  </form> 
              </div>
          </div>
      </div>
    </div>
  </div>
</div>

<script>
    function handle_image_click(filename) {
        var image = document.getElementById(filename);
        var radioBtn = image.previousElementSibling;

        // Remove the "selected" class from all images
        var images = document.getElementsByClassName('img-btn');
        for (var i = 0; i < images.length; i++) {
            images[i].classList.remove('selected');
        }

        // Add the "selected" class to the clicked image
        image.classList.add('selected');

        // Check the associated radio button
        radioBtn.checked = true;
    }

    window.addEventListener("load", function() {
      var myModal = new bootstrap.Modal(document.getElementById("registerModal"));
      myModal.show();
    });

    const usernameContainer = document.getElementById("username-registration");

    usernameContainer.addEventListener("input", () => {
      $.ajax({
        type: "POST",
        url: "<?php echo GLOBAL_URL ?>connection/dependencies.php?function_name=getUsername",
        data: {
          username: usernameContainer.value,
        },
        success: function (res) {
          var response = JSON.parse(res);

          if (response) {
            document.getElementById("username-indicator").textContent = "";
            usernameContainer.style.border = "2px solid green";
          } else {
            document.getElementById("username-indicator").textContent = "username already taken";
            document.getElementById("username-indicator").style.color = "red";
            usernameContainer.style.border = "2px solid red";
          }
        },
      });
    });

    const formRegistration = document.getElementById("registration-form");

    formRegistration.addEventListener("submit", (event) => {
      event.preventDefault();

      const avatar = formRegistration.elements["avatar"].value;
      const username = formRegistration.elements["username"].value;

      if (!avatar) {
        showPopup("Error", "Please enter your avatar!");
        return;
      }

      if (!username) {
        showPopup("Error", "Please enter your username!");
        return;
      }

      $.ajax({
        type: "post",
        url: "<?php echo GLOBAL_URL; ?>connection/dependencies.php?function_name=setAvatarUsername",
        data: {
          avatar, username
        },
        success: function(res) {
          var response = JSON.parse(res);

          if(response) {
            window.location.href = "<?php echo GLOBAL_URL; ?>";
          }
        }
      })
    });
</script> 
</body>
</html>
