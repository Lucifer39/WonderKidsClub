<?php
include '../connection/conn.php';
include '../global/navigation.php';

$conn = makeConnection();

//parents details form submit
if(isset($_POST['parentshare']))
{
    if(!empty($_FILES['pdfattach']['name'])){
        echo "Helo";
        $parentname=$_POST['parentname'];
        $phone = $_POST['phone'];
        $category = $_POST['category'];
        $url = $_POST['url'];

        $uploadDir = __DIR__."/images/pdfupload/";
        $fileName = basename($_FILES["pdfattach"]["name"]);
        $targetPath = $uploadDir. $fileName;

        echo $targetPath;

        if(move_uploaded_file($_FILES["pdfattach"]["tmp_name"], $targetPath)){
            echo "Hello world";
            $sql="INSERT INTO `parentsshare`(`name`, `contact_no`, `category`, `url`, `file_upload`, `upload_date`) VALUES ('$parentname','$phone','$category','$url','$fileName',NOW())";
            if(mysqli_query($conn, $sql)){
                echo '<script>alert("Form Submitted Successfully")
                window.location.href="./"
                </script>';
            } else{
                header('location:./');
            }
        }
    }else{
        echo '<script>alert("Please upload the pdf for the Event")
        window.location.href="./"
        </script>';
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

        $pdfuploadDir = "./images/pdfupload/";
        $pdfupload = basename($_FILES["pdfattach"]["name"]);
        $pdftargetPath = $pdfuploadDir. $pdfupload;

        $banneruploadDir = "./images/banner/";
        $banner = basename($_FILES["banner"]["name"]);
        $bannertargetPath = $banneruploadDir. $banner;

        if(move_uploaded_file($_FILES["pdfattach"]["tmp_name"], $pdftargetPath) && move_uploaded_file($_FILES["banner"]["tmp_name"], $bannertargetPath)){
            $sql="INSERT INTO `organizationshare`(`org_name`, `contact`, `category`, `description`, `banner`, `url`, `file_upload`,`upload_date`) VALUES ('$orgname','$phone','$category','$description','$banner','$url','$pdfupload',NOW())";
            if(mysqli_query($conn, $sql)){
                echo '<script>alert("Form Submitted Successfully")
                window.location.href="./"
                </script>';
            } else{
                header('location:./');
            }
        }
    }else{
        echo '<script>alert("Please upload the Banner for the Event")
        window.location.href="./"
        </script>';
    }
}
?>