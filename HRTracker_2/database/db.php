<?php
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "hrtracker";

    $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

    
    // Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>