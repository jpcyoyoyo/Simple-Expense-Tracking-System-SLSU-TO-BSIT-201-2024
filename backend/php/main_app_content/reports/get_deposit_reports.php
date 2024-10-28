<?php
    include '../../../../conn/conn.php';

    header('Content-Type: application/json');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Start session to access session variables
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not authenticated']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Fetch deposit records
    $stmt = $conn->prepare("SELECT id, description, date, category, amount FROM deposit WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $deposits = [];
    while ($row = $result->fetch_assoc()) {
        // Extract month and year from the date field
        $row['month'] = date('F', strtotime($row['date'])); // Full month name (e.g., January)
        $row['year'] = date('Y', strtotime($row['date']));  // Year (e.g., 2023)
        $deposits[] = $row;
    }

    // Fetch distinct categories for filtering
    $stmt_categories = $conn->prepare("SELECT DISTINCT category FROM deposit WHERE user_id = ?");
    $stmt_categories->bind_param("i", $user_id);
    $stmt_categories->execute();
    $result_categories = $stmt_categories->get_result();

    $categories = [];
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row['category'];
    }

    // Fetch distinct month-year combinations for filtering
    $stmt_dates = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date, '%Y-%m') AS month_year FROM deposit WHERE user_id = ? ORDER BY date");
    $stmt_dates->bind_param("i", $user_id);
    $stmt_dates->execute();
    $result_dates = $stmt_dates->get_result();

    $months_years = [];
    while ($row = $result_dates->fetch_assoc()) {
        // Separate month and year for each record
        $month_year = explode("-", $row['month_year']);
        $months_years[] = [
            'month' => date('F', mktime(0, 0, 0, $month_year[1], 10)), // Month as full name (e.g., January)
            'year' => $month_year[0] // Year (e.g., 2023)
        ];
    }

    // Send response including deposits, distinct categories, and month-year options
    echo json_encode([
        'success' => true,
        'deposits' => $deposits,
        'categories' => $categories,
        'months_years' => $months_years
    ]);

    // Close prepared statements and connection
    $stmt->close();
    $stmt_categories->close();
    $stmt_dates->close();
    $conn->close();
?>
