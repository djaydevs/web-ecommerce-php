<!-- DATABASE CONNECTION -->

<?php

    $serverName = "localhost";
    $userName = "root"
    $pass = "";
    $dbName = "cafe_db";

    $conn =  mysqli_connect($serverName, $userName, $pass, $dbName);

    if (!$conn) {
        die('Connection Failed'. mysqli_connect_error());
    } 

?>