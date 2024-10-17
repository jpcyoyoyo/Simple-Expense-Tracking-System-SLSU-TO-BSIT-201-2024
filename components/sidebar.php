<?php
    // Get the current file name
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="col-md-3 col-12 sidebar vh-100 position-fixed">
    <div class="container-fluid">
        <div class="nav-elements container flex-column">
            <img class="profile" src="assets/reserve_profile.svg" alt="Profile Image">
            <div class="line container"></div>
            <p class="h5 text-center" style="color:black;">Computer Society Org.</p>
            <p class="display-h6 text-center" style="font-size: 15px; color:black;">comsocsociety@gmail.com</p>
            <a href="editprofile.php" class="btn container-fluid">Edit Profile</a>
        </div>

        <div class="space"></div>
        
        <ul class="navbar-nav flex-column">
            <li class="nav-item <?php if($currentPage == 'dashboard.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="dashboard.php">
                    <img class="icon" src="assets/expense_tracker_dashboard.svg" alt="Dashboard Icon">
                    Dashboard
                </a>
            </li>

            <li class="nav-item <?php if($currentPage == 'deposits.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="deposits.php">
                    <img class="icon" src="assets/expense_tracker_deposit.svg" alt="Deposits Icon">
                    Deposits
                </a>
            </li>

            <li class="nav-item <?php if($currentPage == 'expenses.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="expenses.php">
                    <img class="icon" src="assets/expense_tracker_expenses.svg" alt="Expenses Icon">
                    Expenses
                </a>
            </li>

            <li class="nav-item <?php if($currentPage == 'reports.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="reports.php">
                    <img class="icon" src="assets/expense_tracker_reports.svg" alt="Reports Icon">
                    Reports
                </a>
            </li>

            <li class="nav-item <?php if($currentPage == 'settings.php'){ echo 'active'; } ?>" style="padding: 0;">
                <a class="nav-link container-fluid" href="settings.php">
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