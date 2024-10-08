<?php
    session_start(); // Start the session
    include "conn/conn.php"; // Include your database connection

    // Check if user is logged in
    if (isset($_SESSION['username']) && isset($_SESSION['fullname'])) {
        // User is logged in, redirect to dashboard
        header("Location: dashboard.php");
        exit(); // Exit to prevent further execution
        
    } else {
        // User is not logged in, redirect to login page
        header("Location: signin.php");
        exit(); // Exit to prevent further execution
    }
