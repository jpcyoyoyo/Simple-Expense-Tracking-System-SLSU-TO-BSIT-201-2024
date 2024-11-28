<?php
/**
 * Function to create a log record in the logs table.
 * 
 * @param mysqli $conn Database connection.
 * @param int|null $user_id User ID associated with the log. Can be null for failed attempts.
 * @param string $description Log description.
 * @param int $status Status of the log (1 for success, 0 for error).
 */
function createLog($conn, $user_id, $description, $status) {
    // Ensure no previous results block the connection
    // Clear any remaining results
    while ($conn->more_results() && $conn->next_result()) {
        // Use or discard pending results
        if ($result = $conn->store_result()) {
            $result->free();
        }
    }

    // Prepare the SQL statement for logging
    $log_stmt = $conn->prepare("INSERT INTO logs (status, description, user_id) VALUES (?, ?, ?)");
    if ($log_stmt) {
        $log_stmt->bind_param("isi", $status, $description, $user_id);
        if (!$log_stmt->execute()) {
            error_log("Error inserting log record: " . $log_stmt->error);
        }
        $log_stmt->close(); // Ensure the statement is closed
    } else {
        error_log("Error preparing log insert statement: " . $conn->error);
    }
}
?>
