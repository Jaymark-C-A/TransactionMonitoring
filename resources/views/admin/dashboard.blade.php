<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('includes.head')
    <style>
        /* CSS styles for card layout */
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

        .queue-list, .current-ticket {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
            width: 48%;
        }
        .current-ticket {
            text-align: center;
        }

        .current-ticket .ticket-number {
            font-size: 3em;
            margin: 20px 0;
        }

        .current-ticket .service-time {
            font-size: 1.2em;
            color: #666;
        }

        .current-ticket .actual-time {
            font-size: 1.5em;
            color: #d9534f;
            margin-bottom: 20px;
        }

        .current-ticket .actions button {
            background-color: #5bc0de;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .current-ticket .actions button.no-show {
            background-color: #d9534f;
        }

        .current-ticket .actions button.recall {
            background-color: #f0ad4e;
        }

        .current-ticket .actions button.transfer {
            background-color: #0275d8;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body class="text-sm">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-lg navbar-light" style="background:rgb(6, 193, 255);">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('includes.sidebar.sidebar-admin')  
        </aside>
        <div class="content-wrapper bg-light">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">Admin Transaction</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item" style="color:rgb(6, 193, 255);">Home</li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->
            <div class="queue-info">
                <!-- My Queue List -->
                <div class="queue-list" style="border:1px solid rgb(6, 193, 255);">
                    <h5>Queue List :</h5>
                    <div id="data-container"></div>
                </div>
                
                <!-- Current Ticket Info -->
                <div class="current-ticket" data-ticket-id="" style="border:1px solid rgb(6, 193, 255);">
                    <p style="font-size: 24px; color:blue;">Currently Serving!</p>
                    <div class="ticket-number">---</div>
                    <div class="actual-time">Actual Service Time: 00:00:00</div>
                    <div class="actions">
                        <button class="next" style="background: green">Next</button>
                        <button class="no-show">Canceled</button>
                        <button class="recall">Recall</button>
                        <button class="pending">Pending</button>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            @include('includes.footer')
        </footer>
    </div>
    <!-- ./wrapper -->
    <script>
        $(document).ready(function() {
             var csrfToken = $('meta[name="csrf-token"]').attr('content');
             var serviceStartTime = null;
 
             function fetchData() {
                 $.ajax({
                     url: '/fetch-dataAdmin',
                     type: 'GET',
                     dataType: 'json',
                     headers: {
                         'X-CSRF-TOKEN': csrfToken
                     },
                     success: function(data) {
                         var filteredData = data.filter(function(item) {
                             return item.status !== 'completed' && item.status !== 'canceled' && item.status !== 'pending' && item.department;
                         });
                         var html = '<div class="card-container w-50 pl-4 pb-3">';
                         for (var i = 0; i < Math.min(filteredData.length, 2); i++) {
                             var visitor = filteredData[i];
                             html += '<div class="card">';
                             html += '<p class="mb-0" style="font-size:20px;"><strong>' + visitor.ticket_number + '</strong></p>';
                             html += '<p class="mb-0"><strong>Department:</strong> ' + visitor.department + '</p>';
                             html += '<p class="mb-0"><strong>Purpose:</strong> ' + visitor.purpose + '</p>';
                             html += '</div>';
                         }
                         html += '</div>';
                         $('#data-container').html(html);
                         
                         if (filteredData.length > 0) {
                             $('.current-ticket .ticket-number').text(filteredData[0].ticket_number);
                             $('.current-ticket').attr('data-ticket-id', filteredData[0].id);
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
                             $('.current-ticket .ticket-number').text('---');
                             $('.current-ticket').attr('data-ticket-id', '');
                             serviceStartTime = null;
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
                 $.ajax({
                     url: '/next-ticket2',
                     type: 'POST',
                     dataType: 'json',
                     headers: {
                         'X-CSRF-TOKEN': csrfToken
                     },
                     success: function(response) {
                         fetchData();
                         serviceStartTime = new Date(); 
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
             });
 
             $('.current-ticket .actions button.no-show').click(function() {
                 $.ajax({
                     url: '/cancel-ticket2',
                     type: 'POST',
                     dataType: 'json',
                     headers: {
                         'X-CSRF-TOKEN': csrfToken
                     },
                     success: function(response) {
                         fetchData();
                         serviceStartTime = new Date(); 
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
             });
 
             $('.current-ticket .actions button.recall').click(function() {
                 var ticketNumber = $('.current-ticket .ticket-number').text();
                 $.ajax({
                     url: '/recall-ticket2',
                     type: 'POST',
                     data: { ticket_number: ticketNumber },
                     dataType: 'json',
                     headers: {
                         'X-CSRF-TOKEN': csrfToken
                     },
                     success: function(response) {
                         console.log('Ticket recalled:', ticketNumber);
                     },
                     error: function(xhr, status, error) {
                         console.error('Error recalling ticket:', error);
                     }
                 });
             });
 
             $('.current-ticket .actions button.pending').click(function() {
                 var ticketId = $('.current-ticket').attr('data-ticket-id');
                 if (!ticketId) {
                     console.error('No ticket ID found.');
                     return;
                 }
 
                 $.ajax({
                     url: '/pending-ticket2',
                     type: 'POST',
                     data: {
                         ticket_id: ticketId
                     },
                     dataType: 'json',
                     headers: {
                         'X-CSRF-TOKEN': csrfToken
                     },
                     success: function(response) {
                         fetchData();
                         serviceStartTime = null;
                         console.log('Ticket marked as pending.');
                     },
                     error: function(xhr, status, error) {
                         console.error('Error marking ticket as pending:', error);
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
