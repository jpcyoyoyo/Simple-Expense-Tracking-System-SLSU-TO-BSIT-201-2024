<?php
    include '../../../../conn/conn.php';
    include '../../../../backend/php/create_log.php'; // Include the log function

    header('Content-Type: application/json');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Start session to access session variables
    session_start();

    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
    $username = $_SESSION['username'];

    // Get user_id from session
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User $username not authenticated']);
        exit;
    }

    // Fetch deposits
    $stmt = $conn->prepare("SELECT id, description, date, category, amount FROM deposit WHERE user_id = ?");
    if (!$stmt) {
        createLog($conn, $user_id, "Error preparing statement for deposits for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare update statement']);
        exit();
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $deposits = [];
    while ($row = $result->fetch_assoc()) {
        $row['month'] = date('F', strtotime(datetime: $row['date'])); // Full month name (e.g., January)
        $row['year'] = date('Y', strtotime($row['date']));  // Year (e.g., 2023)
        $deposits[] = $row;
    }
    $stmt->close();
    createLog($conn, $user_id, "Fetched deposits for report table successfully for $username.", 1);

    // Fetch distinct categories
    $stmt_categories = $conn->prepare("SELECT DISTINCT category FROM deposit WHERE user_id = ?");
    if (!$stmt_categories) {
        createLog($conn, $user_id, "Error preparing statement for categories for $username:  " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare fetch statement']);
        $stmt->close();
        exit();
    }

    $stmt_categories->bind_param("i", $user_id);
    $stmt_categories->execute();
    $result_categories = $stmt_categories->get_result();

    $categories = [];
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row['category'];
    }
    $stmt_categories->close();
    createLog($conn, $user_id, "Fetched distinct categories for report filters successfully for $username.", 1);

    // Fetch distinct years
    $stmt_dates = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date, '%Y') AS year_months FROM deposit WHERE user_id = ? ORDER BY date");
    if (!$stmt_dates) {
        createLog($conn, $user_id, "Error preparing statement for years for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare fetch statement']);
        $stmt->close();
        exit();
    }

    $stmt_dates->bind_param("i", $user_id);
    $stmt_dates->execute();
    $result_dates = $stmt_dates->get_result();

    $years = [];
    while ($row = $result_dates->fetch_assoc()) {
        $years[] = $row['year_months'];
    }
    $stmt_dates->close();
    createLog($conn, $user_id, "Fetched distinct years for report filters successfully for $username.", 1);

    // Send response including deposits, distinct categories, and years
    echo json_encode([
        'success' => true,
        'deposits' => $deposits,
        'categories' => $categories,
        'years' => $years
    ]);

    $conn->close();

