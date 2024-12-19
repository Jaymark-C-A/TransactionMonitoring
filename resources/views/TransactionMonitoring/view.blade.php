<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head') 
<!-- CSS styles for card layout -->
<style>

        /* Dark mode styling */
    body{
        background-color: #121212;
    }
    .btn-secondary.dropdown-toggle {
        background-color: #555;
        color: white;
    }

    .btn-secondary.dropdown-toggle:hover {
        background-color: #777;
    }

    /* Widescreen toggle class */
    body.widescreen-mode .main-header {
        display: none;
    }
    
    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }

    .card {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-sizing: border-box;
        width: 100%; /* Make the card take full width on smaller screens */
        margin-bottom: 10px;
    }

    /* Styles for queue and ticket display */
    .queue-info {
        flex-wrap: wrap; /* Allows wrapping on smaller screens */
        gap: 40px;
        gap
        justify-content: center; /* Center content on smaller screens */
        margin: 1rem;
    }

    .queue-list, .current-ticket {
        border-radius: 8px;
        /* box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; */
        padding: 20px;
        box-sizing: border-box;
    }

    .current-ticket {
        text-align: center;
    }
    .current-ticket .ticket-number {
        font-size: 20px; /* Base font size for large screens */
        margin: 20px 0;
        font-weight: bolder; /* Make ticket number bold */
        color: white; /* Ticket number color */
        text-align: center;
    }

    .current-ticket .actual-time {
        font-size: 1em;
        color: #d9534f;
        margin: 20px;
    }

    .col-md-4 {
        /* box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; */
        padding: 45px;
        margin-bottom: 20px; /* Optional: Add some space between columns */
        height: auto; /* Adjust height based on content */
    }

    body {
        background-color: rgb(90, 164, 233) !important;
    }


    /* Responsive Styles */
    @media (max-width: 768px) {
        .queue-info {
            flex-direction: column; /* Stack items vertically on small screens */
        }


        .current-ticket .ticket-number {
            font-size: 24px; /* Smaller font size for medium screens */
        }

        .col-md-4 {
            padding: 20px; /* Reduce padding on small screens */
        }
    }

    @media (max-width: 576px) {
        .current-ticket .ticket-number {
            font-size: 18px; /* Even smaller font size for small screens */
        }

        .current-ticket .actual-time {
            font-size: 0.8em; /* Smaller font for time */
        }

        .col-md-4 {
            padding: 15px; /* Further reduce padding on extra small screens */
        }
    }

    @media (max-width: 400px) {
        .current-ticket .ticket-number {
            font-size: 16px; /* Further reduced font size for very small screens */
        }

        .current-ticket .actual-time {
            font-size: 0.7em; /* Further reduced font for time */
        }
    }


</style>


    <!-- Local FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
</head>
<body>
    <!-- Right navbar links -->
    <div class="row m-0">
        <div class="col-12 text-right text-white" style="background-color: #243258;">
            <h5 class="text-center pt-3 mb-0">OLONGAPO CITY NATIONAL HIGH SCHOOL</h5>
            <h3 class="text-center px-2 pb-2">TRANSACTION MONITORING SYSTEM</h3>
        </div>
        <div class="col-12 text-left py-2 pb-0">
            <ul class="navbar-nav ml-auto pr-3">
                <div class="dropdown" style="text-align: right; cursor: pointer;">
                    <button class="btn dropdown-toggle" style="background: transparent; color: white; border: 1px solid rgb(6, 193, 255);" type="button" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog" style="color: white"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                        <li>
                            <a class="dropdown-item" href="#" id="dark-mode" style="display: flex; align-items: center;">
                                <i class="fas fa-moon" style="margin-right: 8px;"></i> <!-- Dark Mode icon -->
                                Dark Mode
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" id="light-mode" style="display: flex; align-items: center;">
                                <i class="fas fa-sun" style="margin-right: 8px;"></i> <!-- Light Mode icon -->
                                Light Mode
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" style="display: flex; align-items: center;" href="dashboard" id="navbarDropdown" role="button">
                                <i class="fa fa-dashboard" style="margin-right: 8px;"></i> <!-- Widescreen icon -->
                                Back to Dashboard
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>
    </div>
    
    
    <div class="queue-info"  style="height: 85vh;">

        <!-- Current Ticket Info -->
        <div class="current-ticket px-5 pt-5 bg-light" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="container-fluid">
                <div class="row">
                    <!-- DEPARTMENT NAME -->
                    <audio id="ticket-notification-sound" src="../audio/Recording.mp4" preload="auto"></audio>
                    <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                        <div class="card-body" style="background: #e69430; color: white;">
                            <h2 class="card-text text-white">Now Serving!</h2>
                        </div>
                        <div class="card-body" style="background: #d68725; color: white;">
                            <div style="font-size:65px; font-weight:bolder;" class="ticket-number p-0 m-0"  id="records-ticket">---</div>
                            <h2 class="text-white">Records Office</h2> 
                            <div id="ticket-purpose-container5"></div>
                        </div>
                    </div>
                    
                    
                    <!-- DEPARTMENT NAME -->
                    <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                        <div class="card-body" style="background: #20b6bb; color: white;">
                            <h2 class="card-text text-white">Now Serving!</h2>
                        </div>
                        <div class="card-body" style="background: #1eaaaf; color: white">
                            <div style="font-size:65px; font-weight:bolder;" class="ticket-number p-0 m-0" id="admin-ticket">---</div>
                            <h2 class="text-white">Admin Office</h2>
                            <div id="ticket-purpose-container1"></div>
                        </div>
                    </div>
                    <!-- DEPARTMENT NAME -->
                    <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                        <div class="card-body" style="background: #097969; color: white;">
                            <h2 class="card-text text-white">Now Serving!</h2>
                        </div>
                        <div class="card-body" style="background: #076e5e; color: white">
                            <div style="font-size:65px; font-weight:bolder;" class="ticket-number p-0 m-0" id="accounting-ticket">---</div>
                            <h2 class="text-white">Accounting Office</h2> 
                            <div id="ticket-purpose-container2"></div>
                        </div>
                    </div>
                    <!-- DEPARTMENT NAME -->
                    <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                        <div class="card-body" style="background: #844eb1; color: white;">
                            <h2 class="card-text text-white">Now Serving!</h2>
                        </div>
                        <div class="card-body" style="background: #7c49a7; color: white">
                            <div style="font-size:65px; font-weight:bolder;" class="ticket-number p-0 m-0" id="principal-ticket">---</div>
                            <h2 class="text-white">Medical Clinic Office</h2> 
                            <div id="ticket-purpose-container3"></div>
                        </div>
                    </div>
                    <!-- DEPARTMENT NAME -->
                    <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                        <div class="card-body" style="background: #0f74a3; color: white;">
                            <h3 class="card-text">Department Queue Overview</h3>
                        </div>
                        <div class="card-body" style="background: #0c648d; color: white">
                            <div>
                                <div class="row text-left text-lg px-5">
                                    <div class="col-md-7">
                                        <p>Records: <span id="records-count">0</span></p>
                                        <p>Accounting: <span id="accounting-count">0</span></p>
                                        <p>Guidance: <span id="guidance-count">0</span></p>
                                    </div>
                                    <div class="col-md-5">
                                        <p>Admin: <span id="admin-count">0</span></p>
                                        <p>Clinic: <span id="clinic-count">0</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DEPARTMENT NAME -->
                    <div class="card col-md-4 col-sm-12 col-xs-12 p-0">
                        <div class="card-body" style="background: #c4436e; color: white;">
                            <h2 class="card-text text-white">Now Serving!</h2>
                        </div>
                        <div class="card-body" style="background: #a8395e; color: white">
                            <div style="font-size:65px; font-weight:bolder;" class="ticket-number p-0 m-0" id="guidance-ticket">---</div>
                            <h2 class="text-white">Guidance Office</h2> 
                            <div id="ticket-purpose-container4"></div>
                        </div>
                    </div>

                </div>
                <div>
                    <p id="timeDisplay" style="font-size:26px; font-weight:bolder;"></p>
                </div>                
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="{{ asset('../js/bootstrapview.bundle.min.js') }}"></script>

    
    <script>
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
            function fetchData() {
                $.ajax({
                    url: '/monitor-fetch-data',
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(data) {
                        // Filter out completed, canceled, and pending tickets
                        var filteredData = data.filter(function(item) {
                            return item.status !== 'completed' && item.status !== 'canceled';
                        });

                        var waitingTickets = data.filter(function(item) {
                            return item.status === 'waiting';
                        });

                        // Group tickets by department
                        var departmentCounts = {};
                        waitingTickets.forEach(function(ticket) {
                            if (!departmentCounts[ticket.department]) {
                                departmentCounts[ticket.department] = 0;
                            }
                            departmentCounts[ticket.department]++;
                        });

                        // Update counts for each department in the HTML
                        Object.keys(departmentCounts).forEach(function(department) {
                            var countElement = $(`#${department.toLowerCase()}-count`);
                            if (countElement.length) {
                                countElement.text(departmentCounts[department]);
                            }
                        });

                        // Reset counts for departments with no waiting tickets
                        var allDepartments = ["Records", "Accounting", "Clinic", "Admin", "Guidance"];
                        allDepartments.forEach(function(department) {
                            if (!departmentCounts[department]) {
                                $(`#${department.toLowerCase()}-count`).text('0');
                            }
                        });
    
                        // Create a dictionary to store all tickets for each department
                        var departmentTickets = {};
    
                        // Store all tickets for each department
                        filteredData.forEach(function(visitor) {
                            if (!departmentTickets[visitor.department]) {
                                departmentTickets[visitor.department] = [];
                            }
                            departmentTickets[visitor.department].push(visitor);
                        });
    
                        // Map department names to their respective ticket number elements
                        var departmentMap = {
                            'Records': '#records-ticket',
                            'Accounting': '#accounting-ticket',
                            'Clinic': '#principal-ticket',
                            'Admin': '#admin-ticket',
                            'Guidance': '#guidance-ticket'
                        };
    
                        // Reset ticket numbers for all departments
                        for (var key in departmentMap) {
                            $(departmentMap[key]).text('---');
                        }
    
                        // Update the current ticket display
                        for (var department in departmentTickets) {
                            if (departmentMap[department]) {
                                var tickets = departmentTickets[department];
                                if (tickets.length > 0) {
                                    $(departmentMap[department]).text(tickets[0].ticket_number); // Set the first ticket number
                                }
                            }
                        }
    
                        // Additional functionality to update Records Office ticket purpose
                        if (departmentTickets['Records'] && departmentTickets['Records'].length > 0) {
                        var firstTicket = departmentTickets['Records'][0];
                        var purposeHtml = `<p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>`;
                        $('#ticket-purpose-container5').html(purposeHtml);
                    } else {
                        $('#records-ticket').text('---');
                        $('#ticket-purpose-container5').html('<p class="mb-0">No active transactions in progress.</p>');
                    }   
    
                        // The rest of your existing code for updating queue lists remains unchanged...
                        // Update the queue list display with the second ticket per department
                        var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                        var displayedTickets = new Set();
                        var hasTickets = false; // Flag to track if any ticket is displayed

                        for (var i = 1; i < filteredData.length; i++) { // Start from index 1 (the second ticket)
                            var visitor = filteredData[i];
                            if (visitor.department === "Records") {
                                var tickets = departmentTickets[visitor.department];
                                
                                // Display only if more than one ticket is available
                                if (tickets && tickets.length > 1) {
                                    tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                        if (!displayedTickets.has(ticket.ticket_number)) {
                                            hasTickets = true; // Set flag to true if at least one ticket is displayed
                                            html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                            html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                            html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                            html += '</div>';
                                            displayedTickets.add(ticket.ticket_number);
                                        }
                                    });
                                }
                            }
                        }

                        // If no tickets were added, show "No queueing list" message
                        if (!hasTickets) {
                            html += `
                                <div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">
                                    <div class="card-body p-0">
                                        <p class="card-text text-muted">Currently, there are no visitors in the queue.</p>
                                    </div>
                                </div>`;
                        }

                        html += '</div>';
                        $('#data-container').html(html);
    
                        // Admin List
                        if (departmentTickets['Admin'] && departmentTickets['Admin'].length > 0) {
                            var firstTicket = departmentTickets['Admin'][0];
    
                            // Update the purpose container with the first ticket's purpose
                            var purposeHtml = `
                                <p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>
                            `;
                            $('#ticket-purpose-container1').html(purposeHtml);
                        } else {
                            // Reset display if there are no tickets
                            $('#admin-ticket').text('---');
                            $('#ticket-purpose-container1').html('<p class="mb-0">No active transactions in progress.</p>');
                        }

                        var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                        var displayedTickets = new Set();
                        var hasTickets = false; // Flag to track if any ticket is displayed
    
                        // Start loop from index 1 to skip the first ticket
                        for (var i = 1; i < filteredData.length; i++) {
                            var visitor = filteredData[i];
                            if (visitor.department === "Admin") {
                                var tickets = departmentTickets[visitor.department];
    
                                // Display only if more than one ticket is available
                                if (tickets && tickets.length > 1) {
                                    tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                        if (!displayedTickets.has(ticket.ticket_number)) {
                                            hasTickets = true; // Set flag to true if at least one ticket is displayed
                                            html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                            html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                            html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                            html += '</div>';
                                            displayedTickets.add(ticket.ticket_number);
                                        }
                                    });
                                }
                            }
                        }
    
                        // If no tickets were added, show "No queueing list" message
                        if (!hasTickets) {
                            html += 
                                '<div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">' +
                                    '<div class="card-body p-0">' +
                                        '<p class="card-text text-muted">Currently, there are no visitors in the queue.</p>' +
                                    '</div>' +
                                '</div>';
                        }
    
                        html += '</div>';
                        $('#data-container1').html(html);
    
                        // Accounting List
                        if (departmentTickets['Accounting'] && departmentTickets['Accounting'].length > 0) {
                            var firstTicket = departmentTickets['Accounting'][0];
    
                            // Update the purpose container with the first ticket's purpose
                            var purposeHtml = `
                                <p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>
                            `;
                            $('#ticket-purpose-container2').html(purposeHtml);
                        } else {
                            // Reset display if there are no tickets
                            $('#accounting-ticket').text('---');
                            $('#ticket-purpose-container2').html('<p class="mb-0">No active transactions in progress.</p>');
                        }


                        var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                        var displayedTickets = new Set();
                        var hasTickets = false; // Flag to track if any ticket is displayed
    
                        for (var i = 1; i < filteredData.length; i++) { // Start from index 1 (the second ticket)
                            var visitor = filteredData[i];
                            if (visitor.department === "Accounting") {
                                var tickets = departmentTickets[visitor.department];
    
                                // Display only if more than one ticket is available
                                if (tickets && tickets.length > 1) {
                                    tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                        if (!displayedTickets.has(ticket.ticket_number)) {
                                            hasTickets = true; // Set flag to true if at least one ticket is displayed
                                            html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                            html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                            html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                            html += '</div>';
                                            displayedTickets.add(ticket.ticket_number);
                                        }
                                    });
                                }
                            }
                        }
    
                        // If no tickets were added, show "No queueing list" message
                        if (!hasTickets) {
                            html += 
                                '<div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">' +
                                    '<div class="card-body p-0">' +
                                        '<p class="card-text text-muted">Currently, there are no visitors in the queue.</p>' +
                                    '</div>' +
                                '</div>';
                        }
    
                        html += '</div>';
                        $('#data-container2').html(html);
    
                        // Clinic List
                        if (departmentTickets['Clinic'] && departmentTickets['Clinic'].length > 0) {
                            var firstTicket = departmentTickets['Clinic'][0];
    
                            // Update the purpose container with the first ticket's purpose
                            var purposeHtml = `
                                <p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>
                            `;
                            $('#ticket-purpose-container3').html(purposeHtml);
                        } else {
                            // Reset display if there are no tickets
                            $('#principal-ticket').text('---');
                            $('#ticket-purpose-container3').html('<p class="mb-0">No active transactions in progress.</p>');
                        }

                        var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                        var displayedTickets = new Set();
                        var hasTickets = false; // Flag to track if any ticket is displayed
    
                        for (var i = 1; i < filteredData.length; i++) { // Start from index 1 (the second ticket)
                            var visitor = filteredData[i];
                            if (visitor.department === "Clinic") {
                                var tickets = departmentTickets[visitor.department];
    
                                // Display only if more than one ticket is available
                                if (tickets && tickets.length > 1) {
                                    tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                        if (!displayedTickets.has(ticket.ticket_number)) {
                                            hasTickets = true; // Set flag to true if at least one ticket is displayed
                                            html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                            html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                            html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                            html += '</div>';
                                            displayedTickets.add(ticket.ticket_number);
                                        }
                                    });
                                }
                            }
                        }
    
                        // If no tickets were added, show "No queueing list" message
                        if (!hasTickets) {
                            html += 
                                '<div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">' +
                                    '<div class="card-body p-0">' +
                                        '<p class="card-text text-muted">Currently, there are no visitors in the queue.</p>' +
                                    '</div>' +
                                '</div>';
                        }
    
                        html += '</div>';
                        $('#data-container3').html(html);
    
                        // Guidance List
                        if (departmentTickets['Guidance'] && departmentTickets['Guidance'].length > 0) {
                            var firstTicket = departmentTickets['Guidance'][0];
    
                            // Update the purpose container with the first ticket's purpose
                            var purposeHtml = `
                                <p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>
                            `;
                            $('#ticket-purpose-container4').html(purposeHtml);
                        } else {
                            // Reset display if there are no tickets
                            $('#guidance-ticket').text('---');
                            $('#ticket-purpose-container4').html('<p class="mb-0">No active transactions in progress.</p>');
                        }

                        var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                        var displayedTickets = new Set();
                        var hasTickets = false; // Flag to track if any ticket is displayed
    
                        for (var i = 1; i < filteredData.length; i++) { // Start from index 1 (the second ticket)
                            var visitor = filteredData[i];
                            if (visitor.department === "Guidance") {
                                var tickets = departmentTickets[visitor.department];
    
                                // Display only if more than one ticket is available
                                if (tickets && tickets.length > 1) {
                                    tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                        if (!displayedTickets.has(ticket.ticket_number)) {
                                            hasTickets = true; // Set flag to true if at least one ticket is displayed
                                            html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                            html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                            html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                            html += '</div>';
                                            displayedTickets.add(ticket.ticket_number);
                                        }
                                    });
                                }
                            }
                        }
    
                        // If no tickets were added, show "No queueing list" message
                        if (!hasTickets) {
                            html += 
                                '<div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">' +
                                    '<div class="card-body p-0">' +
                                        '<p class="card-text text-muted">Currently, there are no visitors in the queue.</p>' +
                                    '</div>' +
                                '</div>';
                        }
    
                        html += '</div>';
                        $('#data-container4').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }
    
            // Fetch data initially
            fetchData();
    
            // Fetch data every 1 second
            setInterval(fetchData, 1000);
        });
    </script>
    
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Variables to track state
            var isDarkMode = false;


            // Dark mode / Light mode toggle logic
            document.getElementById('dark-mode').addEventListener('click', function(e) {
                e.preventDefault();
                if (!isDarkMode) {
                    document.body.classList.add('dark-mode');
                    isDarkMode = true;
                }
            });

            document.getElementById('light-mode').addEventListener('click', function(e) {
                e.preventDefault();
                if (isDarkMode) {
                    document.body.classList.remove('dark-mode');
                    isDarkMode = false;
                }
            });
        });
    </script>

    <script>
        function updateTime() {
            var now = new Date();
            var days = ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'];
            var day = days[now.getDay()]; // Get the current day of the week
            var time = now.toLocaleTimeString(); // Format the time (e.g., 12:34:56 PM)
            document.getElementById('timeDisplay').textContent = day + ', ' + time; // Combine day, date, and time
        }

        // Update the time and date immediately and every second
        updateTime();
        setInterval(updateTime, 1000);
    </script>

</body>
</html>
