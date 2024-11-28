<?php
    // Redirect based on user role
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
        // If the user is an admin, redirect to the admin dashboard
        header("Location: dashboard_admin.php");
        exit();
    } else if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === false) {
        // If the user is not an admin, redirect to the regular dashboard
        header("Location: dashboard.php");
        exit();
    }
        

