// Function to load dashboard data
function loadDashboardData() {
    fetch('backend/php/main_app_content/dashboard/fetch_dashboard.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const dashboardData = data.data;

                // Parse values to numbers, fallback to 0 if the value is invalid
                const balance = parseFloat(dashboardData.balance) || 0;
                const depositTotal = parseFloat(dashboardData.deposit_total) || 0;
                const expenseTotal = parseFloat(dashboardData.expense_total) || 0;
                const expenseCount = dashboardData.expense_count || 0;
                const depositCount = dashboardData.deposit_count || 0;

                // Update the HTML elements with the retrieved data
                const balanceElement = document.querySelector('.app_body .card:nth-child(1) h1');

                // Apply color based on positive or negative balance
                if (balance >= 0) {
                    balanceElement.style.color = 'lightgreen'; // Green for positive balance
                } else {
                    balanceElement.style.color = 'red'; // Red for negative balance
                }

                // Update the content
                balanceElement.textContent = `₱ ${balance.toFixed(2)}`;
                document.querySelector('.app_body .card:nth-child(2) h1').textContent = `₱ ${expenseTotal.toFixed(2)}`;
                document.querySelector('.app_body .card:nth-child(2) h5').textContent = `Record: ${expenseCount}`;
                document.querySelector('.app_body .card:nth-child(3) h1').textContent = `₱ ${depositTotal.toFixed(2)}`;
                document.querySelector('.app_body .card:nth-child(3) h5').textContent = `Record: ${depositCount}`;
            } else {
                console.error('Error:', data.message);
                // Optionally, display an error message to the user
            }
        })
        .catch((error) => {
            console.error('Error fetching dashboard data:', error);
        });
}

// Call the function to load the dashboard data on page load
document.addEventListener('DOMContentLoaded', loadDashboardData);
