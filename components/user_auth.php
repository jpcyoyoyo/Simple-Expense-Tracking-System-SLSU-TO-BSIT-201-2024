<?php
    session_start(); // Start the session

    // Check if the user is logged in
    if (!isset($_SESSION['username']) && !isset($_SESSION['fullname'])) {
        // User is not logged in, redirect to login page
        header("Location: signin.php");
        exit();
    }

    // User is logged in, proceed with dashboard content

