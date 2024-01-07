<?php

function makeConnection(){
    $host = 'localhost';
    $username = 'root';
    $password = 'password';
    $dbname = 'edtech';
    $port = 3306;

    $conn = mysqli_connect($host, $username, $password, $dbname, $port);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

?>