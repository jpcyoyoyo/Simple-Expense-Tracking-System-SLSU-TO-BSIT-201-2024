<?php
    include '../../../../conn/conn.php';

    header('Content-Type: application/json');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Start session to access session variables
    session_start();

    $user_id = $_SESSION['user_id'];

    // Fetch expense records
    $stmt = $conn->prepare("SELECT id, description, date, category, item, quantity, amount FROM expense WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $expenses = [];
    while ($row = $result->fetch_assoc()) {
        // Extract month and year from the date field
        $row['month'] = date('F', strtotime($row['date'])); // Full month name (e.g., January)
        $row['year'] = date('Y', strtotime($row['date']));  // Year (e.g., 2023)
        $expenses[] = $row;
    }

    // Fetch distinct categories for filtering
    $stmt_categories = $conn->prepare("SELECT DISTINCT category FROM expense WHERE user_id = ?");
    $stmt_categories->bind_param("i", $user_id);
    $stmt_categories->execute();
    $result_categories = $stmt_categories->get_result();

    $categories = [];
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row['category'];
    }

    // Fetch distinct month-year combinations for filtering
    $stmt_dates = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date, '%Y') AS year_months FROM expense WHERE user_id = ? ORDER BY date");
    $stmt_dates->bind_param("i", $user_id);
    $stmt_dates->execute();
    $result_dates = $stmt_dates->get_result();

    $years = [];
    while ($row = $result_dates->fetch_assoc()) {
        $years[] = $row['year_months'];
    }

    // Send response including expenses, distinct categories, and month-year options
    echo json_encode([
        'success' => true,
        'expenses' => $expenses,
        'categories' => $categories,
        'years' => $years
    ]);

    // Close prepared statements and connection
    $stmt->close();
    $stmt_categories->close();
    $stmt_dates->close();
    $conn->close();
