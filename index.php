<?php
session_start(); // Start the session

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['username']) && isset($_SESSION['fullname'])) {
    header("Location: dashboard.php");
    exit(); // Stop further execution
} else {
    // If not logged in, show the login form or redirect
    header("Location: signin.php");
    exit(); // Stop further execution
}


