<?php
// Include the database connection
include '../../../../conn/conn.php'; // Adjust the path as needed

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'logs' => []
];

// Check if `lastLogTime` is provided
if (isset($_GET['lastLogTime']) && !empty($_GET['lastLogTime'])) {
    $lastLogTime = $_GET['lastLogTime'];

    // Prepare the query to fetch logs created after the given time
    $stmt = $conn->prepare("SELECT id, created_at, description, status FROM logs WHERE created_at > ? ORDER BY created_at ASC");

    if ($stmt) {
        $stmt->bind_param("s", $lastLogTime);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $logs = $result->fetch_all(MYSQLI_ASSOC);

            $response['success'] = true;
            $response['logs'] = $logs;
        } else {
            $response['message'] = 'Error executing query: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'Error preparing query: ' . $conn->error;
    }
} else {
    $response['message'] = 'Invalid request. Last log time is required.';
}

// Close the database connection
$conn->close();

// Output the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>