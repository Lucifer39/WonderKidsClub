<?php 
     $dir = __DIR__;
     $parentdir = dirname(dirname($dir));
     require_once($parentdir. "/connection/dependencies.php");

     function deleteCompetition($competition, $comp_id) {
        $conn = makeConnection();

        $sql = "DELETE FROM $competition WHERE id = $comp_id ;";
        $result = $conn->query($sql);

        if(!$result) {
            die("Query failed at deleteCompetition: " . $conn->error);
        }

        return;
     }

     function editCompetitionAdmin($comp_id, $orgName, $contact, $category, $url, $desc) {
        $conn = makeConnection();

        $sql = "UPDATE displaydetails
                SET organized_by = '$orgName', contact_no = '$contact', opportunity = '$category', url = '$url', event_name = '$desc' 
                WHERE id = $comp_id;";

        $result = $conn->query($sql);

        if(!$result) {
            die("Query failed at editCompetitionAdmin: " . $conn->error);
        }

        return;
     }

     function editCompetitionParents($comp_id, $orgName, $contact, $category, $url) {
      $conn = makeConnection();

      $sql = "UPDATE parentsshare
              SET name = '$orgName', contact_no = '$contact', category = '$category', url = '$url'
              WHERE id = $comp_id;";

      $result = $conn->query($sql);

      if(!$result) {
          die("Query failed at editCompetitionAdmin: " . $conn->error);
      }

      return;
   }

   function editCompetitionOrg($comp_id, $orgName, $contact, $category, $url, $desc){
         $conn = makeConnection();

         $sql = "UPDATE organizationshare
               SET org_name = '$orgName', contact = '$contact', category = '$category', url = '$url', description = '$desc' 
               WHERE id = $comp_id;";

         $result = $conn->query($sql);

         if(!$result) {
            die("Query failed at editCompetitionAdmin: " . $conn->error);
         }

         return;
   }

     $function_name = $_GET["function_name"] ?? "";
     if($function_name == "deleteCompetition") {
        echo json_encode(deleteCompetition($_POST["competition"], $_POST["comp_id"]));
     }
     else if($function_name == "editCompetitionAdmin") {
        echo json_encode(editCompetitionAdmin($_POST["comp_id"], $_POST["orgname"], $_POST["contact"], $_POST["category"], $_POST["url"], $_POST["desc"]));
     }
     else if($function_name == "editCompetitionParents") {
         echo json_encode(editCompetitionParents($_POST["comp_id"], $_POST["orgname"], $_POST["contact"], $_POST["category"], $_POST["url"]));
     }
     else if($function_name == "editCompetitionOrg") {
      echo json_encode(editCompetitionOrg($_POST["comp_id"], $_POST["orgname"], $_POST["contact"], $_POST["category"], $_POST["url"], $_POST["desc"]));
     }
?>