<?php
session_start();

// Check if the session contains the username from the previous step
if (!isset($_SESSION['user_id']) && !isset($_SESSION['question_id'])) {
    header("Location: forgotpassword.php"); // Redirect back if no username is found
    exit();
}

$question_id = $_SESSION['question_id'];
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id']; // Username from the session

// Fetch security questions based on the question_id
$query = "SELECT q1, q2, q3, q1_answer, q2_answer, q3_answer FROM security_q WHERE id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $stmt->bind_result($q1, $q2, $q3, $stored_q1_answer, $stored_q2_answer, $stored_q3_answer);
    $stmt->fetch();
    $stmt->close();
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted answers
    $q1_answer = mysqli_real_escape_string($conn, trim($_POST['q1_answer']));
    $q2_answer = mysqli_real_escape_string($conn, trim($_POST['q2_answer']));
    $q3_answer = mysqli_real_escape_string($conn, trim($_POST['q3_answer']));

    // Compare submitted answers with the stored answers (case-insensitive)
    if (strtolower($q1_answer) == strtolower($stored_q1_answer) &&
        strtolower($q2_answer) == strtolower($stored_q2_answer) &&
        strtolower($q3_answer) == strtolower($stored_q3_answer)) {
        // Log the successful attempt
        $log_description = "User {$username} successfully answered the security questions.";
        createLog($conn, $user_id, $log_description, 1);

        // Answers match, proceed to reset password
        header("Location: resetpassword.php");
        exit();
    } else {
        // Log the failed attempt
        $log_description = "User {$username} failed to answer the security questions.";
        createLog($conn, $user_id, $log_description, 0);

        // If answers do not match, show an error message
        $error_message = "Your answers are incorrect. Please try again.";
    }
}
