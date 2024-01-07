<?php
include './connect.php';

//parents details form submit
if(isset($_POST['parentshare']))
{
    if(!empty($_FILES['pdfattach']['name'])){
        $parentname=$_POST['parentname'];
        $phone = $_POST['phone'];
        $category = $_POST['category'];
        $url = $_POST['url'];

        $uploadDir = "../images/pdfupload/";
        $fileName = basename($_FILES["pdfattach"]["name"]);
        $targetPath = $uploadDir. $fileName;

        if(move_uploaded_file($_FILES["pdfattach"]["tmp_name"], $targetPath)){
            $sql="INSERT INTO `parentsshare`(`name`, `contact_no`, `category`, `url`, `file_upload`, `upload_date`) VALUES ('$parentname','$phone','$category','$url','$fileName',NOW())";
            if(mysqli_query($conn, $sql)){
                header('location:../');
            } else{
                header('location:../');
            }
        }
    }else{
        header('location:../error.php');
    }
}
//organization details form submit
if(isset($_POST['orgshare']))
{
    if(!empty($_FILES['pdfattach']['name']) && !empty($_FILES['banner']['name'])){
        $orgname=$_POST['orgname'];
        $phone = $_POST['phone'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $url = $_POST['url'];

        $pdfuploadDir = "../images/pdfupload/";
        $pdfupload = basename($_FILES["pdfattach"]["name"]);
        $pdftargetPath = $pdfuploadDir. $pdfupload;

        $banneruploadDir = "../images/banner/";
        $banner = basename($_FILES["banner"]["name"]);
        $bannertargetPath = $banneruploadDir. $banner;

        if(move_uploaded_file($_FILES["pdfattach"]["tmp_name"], $pdftargetPath) && move_uploaded_file($_FILES["banner"]["tmp_name"], $bannertargetPath)){
            $sql="INSERT INTO `organizationshare`(`org_name`, `contact`, `category`, `description`, `banner`, `url`, `file_upload`,`upload_date`) VALUES ('$orgname','$phone','$category','$description','$banner','$url','$pdfupload',NOW())";
            if(mysqli_query($conn, $sql)){
                header('location:../');
            } else{
                header('location:../');
            }
        }
    }else{
        header('location:../error.php');
    }
}
// admin entering details on his side and then publishing them on the main site
if(isset($_POST['admindisplaydetails']))
{
    if(!empty($_FILES['banner']['name'])){
        $eventname=$_POST['eventname'];
        $orgname=$_POST['orgname'];
        $phone = $_POST['contact'];
        $category = $_POST['category'];
        $fee=$_POST['rfee'];
        $prize=$_POST['prize'];
        $startdate=$_POST['startdate'];
        $enddate=$_POST['enddate'];
        $url = $_POST['url'];

        $stagename = $_POST['stagename'];
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];

        $uploadDir = "../images/pdfupload/";
        $fileName = basename($_FILES["pdfattach"]["name"]);
        $targetPath = $uploadDir. $fileName;

        $uploadBanner = "../images/banner/";
        $banner = basename($_FILES["banner"]["name"]);
        $targetBanner = $uploadBanner. $banner;

        if(move_uploaded_file($_FILES["pdfattach"]["tmp_name"], $targetPath) || move_uploaded_file($_FILES["banner"]["tmp_name"], $targetBanner)){
        
                $sql="INSERT INTO `displaydetails`(`banner`,`event_name`, `organized_by`, `contact_no`, `opportunity`, `reg_fee`, `prizes`, `start_date`, `end_date`, `url`, `pdf`) VALUES
                ('$banner','$eventname','$orgname','$phone','$category','$fee','$prize','$startdate','$enddate','$url','$fileName')";
                
                if(mysqli_query($conn, $sql)){
                    $did = mysqli_insert_id($conn);
                    foreach($stagename as $id=>$val){
                        // Get files upload path
                        $stage        = $stagename[$id];
                        $start = $sdate[$id];
                        $end = $edate[$id];
                        // inserting stages for that particular event if any
                        $stage = "INSERT INTO `stagestable`(`name`, `startdate`, `enddate`, `did`) VALUES ('$stage','$start','$end','$did')";
                        if(mysqli_query($conn, $stage)){
                            header('location:../');
                        }else{
                            header('location:../');
                        }
                    }
                } else{
                    header('location:../');
                }
        }
    }else{
        echo '<script>alert("Please upload the Banner for the Event")
        window.location.href="../"
        </script>';
    }
}
?>