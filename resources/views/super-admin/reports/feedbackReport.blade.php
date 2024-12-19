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
            @include('includes.sidebar.sidebar')  
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
                                <a href="super-admin/dashboard" class="breadcrumb-item active">Dashboard</a>
                                <a href="feedbackReport" class="breadcrumb-item active" style="color: rgb(6, 193, 255);">Feedbacks Report</a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

<div class="container bg-light p-2 smoky-shadow">
    <!-- Statistics and Chart Section -->
    <div class="container bg-light p-4 d-flex" style="gap: 5%;" >
        <!-- Statistics Section -->
        <div class="statistics" style="color: black">
            <h3>Total Feedbacks:</h3>
            <div>
                <strong><span style="font-size: 46px" id="totalFeedbacks">0</span></strong>
            </div>
            <div class="col-md-3" style="text-align: right; padding: 10px 10px 0px 0px;">
                <button class="btn btn-primary"><a href="/printEx" class="text-white">Print Report</a></button>
            </div>
        </div>

        <!-- Feedback Answer Chart Container -->
        <div class="chart-container d-none d-sm-block">
            <canvas id="feedbackAnswerChart"></canvas>
        </div>
    </div>

    
    <!-- Feedback Table -->
    <div class="table-container bg-light p-2">
        <table id="visitorTable" class="table table-striped">
            <thead id="feedbackTableHead">
                <tr>
                    <th class="id">No.</th>
                    <th class="Office">Office</th>
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
            const clientType = $('#clientType').val();
            const gender = $('#gender').val();
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            $.ajax({
                url: '{{ route('feedback.get') }}',
                type: 'GET',
                data: {
                    client_type: clientType,
                    gender: gender,
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    $('#feedbackTableBody').empty();
                    
                    let totalAge = 0;
                    let maleCount = 0;
                    let femaleCount = 0;
                    let ageGroups = {
                        'Under 20': 0,
                        '20-29': 0,
                        '30-39': 0,
                        '40-49': 0,
                        '50-59': 0,
                        '60 and above': 0
                    };
                    let answerCounts = {
                        'CC1': 0,
                        'CC2': 0,
                        'CC3': 0,
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
                        response.forEach(function(feedback, index) {
                            // Format date
                            const date = new Date(feedback.created_at);
                            const formattedDate = `${date.getDate().toString().padStart(2, '0')}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getFullYear()}`;

                            const row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${feedback.Office ? feedback.Office : 'N/A'}</td>
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


                            // Calculate statistics
                            totalAge += parseInt(feedback.Age, 10);
                            if (feedback.Gender && feedback.Gender.toLowerCase() === 'male') maleCount++;
                            if (feedback.Gender && feedback.Gender.toLowerCase() === 'female') femaleCount++;

                            // Calculate age groups
                            const age = parseInt(feedback.Age, 10);
                            if (age < 20) ageGroups['Under 20']++;
                            else if (age >= 20 && age < 30) ageGroups['20-29']++;
                            else if (age >= 30 && age < 40) ageGroups['30-39']++;
                            else if (age >= 40 && age < 50) ageGroups['40-49']++;
                            else if (age >= 50 && age < 60) ageGroups['50-59']++;
                            else ageGroups['60 and above']++;

                            // Count answers
                            for (const [key, value] of Object.entries(answerCounts)) {
                                if (feedback[key] !== null) {
                                    answerCounts[key]++;
                                }
                            }
                        });

                        const averageAge = (totalAge / response.length).toFixed(2);
                        $('#totalFeedbacks').text(response.length);
                        $('#averageAge').text(averageAge);
                        $('#maleCount').text(maleCount);
                        $('#femaleCount').text(femaleCount);
                        updateAnswerChart(answerCounts); // Update the answer chart with new data
                        updateChart(ageGroups); // Update the age distribution chart with new data
                    } else {
                        $('#feedbackTableBody').append('<tr><td colspan="18" class="text-center">No feedback available</td></tr>');
                        $('#totalFeedbacks').text('0');
                        $('#averageAge').text('N/A');
                        $('#maleCount').text('0');
                        $('#femaleCount').text('0');
                        updateAnswerChart({}); // Clear the answer chart if no data
                        updateChart({}); // Clear the age distribution chart if no data
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Unable to load data.');
                }
            });
        }

        function updateAnswerChart(answerCounts) {
            const ctx = document.getElementById('feedbackAnswerChart').getContext('2d');
            const chartData = {
                labels: Object.keys(answerCounts),
                datasets: [{
                    label: 'Feedback Answers Count',
                    data: Object.values(answerCounts),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                }]
            };

            if (window.answerChart) {
                window.answerChart.destroy(); // Destroy existing chart if it exists
            }

            window.answerChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: {
                                color: 'rgb(6, 193, 255)' // Change this to your desired text color for the x-axis
                            },
                            beginAtZero: true
                        },
                        y: {
                            ticks: {
                                color: 'rgb(6, 193, 255)' // Change this to your desired text color for the x-axis
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function updateChart(ageGroups) {
            const ctx = document.getElementById('ageDistributionChart').getContext('2d');
            const chartData = {
                labels: Object.keys(ageGroups),
                datasets: [{
                    label: 'Age Distribution',
                    data: Object.values(ageGroups),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            if (window.ageChart) {
                window.ageChart.destroy(); // Destroy existing chart if it exists
            }

            window.ageChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: {
                                color: 'rgb(6, 193, 255)' // Change this to your desired text color for the x-axis
                            },
                            beginAtZero: true
                        },
                        y: {
                            ticks: {
                                color: 'rgb(6, 193, 255)' // Change this to your desired text color for the x-axis
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Load data when the page loads
        loadFeedbackData();

        // Reload data when filters change
        $('#clientType, #gender, #startDate, #endDate').change(function() {
            loadFeedbackData();
        });
    });
</script>




<script>
    $('#print-button').click(function() {
        // Get the header content
        var headerContent = $('#feedbackTableHead').html(); // Ensure you have a thead with an id of feedbackTableHead
        // Get the body content
        var printContent = `<table class="table table-bordered table-striped"><thead>${headerContent}</thead><tbody>${$('#feedbackTableBody').html()}</tbody></table>`;
        
        var printWindow = window.open('', '', 'height=600,width=800'); 

        printWindow.document.write('<html><head><title>Print Report</title>');
        printWindow.document.write('<link rel="stylesheet" href="' + '{{ asset('../css/bootstrap.min.css') }}' + '">');
        printWindow.document.write(`
            <style>
                @media print {
                    body {
                        width: 210mm;
                        height: 297mm;
                        margin: 0 auto;
                        font-size: 12px;
                    }
                    .container {
                        padding: 15mm;
                    }
                    .text-center {
                        text-align: center;
                    }
                    .page-break {
                        page-break-after: always;
                    }
                    .table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    .table-bordered th, .table-bordered td {
                        border: 1px solid #dee2e6;
                        padding: 8px;
                    }
                    .table th {
                        background-color: #f8f9fa;
                        font-weight: bold;
                    }
                    .table-striped tbody tr:nth-of-type(odd) {
                        background-color: #f2f2f2;
                    }
                }
            </style>
        `);
        
        printWindow.document.write('</head><body class="container">');
        printWindow.document.write('<h3 class="text-center">Feedbacks Report</h3>'); 
        printWindow.document.write(printContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close(); 
        
        printWindow.print();
    });
</script>












<script>
    $(document).ready(function() {
        // Toggle sidebar menu
        $('.nav-link').click(function() {
            var parent = $(this).parent();
            $(parent).toggleClass('menu-open');
        });
    });
</script>

</body>
</html>
