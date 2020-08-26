<?php

// Enter your Host, username, password, database below.
// I left password empty because i do not set password on localhost.
$con = mysqli_connect("172.18.0.2","root","1234","mydb");
        if (mysqli_connect_errno()){
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                die();
                }
?>
