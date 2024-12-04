<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "example_db";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch logs from the database
$sql = "SELECT log_id, user_id, username, login_time, logout_time FROM user_logs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Logs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th,td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            bordere: none;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>User Logs</h1>
    <table>
        <thead>
            <tr>
                <th>Log ID</th>
                <th>Username</th>
                <th>Login Time</th>
                <th>Logout Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['log_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['login_time']; ?></td>
                        <td><?php echo $row['logout_time']; ?></td>
                        <td>
                            <a class="btn" href="view_activities.php?log_id=<?php echo $row['log_id']; ?>">View Activities</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No logs available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php $conn->close(); ?>
