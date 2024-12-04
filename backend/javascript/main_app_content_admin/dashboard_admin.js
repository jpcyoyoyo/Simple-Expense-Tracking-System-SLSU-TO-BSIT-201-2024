// Function to load dashboard data
function loadDashboardData() {
    fetch('backend/php/main_app_content_admin/dashboard_admin/fetch_dashboard_admin.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const dashboardData = data.data;

                // Parse values to numbers, fallback to 0 if the value is invalid
                const accountTotal = parseFloat(dashboardData.accountTotal) || 0;
                const accountActive = parseFloat(dashboardData.accountActive) || 0;
                const totalLog = parseFloat(dashboardData.totalLogs) || 0;
                const depositRecords = parseFloat(dashboardData.depositRecords) || 0;
                const expenseRecords = parseFloat(dashboardData.expenseRecords) || 0;
                const categoryRecords = parseFloat(dashboardData.categoryRecords) || 0;

                // Update the HTML elements with the retrieved data
                document.querySelector('.app_body .card:nth-child(1) h1').textContent = `${accountTotal}`;
                document.querySelector('.app_body .card:nth-child(2) h1').textContent = `${accountActive}`;
                document.querySelector('.app_body .card:nth-child(3) h1').textContent = `${totalLog}`;
                document.querySelector('.app_body .card:nth-child(4) h1').textContent = `${depositRecords}`;
                document.querySelector('.app_body .card:nth-child(5) h1').textContent = `${expenseRecords}`;
                document.querySelector('.app_body .card:nth-child(6) h1').textContent = `${categoryRecords}`;
            } else {
                console.error('Error:', data.message);
                // Optionally, display an error message to the user
            }
        })
        .catch((error) => {
            console.error('Error fetching dashboard data:', error);
        });
}

// Function to initialize periodic fetching
function startDashboardDataFetch(intervalMs = 5000) {
    // Load data once on page load
    loadDashboardData();

    // Set an interval to fetch data periodically
    setInterval(loadDashboardData, intervalMs);
}

// Call the function to start fetching data on page load
document.addEventListener('DOMContentLoaded', () => startDashboardDataFetch(2000)); // Fetch every 5 seconds
