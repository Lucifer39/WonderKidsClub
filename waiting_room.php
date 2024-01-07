<?php 
    include('config/config.php');
    include('battle_functions.php');

    $sessionsql = mysqli_query($conn, "SELECT isAdmin,fullname,school,class,avatar FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_array($sessionsql, MYSQLI_ASSOC);

    $clsSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE id='".$sessionrow['class']."' and type=2 and status=1");
    $clsrow = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

    $schSQL = mysqli_query($conn, "SELECT id,name FROM school_management WHERE id='".$sessionrow['school']."' and status=1");
    $schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);
    $schrow_main = $schrow['name'];

    $usrSQL = mysqli_query($conn, "SELECT id,school,class,fullname FROM users WHERE school='".$sessionrow['school']."' and class='".$sessionrow['class']."' and isAdmin=2 and status=1");
    $usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

    if($sessionrow['isAdmin'] == '2' && isset($_GET['room'])) { ?>
        <?php 
        include("header.php");
        $room_id = urldecode($_GET['room']); 
        $res_join = joinRoom($room_id);

        if($res_join['status'] == 'Error') {
            header('Location:'.$baseurl.'');
        }
        ?>
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 pe-5">
                        <div class="breadcrumbs st-breadcrumbs mb-4">
                            <span><a href="<?php echo $baseurl.'dashboard'; ?>">Home</a></span>
                            <span>Waiting Room</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <h2 class="section-title flex-1 mb-2">Waiting Room</h2>
                    </div>

                    <div class="d-flex justify-content-evenly align-items-center p-2 waiting-room-desc">
                        <div class="timer-wrapper timer-container-waiting-room position-relative border-0" style="right: auto">
                            <h6 class="me-2">Room starts in: </h6> 
                            <div class="time-main"><img class="me-2" src="../assets/images/clock-time.svg" width="25" height="25" alt=""><div id="timer"></div></div>
                        </div>
                        <div class="room-code-container">
                            <div class="input-group">
                                <input type="text" id="room-code-text" class="form-control" value="<?php echo $_GET['room'] ?>" disabled>
                                <span class="input-group-text">Copy</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-evenly align-items-center p-2">
                    <div class="waiting-list-container">
                        <h3>Waiting List</h3>
                        <ul class="waiting-list-ul" id="waiting-list-ul"></ul>
                    </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include("footer.php"); mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>