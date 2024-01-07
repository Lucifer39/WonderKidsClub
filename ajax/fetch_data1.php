<?php
// Fetch and process the necessary data
$data = $_GET['id'];  // Retrieve the data using your own logic

// Encode the data as JSON and send it back to the client
echo json_encode($data);
?>