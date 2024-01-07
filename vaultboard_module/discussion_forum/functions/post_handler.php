<?php 
     $dir = __DIR__;
     $parent = dirname($dir);
     $parentdir = dirname($parent);
 
     require_once($parentdir . "/connection/dependencies.php");
 
    function create_post($user_id, $content, $media_url, $file_type){
        $conn = makeConnection();

        $sql = "INSERT INTO posts (user_id, content) VALUES (?,?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $user_id, $content);

        if (mysqli_stmt_execute($stmt)) {
            $post_id = mysqli_insert_id($conn);
            if($media_url && $file_type){
                $sql_media = "INSERT INTO media_files (post_id, file_type, media_url) VALUES (?,?,?);";
                $stmt_media = mysqli_prepare($conn, $sql_media);
                mysqli_stmt_bind_param($stmt_media, "iss", $post_id, $file_type, $media_url);
    
                if(mysqli_stmt_execute($stmt_media)){
                    return json_encode("ok");
                }
                else{
                    $sql_delete = "DELETE FROM posts WHERE post_id = $post_id";
                    $result = $conn->query($sql_delete);
                }
            }
           
            return json_encode("ok");
        } 
        else {
          return json_encode(mysqli_stmt_error($stmt));
        }

    }

    function saveFile($file, $file_type) {
        $dir = __DIR__;
        $parentdir = dirname($dir);

        $targetDir = $parentdir ."/media_bucket/posts/$file_type/"; // Specify the target folder where you want to save the files
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION); // Get the file extension
        $fileName = uniqid('', true) . '.' . $extension; // Generate a unique file name using the current timestamp and random string
        $targetPath = $targetDir . $fileName; // Concatenate the target directory and the file name
      
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
          return $fileName; // Return the complete file name with the extension if the file is successfully saved
        } else {
            // File move operation failed
            $lastError = error_get_last();
        
            if ($lastError !== null && isset($lastError['message'])) {
                $errorMessage = "Error uploading file: " . $lastError['message'];
            } else {
                $errorMessage = "Unknown error occurred while uploading the file.";
            }
        
            // Add additional error information if available
            $phpError = error_get_last();
            if ($phpError !== null && isset($phpError['message'])) {
                $errorMessage .= " PHP Error: " . $phpError['message'];
            }
        
            // Return the error message
            return false;
        }
      }
      
    $function_name = $_GET["function_name"] ?? "";

    if($function_name == "create_post"){
        echo create_post($_POST["user_id"], $_POST["content"] ?? "", $_POST["media_url"] ?? NULL, $_POST["file_type"] ?? NULL);
    }

    else if($function_name == "save_file"){
        echo json_encode(saveFile($_FILES["file"], $_POST["file_type"]));
    }
?>