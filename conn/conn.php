<?php
    $host = "locahost";
    $username = "root";
    $password = "";
    $dbname = "expense_tracker";

    $conn = mysqli_connect($host, $username, $password, $dbname);
    
    if (!$conn) {
        die("Connection error" . mysqli_connect_error());
    }
    