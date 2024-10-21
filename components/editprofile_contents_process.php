<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    die("Access denied. Please log in.");
}

// Get the logged-in user's ID from the session
$userId = $_SESSION['userId'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense_tracker";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form data
$fullname = $_POST['fullname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

if (!empty($_FILES['profilePic']['name'])) {
    $profilePicName = basename($_FILES['profilePic']['name']);
    $targetDir = "uploads/";
    $targetFilePath = $targetDir . $profilePicName;

    if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $targetFilePath)) {
        $profilePicPath = $targetFilePath;
    } else {
        $profilePicPath = null;
    }
}

// Prepare the SQL update query based on what fields are being updated
if ($password && $profilePicPath) {
    $sql = "UPDATE user_accounts SET fullname = ?, username = ?, email = ?, password = ?, profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $fullname, $username, $email, $password, $profilePicPath, $userId);
} elseif ($password) {
    $sql = "UPDATE user_accounts SET fullname = ?, username = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $fullname, $username, $email, $password, $userId);
} elseif ($profilePicPath) {
    $sql = "UPDATE user_accounts SET fullname = ?, username = ?, email = ?, profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $fullname, $username, $email, $profilePicPath, $userId);
} else {
    $sql = "UPDATE user_accounts SET fullname = ?, username = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $fullname, $username, $email, $userId);
}

// Execute the query and check for success
if ($stmt->execute()) {
    echo "Profile updated successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
