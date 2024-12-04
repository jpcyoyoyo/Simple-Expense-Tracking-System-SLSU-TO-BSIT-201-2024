document.addEventListener('DOMContentLoaded', fetchLogs);

let activeFilterType = 'all'; // Track the currently applied filter
let activeFilterParams = {};  // Store filter parameters
let activeSearch = '';
let lastLogTime = null; // Initialize to null to track the latest log timestamp

function fetchLogs() {
    fetch('backend/php/main_app_content_admin/logs/get_logs.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateLogsTable(data.logs);
                populateLogFilters(data.years);
            } else {
                console.error('Failed to fetch logs:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching logs:', error);
        });
}

function populateLogsTable(logs) {
    const tableBody = document.getElementById('logs-table-body');
    let noRecordsRow = document.getElementById('logs-no-records-row');
    tableBody.innerHTML = '';

    if (!noRecordsRow) {
        noRecordsRow = document.createElement('tr');
        noRecordsRow.id = 'logs-no-records-row';
        noRecordsRow.style.display = 'none';
        noRecordsRow.innerHTML = '<td colspan="3">No logs records found.</td>';
        tableBody.appendChild(noRecordsRow);
    }

    if (logs.length === 0) {
        noRecordsRow.style.display = '';
        calculateTotal();
        return;
    }

    noRecordsRow.style.display = 'none';

    logs.forEach((log) => {
        const statusClass = log.status ? 'status-online' : 'status-offline';

        const row = document.createElement('tr');
        row.setAttribute('data-log-id', log.id); // Mark the row with the log ID
        row.innerHTML = `
            <td>${log.id}</td>
            <td>${log.created_at}</td>
            <td>
                <span class="status-indicator ${statusClass}">${log.description}</span>
            </td>
            <input type="hidden" class="logs-month" value="${log.month}">
            <input type="hidden" class="logs-year" value="${log.year}">
            <input type="hidden" class="logs-created_at" value="${log.created_at}">
        `;
        tableBody.appendChild(row);
    });

    // Update lastLogTime with the most recent log's created_at timestamp
    lastLogTime = logs[0]?.created_at || null;

    // Apply the currently active filter or search
    applyCurrentFilterOrSearch();

    calculateTotal();
}

function toggleFilterOptions(filterType, tabType) {
    activeFilterType = filterType;
    const filterContainer = document.getElementById(`${tabType}-filters`);
    const allFilters = filterContainer.querySelectorAll('.filter-option');

    allFilters.forEach(filter => filter.style.display = 'none');

    if (filterType === 'all') {
        applyFilter('all', tabType);
    } else {
        const selectedFilter = document.getElementById(`${tabType}-${filterType}-filter`);
        if (selectedFilter) selectedFilter.style.display = 'block';
    }
}

function populateLogFilters(years) {
    const monthSelect = document.getElementById('logs-month-select');
    const yearSelect = document.getElementById('logs-year-select');

    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    if (years.length > 0) {
        // Populate years
        yearSelect.innerHTML = years.map(year => `<option value="${year}">${year}</option>`).join('');

        // Populate months
        monthSelect.innerHTML = months.map(month => `<option value="${month}">${month}</option>`).join('');
        monthSelect.disabled = false; // Enable month select
    } else {
        // Show "No records available" for years and disable month dropdown
        yearSelect.innerHTML = `<option value="">No records available</option>`;
        monthSelect.disabled = true; // Disable month select
    }
}

function applyFilter(filterType, reportType) {
    activeFilterType = filterType;
    activeFilterParams = {};

    const tableBody = document.getElementById(`${reportType}-table-body`);
    const rows = tableBody.querySelectorAll('tr');
    const descriptionElement = document.getElementById(`${reportType}-description`);
    const noRecordsRow = document.getElementById(`${reportType}-no-records-row`);
    let descriptionText = `All ${reportType} records`;
    let filterMonth, filterYear, filterStartDate, filterEndDate;
    let hasVisibleRows = false;

    // Set filter parameters based on filterType
    if (filterType === 'month') {
        filterMonth = document.getElementById(`${reportType}-month-select`).value;
        filterYear = document.getElementById(`${reportType}-year-select`).value;
        activeFilterParams = { filterMonth, filterYear };
        if (filterMonth && filterYear) {
            descriptionText = `Showing ${reportType} records for ${filterMonth} ${filterYear}`;
        }
    } else if (filterType === 'dateRange') {
        const startDateInput = document.getElementById(`${reportType}-start-date`).value;
        const endDateInput = document.getElementById(`${reportType}-end-date`).value;

        if (!startDateInput || !endDateInput) {
            descriptionElement.textContent = 'Error: Please select both a start date and an end date.';
            return;
        }

        filterStartDate = new Date(startDateInput);
        filterEndDate = new Date(endDateInput);

        if (isNaN(filterStartDate) || isNaN(filterEndDate)) {
            descriptionElement.textContent = 'Error: One or both of the dates are invalid.';
            return;
        }

        if (filterEndDate < filterStartDate) {
            descriptionElement.textContent = 'Error: End date cannot be earlier than start date.';
            return;
        }

        activeFilterParams = { filterStartDate, filterEndDate };
        descriptionText = `Showing ${reportType} records from ${filterStartDate.toLocaleDateString()} to ${filterEndDate.toLocaleDateString()}`;
    }

    // Update description text
    descriptionElement.textContent = descriptionText;

    // Filter rows and check visibility
    rows.forEach(row => {
        const rowMonth = row.querySelector(`.${reportType}-month`)?.value;
        const rowYear = row.querySelector(`.${reportType}-year`)?.value;
        const rowDateValue = row.querySelector(`.${reportType}-created_at`)?.value;
        const rowDate = rowDateValue ? new Date(rowDateValue) : null;

        let showRow = true;

        if (row.id === `${reportType}-no-records-row`) {
            return;
        }

        if (filterType === 'month' && (rowMonth !== filterMonth || rowYear !== filterYear)) {
            showRow = false;
        }

        if (filterType === 'dateRange' && rowDate) {
            if (rowDate < filterStartDate || rowDate > filterEndDate) {
                showRow = false;
            }
        }

        row.dataset.isVisible = showRow; // Set filter visibility state
        row.style.display = showRow ? '' : 'none';

        if (showRow) {
            hasVisibleRows = true;
        }
    });

    // Update noRecordsRow visibility based on hasVisibleRows
    noRecordsRow.style.display = hasVisibleRows ? 'none' : '';

    // Reapply search if active
    if (activeSearch === 'search') {
        searchTable(); // This will respect the current filtering
    }
}

function searchTable() {
    activeSearch = 'search';

    const searchValue = document.getElementById('search-bar').value.toLowerCase();
    const table = document.getElementById('logs-table-body');
    const rows = table.getElementsByTagName('tr');
    const noRecordsRow = document.getElementById('logs-no-records-row');

    let hasVisibleRows = false; // Flag to check if any rows match

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');

        // Skip the no-records-row for now
        if (row.id === 'logs-no-records-row') {
            continue;
        }

        let match = !searchValue; // If searchValue is empty, show all rows
        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(searchValue)) {
                match = true;
                break;
            }
        }

        const isVisible = match && row.dataset.isVisible === 'true';
        row.style.display = isVisible ? '' : 'none';

        if (isVisible) {
            hasVisibleRows = true;
        }
    }

    noRecordsRow.style.display = hasVisibleRows ? 'none' : '';
}

function fetchNewLogs() {
    fetch(`backend/php/main_app_content_admin/logs/check_new_logs.php?lastLogTime=${encodeURIComponent(lastLogTime || '')}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newLogs = data.logs;
                if (newLogs.length > 0) {
                    lastLogTime = newLogs[0].created_at;
                    addNewLogsToTable(newLogs);
                }
            } else {
                console.error('Failed to fetch new logs:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching new logs:', error);
        });
}

function addNewLogsToTable(newLogs) {
    const tableBody = document.getElementById('logs-table-body');

    newLogs.forEach((log) => {
        const existingRow = document.querySelector(`tr[data-log-id="${log.id}"]`);
        if (existingRow) return;

        const statusClass = log.status ? 'status-online' : 'status-offline';

        const row = document.createElement('tr');
        row.setAttribute('data-log-id', log.id);
        row.innerHTML = `
            <td>${log.id}</td>
            <td>${log.created_at}</td>
            <td>
                <span class="status-indicator ${statusClass}">${log.description}</span>
            </td>
            <input type="hidden" class="logs-month" value="${log.month}">
            <input type="hidden" class="logs-year" value="${log.year}">
            <input type="hidden" class="logs-created_at" value="${log.created_at}">
        `;

        tableBody.insertBefore(row, tableBody.firstChild);
    });

    applyCurrentFilterOrSearch(); // Reapply the active filter or search
    calculateTotal();
}

function applyCurrentFilterOrSearch() {
    if (activeSearch === 'search' && (activeFilterType === 'month' || activeFilterType === 'dateRange')) {
        applyFilter(activeFilterType, 'logs'); // Apply current filter, then search
    } else if (activeSearch === 'search') {
        searchTable(); // Only search if no filters are applied
    } else {
        applyFilter(activeFilterType, 'logs'); // Apply filter if no active search
    }
}

function calculateTotal() {
    const totalAmount = document.getElementById('logs-total-amount');
    const rows = document.querySelectorAll('#logs-table-body tr');
    totalAmount.textContent = rows.length - 1;
}

setInterval(fetchNewLogs, 5000); // Poll for new logs every 5 seconds