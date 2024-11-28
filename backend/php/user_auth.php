<?php
    session_start(); // Start the session
    
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // If no user is logged in, redirect to login page
        header("Location: signin.php");
        exit();
    }
    
    // Redirect based on user role
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
        // If the user is an admin, redirect to the admin dashboard
        header("Location: dashboard_admin.php");
        exit();
    } 
    

