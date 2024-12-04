

// Fetch and display deposits on page load
document.addEventListener('DOMContentLoaded', () => {
    fetchUsers(); // Initial population of users
    monitorUserTable(); // Start monitoring user status
});

let activeFilterType = 'all'; // Track the currently applied filter
let activeFilterParams = {};  // Store filter parameters
let activeSearch = '';
let lastLogTimeUserLogs = null; // Initialize to null to track the latest log timestamp
let fetchLogsIntervalId = null;
let userDetailsUpdateInterval = null;
let userStatusInterval; // Variable to store the interval ID

function fetchUsers() {
    fetch('backend/php/main_app_content_admin/user_accounts/get_users.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateUsersTable(data.users);
                populateFilters(data.years, 'users');
            } else {
                console.error('Failed to fetch users:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching deposits:', error);
        });
}

function populateUsersTable(users) {
    const tableBody = document.getElementById('users-table-body');
    let noRecordsRow = document.getElementById('users-no-records-row');
    tableBody.innerHTML = '';

    if (!noRecordsRow) {
        noRecordsRow = document.createElement('tr');
        noRecordsRow.id = 'users-no-records-row';
        noRecordsRow.style.display = 'none';
        noRecordsRow.innerHTML = '<td colspan="6">No user accounts found.</td>';
        tableBody.appendChild(noRecordsRow);
    }

    if (users.length === 0) {
        noRecordsRow.style.display = '';
        calculateTotal('users');
        return;
    }

    noRecordsRow.style.display = 'none';

    users.forEach((user, index) => {
        const row = document.createElement('tr');
        const statusClass = user.is_login ? 'status-online' : 'status-offline'; // Assign class based on login status
        const statusText = user.is_login ? 'Online' : 'Offline'; // Text for login status

        row.innerHTML = `
            <td>${index + 1}</td> <!-- Sequential numbering -->
            <td>${user.id}</td>
            <td>
                <span class="status-indicator ${statusClass}">${statusText}</span>
            </td> <!-- User's online status with color -->
            <td>${user.username}</td>
            <td>${user.created_at}</td>
            <td class="action-buttons">
                <div class="row g-2 justify-content-center" style="--bs-gutter-y: 0;">
                    <div class="col-auto">
                        <button 
                            class="btn btn-md btn-outline-primary" 
                            style="font-size: small; width: 60px; padding: 2px 0;" 
                            onclick="viewRow(this, '${user.id}')">
                            View
                        </button>
                    </div>
                </div>
            </td>
            <input type="hidden" class="user-fullname" value="${user.fullname}">
            <input type="hidden" class="user-email" value="${user.email}">
            <input type="hidden" class="user-profile_pic" value="${user.profile_pic}">
            <input type="hidden" class="user-updated_at" value="${user.updated_at}">
            <input type="hidden" class="user-is_login" value="${user.is_login}">
            <input type="hidden" class="users-month" value="${user.month}">
            <input type="hidden" class="users-year" value="${user.year}">
            <input type="hidden" class="users-created_at" value="${user.created_at}">
        `;
        tableBody.appendChild(row);
    });

    calculateTotal('users'); // Update totals after populating the table
    applyCurrentFilterOrSearch('users');
}

function viewRow(button) {
    const row = button.closest('tr');
    if (!row) {
        console.error("Row not found");
        return;
    }

    const userId = row.cells[1]?.innerText.trim();
    const fullname = row.querySelector('.user-fullname').value;
    const username = row.cells[3]?.innerText.trim();
    const email = row.querySelector('.user-email').value;
    const profile_pic = row.querySelector('.user-profile_pic').value;
    const created_at = row.cells[4]?.innerText.trim();
    const updated_at = row.querySelector('.user-updated_at').value;
    const is_login = row.querySelector('.user-is_login').value;

    const statusClass = is_login === "1" ? 'status-online' : 'status-offline'; // Assign class based on login status
    const statusText = is_login === "1" ? 'Online' : 'Offline'; // Text for login status

    fetchUserLogs(userId);
    fetchNewUserLogs(userId);

    // Populate modal fields
    document.getElementById('view-user-id').innerText = userId;
    document.getElementById('view-user-fullname').innerText = fullname;
    document.getElementById('view-user-username').innerText = username;
    document.getElementById('view-user-email').innerText = email;
    document.getElementById('view-user-created_at').innerText = created_at;
    document.getElementById('view-user-updated_at').innerText = updated_at;
    document.getElementById('view-user-is_login').innerText = statusText;
    document.getElementById('view-user-is_login').className = `h1 status-indicator ${statusClass}`;
    document.getElementById('view-user-profile-pic').src = profile_pic;

    fetchAndUpdateUserDetails(userId);
    openViewAccountModal();
}

function previewProfilePic(event) {
    const profilePic = document.getElementById('edit-user-profile-pic');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            profilePic.src = e.target.result; // Replace the current profile picture
        };
        reader.readAsDataURL(file); // Read the selected file as a data URL
    }
}

function createUserAccount(event) {
    event.preventDefault(); // Prevent the default form submission

    const form = document.getElementById('create-account-form');
    const formData = new FormData(form);

    // Manually collect input fields outside the form
    const outsideInputs = [
        { id: 'q1', name: 'q1' },
        { id: 'q1_answer', name: 'q1_answer' },
        { id: 'q2', name: 'q2' },
        { id: 'q2_answer', name: 'q2_answer' },
        { id: 'q3', name: 'q3' },
        { id: 'q3_answer', name: 'q3_answer' },
    ];

    outsideInputs.forEach(input => {
        const element = document.getElementById(input.id);
        if (element) {
            formData.append(input.name, element.value);
        }
    });

    // Add the profile picture file to the form data
    const profilePicInput = document.getElementById('createProfilePicInput');
    if (profilePicInput.files.length > 0) {
        formData.append('profilePic', profilePicInput.files[0]);
    }

    // Display loading or disable the submit button
    const submitButton = document.getElementById('create-user-btn');
    submitButton.disabled = true;
    submitButton.innerHTML = 'Creating...';

    // Send data to the server
    fetch('backend/php/main_app_content_admin/user_accounts/create_user_account.php', { // Replace with your API endpoint
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Create User Account';

        if (data.success) {
            alert('User account created successfully!');
            closeAccountModal(); // Assuming this function closes the modal
            form.reset(); // Clear the form

            // Clear additional inputs
            outsideInputs.forEach(input => {
                const element = document.getElementById(input.id);
                if (element) {
                    element.value = '';
                }
            });
        } else {
            // Show error message
            const errorMessage = document.getElementById('create-modal-error-message');
            errorMessage.style.display = 'block';
            errorMessage.textContent = data.error || 'An error occurred while creating the account.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitButton.disabled = false;
        submitButton.innerHTML = 'Create User Account';

        const errorMessage = document.getElementById('create-modal-error-message');
        errorMessage.style.display = 'block';
        errorMessage.textContent = 'An unexpected error occurred. Please try again.';
    });
}

function editUser() {
    const userId = document.getElementById('view-user-id').innerText;
    const fullname = document.getElementById('view-user-fullname').innerText;
    const username = document.getElementById('view-user-username').innerText;
    const email = document.getElementById('view-user-email').innerText;
    const profile_pic = document.getElementById('view-user-profile-pic').src;

    document.getElementById('user-id').value = userId;
    document.getElementById('edit-user-fullname').value = fullname;
    document.getElementById('edit-user-username').value = username;
    document.getElementById('edit-user-email').value = email;
    document.getElementById('edit-user-profile-pic').src = profile_pic;
    document.getElementById('prev-user-profile-pic').value = profile_pic;

    closeViewAccountModal();
    openEditAccountModal();
}

function editUserAccount(event) {
    event.preventDefault();

    const userId = document.getElementById('user-id').value;
    const fullname = document.getElementById('edit-user-fullname').value;
    const username = document.getElementById('edit-user-username').value;
    const email = document.getElementById('edit-user-email').value;
    const prevProfilePic = document.getElementById('prev-user-profile-pic').value;
    const profilePicInput = document.getElementById('profilePicInput');

    const formData = new FormData();
    formData.append('user_id', userId);
    formData.append('fullname', fullname);
    formData.append('username', username);
    formData.append('email', email);
    formData.append('previousProfilePic', prevProfilePic);
    // Check if a new profile picture is selected
    if (profilePicInput.files.length > 0) {
        formData.append('profilePic', profilePicInput.files[0]);
    }

    fetch('backend/php/main_app_content_admin/user_accounts/edit_user_account.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User updated successfully.');
                closeEditAccountModal();
                // Optionally, refresh the user list or update the table
            } else {
                const errorElement = document.getElementById('edit-modal-error-message');
                errorElement.textContent = data.message;
                errorElement.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error updating user:', error);
            alert('An error occurred while updating the user.');
        });
}


function fetchUserLogs(userId) {
    fetch('backend/php/main_app_content_admin/user_accounts/get_user_logs.php', {
        method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ user_id: userId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            populateUserLogsTable(data.userLogs);
            populateFilters(data.years, 'user-logs');
        } else {
            console.error('Failed to fetch logs:', data.message);
        }
    })
    .catch(error => {
        console.error('Error fetching logs:', error);
    });
}

function populateUserLogsTable(userLogs) {
    const tableBody = document.getElementById('user-logs-table-body');
    let noRecordsRow = document.getElementById('user-logs-no-records-row');
    tableBody.innerHTML = '';

    if (!noRecordsRow) {
        noRecordsRow = document.createElement('tr');
        noRecordsRow.id = 'user-logs-no-records-row';
        noRecordsRow.style.display = 'none';
        noRecordsRow.innerHTML = '<td colspan="3">No logs records found.</td>';
        tableBody.appendChild(noRecordsRow);
    }

    if (userLogs.length === 0) {
        noRecordsRow.style.display = '';
        calculateTotal('user-logs');
        return;
    }

    noRecordsRow.style.display = 'none';

    // Sort logs by created_at descending (newest first)
    userLogs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

    userLogs.forEach((userLog) => {
        const statusClass = userLog.status ? 'status-online' : 'status-offline';

        const row = document.createElement('tr');
        row.setAttribute('data-log-id', userLog.id); // Mark the row with the log ID
        row.innerHTML = `
            <td>${userLog.id}</td>
            <td>${userLog.created_at}</td>
            <td>
                <span class="status-indicator ${statusClass}">${userLog.description}</span>
            </td>
            <input type="hidden" class="user-logs-month" value="${userLog.month}">
            <input type="hidden" class="user-logs-year" value="${userLog.year}">
            <input type="hidden" class="user-logs-created_at" value="${userLog.created_at}">
        `;
        tableBody.appendChild(row);
    });

    // Update lastLogTime with the most recent log's created_at timestamp
    lastLogTimeUserLogs = userLogs[0]?.created_at || null;

    calculateTotal('user-logs');
    applyCurrentFilterOrSearch('user-logs');
}

// Fetch updated user data and refresh the table periodically
function monitorUserTable() {
    // Start the interval to fetch user status
    userStatusInterval = setInterval(() => { // Only fetch if the modal is not open
        fetch('backend/php/main_app_content_admin/user_accounts/check_user_status.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    crudUserRows(data.users);
                } else {
                    console.error('Failed to update user status:', data.message);
                }
            })
            .catch(error => {
                console.error('Error updating user status:', error);
            });
    }, 2000); // Check every 2 seconds
}

function fetchAndUpdateUserDetails(userId) {
    // Stop any existing interval if the modal is reopened
    if (userDetailsUpdateInterval) {
        clearInterval(userDetailsUpdateInterval);
    }

    userDetailsUpdateInterval = setInterval(() => {
        fetch('backend/php/main_app_content_admin/user_accounts/get_user_details.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ user_id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const is_login = data.data.is_login;
                const statusClass = is_login === 1 ? 'status-online' : 'status-offline'; // Assign class based on login status
                const statusText = is_login === 1 ? 'Online' : 'Offline'; // Text for login status

                // Populate modal fields
                document.getElementById('view-user-fullname').innerText = data.data.fullname;
                document.getElementById('view-user-username').innerText = data.data.username;
                document.getElementById('view-user-email').innerText = data.data.email;
                document.getElementById('view-user-created_at').innerText = data.data.created_at;
                document.getElementById('view-user-updated_at').innerText = data.data.updated_at;
                document.getElementById('view-user-is_login').innerText = statusText;
                document.getElementById('view-user-is_login').className = `h1 status-indicator ${statusClass}`;
                
                const profilePicElement = document.getElementById('view-user-profile-pic');
                if (profilePicElement.src !== data.data.profile_pic) {
                    profilePicElement.src = data.data.profile_pic;
                }
            } else {
                console.error('Failed to fetch user detail: ', data.message);
            }
        })
        .catch(error =>{
            console.error('Error fetching user details: ', error)
        })
    }, 2000);
}

function stopUpdatingUserDetails() {
    if (userDetailsUpdateInterval) {
        clearInterval(userDetailsUpdateInterval);
        userDetailsUpdateInterval = null;
    }
}

function fetchNewUserLogs(userId) {
    // Clear any existing interval to avoid multiple intervals running
    if (fetchLogsIntervalId) {
        clearInterval(fetchLogsIntervalId);
    }

    fetchLogsIntervalId = setInterval(() => {
        fetch(`backend/php/main_app_content_admin/user_accounts/check_new_user_logs.php?lastLogTime=${encodeURIComponent(lastLogTimeUserLogs || '')}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ user_id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newLogs = data.logs;
                if (newLogs.length > 0) {
                    lastLogTimeUserLogs = newLogs[0].created_at;
                    addNewUserLogsToTable(newLogs);
                }
            } else {
                console.error('Failed to fetch new logs:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching new logs:', error);
        });
    }, 2000);
}

function addNewUserLogsToTable(newLogs) {
    const tableBody = document.getElementById('user-logs-table-body');

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
            <input type="hidden" class="user-logs-month" value="${log.month}">
            <input type="hidden" class="user-logs-year" value="${log.year}">
            <input type="hidden" class="user-logs-created_at" value="${log.created_at}">
        `;

        tableBody.insertBefore(row, tableBody.firstChild);
    });

    applyCurrentFilterOrSearch('user-logs'); // Reapply the active filter or search
    calculateTotal('user-logs');
}

// Update rows dynamically based on new data
function crudUserRows(users) {
    const tableBody = document.getElementById('users-table-body');
    const currentRows = Array.from(tableBody.getElementsByTagName('tr'));

    // Map current rows by user ID for quick lookup, skipping no_record-row
    const currentRowsMap = new Map();
    let rowIndex = 1; // Start row numbering from 1, excluding the no_record-row

    currentRows.forEach(row => {
        if (row.id === 'users-no-records-row' || !row.cells[1]) {
            return;
        }

        const userId = row.cells[1].innerText.trim(); // Assuming user ID is in the second cell
        currentRowsMap.set(userId, row);

        // Re-assign the row index (only for valid rows)
        row.cells[0].innerText = rowIndex++;
    });

    // Keep track of which users exist in the new data
    const existingUserIds = new Set(users.map(user => user.id));

    // Check for deleted users and remove their rows
    currentRows.forEach(row => {
        if (row.id !== 'users-no-records-row' && row.cells[1]) {
            const userId = row.cells[1].innerText.trim();
            if (!existingUserIds.has(userId)) {
                // Remove the row if the user is not found in the new data
                row.remove();
            }
        }
    });

    // Add or update rows based on new data
    users.forEach(user => {
        const existingRow = currentRowsMap.get(user.id);
        const statusClass = user.is_login === "1" ? 'status-online' : 'status-offline'; // Assign class based on login status
        const statusText = user.is_login === "1" ? 'Online' : 'Offline'; // Text for login status

        if (existingRow) {
            // Update the existing row
            existingRow.cells[2].innerHTML = `<span class="status-indicator ${statusClass}">${statusText}</span>`;
            existingRow.cells[3].innerText = user.username; // Update username if changed
        } else {
            // Add new row if not found
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${rowIndex++}</td> <!-- Correct index placement -->
                <td>${user.id}</td>
                <td>
                    <span class="status-indicator ${statusClass}">${statusText}</span>
                </td>
                <td>${user.username}</td>
                <td>${user.created_at}</td>
                <td class="action-buttons">
                    <div class="row g-2 justify-content-center" style="--bs-gutter-y: 0;">
                        <div class="col-auto">
                            <button 
                                class="btn btn-md btn-outline-primary" 
                                style="font-size: small; width: 60px; padding: 2px 0;" 
                                onclick="viewRow(this, '${user.id}')">
                                View
                            </button>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="user-fullname" value="${user.fullname}">
                <input type="hidden" class="user-email" value="${user.email}">
                <input type="hidden" class="user-profile_pic" value="${user.profile_pic}">
                <input type="hidden" class="user-updated_at" value="${user.updated_at}">
                <input type="hidden" class="user-is_login" value="${user.is_login}">
                <input type="hidden" class="users-month" value="${user.month}">
                <input type="hidden" class="users-year" value="${user.year}">
                <input type="hidden" class="users-created_at" value="${user.created_at}">
            `;
            tableBody.appendChild(newRow);
            applyCurrentFilterOrSearch('users');
        }
    });

    // Sort table rows based on login status and exclude no_record-row
    sortTableByLoginStatus();
}


// Sort table rows based on login status (Online first)
function sortTableByLoginStatus() {
    const tableBody = document.getElementById('users-table-body');
    const rows = Array.from(tableBody.getElementsByTagName('tr'));

    // Filter out the "no-record-row" and any rows without a .status-indicator
    const rowsToSort = rows.filter(row => 
        row.id !== 'no-record-row' && row.querySelector('.status-indicator') !== null
    );

    rowsToSort.sort((rowA, rowB) => {
        const statusA = rowA.querySelector('.status-indicator').classList.contains('status-online') ? 1 : 0;
        const statusB = rowB.querySelector('.status-indicator').classList.contains('status-online') ? 1 : 0;
        return statusB - statusA; // Online first
    });

    // Re-append sorted rows and then re-append the "no-record-row" if it exists
    rowsToSort.forEach(row => tableBody.appendChild(row));

    const noRecordRow = rows.find(row => row.id === 'no-record-row');
    if (noRecordRow) {
        tableBody.appendChild(noRecordRow);
    }

    recalculateRowNumbers('users');
    calculateTotal('users');
}


function populateFilters(years, tableType) {
    const monthSelect = document.getElementById(`${tableType}-month-select`);
    const yearSelect = document.getElementById(`${tableType}-year-select`);

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

function stopFetchingLogsAndCleanTable() {
    // Stop the interval
    if (fetchLogsIntervalId) {
        clearInterval(fetchLogsIntervalId);
        fetchLogsIntervalId = null;
    }

    // Clean the table
    const logsTableBody = document.getElementById('user-logs-table-body'); // Replace with your table's `tbody` ID
    logsTableBody.innerHTML = ''; // Remove all rows

    // Reset the last log time
    lastLogTimeUserLogs = null;
}

function deleteUserAccount() {
    const userId = document.getElementById('view-user-id').innerText;

    if (!confirm("Are you sure you want to delete this user account? This action cannot be undone.")) {
        return; // Exit if user cancels
    }

    fetch('backend/php/main_app_content_admin/user_accounts/delete_user_account.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: userId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User account deleted successfully.');
            } else {
                alert('Failed to delete user account: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting user account:', error);
            alert('An error occurred while deleting the user account.');
        });

    closeViewAccountModal();
}


// Open the modal
function openAccountModal() {
    document.getElementById('user-modal').style.display = 'block';
}

function openEditAccountModal() {
    document.getElementById('edit-user-modal').style.display = 'block';
}

function openViewAccountModal() {
    document.getElementById('view-user-modal').style.display = 'block';
}

function closeAccountModal() {
    document.getElementById('user-modal').style.display = 'none';
}

function closeEditAccountModal() {
    document.getElementById('edit-user-modal').style.display = 'none';
}

function closeViewAccountModal() {
    document.getElementById('view-user-modal').style.display = 'none';
    activeFilterType = 'all';
    stopUpdatingUserDetails();
    stopFetchingLogsAndCleanTable();
    applyCurrentFilterOrSearch('users');
}

// Add a new deposit record to the table
let rowCount = 0;

// Utility function to sanitize user input
function sanitizeInput(input) {
    // Remove leading/trailing whitespace and escape any HTML characters
    return input.trim().replace(/</g, "&lt;").replace(/>/g, "&gt;");
}

// Recalculate row numbers after deletion
function recalculateRowNumbers(tableType) {
    const tableBody = document.getElementById('users-table-body');
    const rows = tableBody.querySelectorAll('tr');
    rows.forEach((row, index) => {
        if (row.id === `${tableType}-no-records-row`) {
            return;
        }

        row.querySelector('td:first-child').textContent = `${index}.`;
    });
}

// Calculate the total amount in the table
function calculateTotal(tableType) {
    const totalAmount = document.getElementById(`${tableType}-total-amount`);
    const rows = document.querySelectorAll(`#${tableType}-table-body tr`);

    if (rows.length == 0) {
        totalAmount.textContent = rows.length;
    } else {
        totalAmount.textContent = rows.length - 1;
    }
    
}

function searchTable(tableType) {
    activeSearch = 'search';

    const searchValue = document.getElementById(`${tableType}-search-bar`).value.toLowerCase();
    const table = document.getElementById(`${tableType}-table-body`);
    const rows = table.getElementsByTagName('tr');
    const noRecordsRow = document.getElementById(`${tableType}-no-records-row`);

    let hasVisibleRows = false; // Flag to check if any rows match

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');

        // Skip the no-records-row for now
        if (row.id === `${tableType}-no-records-row`) {
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
        searchTable(reportType); // This will respect the current filtering
    }
}

function applyCurrentFilterOrSearch(tableType) {
    if (activeSearch === 'search' && (activeFilterType === 'month' || activeFilterType === 'dateRange')) {
        applyFilter(activeFilterType, tableType); // Apply current filter, then search
    } else if (activeSearch === 'search') {
        searchTable(tableType); // Only search if no filters are applied
    } else {
        applyFilter(activeFilterType, tableType); // Apply filter if no active search
    }
}

window.onclick = function(event) {
    const modal = document.getElementById("user-modal");
    const editModal = document.getElementById("edit-user-modal");
    const viewModal = document.getElementById("view-user-modal");

    if (event.target === modal || event.target === editModal || event.target === viewModal) {
        closeAccountModal();
        closeEditAccountModal();
        closeViewAccountModal();
    }
};
