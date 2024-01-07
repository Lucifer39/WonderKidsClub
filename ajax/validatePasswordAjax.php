<?php 
    include("../config/config.php");

    if(isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['new_password_again'])) {
        $old = $_POST['old_password'];
        $new = $_POST['new_password'];
        $new_again = $_POST['new_password_again'];

        if($new !== $new_again) {
            echo json_encode(array("status" => 400, "msg" => "New Passwords Don't Match"));
        } else {
            $sql_get = mysqli_query($conn, "SELECT password FROM users WHERE id = '". $_SESSION['id'] . "'");
            $sql_res = mysqli_fetch_assoc($sql_get);

            if($sql_res['password'] == md5($old)) {
                $new_md = md5($new);
                $sql_upd = mysqli_query($conn, "UPDATE users SET password = '$new_md' WHERE id = '". $_SESSION['id'] . "'");
                if($sql_upd) {
                    echo json_encode(array("status" => 200, "msg" => "Saved Successfully!"));
                } else {
                    echo json_encode(array("status" => 400, "msg" => "Error Updating the Database!"));
                }
            } else {
                echo json_encode(array("status" => 400, "msg" => "Old Password Incorrect"));
            }
        }
    } else {
        echo json_encode(array("status" => 400, "msg" => "Some Fields are incomplete"));
    }
?>