<?php
// Database connection (replace with your actual connection)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense_tracker"; // Updated with the correct database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current logged-in user ID (e.g., from session)
session_start();
$user_id = $_SESSION['user_id']; // Ensure user ID is available from session

// Get form data from POST
$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Validate required fields
if ($fullname && $username && $email) {
    // Start SQL query for updating the user info
    $sql = "UPDATE userinfo SET fullname=?, username=?, email=?";

    // Only update the password if the user has entered a new one
    if (!empty($password)) {
        // Hash the password for security (use PASSWORD_BCRYPT for secure hashing)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql .= ", password=?";
    }

    $sql .= " WHERE id=?"; // Update user by their ID

    // Prepare and bind
    if ($stmt = $conn->prepare($sql)) {
        if (!empty($password)) {
            // If the password is provided, bind the password
            $stmt->bind_param("ssssi", $fullname, $username, $email, $hashedPassword, $user_id);
        } else {
            // If no password is provided, exclude password binding
            $stmt->bind_param("sssi", $fullname, $username, $email, $user_id);
        }

        // Execute the statement
        if ($stmt->execute()) {
            // Success message or redirect
            echo "Profile updated successfully!";
            header("Location: profile.php"); // Redirect to profile page after updating
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "All fields except password are required.";
}

$conn->close();
?>
