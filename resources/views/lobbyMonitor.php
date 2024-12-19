<!DOCTYPE html>
<html lang="en">
<head>
    
@include('includes.head')
<!-- CSS styles for card layout -->
<style>
    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }

    .card {
        flex: 0 0 calc(50% - 10px); /* Adjust the width as needed */
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        width: 100%; /* Make the card take full width on smaller screens */
        margin-bottom: 10px;
    }

    /* Styles for queue and ticket display */
    .queue-info {
        display: flex;
        flex-wrap: wrap; /* Allows wrapping on smaller screens */
        gap: 20px;
        justify-content: center; /* Center content on smaller screens */
        margin: 1rem;
    }

    .queue-list, .current-ticket {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        box-sizing: border-box;
        flex: 1; /* Make both queue-list and current-ticket flexible */
        min-width: 300px; /* Minimum width to avoid too small cards */
    }
    
    .queue-list {
        max-width: 65%; /* Limit width on larger screens */
        flex-basis: calc(35% - 20px); /* Ensure correct spacing */
    }

    .current-ticket {
        text-align: center;
        max-width: 60%; /* Limit width on larger screens */
        flex-basis: calc(60% - 20px); /* Ensure correct spacing */
    }

    .current-ticket .ticket-number {
        font-size: 20px; /* Base font size for large screens */
        margin: 20px 0;
        font-weight: bolder; /* Make ticket number bold */
        color: black; /* Ticket number color */
    }

    .current-ticket .actual-time {
        font-size: 1em;
        color: #d9534f;
        margin: 20px;
    }

    .col-md-4 {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 35px;
        margin-bottom: 20px; /* Optional: Add some space between columns */
        height: auto; /* Adjust height based on content */
    }

    /* Marquee styling */
    .marquees {
        overflow: hidden;
        white-space: nowrap;
        background-color: #06c1ff; /* Background color for marquee */
        color: red;
        font-size: 22px;
        font-weight: 700;
        padding: 10px 0;
        box-sizing: border-box;
        opacity: .5;
        letter-spacing: .5ch
    }

    .marquees span {
        display: inline-block;
        padding-left: 70%;
        animation: marquee 15s linear infinite;
    }

    
    .marquee {
        overflow: hidden;
        white-space: nowrap;
        background-color: #06c1ff; /* Background color for marquee */
        color: rgb(0, 0, 0);
        font-size: 16px;
        font-weight: 600;
        padding: 10px 0;
        box-sizing: border-box;
        opacity: .5;
        letter-spacing: .5ch
    }

    .marquee span {
        display: inline-block;
        padding-left: 70%;
        animation: marquee 15s linear infinite;
    }

    @keyframes marquee {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(-100%);
        }
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
    <link rel="stylesheet" href="{{ asset('../../css/bootstrap.min.css') }}">
</head>
<body>
    <div class="queue-info" style="margin: 3% 5% 3% 5%">
        <!-- Queue List -->
        <div class="queue-list" style="border: 2px solid rgb(6, 193, 255);">
            <div>
                <h4 style="letter-spacing: .5ch">Queueing List...</h4>
            </div>
            <div id="data-container"></div>
        </div>
        
        <!-- Current Ticket Info -->
        <div class="current-ticket" style="border: 2px solid rgb(6, 193, 255);">
                <!-- Marquee Element -->
    <div class="marquees">
        <span>Now Serving !</span>
    </div>
    
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12" style="line-height: 20px;"> <!-- Adjusted column classes -->
                        <div>
                            <p style="font-size:26px; color:blue; font-weight:bolder;">Records</p>
                            <p style="font-size:18px; color:blue;">Currently Serving!</p>
                            <div style="font-size:26px; font-weight:bolder;" class="ticket-number" id="records-ticket">---</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12" style="line-height: 20px;"> <!-- Adjusted column classes -->
                        <div>
                            <p style="font-size:26px; color:blue; font-weight:bolder;">Accounting</p>
                            <p style="font-size:18px; color:blue;">Currently Serving!</p>
                            <div style="font-size:26px; font-weight:bolder;" class="ticket-number" id="accounting-ticket">---</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12" style="line-height: 20px;"> <!-- Adjusted column classes -->
                        <div>
                            <p style="font-size:26px; color:blue; font-weight:bolder;">Principal</p>
                            <p style="font-size:18px; color:blue;">Currently Serving!</p>
                            <div style="font-size:26px; font-weight:bolder;" class="ticket-number" id="principal-ticket">---</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12" style="line-height: 20px;"> <!-- Adjusted column classes -->
                        <div>
                            <p style="font-size:26px; color:blue; font-weight:bolder;">Admin</p>
                            <p style="font-size:18px; color:blue;">Currently Serving!</p>
                            <div style="font-size:26px; font-weight:bolder;" class="ticket-number" id="admin-ticket">---</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12" style="line-height: 20px;"> <!-- Adjusted column classes -->
                        <a id="hamburger-menu" class="nav-link" data-widget="pushmenu" href="/super-admin/dashboard" role="button">
                            <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 150px; height: auto;">
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12" style="line-height: 20px;"> <!-- Adjusted column classes -->
                        <div>
                            <p style="font-size:26px; color:blue; font-weight:bolder;">Guidance</p>
                            <p style="font-size:18px; color:blue;">Currently Serving!</p>
                            <div style="font-size:32px; font-weight:bolder;" class="ticket-number" id="department-head-ticket">---</div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="marquee">
        <span>Welcome to the School Queue Management System! Stay updated with the latest information here.</span>
    </div>
    <script src="../public/js/jquery.min.js"></script>
    <!-- Bootstrap JS (local) -->
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <!-- Your custom script -->
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
                            return item.status !== 'completed' && item.status !== 'canceled' && item.status !== 'pending';
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
                            'Principal': '#principal-ticket',
                            'Admin': '#admin-ticket',
                            'Department_Head': '#department-head-ticket'
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
    
                        // Update the queue list display with the second ticket per department
                        var html = '<div class="w-50 pl-4 pb-3">';
                        var displayedDepartments = new Set();
                        for (var i = 0; i < filteredData.length; i++) {
                            var visitor = filteredData[i];
                            if (!displayedDepartments.has(visitor.department)) {
                                var tickets = departmentTickets[visitor.department];
                                if (tickets && tickets.length > 1) {
                                    html += '<div class="card" style="border: 1px solid rgb(6, 193, 255);">';
                                    html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + tickets[1].ticket_number + '</strong></p>';
                                    html += '<p class="mb-0"><strong>Department:</strong> ' + tickets[1].department + '</p>';
                                    html += '<p class="mb-0" ><strong>Purpose:</strong> ' + tickets[1].purpose + '</p>';
                                    html += '</div>';
                                    displayedDepartments.add(visitor.department);
                                }
                            }
                        }
                        html += '</div>';
                        $('#data-container').html(html);
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
</body>
</html>
