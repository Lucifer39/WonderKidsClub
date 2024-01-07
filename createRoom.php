<?php 
    include("config/config.php");
    include("battle_functions.php");

    $sessionsql = mysqli_query($conn, "SELECT isAdmin,fullname,school,class,avatar FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_array($sessionsql, MYSQLI_ASSOC);

    $clsSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE id='".$sessionrow['class']."' and type=2 and status=1");
    $clsrow = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

    $schSQL = mysqli_query($conn, "SELECT id,name FROM school_management WHERE id='".$sessionrow['school']."' and status=1");
    $schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);
    $schrow_main = $schrow['name'];

    $usrSQL = mysqli_query($conn, "SELECT id,school,class,fullname FROM users WHERE school='".$sessionrow['school']."' and class='".$sessionrow['class']."' and isAdmin=2 and status=1");
    $usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

    if(isset($_POST['createRoomNow'])) {
        $numQues = $_POST['numQues'] ?? 10;
        $selTopic = $_POST['selTopic'] ?? "All";
        $numPlayers = $_POST['numPlayers'] ?? 5;
        $timePerQues = $_POST['timePerQues'] ?? 60;

        // Create a DateTime object
        $dateTimeObj = new DateTime();
        $dateTimeObj->add(new DateInterval('PT1M'));
        // Format DateTime as a string suitable for MySQL DATETIME type
        $formattedDateTime = $dateTimeObj->format('Y-m-d H:i:s');

        $room = createRoom($numQues, $selTopic, $numPlayers, $timePerQues, $formattedDateTime);
        
        if($room) {
           header('Location:'. $baseurl .'waiting_room?room='. urlencode($room)); 
        } else {
            $errMsgCreateRoom = '<div class="alert-danger w-100 p-2 mb-2">Error Creating Room. '. $conn->error .'</div>';
        }
    }
    
    if(isset($_POST['createRoom'])) {
        $numQues = $_POST['numQues'] ?? 10;
        $selTopic = $_POST['selTopic'] ?? "All";
        $numPlayers = $_POST['numPlayers'] ?? 5;
        $timePerQues = $_POST['timePerQues'] ?? 60;
        $scheduleDate = $_POST['scheduleDate'];
        $scheduleTime = $_POST['sel-hour'] . ":" . $_POST['sel-min'];

        $dateTime = $scheduleDate . ' ' . $scheduleTime;

        // Create a DateTime object
        $dateTimeObj = new DateTime($dateTime);

        // Format DateTime as a string suitable for MySQL DATETIME type
        $formattedDateTime = $dateTimeObj->format('Y-m-d H:i:s');

        $room = createRoom($numQues, $selTopic, $numPlayers, $timePerQues, $formattedDateTime);
        
        if($room) {
           header('Location:'. $baseurl .'waiting_room?room='. urlencode($room)); 
        } else {
            $errMsgCreateRoom = '<div class="alert-danger w-100 p-2 mb-2">Error Creating Room. '. $conn->error .'</div>';
        }
    }
    
    if($sessionrow['isAdmin'] == '2') { ?>
        <?php include("header.php"); ?>
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 pe-5">
                        <div class="breadcrumbs st-breadcrumbs mb-4">
                            <span><a href="<?php echo $baseurl.'dashboard'; ?>">Home</a></span>
                            <span>Create Room</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <h2 class="section-title flex-1 mb-2">Create Room</h2>
                        <?php echo $errMsgCreateRoom; ?>
                        <form action="" method="post">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Number of Questions</span>
                                <input type="number" name="numQues" id="numQues" class="form-control" placeholder="Enter Number of Questions" value="10" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Topic</span>
                                <select name="selTopic" id="selTopic" class="form-select">
                                    <option value="All" selected>All</option>
                                    <?php 
                                        $selTopSQL = mysqli_query($conn, "SELECT id, topic FROM topics_subtopics WHERE class_id = '".$sessionrow['class']."' AND parent = 0 AND status = 1"); 
                                        while($selTopRow = mysqli_fetch_assoc($selTopSQL)) { ?>
                                            <option value="<?php echo $selTopRow['id']; ?>"><?php echo $selTopRow['topic']; ?></option>
                                        <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Number of Players</span>
                                <input type="number" name="numPlayers" id="numPLayers" class="form-control" placeholder="Enter Maximum Number of Players" value="10" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Time per Question</span>
                                <input type="number" name="timePerQues" id="timePerQues" class="form-control" placeholder="Enter Time Needed Per Question (in secs)" value="60" required>
                            </div>

                            <div class="input-group mb-3">
                                <input type="submit" value="Create Room Now" name="createRoomNow" class="btn btn-primary custom-btn">
                            </div>

                            <hr>

                            <h5 class="title mb-2">Schedule Later</h5>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Schedule Date</span>
                                <input type="date" name="scheduleDate" id="scheduleDate" class="form-control">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Schedule Time</span>
                                    <select id="hour" name="sel-hour"></select>
                                    <select id="minute" name="sel-min"></select>
                            </div>
                            <div class="input-group mb-3">
                                <input type="submit" value="Create Room" name="createRoom" class="btn btn-primary custom-btn">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php include("footer.php"); mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>