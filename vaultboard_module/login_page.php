<?php
    $dir = __DIR__;
    $parentdir = dirname($dir);

    $pathforavatar = __DIR__;
    $avatardir = dirname($pathforavatar);

    // define("BASEURL", "http://localhost/vaultboard_module/");
    // define('ROOT_FOLDER', $_SERVER["DOCUMENT_ROOT"] . "/vaultboard_module/");

    require_once(ROOT_FOLDER . "/connection/dependencies.php");
    require_once(ROOT_FOLDER ."/global/head.php");
    require_once(ROOT_FOLDER ."/global/navigation.php");
    require_once(ROOT_FOLDER ."/global/popup.php");

    $schools = getSchools();
    $classes = getClasses();

    $gclass = '';
    $guest = getGuest();
    if($guest == '')
      $gclass = 'modal-lg';

?>

<style>
  .reglink{
    color:black
  }
  .reglink:hover{
    color:darkblue !important
  }
  .header,
.marketing,
.footer {
  padding-right: 15px;
  padding-left: 15px;
}

/* Custom page header */
.header {
  border-bottom: 1px solid #e5e5e5;
}
/* Make the masthead heading the same height as the navigation */
.header h3 {
  padding-bottom: 19px;
  margin-top: 0;
  margin-bottom: 0;
  line-height: 40px;
}

/* Custom page footer */
.footer {
  padding-top: 19px;
  color: #777;
  border-top: 1px solid #e5e5e5;
}

.suggestionsList {
  position: absolute;
  z-index: 1;
  background-color: #fff;
  border: 1px solid #ddd;
  max-height: 200px;
  overflow-y: auto;
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.suggestionsList li {
  padding: 10px;
  cursor: pointer;
}

.suggestionsList li:hover {
  background-color: #f5f5f5;
}

.suggestionsList li.active {
  background-color: #008080;
  color: #fff;
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
.flip {
    animation: flip 0.6s;
    backface-visibility: hidden;
    perspective: 1000px;
    transform-style: preserve-3d;
  }

  @keyframes flip {
    from {
      transform: rotateY(180deg);
    }
    to {
      transform: rotateY(0deg);
    }
  }

  @media screen and (max-width: 768px) {
    .login-body-modal{
      flex-direction: column;
    }

    .border-start{
      border-top: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;
      border-left: none !important;
    }
  }
</style>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered<?php echo " ".$gclass." " ?>flip">
    <div class="modal-content">
      <div class="modal-body p-5">
          <h3 class="text-center"><b>Welcome to WonderKids!</b></h3>
          <div class="row mt-5 login-body-modal">
            <div class="col d-flex justify-content-center align-items-center">
              <form method="POST" id="form-login" class="p-3">
                <input type="hidden" id="selectedCard" name="selectedCard" value="<?php echo $_POST["selectedCard"] ?? ""; ?>">
                <button type="submit" class="btn btn-info">Sign in/Register</button>
              </form>
            </div>
            <?php 
              if(getGuest() == "") {
            ?>
            <br><br>
            <div class="col border-2 border-start border-info">
              <form method="POST" id="form-guest">
                <h6 class="text-center"><b>Login As a Guest</b></h6>
                <input type="hidden" id="selectedCardGuest" name="selectedCardGuest" value="<?php echo $_POST["selectedCard"] ?? ""; ?>">

                <div class="text-center mt-5">
                  <select class="form-select mb-3" name="guest-class-select" id="guest-class-select">
                    <option selected disabled value="">Select Class</option>
                    <option value="Prep">Prep</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                  <button type="submit" class="btn btn-info">View as Guest</button>
                </div>
              </form>
            </div>
            <?php } ?>
          </div>
      </div>
    </div>
  </div>
</div>


  <script>
    
    var loginForm =document.getElementById("form-login");

    loginForm.addEventListener("submit", (event) => {
      event.preventDefault();

      var selectedCard =loginForm.elements["selectedCard"].value;
      var url = "<?php echo ROOT_DOMAIN_URL; ?>?modal=login&redirect=<?php echo urlencode(REDIRECT_URL); ?>";

      // console.log(url);
      if(selectedCard) {
        window.location.href = url + selectedCard;
      }
      else {
        window.location.href = url;
      }
    });

    <?php if(getGuest() == ""){
  ?>

    var guestForm =document.getElementById("form-guest");

    guestForm.addEventListener("submit", (event) => {
      event.preventDefault();

      var guestClass =guestForm.elements["guest-class-select"].value;
      var selectedCard =loginForm.elements["selectedCard"].value;

      
      if(guestClass == ""){
        document.getElementById("guest-class-select").style.border = "2px solid red";

        return;
      }

      $.ajax({
        type: "post",
        url: "<?php echo GLOBAL_URL; ?>connection/dependencies.php?function_name=setGuest",
        data: {
          guestClass
        },
        success: function(res){
          var response = JSON.parse(res);

          if(response){
            if(selectedCard == "vocabulary_module" 
              || selectedCard == "type_master" 
              || selectedCard == "discussion_forum/pages/newsfeed.php"
              || selectedCard == "vocabulary_context"){
              window.location.href = "<?php echo GLOBAL_URL; ?>" + selectedCard;
            }
            else{
              location.reload();
            }
          }
        }
      })

    });
    <?php
} ?>
  </script>


