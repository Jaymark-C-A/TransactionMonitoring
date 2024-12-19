<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('includes.head')
    <style>
        .circle {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: rgb(48, 47, 47);
            transition: transform 0.2s ease;
        }

        .circle:hover {
            transform: scale(1.05);
        }

        .circle-purple { 
            border: 2px solid #845EC2;
            border-left: none;
            border-top: none;
            border-right: none;
         }
        .circle-yellow { 
            border: 2px solid #FFB800;
            border-left: none;
            border-top: none;
            border-right: none; 
        }
        .circle-green { 
            border: 2px solid #00C9A7; 
            border-left: none;
            border-top: none;
            border-right: none;
        }

        .metrics p {
            margin: 5px 0;
            font-size: 14px;
        }

        .metric-value {
            font-size: 46px;
            font-weight: bold;
            color: black;
        }

        .metrics-container {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .metrics-box {
            padding: 20px;
            width: 200px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            color: black;
        }

        .season-buttons {
            display: inline-flex;
            margin-top: 20px;
        }

        .season-buttons button {
            background-color: #1971e433;
            margin: 0 10px;
            padding: 5px 15px;
            transition: background-color 0.3s ease;
            border: 4px solid gray;
            border-top: none;
            border-bottom: none;
            border-right: none;
            margin-bottom: 5%;
        }

        .season-buttons button:hover {
            background-color: rgb(48, 47, 47);
            color: white;
        }

        .container {
            max-width: 900px;
            padding: 0 15px;
        }

        .metrics-box p {
            font-size: 14px;
            color: #ccc;
        }

        .metrics-box .metric-value {
            color: #fff;
        }

        /* Responsive layout */
        @media (max-width: 360px) {
            .circle {
                width: 100%;
                height: auto;
                font-size: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: auto; /* Centers the circle horizontally */
            }

            .metrics-box {
                width: 150px;
            }

            .season-buttons button {
                margin: 0 5px;
                padding: 8px 16px;
            }
        }

        .time-date-box {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .metric-boxes {
            border-radius: 0.5rem;
            padding: 1rem;
            background-color: white;
        }

        .metric-values {
            color: #343a40;
        }

        /* Flip Container Styles */
        .flip-container {
            perspective: 1000px;
        }

        .flipper {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.6s;
        }

        .front, .back {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
        }

        .back {
            transform: rotateY(180deg);
        }

        .smoky-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;
        }
    </style>
    <!-- Local FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">

</head>
<body class="text-sm" style="background-color: #cecece">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-lg navbar-light" style="background-color: #084262;">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
            @include('includes.sidebar.sidebar-clinic')  
        </aside>
        <div class="content-wrapper" style="background-color: transparent">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">My Dashboard</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="dashboard" class="breadcrumb-item active">Dashboard</a>
                                <li class="breadcrumb-item"><a href="#"></a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section>
                <div class="row m-0">
                    <div class="col-md-12">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="smoky-shadow metric-boxes mb-3 bg-light px-3 py-2">
                                        <div class="metric-values text-black" id="currentDate" style="letter-spacing: 4px; font-size: 1.5rem; font-weight: bold;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="smoky-shadow metric-boxes bg-light px-3 py-2 mb-2">
                                        <div class="metric-values text-black" id="currentTime" style="letter-spacing: 4px; font-size: 1.5rem; font-weight: bold;"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="flip-container">
                                        <div class="flipper">
                                            <div class="front">
                                                <div class="smoky-shadow container-fluid text-left bg-light p-2">
                                                    <div class="season-buttons">
                                                        <button class="btn" id="statisticsButton">Statistics Chart   <i class="fas fa-arrow-right"></i></button>
                                                    </div>
                                                    <div class="row my-4 mx-1">
                                                        <div class="col-md-12 col-sm-12" style="padding: 0px 10rem">
                                                            <div class="circle circle-yellow py-2">
                                                                <div class="text-center" style="line-height: 35px">
                                                                    <div id="todayVisitors" style="font-size: 46px">Loading...</div>
                                                                    <div style="font-size: 24px">Today’s Transactions</div>
                                                                </div>
                                                            </div>
                                                        </div>                                 
                                                    </div>

                                                    <div class="metrics-container my-14">
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="small-box bg-primary smoky-shadow m-6">
                                                                <div class="inner" style="height: 13vh">
                                                                    <div class="metric-value px-2 py-3" id="totalVisitors" style="color: #FFFFFF;">0</div> <!-- Make it Today Serving -->
                                                                </div>
                                                                <div class="icon">
                                                                    <i class="fa fa-bell"></i>
                                                                </div>
                                                                <p class="small-box-footer text-sm">Total Queued Transactions</p> 
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="small-box bg-success smoky-shadow m-6">
                                                                <div class="inner" style="height: 13vh">
                                                                    <div class="metric-value px-2 py-3" id="yesterdayVisitors" style="color: #FFFFFF;">0</div> <!-- Make it Total Serving -->
                                                                </div>
                                                                <div class="icon">
                                                                    <i class="fa fa-bell"></i>
                                                                </div>
                                                                <p class="small-box-footer text-sm">Yesterday's Queued Transactions</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="small-box bg-danger smoky-shadow m-6">
                                                                <div class="inner" style="height: 13vh">
                                                                    <div class="metric-value px-2 py-3 " id="todayCanceledTransactions" style="color: #FFFFFF;">0</div>
                                                                </div>
                                                                <div class="icon">
                                                                    <i class="fa fa-bell"></i>
                                                                </div>
                                                                <p class="small-box-footer text-sm">Today's Canceled Transactions</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="small-box bg-warning smoky-shadow m-6">
                                                                <div class="inner" style="height: 13vh">
                                                                    <div class="metric-value px-2 py-3" id="totalCanceledTransactions" style="color: #FFFFFF;">0</div>
                                                                </div>
                                                                <div class="icon">
                                                                    <i class="fa fa-bell"></i>
                                                                </div>
                                                                <p class="small-box-footer text-sm">Total Canceled Transactions</p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        // Fetch announcements with pagination, filtering by status
                                                        $announcements = \App\Models\Announcement::where('status', 'published')->paginate(3); // Limit to 3 per page
                                                        ?>
                                                        <div class="container-fluid my-4">
                                                            <h3 class="pb-2">Announcement:</h3>
                                                            <div class="row">
                                                                @if($announcements->isEmpty())
                                                                    <!-- Display this message if there are no published announcements -->
                                                                    <div class="announcement-box bg-light p-3 rounded shadow-sm">
                                                                        <h5 style="color: #007bff;">No Announcements Available</h5>
                                                                        <p id="announcementText" style="margin: 0;">Currently, there are no announcements to display. Please check back later for updates.</p>
                                                                    </div>
                                                                @else
                                                                    @foreach($announcements as $announcement)
                                                                        <div class="col-md-6 col-sm-12 col-lg-12 mb-1"> <!-- Responsive column for layout -->
                                                                            <div class="card smoky-shadow border-0 p-0"> <!-- Bootstrap card for modern design -->
                                                                                <div class="card-header p-2 text-white d-flex justify-content-between align-items-center" style="background-color: #084262;"> <!-- Card header with title -->
                                                                                    <h5 class="mb-0">{{ $announcement->title }}</h5> <!-- Title -->
                                                                                </div>
                                                                                <div class="card-body p-1"> <!-- Card body for content -->
                                                                                    <p class="card-text mb-1 px-2">{{ $announcement->content }}</p> <!-- Announcement content -->
                                                                                    <p class="text-muted small mb-1 px-2">Published on: {{ $announcement->created_at->format('F j, Y') }}</p> <!-- Publication date -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="back">
                                                <div class=" smoky-shadow chart-container bg-light p-6">
                                                    <div class="season-buttons">
                                                        <button class="btn" id="todayServedButtons">Today Served</button>
                                                    </div>
                                                    <canvas id="myChart" class="p-2" style="height: 20vh"></canvas> <!-- Example for a chart -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="{{ asset('../js/chart.min.js') }}"></script>
    <script src="{{ asset('../js/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#statisticsButton').click(function() {
                $('.flipper').css('transform', 'rotateY(180deg)');
            });

            $('#todayServedButton').click(function() {
                $('.flipper').css('transform', 'rotateY(0deg)');
            });
            
            $('#todayServedButtons').click(function() {
                $('.flipper').css('transform', 'rotateY(0deg)');
            });

            $('#statisticsButtons').click(function() {
                $('.flipper').css('transform', 'rotateY(180deg)');
            });
            

            

            function fetchVisitorData() {
                $.ajax({
                    url: '/dashboard', // Ensure this matches the route in web.php
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the visitor counts on success
                        $('#totalVisitors').text(data.totalVisitors);
                        $('#yesterdayVisitors').text(data.yesterdayVisitors);
                        $('#todayVisitors').text(data.todayVisitors);
                        $('#totalCanceledTransactions').text(data.totalCanceledTransactions);
                        $('#todayCanceledTransactions').text(data.todayCanceledTransactions); // Update for today’s canceled transactions
                        $('#totalPendingTransactions').text(data.totalPendingTransactions); // Update for total pending transactions
                        $('#todayPendingTransactions').text(data.todayPendingTransactions); // Update for today’s pending transactions
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching visitor data:", xhr.responseText);
                        $('#totalVisitors').text('Error');
                        $('#yesterdayVisitors').text('Error');
                        $('#todayVisitors').text('Error');
                        $('#totalCanceledTransactions').text('Error');
                        $('#todayCanceledTransactions').text('Error'); // Also handle error here
                        $('#totalPendingTransactions').text('Error'); // Handle error here
                        $('#todayPendingTransactions').text('Error'); // Handle error here
                    }
                });
            }
        
            // Call the function to fetch data on page load
            fetchVisitorData();
        });
    </script>

<script> // Initialize Chart
        $(document).ready(function() {
    $('#statisticsButton').click(function() {
        $('.flipper').css('transform', 'rotateY(180deg)');
        fetchMonthlyVisitorData(); // Fetch monthly data when switching to statistics
    });

    $('#todayServedButton').click(function() {
        $('.flipper').css('transform', 'rotateY(0deg)');
    });

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [], // Initial empty labels
        datasets: [{
            label: 'Total Visitors by Month',
            data: [], // Initial empty data
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            height: 10,
            fill: false,
            pointRadius: 5, // Size of the points on the chart
            pointHoverRadius: 7, // Size of the points on hover
            pointBackgroundColor: 'rgba(75, 192, 192, 1)', // Point color
            pointHoverBackgroundColor: 'rgba(255, 99, 132, 1)', // Point hover color
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            tooltip: {
                enabled: true, // Enable tooltips
                mode: 'index', // Tooltip shows on hover over all datasets at the same index
                intersect: false, // Allow for tooltips when hovering close to the line
                callbacks: {
                    label: function(tooltipItem) {
                        return `Month: ${tooltipItem.label}, Visitors: ${tooltipItem.raw}`; // Custom tooltip label
                    }
                }
            },
            legend: {
                display: true, // Show legend
                position: 'top' // Position of the legend
            },
            hover: {
                mode: 'nearest', // Hover mode for nearest point
                intersect: true // Only activate on nearest point
            }
        },
        interaction: {
            mode: 'nearest', // Interaction mode
            intersect: true // Interact with the nearest point
        }
    }
 });


    function fetchMonthlyVisitorData() {
    $.ajax({
        url: '/dashboard/monthly', // Ensure this matches the route in web.php
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const labels = data.map(item => item.month); // Use month names directly
            const visitorCounts = data.map(item => item.count);
            
            // Update the chart with the new data
            myChart.data.labels = labels;
            myChart.data.datasets[0].data = visitorCounts;
            myChart.update();
        },
        error: function(xhr, status, error) {
            console.error("Error fetching monthly visitor data:", xhr.responseText);
        }
    });
 }


    // Initial call to fetch data
    fetchMonthlyVisitorData();
 });

</script>

<script>
    function updateTimeAndDate() {
        const currentDateElement = document.getElementById('currentDate');
        const currentTimeElement = document.getElementById('currentTime');

        const now = new Date();
        const dateOptions = { year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

        currentDateElement.innerText = now.toLocaleDateString(undefined, dateOptions);
        currentTimeElement.innerText = now.toLocaleTimeString(undefined, timeOptions);
    }

    // Update every second
    setInterval(updateTimeAndDate, 1000);
</script>

<script>
    $(document).ready(function() {
        // Toggle sidebar menu
        $('.nav-link').click(function() {
            var parent = $(this).parent();
            if ($(parent).hasClass('menu-open')) {
                $(parent).removeClass('menu-open');
            } else {
                $(parent).addClass('menu-open');
            }
        });
    });
</script>
</body>
</html>
