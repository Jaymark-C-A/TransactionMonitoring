<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <!-- Local FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
</head>
<body class="text-sm">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-lg navbar-light" style="background: rgb(6, 193, 255);">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('includes.sidebar.sidebar')  
        </aside>
                <div class="content-wrapper bg-light">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">Account Dashboard</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h5 id="today-queue-count">Loading...</h5>
                                    <p class="text-sm">Today Queue</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer text-sm">More info  <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h5 id="today-served-count">Loading...</h5>
                                    <p class="text-sm">Today Served</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer text-sm">More info <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h5 id="today-no-show-count">Loading...</h5>
                                    <p class="text-sm">Today Canceled</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-close"></i>
                                </div>
                                <a href="#" class="small-box-footer text-sm">More info <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h5 id="today-serving-count">Loading...</h5>
                                    <p class="text-sm">Today Serving</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bell"></i>
                                </div>
                                <a href="#" class="small-box-footer text-sm">More info <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                
                    <!-- /.row -->

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">School Visitors</h3>
                                        <a href="/super-admin/reports/transactReport">View Report</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <span id="visitor-count" class="text-bold text-lg">Loading...</span>
                                            <span>Visitors Over Time</span>
                                        </p>
                                        <p class="ml-auto d-flex flex-column text-right">
                                            <span class="text-success">
                                                <i class="fas fa-arrow-up"></i> 12.5%
                                            </span>
                                            <span class="text-muted">Since last week</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->

                                    <div class="position-relative mb-4">
                                        <canvas id="visitors-chart" height="200"></canvas>
                                    </div>

                                    <div class="d-flex flex-row justify-content-end">
                                        <span class="mr-2">
                                            <i class="fas fa-square text-primary"></i> This Week
                                        </span>

                                        <span>
                                            <i class="fas fa-square text-gray"></i> Last Week
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </section>
                        <!-- /.Left col -->
                        <!-- Right col -->
                            <section class="col-lg-5 connectedSortable">
         <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Survey Evaluation</h3>
                    <a href="javascript:void(0);">View Report</a>
                </div>
            </div>
            <div class="card-body">
                 <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Survey Results</span>
                        <span>Survey Responses Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                            <i class="fas fa-arrow-up"></i> 5.3%
                        </span>
                        <span class="text-muted">Since last survey</span>
                    </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                    <canvas id="survey-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Positive Responses
                    </span>

                    <span>
                        <i class="fas fa-square text-gray"></i> Negative Responses
                    </span>
                </div>
            </div>
         </div>
         <!-- /.card -->
             </section>
                        <!-- /.Right col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            @include('includes.footer')
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery (local) -->
    <script src="../js/jquery.min.js"></script>
    <!-- Chart.js (local) -->
    <script src="{{ asset('../js/chart.min.js') }}"></script>

        <!-- Chart.js script -->
        <script>
            // Sample data for the survey chart
            const surveyData = {
                labels: ['Question 1', 'Question 2', 'Question 3', 'Question 4', 'Question 5'],
                datasets: [{
                    label: 'Positive Responses',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    data: [45, 59, 80, 81, 56]
                },
                {
                    label: 'Negative Responses',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    data: [20, 48, 40, 19, 36]
                }]
            };
    
            // Sample data for the visitors chart

            // Create the survey chart
            const surveyChartCanvas = document.getElementById('survey-chart').getContext('2d');
            new Chart(surveyChartCanvas, {
                type: 'bar',
                data: surveyData,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                display: true
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

<script>
    $(document).ready(function() {
        const visitorsChartCanvas = document.getElementById('visitors-chart').getContext('2d');
        let visitorsChart = new Chart(visitorsChartCanvas, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Visitors',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    data: []
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: { display: false },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { display: false }, beginAtZero: true }
                }
            }
        });

        function updateVisitorChart() {
            $.ajax({
                url: '/visitor-data',
                method: 'GET',
                success: function(response) {
                    const labels = response.map(data => data.date);
                    const data = response.map(data => data.count);

                    visitorsChart.data.labels = labels;
                    visitorsChart.data.datasets[0].data = data;
                    visitorsChart.update();
                }
            });
        }

        function updateVisitorCount() {
            $.ajax({
                url: '/visitor-count',
                method: 'GET',
                success: function(response) {
                    $('#visitor-count').text(response.count);
                }
            });
        }

        setInterval(updateVisitorChart, 1000); // Update chart every 1 seconds
        setInterval(updateVisitorCount, 1000); // Update count every 1 seconds
        updateVisitorChart(); // Initial chart update
        updateVisitorCount(); // Initial count update
    });
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



<script>
    function fetchVisitorCount(endpoint, elementId) {
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                document.getElementById(elementId).innerText = data.count;
            })
            .catch(error => {
                console.error(`Error fetching ${elementId}:`, error);
                document.getElementById(elementId).innerText = 'loading...';
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initial fetch
        fetchVisitorCount('/api/visitors/today', 'today-queue-count');
        fetchVisitorCount('/api/visitors/served', 'today-served-count');
        fetchVisitorCount('/api/visitors/no-show', 'today-no-show-count');
        fetchVisitorCount('/api/visitors/serving', 'today-serving-count');

        // Set up interval to fetch counts every 1 seconds
        setInterval(() => {
            fetchVisitorCount('/api/visitors/today', 'today-queue-count');
            fetchVisitorCount('/api/visitors/served', 'today-served-count');
            fetchVisitorCount('/api/visitors/no-show', 'today-no-show-count');
            fetchVisitorCount('/api/visitors/serving', 'today-serving-count');
        }, 1000); // 1seconds
    });
</script>
</body>
</html>
