<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .table-wrapper {
            overflow-x: auto;
            max-height: 700px;
            overflow-y: auto;
        }
        table {
            min-width: 1000px; /* Adjust this width based on your column content */
        }
        .table-container {
            width: 100%; /* Full width container */
            overflow-x: auto; /* Horizontal scrolling */
        }

        .table thead th {
            text-align: center; /* Center align header text */
            transition: all 0.3s ease; /* Smooth transition */
        }
        .table tbody td {
            text-align: center; /* Center align table data */
            transition: all 0.3s ease; /* Smooth transition */
        }
        .table th, .table td {
            padding: 12px; /* Increase padding for better readability */
            overflow: hidden; /* Hide overflow text */
        }

        .statistics, .chart-container {
            flex: 1; /* Allow elements to take up equal space */
            min-width: 0; /* Ensure items don’t overflow */
        }

        .chart-container {
            display: flex;
            flex-direction: column;
        }

        @media print {

            .container-fluid {
                width: 100%; /* Full width for print */
            }

            .row {
                border: none; /* Remove border for print */
                display: block; /* Stack items vertically for print */
                padding: 0; /* Remove padding for print */
            }

            .statistics, .chart-container {
                width: 100%; /* Full width for print */
                margin-bottom: 20px; /* Space between sections */
            }

            .table-container {
                width: 100%; /* Full width for print */
            }

            @page {
                size: A4; /* Set print size */
                margin: 10mm; /* Set page margins */
            }
        }

        .smoky-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/dataTable.css') }}">
</head>
<body style="background-color: #cecece">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-lg navbar-light" style="background-color: #084262;">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
            @include('includes.sidebar.sidebar-admin')  
        </aside>
        <div class="content-wrapper" style="background-color: transparent">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">Feedback Report</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="admin/dashboard" class="breadcrumb-item active">Dashboard</a>
                                <a href="feedbackReport" class="breadcrumb-item active" style="color: rgb(6, 193, 255);">Feedbacks Report</a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container w-100 bg-light p-2 smoky-shadow">
                <!-- Statistics and Chart Section -->
                <div class="col-md-12 text-right my-3">
                    <button class="btn btn-primary"><a href="/admin/reports/printEx" class="text-white">Print Report</a></button>
                </div>

                <!-- Feedback Table -->
                <div class="table-container bg-light p-2">
                    <table id="visitorTable" class="table table-striped">
                        <thead id="feedbackTableHead">
                            <tr>
                                <th class="id">No.</th>
                                <th class="SQD_0">SQD_1</th>
                                <th class="SQD_1">SQD_2</th>
                                <th class="SQD_2">SQD_3</th>
                                <th class="SQD_3">SQD_4</th>
                                <th class="SQD_4">SQD_5</th>
                                <th class="SQD_5">SQD_6</th>
                                <th class="SQD_6">SQD_7</th>
                                <th class="SQD_7">SQD_8</th>
                                <th class="feedback">Feedback</th>
                            </tr>
                        </thead>
                        <tbody id="feedbackTableBody">
                            <!-- Data will load here via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('../js/sweetalert2.min.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('../js/chart.min.js') }}"></script>
    <script src="{{ asset('../js/dataTable.js') }}"></script>

    <!-- AJAX Script -->
    <script>
        $(document).ready(function() {
            function loadFeedbackData() {
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();
    
                $.ajax({
                    url: '{{ route('feedback.get') }}',
                    type: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        $('#feedbackTableBody').empty();
                        
                        let answerCounts = {
                            'SQD_0': 0,
                            'SQD_1': 0,
                            'SQD_2': 0,
                            'SQD_3': 0,
                            'SQD_4': 0,
                            'SQD_5': 0,
                            'SQD_6': 0,
                            'SQD_7': 0
                        };
    
                        if (response.length > 0) {
                            // Filter feedback to include only entries from the clinic
                            const clinicFeedback = response.filter(feedback => feedback.Office === 'Admin');

                            clinicFeedback.forEach(function(feedback, index) {

                                const row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${feedback.SQD_0 ? feedback.SQD_0 : 'N/A'}</td>
                                        <td>${feedback.SQD_1 ? feedback.SQD_1 : 'N/A'}</td>
                                        <td>${feedback.SQD_2 ? feedback.SQD_2 : 'N/A'}</td>
                                        <td>${feedback.SQD_3 ? feedback.SQD_3 : 'N/A'}</td>
                                        <td>${feedback.SQD_4 ? feedback.SQD_4 : 'N/A'}</td>
                                        <td>${feedback.SQD_5 ? feedback.SQD_5 : 'N/A'}</td>
                                        <td>${feedback.SQD_6 ? feedback.SQD_6 : 'N/A'}</td>
                                        <td>${feedback.SQD_7 ? feedback.SQD_7 : 'N/A'}</td>
                                        <td>${feedback.Feedback ? feedback.Feedback.substring(0, 10) + (feedback.Feedback.length > 10 ? '...' : '') : 'N/A'}</td>
                                    </tr>`;
                                $('#feedbackTableBody').append(row);
                                $('#visitorTable').DataTable();
                            });
                        }  else {
                            $('#feedbackTableBody').append('<tr><td colspan="18" class="text-center">No feedback available</td></tr>');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
    
            // Load data when the page loads
            loadFeedbackData();
    
            // Reload data when filters change
            $('#startDate, #endDate').change(function() {
                loadFeedbackData();
            });
        });
    </script>
    
</body>
</html>
