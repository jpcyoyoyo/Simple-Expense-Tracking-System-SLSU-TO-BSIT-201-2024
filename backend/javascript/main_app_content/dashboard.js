// Function to load dashboard data
function loadDashboardData() {
    fetch('backend/php/fetch_dashboard.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const dashboardData = data.data;

                // Update the HTML elements with the retrieved data
                document.querySelector('.app_body .card:nth-child(1) h1').textContent = `₱ ${dashboardData.balance.toFixed(2)}`;
                document.querySelector('.app_body .card:nth-child(2) h1').textContent = `₱ ${dashboardData.expense_total.toFixed(2)}`;
                document.querySelector('.app_body .card:nth-child(2) h5').textContent = `Record: ${dashboardData.expense_count}`;
                document.querySelector('.app_body .card:nth-child(3) h1').textContent = `₱ ${dashboardData.deposit_total.toFixed(2)}`;
                document.querySelector('.app_body .card:nth-child(3) h5').textContent = `Record: ${dashboardData.deposit_count}`;
            } else {
                console.error(data.message);
                // Handle errors, e.g., display a message to the user
            }
        })
        .catch((error) => {
            console.error('Error fetching dashboard data:', error);
        });
}

// Call the function to load the dashboard data on page load
document.addEventListener('DOMContentLoaded', loadDashboardData);
