<?php
// Get the current file name
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="col-md-3 col-12 sidebar vh-100 position-fixed">
    <div class="container-fluid">
        <div class="nav-elements container flex-column">
            <img class="profile" src="<?php echo isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'assets/reserve_profile.svg'; ?>" alt="Profile Image">
            <div class="line container"></div>
            <p class="h6 text-center" style="color:black;">
                <?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] . '(Admin)': 'User'; ?>
            </p>
            <p class="display-h6 text-center" style="font-size: 15px; color:black;">
                <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'user@example.com'; ?>
            </p>
            <a href="editprofile_admin.php" class="btn container-fluid">Edit Profile</a>
        </div>

        <div class="space"></div>
        
        <ul class="navbar-nav flex-column">
            <li class="nav-item <?php if($currentPage == 'dashboard_admin.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="dashboard.php">
                    <img class="icon" src="assets/expense_tracker_dashboard.svg" alt="Dashboard Icon">
                    Dashboard
                </a>
            </li>

            <li class="nav-item <?php if($currentPage == 'user_accounts.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="user_accounts.php">
                    <img class="icon" src="assets/expense_tracker_user_accounts.svg" alt="User Accounts Icon">
                    User Accounts
                </a>
            </li>

            <li class="nav-item <?php if($currentPage == 'logs.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="logs.php">
                    <img class="icon" src="assets/expense_tracker_logs.svg" alt="Logs Icon">
                    Logs
                </a>
            </li>

            <li class="nav-item <?php if($currentPage == 'settings_admin.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="settings_admin.php">
                    <img class="icon" src="assets/expense_tracker_settings.svg" alt="Settings Icon">
                    Settings
                </a>
            </li>

            <div class="nav-elements container">
                <div class="line container"></div>
            </div>

            <li class="nav-item <?php if($currentPage == 'logout.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="logout.php">
                    <img class="icon" src="assets/expense_tracker_logout.svg" alt="Log Out Icon">
                    Log Out
                </a>
            </li>
        </ul>
    </div>
</nav>
