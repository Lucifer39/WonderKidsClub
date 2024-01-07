<?php 
    $dir = __DIR__;
    $parentdir = dirname($dir);
    require_once($parentdir . "/global/navbar.php");
    require_once("functions/user_profile_functions.php");

    $getGuest = getGuest();
    if($getid == "" && $getGuest == ""){
        echo '<script>window.location.href = "'. GLOBAL_URL .'index.php";</script>';
    }


    $current_student = getCurrentStudent();

    $student_id = $_GET["student_id"] ?? $current_student["id"];

    $student = get_user_details($student_id);
    $student_list = getStudents();
?>

<script>
    var student_list = <?php echo json_encode($student_list); ?>;
    var student_on_profile = <?php echo json_encode($student); ?>;
</script>

<link rel="stylesheet" href="user_profile.css">
<link rel="stylesheet" href="highlights.css">

<?php 
    if($current_student["id"] == $student["id"]) {
        ?>
       

<div class="modal fade" id="edit-about" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="new-about" class="col-form-label">Write about yourself in 50 words:</label>
            <input type="text" class="form-control" id="new-about">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="save-new-about">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add-achievements" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Achievements</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Add photos of your achievements</label>
            <input class="form-control" type="file" id="formFileMultiple" accept="image/*" multiple>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="add-achievement-photos">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php
    }
?>

<div class="user-profile-container">
    <div class="user-profile-details">
        <div class="user-profile-header-flex">
        <div class="user-profile-header card">
            <div class="user-profile-img">
                <img src="../type_master/assets/avatars/<?php echo $student["avatar"] ?? "default-icon.svg"; ?>" alt="">
            </div>
            <div class="user-profile-name">
                <span class="user-profile-username">
                    <?php echo $student["name"]; ?> 
                </span>
                <?php 
                    if($student["fullname"] !== " "){
                        ?>
                             <span class="user-profile-realname">
                                (<?php echo $student["fullname"]; ?>)
                            </span>
                        <?php
                    }
                ?>
            </div>
            <div class="user-profile-class-school">
                <?php echo $student["school"] . " | " . $student["class"]; ?>
            </div>
            <div class="user-profile-adjectives">
                <?php
                    $words = explode(",", $student["adjectives"]); // Split the string into an array of words

                    foreach ($words as &$word) {
                        $w = trim($word);
                        $firstLetter = substr($w, 0, 1); // Get the first letter of each word
                        $remainingLetters = substr($w, 1); // Get the remaining letters of each word

                        $word = "<b>$firstLetter</b>$remainingLetters"; // Wrap the first letter in <strong> tags
                    }

                    $newString = implode(", ", $words); // Join the modified words back into a string

                    echo $newString;
                ?>
            </div>
        </div>
        <div class="user-profile-bio-card card">
            <div class="user-profile-bio-header">
                About
                <?php 
                    if($current_student["id"] == $student["id"]) {
                        ?>
                            <a href="#" class="edit-btn" data-bs-toggle="modal" data-bs-target="#edit-about"><i class="bi bi-pencil-square edit-pencil"></i></a>
                        <?php
                    }
                ?>
            </div>
            <div class="user-profile-bio-content">
                <?php echo $student["bio"]; ?>
            </div>
        </div>
        </div>
        <div class="card user-profile-achievement-card">
            <div class="user-profile-achievement-header">
                    Achievements
                    <?php 
                    if($current_student["id"] == $student["id"]) {
                        ?>
                            <div class="user-profile-adhievement-edit-btns">
                                <a href="#" class="edit-btn" data-bs-toggle="modal" data-bs-target="#add-achievements"><i class="bi bi-plus-lg"></i></a>
                                <!-- <a href="#"><i class="bi bi-pencil-square edit-pencil"></i></a> -->
                            </div>
                        <?php
                    }
                ?>
            </div>
            
            <div class="user-profile-achievement-content">
                <?php 
                    $achievement_list = get_achievements($student["id"]);

                    if(count($achievement_list) == 0 && $current_student["id"] == $student["id"]){
                        echo "Add pictures of your achievements to show off to your friends";
                    }

                    foreach($achievement_list as $achievement){
                        if($achievement->file_type == "img"){
                            echo "<img src='media_bucket/achievements/img/". $achievement->file_name ."' alt=''>";
                        }
                    }
                ?>
            </div>
        </div>
        <div class="card user-progress-card">
            <div class="user-progress-header">
                User Progress
            </div>
            <div class="user-progress-content">
                <script src="https://code.highcharts.com/js/highcharts.js"></script>
                <div id="container-charts" class="charts-div"></div>
                <div id="container-pie-chart" class="charts-div"></div>
                <script src="scripts/pie_chart.js"></script>
            </div>
        </div>
    </div>
    <div class="other-people-container card">
        <div class="other-people-header">
            Visit Your Peers
        </div>
        <div class="other-people-list" id="other-people-list"></div>
    </div>
</div>
<?php 
    if($current_student["id"] == $student["id"]) {
?>
<script src="scripts/user_profile_script.js"></script>
<?php } ?>

<script>
    const otherPeopleList =document.getElementById("other-people-list");

    function populateOtherList(){

        student_list.forEach(student => {

            if(student.id != current_student.id && student.avatar){
                const divContainer =document.createElement("div");
                const avatarSect =document.createElement("div");
                const detailsSect =document.createElement("div");
                const nameSect =document.createElement("div");
                const detSect =document.createElement("div");
                const anchor =document.createElement("a");

                divContainer.className = "other-people-div";
                avatarSect.className = "avatar-section";
                detailsSect.className = "details-section";
                nameSect.className = "name-section";
                detSect.className = "detail-section";

                anchor.href =  `index.php?student_id=${student.id}`;
                const avatar =document.createElement("img");
                avatar.src = `../type_master/assets/avatars/${student?.avatar || "default-icon.svg"}`;

                avatarSect.appendChild(avatar);
                nameSect.textContent = student.name;
                detSect.textContent = student.school + " | " + student.class;

                divContainer.appendChild(avatarSect);
                detailsSect.appendChild(nameSect);
                detailsSect.appendChild(detSect);

                divContainer.appendChild(detailsSect);
                anchor.appendChild(divContainer);

                otherPeopleList.appendChild(anchor);
            }
        })
    }

    populateOtherList();
</script>