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
            min-width: 1000px; 
        }
        .smoky-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
        }
    </style>
    <!-- Local FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<body class="text-sm" style="background-color: #cecece">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-lg navbar-light" style="background-color: #084262;">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
            @include('includes.sidebar.sidebar-guidance')  
        </aside>
        <div class="content-wrapper" style="background-color: transparent">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">Transactions Report</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="guidance/dashboard" class="breadcrumb-item active">Dashboard</a>
                                <a href="transactReport" class="breadcrumb-item active" style="color: rgb(6, 193, 255);">Transactions Report</a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container p-4 bg-light smoky-shadow">
                <div class="row my-4">
                    <div class="col-md-5">
                        <label for="start-date">Start Date</label>
                        <input type="date" id="start-date" class="form-control" placeholder="Start Date">
                    </div>
                    <div class="col-md-5">
                        <label for="end-date">End Date</label>
                        <input type="date" id="end-date" class="form-control" placeholder="End Date">
                    </div>
                    <div class="col-md-2">
                        <label for="print" class="text-left">Print</label>
                        <button id="print-button" class="form-control btn btn-success">Print Report</button>
                    </div>
                </div>
                <div id="report-content3" class="table-wrapper p-2 bg-light">
                    <!-- Report Content will be loaded here by AJAX -->
                </div>
            </div>
            
        </div>

        {{-- <footer class="main-footer bg-dark text-light py-16">
            @include('includes.footer')
        </footer> --}}
    </div>

    <!-- jQuery (local) -->
    <script src="../js/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('../js/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('../js/chart.min.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>



    <script>
        function fetchReportData(startDate, endDate, query, department) {
            let url = '/visitorGui';
            let params = [];

            if (startDate) params.push(`start_date=${startDate}`);
            if (endDate) params.push(`end_date=${endDate}`);
            if (query) params.push(`query=${query}`);
            if (department) params.push(`department=${department}`);

            if (params.length > 0) url += `?${params.join('&')}`;

            $.ajax({
                url: url,
                dataType: 'json',
                success: function(data) {
                    let content = `
                        <table id="visitorTable"  class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Purpose</th>
                                    <th>Ticket Number</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data
                                .filter(visitor => visitor.status.toLowerCase() !== 'waiting' && visitor.status.toLowerCase() !== 'serving')                                    .map(visitor => `
                                        <tr>
                                            <td>${visitor.id}</td>
                                            <td>${visitor.name ? visitor.name : 'N/A'}</td>
                                            <td>${visitor.contact ? visitor.contact : 'N/A'}</td>
                                            <td>${visitor.purpose ? visitor.purpose : 'N/A'}</td>
                                            <td>${visitor.ticket_number}</td>
                                            <td><label class="badge badge-primary mx-1">${visitor.status}</label></td>
                                            <td>${new Date(visitor.created_at).toLocaleString()}</td>
                                        </tr>
                                    `).join('')}
                            </tbody>
                        </table>
                    `;
                    $('#report-content3').html(content);

                                // Initialize DataTable
                    $('#visitorTable').DataTable();
                },
                error: function() {
                    $('#report-content3').html('<p>Error loading report data.</p>');
                }
            });
        }

        $(document).ready(function() {
            function fetchData() {
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();
                const query = $('#search-bar').val();
                const department = $('#department-dropdown').val();
                fetchReportData(startDate, endDate, query, department);
            }

            $('#start-date, #end-date, #search-bar, #department-dropdown').on('change input', fetchData);

            // Fetch initial report data without any filters
            fetchData();

        });
    </script>

<iframe id="print-iframe" style="display:none;"></iframe>

<script>
    $('#print-button').click(function() {
        // Check for the "No data available" message first
        if ($('#report-content3 tbody').text().includes('No data available in table')) {
            totalTransactions = 0; // Set count to zero if the message is present
        } else {
            // Count the number of rows in the table
            totalTransactions = $('#report-content3 tbody tr').length;
        }
        let departmentCounts = {}; // Object to store counts by department
        let statusCounts = { canceled: 0, completed: 0 }; // Object to store counts for "canceled" and "completed"

        $('#report-content3 tbody tr').each(function() {
            let department = $(this).find('td').eq(3).text(); // Assuming department is in the 4th column
            let status = $(this).find('td').eq(6).text().toLowerCase(); // Assuming status is in the 6th column

            // Count department transactions
            if (departmentCounts[department]) {
                departmentCounts[department]++;
            } else {
                departmentCounts[department] = 1;
            }

            // Count status transactions
            if (status === "canceled") {
                statusCounts.canceled++;
            } else if (status === "completed") {
                statusCounts.completed++;
            }
        });

        // Capture the selected start date and end date from the filter inputs
        let startDate = $('#start-date').val() ? new Date($('#start-date').val()).toLocaleDateString() : 'N/A';
        let endDate = $('#end-date').val() ? new Date($('#end-date').val()).toLocaleDateString() : 'N/A';

        // Prepare the statistics content
        let statisticsContent = `
            <div class="statistics-report pt-2">
                <div class="row">
                    <div class="col-md-5">
                        <h1>Statistics:</h1>
                        <p><strong>Report Duration: </strong>${startDate} to ${endDate}</p>
                        <p><strong>Total Transactions: </strong>${totalTransactions}</p>
                        <strong>Transactions by Department:</strong>
                        <ul class="list-unstyled">
                            ${Object.keys(departmentCounts).map(dept => `<li><strong>${dept}: </strong>${departmentCounts[dept]} Transactions</li>`).join('')}
                        </ul>
                    </div>
                </div>
            </div>
        `;

 // Extract data from the original table and construct a new table for printing
var printTableContent = `
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
                <!-- Add headers as needed -->
            </tr>
        </thead>
        <tbody>
`;

// Iterate through each row in the original table and copy the data
$('#report-content3 tbody tr').each(function() {
    printTableContent += '<tr>';
    $(this).find('td').each(function() {
        printTableContent += `<td>${$(this).html()}</td>`;
    });
    printTableContent += '</tr>';
});

printTableContent += `
        </tbody>
    </table>
`;

var printIframe = document.getElementById('print-iframe');
var printWindow = printIframe.contentWindow.document;

// Create a new window for printing
printWindow.open();
printWindow.write(`
    <html>
        <head>
            <title>Print Report</title>
            <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
            <style>
                @media print {
                    body {
                        width: 210mm;
                        height: 297mm;
                        margin: 0 auto;
                        font-size: 16px;
                    }

                    .text-center {
                        text-align: center;
                    }

                    .page-break {
                        page-break-after: always;
                    }

                    .analysis {
                        max-width: 68%;
                    }

                    /* Fixed header and footer for each page */
                    @page {
                        margin: 20mm;
                    }

                    header {
                        position: fixed;
                        top: 0;
                        width: 100%;
                        text-align: center;
                        background: white;
                        z-index: 1000;
                        display: block;
                    }

                    footer {
                        position: fixed;
                        bottom: 0;
                        width: 100%;
                        text-align: center;
                        padding-bottom: 10mm;
                        background: white;
                        z-index: 1000;
                        display: block;
                    }

                    /* To avoid content being hidden behind the fixed header and footer */
                    body {
                        padding-top: 60mm; /* Adjust padding-top to the height of header */
                        padding-bottom: 30mm; /* Adjust padding-bottom to the height of footer */
                    }
                }
            </style>
        </head>
        <body>
            <header class="text-center text-md pb-1 mb-1" style="line-height: 20px">
                <img src="{{ asset('img/printLogo.png') }}" alt="logo" style="width: 100px; height: auto;">
                <p class="lead mb-0 pb-0 pt-2" style="font-family: Old English Text MT">Republic of the Philippines</p>
                <h2 class="text-black py-0 my-0" style="font-family: Old English Text MT">Department of Education</h2>
                <p class="py-0 my-0" style="font-family: Trajan Pro; font-weight: 800; font-size: 18px">Region III</p>
                <p class="py-0 my-0" style="font-size: 20px; font-family: Trajan Pro;"><strong>SCHOOLS DIVISION OFFICE OF OLONGAPO CITY</strong></p>
                <strong style="font-size: 20px; font-family: Trajan Pro;">OLONGAPO CITY NATIONAL HIGH SCHOOL</strong>
                <hr class="my-3 w-75">
            </header>
            <main>
                <h3 class="text-center">Transactions Report</h3>
                ${statisticsContent}
                ${printTableContent}

                <div class="analysis col-md-7">
                    <h1>Analysis:</h1>
                    <p>The client transactions Report was conducted on ${startDate} to ${endDate}, and there are ${totalTransactions} respondents in total.</p>
                    <p>Based on the submitted survey form, ${statusCounts.completed} out of ${totalTransactions} respondents are marked as “Completed” and ${statusCounts.canceled} out of ${totalTransactions} are marked as "Canceled".</p>
                </div>

            </main>
            <footer>
                <div class="container-fluid mb-2">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="{{ asset('img/footer.png') }}" alt="footer-logo" style="width: 100%; height: auto;">
                        </div>
                    </div>
                </div>
            </footer>
        </body>
    </html>
`);

printWindow.close();

// Trigger print on the iframe
printIframe.contentWindow.print();
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
