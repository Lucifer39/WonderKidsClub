<?php
    $dir = __DIR__;
    $parentdir = dirname($dir);

    require_once($parentdir . "/connection/dependencies.php");
    require_once($parentdir. "/global/head.php");
    require_once($parentdir . "/global/navigation.php");
    require_once($parentdir ."/global/popup.php");
    $schools = getSchools();
    $classes = getClasses();
?>

<style>
    /* @import "font-awesome.min.css";
    @import "font-awesome-ie7.min.css"; */
/* Space out content a bit */
body {
  padding-top: 20px;
  padding-bottom: 20px;
}

/* Everything but the jumbotron gets side spacing for mobile first views */
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
    width: 10rem;
    height: 10rem;
    border: 1px solid black;
    margin: 2rem;
    padding: 1rem;
}

.img-btn:hover{
    cursor: pointer;
}


</style>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<script>
    function handle_image_click(filename){
        document.getElementById("filename").value = filename;
        document.getElementById(filename).style.border = "5px solid black";
    }
</script>

<div class="container">
    <h1 class="well">Word Sprinter Registration</h1>
	<div class="col-lg-12 well">
        <div class="row">
                <form method="post" id="registration-form">
                    <div class="col-sm-12">
                        <!-- <div class="form-group">
                            <label>Stage Name</label>
                            <input type="text" placeholder="Stage Name..." class="form-control">
                        </div> -->
                        <form>
                        <label>Select Avatar*</label>
                        <input type="hidden" name="avatar" id="filename">
                        <div class="grid-container">
                            <?php
                                $dir = "../type_master/assets/avatars";
                                if ($handle = opendir($dir)) {
                                    
                                    while (($file = readdir($handle)) !== false) {
                                        $selected = "";
                                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                                        if (in_array($ext, array("jpg", "jpeg", "png", "gif", "svg"))) {
                                            $filename = pathinfo($file, PATHINFO_FILENAME);
                                            // $full_file = $filename. '.' .$ext;

                                            // if($_POST["avatar"]??"" == $full_file){
                                            //     $selected = "img-select";
                                            // }

                                            echo '<span onclick="handle_image_click(\''.$filename.'.'.$ext.'\')">
                                                    <img src="'.$dir.'/'.$file.'" alt="'.$filename.'" id="'.$filename.'.'.$ext.'" class="img-btn">
                                                </span>';
                                        }
                                    }
                                    closedir($handle);
                                }
                            ?>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Username*</label>
                                <input type="text" id="username" name="username" placeholder="Enter Username Here..." class="form-control" required>
                                <span class="username-indicator" id="username-indicator"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>First Name*</label>
                                <input type="text" name="first-name" placeholder="Enter First Name Here..." class="form-control" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Last Name*</label>
                                <input type="text" name="last-name" placeholder="Enter Last Name Here..." class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Email Address*</label>
                                <input type="text" name="email" id="email" placeholder="Enter Email Address Here..." class="form-control" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Age*</label>
                                <input type="number" name="age" placeholder="Enter Age..." class="form-control">
                            </div>
                        </div>	                    
                       
                
                    <div class="row">
                        
                        <div class="col-sm-6 form-group">
                            <label>School*</label>
                            <input type="text" name="school" placeholder="Type School Name..." id="school-form" class="form-control">
                            <ul id="suggestionsList" class="suggestionsList"></ul>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label>Class*</label>
                            <!-- <input type="text" name="class" placeholder="Type class..." id="class-form" class="form-control"> -->
                            <!-- <ul id="suggestionsListClass" class="suggestionsList"></ul> -->
                            <select class="form-control" name="class">
                                <option value="Prep">Prep</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>	
                    
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Password*</label>
                            <input type="text" name="password" placeholder="Enter password..." id="password" class="form-control" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Confirm Password*</label>
                            <input type="text" name="password-confirm" placeholder="Re-type password..." id="confirm-password" class="form-control" required>
                        </div>
                    </div>

                        <input type="submit" name="submit-btn" class="btn btn-lg btn-info" value="Submit">
                        <button class="btn btn-lg btn-info" id="cancel-btn">Cancel</button>

                    </div>
                </form> 
            </div>
        </div>
</div>

<script src="registration_page.js"></script>

<script>
    var schoolInput = document.getElementById("school-form");
    var classInput = document.getElementById("class-form");
    var suggestionsListSchool = document.getElementById("suggestionsList");
    var suggestionsListClass =document.getElementById("suggestionsListClass");
    var suggestionsSchools = <?php echo json_encode($schools); ?>;
    var suggestionsClasses = <?php echo json_encode($classes); ?>;

    schoolInput.addEventListener("input", () => autoComplete(schoolInput, suggestionsSchools, suggestionsListSchool));
    // classInput.addEventListener("input", () => autoComplete(classInput, suggestionsClasses, suggestionsListClass));
    schoolInput.addEventListener("blur", () => {
        suggestionsListSchool.style.display = "none";
    });
    // classInput.addEventListener("blur", () => {
    //     suggestionsListClass.style.display = "none";
    // });



    function autoComplete(input, suggestions, suggestionsList) {
        // Get the input element and value
        var inputValue = input.value;


        // Filter the suggestions based on the input value
        var filteredSuggestions = suggestions.filter(function(suggestion) {
            return suggestion.toLowerCase().startsWith(inputValue.toLowerCase());
        });

        // Display the filtered suggestions
        suggestionsList.innerHTML = "";
        suggestionsList.style.display = "block";
        filteredSuggestions.forEach(function(suggestion) {
            var li = document.createElement("li");
            li.textContent = suggestion;
            li.addEventListener("click", function() {
                input.value = suggestion;
                suggestionsList.innerHTML = "";
            });
            suggestionsList.appendChild(li);
        });
    }

    let pwd = document.getElementById("password");
    let conPwd = document.getElementById("confirm-password");

    function checkPassword(){
        if(pwd.value === conPwd.value){
            conPwd.style.border = "2px solid green";
        }
        else{
            conPwd.style.border = "2px solid red";
        }
    }

    conPwd.addEventListener("input", checkPassword);

    // if(document.activeElement === input){
    //     suggestionsList.style.display = "block";
    // }
    // else{
    //     suggestionsList.style.display = "none";
    // }



</script>

