function loadDashboardData(){
    fetch('backend/php/main_app_content_admin/dashboard_admin/fetch_dashboard_admin.php')
    .then(response => response.json())
    .then(data => {
        if (data.success){
            const dashboardData = data.data;

            const accountTotal = parseFloat(dashboardData.accountTotal) || 0;
            const accountActive = parseFloat(dashboardData.accountActive) || 0;
            const totalLog = parseFloat(dashboardData.totalLogs) || 0;

            document.querySelector('.app_body .card:nth-child(1) h1') .textContent = '${accountTotal}';
            document.querySelector('.app_body .card:nth-child(2) h1') .textContent = '${accountActive}';
            document.querySelector('.app_body .card:nth-child(3) h1') .textContent = '${totalLog}';
        } else {
            console.error('Error:', data.message);
        }
    })
    .catch((error) =>{
        console.error('Error fetching dashboard data', error);
    });
}

function startDashboardDataFetch(intervals = 5000) {
    loadDashboardData();

    setInterval(loadDashboardData, intervalMs);
}

document.addEventListener('DOMContentLoaded', () => startDashboardDataFetch(2000));