<?php
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // User is not logged in, redirect to login page
        header("Location: dashboard.php");
        exit();
    }

    // User is logged in, proceed with dashboard content

