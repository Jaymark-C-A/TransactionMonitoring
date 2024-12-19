<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('includes.head')
    <style>
        /* CSS styles for card layout */
        .actions {
            display: flex;  
            flex: 1;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .card {
            flex: 0 0 calc(150% - 6px); /* Adjust the width as needed */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        /* Styles for queue and ticket display */
        .queue-info {
            display: flex;
            justify-content: space-between;
            margin: 1.5rem;
        }

        .queue-list {
            padding: 20px;
            box-sizing: border-box;
        }
        .current-ticket {
            padding: 20px;
            box-sizing: border-box;
        }
        .current-ticket {
            text-align: center;
        }
        .ticket-purpose{
            font-size: 2.5em;
            padding-top: 3%; 
        }
        .current-ticket .ticket-number {
            padding-top: 5%; 
            padding-bottom: 5%; 
            font-size: 8em;
        }

        .ticket-number, .ticket-purpose {
            color: white;
        }

        .current-ticket .actions button {
            color: white;
            border: none;
            padding: 10px 40px;
            margin: 7% 0% 0% auto;
            cursor: pointer;
            width: 50%;
            height: 5rem;
            font-size: 30px !important;
            border-radius: 0;
        }

        .current-ticket .actions button.no-show .actions button.next{
            font-size: 50px;
        }

        .current-ticket .actions button.transfer {
            background-color: #0275d8;
        }

        /* Ensure the card body height is constrained */
        .card-body {
            max-height: 400px; /* Adjust this height as needed */
            overflow-y: auto; /* Enable vertical scrolling */
        }
        .smoky-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
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
        <div class="content-wrapper bg-transparent">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">My Transaction</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="dashboard" class="breadcrumb-item active">Dashboard</a>
                                <li class="breadcrumb-item active"><a href="monitor">Monitoring</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->
            <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="queue-list bg-light smoky-shadow m-0 p-0">
                        <div class="card-header m-0" style="background: rgb(42, 118, 143); color: white;">
                            <h2>QUEUE LIST</h2>
                        </div>
                        <div id="data-container" class="my-3"></div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="current-ticket smoky-shadow m-0 p-0" style="background: #844eb1;">
                        <div class="card-header mb-5 text-left" style="background: #7c49a7; color: white;">
                            <h2>CURRENTLY SERVING!</h2>
                        </div>
                        <div class="ticket-number">---</div>
                        <div class="ticket-purpose"></div>
                        <div class="actions">
                            <button class="btn btn-danger no-show">Cancel</button>
                            <button class="btn btn-success next">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
            <!-- Main content -->
            <!-- /.content -->
        </div>
    </div>
    <!-- ./wrapper -->

    <script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('../js/jquery.min.js') }}"></script>
    <script src="{{ asset('../js/sweetalert2.min.js') }}"></script>
    
<script>
        $(document).ready(function() {
             var csrfToken = $('meta[name="csrf-token"]').attr('content');
             var serviceStartTime = null;
 
             function fetchData() {
                $.ajax({
                    url: '/fetch-dataPrin',
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(data) {
                        var filteredData = data.filter(function(item) {
                            return item.status !== 'completed' && item.status !== 'canceled' && item.status !== 'pending' && item.department;
                        });

                        var html = '<div class="card-container p-2" style="width: 65%;">';
                        
                        // Check if filteredData is empty
                        if (filteredData.length === 0 || filteredData.length === 1) {
                            html += '<div class="card" style="background-color: #f8d7da;">'; // Light red background
                            html += '<p class="mb-0" style="font-size:20px; text-align:left;"><strong>No Queueing List</strong></p>';
                            html += '</div>';
                        } else {
                            if (filteredData.length > 1) { // Check if at least two tickets exist
                                var visitor = filteredData[1]; // Get the 2nd ticket (index 1)
                                html += '<div class="card" style="background-color: #66b5e93d">';
                                html += '<p class="mb-0" style="font-size:24px;"><strong>' + visitor.ticket_number + '</strong></p>';
                                html += '<p class="mb-0"><strong>Purpose:</strong> ' + visitor.purpose + '</p>';
                                html += '</div>';
                            }
                        }
                        html += '</div>';
                        $('#data-container').html(html);
                        
                        if (filteredData.length > 0) {
                            var firstVisitor = filteredData[0];
                            
                            // Check if the first visitor's status is not 'serving' and set it to 'serving'
                            if (firstVisitor.status !== 'serving') {
                                $.ajax({
                                    url: '/update-status-to-serving',
                                    type: 'POST',
                                    data: { ticket_id: firstVisitor.id },
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    success: function(response) {
                                        console.log('First visitor status updated to serving.');
                                        firstVisitor.status = 'serving'; // Update the local data to reflect the change
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error updating first visitor status:', error);
                                    }
                                });
                            }
                            
                            // Update the current ticket display
                            $('.current-ticket .ticket-number').text(firstVisitor.ticket_number);
                            $('.current-ticket .ticket-purpose').html('<span>Purpose: </span>' + firstVisitor.purpose);
                            $('.current-ticket').attr('data-ticket-id', firstVisitor.id);
                            
                            if (!serviceStartTime) {
                                $.ajax({
                                    url: '/get-service-start-time',
                                    type: 'GET',
                                    dataType: 'json',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    success: function(response) {
                                        serviceStartTime = new Date(response.start_time);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error fetching service start time:', error);
                                    }
                                });
                            }
                        } else {
                            // Reset current ticket display if no active tickets
                            $('.current-ticket .ticket-number').text('---');
                            $('.current-ticket .ticket-purpose').text('---');
                            $('.current-ticket').attr('data-ticket-id', '');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }


 
             function updateServiceTime() {
                 if (serviceStartTime) {
                     var now = new Date();
                     var elapsedTime = Math.floor((now - serviceStartTime) / 1000); 
                     var minutes = Math.floor((elapsedTime % 3600) / 60);
                     var seconds = elapsedTime % 60;
 
                     var formattedTime = [
                         minutes.toString().padStart(2, '0'),
                         seconds.toString().padStart(2, '0')
                     ].join(':');
 
                     $('.current-ticket .actual-time').text('Actual Service Time: ' + formattedTime);
                 }
             }
 
             $('.current-ticket .actions button.next').click(function() {
                var nextTicket = $('.current-ticket').attr('data-ticket-id');
                if (!nextTicket) {
                    Swal.fire({
                        title: 'Error',
                        text: 'No ticket selected to proceed to the next.',
                        icon: 'error',
                        position: 'top'
                    });
                    return;
                }
                // SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will proceed to the next ticket.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed!',
                    position: 'top'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/next-ticket4',
                            type: 'POST',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                fetchData();
                                serviceStartTime = new Date();
                                // Reset displayed time to zero
                                $('.current-ticket .actual-time').text('Actual Service Time: 00:00:00');
                                $.ajax({
                                    url: '/set-service-start-time',
                                    type: 'POST',
                                    data: { start_time: serviceStartTime.toISOString() },
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    success: function(response) {
                                        console.log('Service start time set successfully');
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error setting service start time:', error);
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error updating ticket status:', error);
                            }
                        });
                    }
                });
            });


                                // Skip functionality
        $('.skip').click(function() {
            var ticketId = $('.current-ticket').attr('data-ticket-id');
            if (!ticketId) {
                Swal.fire({
                    title: 'Error',
                    text: 'No ticket selected to skip.',
                    icon: 'error',
                    position: 'top'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "This will skip the current ticket and move it to the end of the queue.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, skip it!',
                position: 'top'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/skip-ticket4',
                        type: 'POST',
                        data: { ticket_id: ticketId },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Skipped!',
                                text: 'The ticket has been moved to the end of the queue.',
                                icon: 'success',
                                position: 'top'
                            });
                            fetchData();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error skipping ticket:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while skipping the ticket.',
                                icon: 'error',
                                position: 'top'
                            });
                        }
                    });
                }
            });
        });


    $('.current-ticket .actions button.no-show').click(function() {
    var cancelTicket = $('.current-ticket').attr('data-ticket-id');
        if (!cancelTicket) {
            Swal.fire({
                title: 'Error',
                text: 'No ticket selected to cancel.',
                icon: 'error',
                position: 'top'
            });
            return;
        }
    // SweetAlert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "This will cancel the ticket.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel it!',
        position: 'top'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/cancel-ticket4',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    fetchData();
                    serviceStartTime = new Date();
                    // Reset displayed time to zero
                    $('.current-ticket .actual-time').text('Actual Service Time: 00:00:00');
                    $.ajax({
                        url: '/set-service-start-time',
                        type: 'POST',
                        data: { start_time: serviceStartTime.toISOString() },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            console.log('Service start time set successfully');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error setting service start time:', error);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error updating ticket status:', error);
                }
            });
        }
    });
 });
 
             fetchData();
             setInterval(updateServiceTime, 1000); 
             setInterval(fetchData, 5000); 
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
