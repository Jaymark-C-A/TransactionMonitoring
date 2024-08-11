<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <!-- Local FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <style>
        .table-wrapper {
            overflow-x: auto;
            max-height: 500px;
            overflow-y: auto;
        }
        table {
            min-width: 1000px; /* Ensure the table is wide enough to trigger horizontal scrolling */
        }
    </style>
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
                            <h4 class="m-0">Transactions Report</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item" style="color: rgb(6, 193, 255);">Home</li>
                                <li class="breadcrumb-item active">Dashboard</li>
                                <li class="breadcrumb-item active">Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="container">
                <div class="row my-4">
                    <div class="col-md-5">
                        <input type="date" id="start-date" class="form-control" placeholder="Start Date">
                    </div>
                    <div class="col-md-5">
                        <input type="date" id="end-date" class="form-control" placeholder="End Date">
                    </div>
                    <div class="col-md-2">
                        <button id="filter-button" class="btn btn-block" style="background: rgb(6, 193, 255);">Filter</button>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-12">
                        <input type="text" id="search-bar" class="form-control" placeholder="Search...">
                    </div>
                </div>
                <div id="report-content">
                    <!-- Report Content will be loaded here by AJAX -->
                </div>
                <div class="text-right pb-3">
                    <button id="print-button" class="btn btn-success">Print Report</button>
                </div>
                
                
            </div>

            <!-- jQuery (local) -->
            <script src="../js/jquery.min.js"></script>
        
            <script>
            function fetchReportData(startDate, endDate, query) {
                let url = '/visitors';
                let params = [];
                if (startDate) params.push(`start_date=${startDate}`);
                if (endDate) params.push(`end_date=${endDate}`);
                if (query) params.push(`query=${query}`);
                if (params.length > 0) url += `?${params.join('&')}`;

                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function(data) {
                        let content = `
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Department</th>
                                        <th>Purpose</th>
                                        <th>Ticket Number</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.map(visitor => `
                                        <tr>
                                            <td>${visitor.id}</td>
                                            <td>${visitor.name}</td>
                                            <td>${visitor.contact}</td>
                                            <td>${visitor.department}</td>
                                            <td>${visitor.purpose}</td>
                                            <td>${visitor.ticket_number}</td>
                                            <td>${visitor.status}</td>
                                            <td>${new Date(visitor.created_at).toLocaleDateString()}</td>
                                        </tr>`).join('')}
                                </tbody>
                            </table>
                        `;
                        $('#report-content').html(content);
                    },
                    error: function() {
                        $('#report-content').html('<p>Error loading report data.</p>');
                    }
                });
            }

            $(document).ready(function(){
                $('#filter-button').click(function() {
                    const startDate = $('#start-date').val();
                    const endDate = $('#end-date').val();
                    const query = $('#search-bar').val();
                    fetchReportData(startDate, endDate, query);
                });

                $('#search-bar').on('input', function() {
                    const startDate = $('#start-date').val();
                    const endDate = $('#end-date').val();
                    const query = $(this).val();
                    fetchReportData(startDate, endDate, query);
                });

                // Fetch initial report data without any filters
                fetchReportData();

                // Print button functionality
                $('#print-button').click(function() {
                    window.print();
                });
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
</body>
</html>
