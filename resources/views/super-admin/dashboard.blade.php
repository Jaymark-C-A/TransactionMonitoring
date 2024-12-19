<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <!-- Local FontAwesome CSS -->
    <style>
        
    body:not(.layout-fixed) .main-sidebar {
    height: inherit;
    min-height: 100%;
    position: absolute;
    top: 0;
    }
    .container-fluid {
        padding-left: 5px;
        padding-right: 5px;
    }

    .row.no-gutters {
        margin-left: 0;
        margin-right: 0;
    }

    .card {
        margin: 10px 10px 15px 10px;
    }
    
    #calendar {
        width: 100%;
        height: 300px; /* Adjust height as needed */
    }
    .form-select {
        margin: 10px 0;
    }

    /* Ensure the card body height is constrained */
    .card-body {
        max-height: 300px; /* Adjust this height as needed */
        overflow-y: auto; /* Enable vertical scrolling */
        margin-top: -10px;
    }

    /* Optional: Style the table to make it fit well within the card body */
    #pending-visitors-table {
        width: 110%; /* Make table width fit the container */
    }
    

   .smoky-shadow {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
    } 

    #announcement-table th,
    #announcement-table td {
        max-width: 250px; 
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

        <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
    
</head>
<body class="text-sm" style="background-color: #cecece;">
    <div class="wrapper" style="background-color: transparent">
        <nav class="main-header navbar navbar-expand-lg navbar-light" style="background-color: #084262;">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
            @include('includes.sidebar.sidebar')  
        </aside>
        <div class="content-wrapper" style="background-color: transparent">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">Account Dashboard</h4>
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
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content px-0">
                <div class="container-fluid bg-transparent py-2">
                    <!-- Small boxes -->
                    <div class="row mx-auto p-0 m-0">
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-info smoky-shadow" style="height: 95%">
                                <div class="inner">
                                    <h5 id="today-queue-count" style="font-size: 46px;">Loading...</h5>
                                    <p class="text-md">Today Queue</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-plus" aria-hidden="true" style="font-size: 5rem"></i>
                                </div>
                                <div class="small-box-footer text-sm py-3 mb-0" ></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-success smoky-shadow" style="height: 95%">
                                <div class="inner">
                                    <h5 id="today-served-count" style="font-size: 46px;">Loading...</h5>
                                    <p class="text-md">Today Served</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-chart-bar" aria-hidden="true" style="font-size: 5rem"></i>
                                </div>
                                <div class="small-box-footer text-sm py-3" ></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-danger smoky-shadow" style="height: 95%">
                                <div class="inner">
                                    <h5 id="today-no-show-count" style="font-size: 46px;">Loading...</h5>
                                    <p class="text-md">Today Canceled</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-close" aria-hidden="true" style="font-size: 5rem"></i>
                                </div>
                                <div class="small-box-footer text-sm py-3" ></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-warning smoky-shadow" style="height: 95%">
                                <div class="inner">
                                    <h5 id="today-serving-count" style="font-size: 46px; color: #FFFFFF;">Loading...</h5>
                                    <p class="text-md" style="color: #FFFFFF;">Today Serving</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bell" aria-hidden="true" style="font-size: 5rem"></i>
                                </div>
                                <div class="small-box-footer text-sm py-3" ></div>
                            </div>
                        </div>
                    </div>
                    
                
                    <!-- Modal -->
                    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="infoModalLabel">More Info</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-info-content">Loading...</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                    <!-- Main row -->
                    <div class="container-fluid p-0">
                        <div class="row p-0">
                            <!-- First Section: School Visitors -->
                            <section class="col-lg-7 col-md-3 connectedSortable">
                                <div class="card smoky-shadow">
                                    <div class="card-header border-0" style="background: rgb(20, 129, 165);">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="text-white">School Visitors</h4>
                                            {{-- <a href="/super-admin/reports/transactReport" class="text-bold text-lg" style="color: #FFFFFF;">View Report</a> --}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <p class="d-flex flex-column">
                                                <span id="visitor-count" class="text-bold text-xl">Loading...</span>
                                                <span>Visitors Over Time</span>
                                            </p>
                                        </div>
                                        <!-- /.d-flex -->
                    
                                        <div class="position-relative">
                                            <canvas id="visitors-chart" height="auto"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </section>
                                                
                            <!-- Announcement Section -->
                            <section class="col-lg-5 col-md-3 connectedSortable">
                                <div class="card smoky-shadow">
                                    <div class="card-header border-0" style="background: rgb(20, 160, 165);">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="text-white">Announcement</h4>
                                            <!-- Trigger Icon -->
                                            <i class="fas fa-plus text-white" id="create-announcement" style="font-size: 30px;" data-bs-toggle="modal" data-bs-target="#announcementModal"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- New Table for Announcement Drafts -->
                                        <div class="card-body pb-0 px-0" height="auto">
                                            <table id="announcement-table" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Title</th>
                                                        <th class="text-center">Draft</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="announcementBody">
                                                    <!-- Data will be populated here dynamically -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Announcement Modal -->
                            <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="announcementModalLabel">New Announcement</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="announcementTitle" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="announcementTitle" placeholder="Enter the announcement title">
                                            </div>
                                            <div class="mb-3">
                                                <label for="announcementContent" class="form-label">Content</label>
                                                <textarea class="form-control" id="announcementContent" rows="4" placeholder="Enter the announcement content"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="announcementStatus" class="form-label">Status</label>
                                                <select class="form-select" id="announcementStatus">
                                                    <option value="draft">Draft</option>
                                                    <option value="published">Publish</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="saveAnnouncement">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Announcement Modal -->
                            <!-- Edit Announcement Modal -->
                            <div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAnnouncementModalLabel">Edit Announcement</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="announcementId"> <!-- Hidden input for storing ID -->
                                            <div class="mb-3">
                                                <label for="editAnnouncementTitle" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="editAnnouncementTitle" placeholder="Edit the announcement title">
                                            </div>
                                            <div class="mb-3">
                                                <label for="editAnnouncementContent" class="form-label">Content</label>
                                                <textarea class="form-control" id="editAnnouncementContent" rows="4" placeholder="Edit the announcement content"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editAnnouncementStatus" class="form-label">Status</label>
                                                <select class="form-select" id="editAnnouncementStatus">
                                                    <option value="draft">Draft</option>
                                                    <option value="published">Publish</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="updateAnnouncement">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    
                        <div class="row no-gutters">
                            <!-- Right col -->
                            <section class="col-lg-12 connectedSortable">
                                <div class="card smoky-shadow">
                                    <div class="card-header border-0"  style="background: rgb(214, 131, 6);">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="text-white">Feedback Evaluation</h4>
                                            {{-- <a href="/super-admin/reports/feedbackReport" class="text-bold text-lg" style="color: #FFFFFF;">View Report</a> --}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-body pb-2">
                                            <label for="period-filter">Filter by:</label>
                                            <select id="period-filter" class="form-control">
                                                <option value="daily">Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="yearly">Yearly</option>
                                            </select>
                                        </div>
                                        <div class="d-flex">
                                            <p class="d-flex flex-column">
                                                <span id="survey-count" class="text-bold text-xl">Loading...</span>
                                                <span>Feedback Responses</span>
                                            </p>
                                        </div>
                                        <!-- /.d-flex -->
                    
                                        <div class="position-relative">
                                            <canvas id="survey-chart" height=120"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </section>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </section>
        </div>

    <script src="{{ asset('../js/bootstrapInfo.bundle.min.js') }}"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="{{ asset('../js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('../js/chart.min.js') }}"></script>

<script>
    $(document).ready(function() {
        fetchAnnouncements(); // Fetch announcements when the DOM is ready

        // Set an interval to fetch announcements every 5 seconds
        setInterval(fetchAnnouncements, 10000);

        // Event listener for saving a new announcement
        $('#saveAnnouncement').on('click', function() {
            const title = $('#announcementTitle').val();
            const content = $('#announcementContent').val();
            const status = $('#announcementStatus').val();

            if (!title || !content) {
                Swal.fire('Error!', 'Please fill in all fields.', 'error');
                return;
            }

            // SweetAlert confirmation before saving
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to save this announcement!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/announcements',
                        type: 'POST',
                        data: {
                            title: title,
                            content: content,
                            status: status,
                            _token: $('input[name="_token"]').val() // CSRF token
                        },
                        success: function(data) {
                            fetchAnnouncements(); // Refresh announcements
                            clearAnnouncementForm(); // Clear the form
                            $('#announcementModal').modal('hide'); // Close the modal
                            Swal.fire('Saved!', 'Your announcement has been saved.', 'success');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            Swal.fire('Error!', 'There was an error saving the announcement.', 'error');
                        }
                    });
                }
            });
        });

        // Event listener for updating an announcement
        $('#updateAnnouncement').on('click', function() {
            const id = $('#announcementId').val();
            const title = $('#editAnnouncementTitle').val();
            const content = $('#editAnnouncementContent').val();
            const status = $('#editAnnouncementStatus').val();

            if (!title || !content) {
                Swal.fire('Error!', 'Please fill in all fields.', 'error');
                return;
            }

            // SweetAlert confirmation before updating
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to update this announcement!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/announcements/${id}`,
                        type: 'PUT',
                        data: {
                            title: title,
                            content: content,
                            status: status,
                            _token: $('input[name="_token"]').val() // CSRF token
                        },
                        success: function(data) {
                            fetchAnnouncements(); // Refresh announcements
                            $('#editAnnouncementModal').modal('hide'); // Close the modal
                            Swal.fire('Updated!', 'Your announcement has been updated.', 'success');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            Swal.fire('Error!', 'There was an error updating the announcement.', 'error');
                        }
                    });
                }
            });
        });
    });

    // Function to fetch announcements in real-time
    function fetchAnnouncements() {
        $.ajax({
            url: '/announcements',
            type: 'GET',
            success: function(data) {
                const announcementBody = $('#announcementBody');
                announcementBody.empty(); // Clear existing rows

                $.each(data, function(index, announcement) {
                    const row = `<tr>
                        <td class="text-center">${announcement.title}</td>
                        <td class="text-center">${announcement.status}</td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm" onclick="viewAnnouncement(${announcement.id})" data-bs-toggle="modal" data-bs-target="#announcementModal">View</button>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAnnouncementModal" onclick="editAnnouncement(${announcement.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteAnnouncement(${announcement.id})">Delete</button>
                        </td>
                    </tr>`;
                    announcementBody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching announcements:', error);
            }
        });
    }

    // Function to edit an announcement
    function editAnnouncement(id) {
        $.ajax({
            url: `/announcements/${id}`,
            type: 'GET',
            success: function(data) {
                $('#editAnnouncementTitle').val(data.title);
                $('#editAnnouncementContent').val(data.content);
                $('#editAnnouncementStatus').val(data.status);
                $('#announcementId').val(id); // Store the ID in a hidden input
                $('#editAnnouncementModal').modal('show'); // Show the modal
            },
            error: function(xhr, status, error) {
                console.error('Error fetching announcement:', error);
                alert('Failed to load announcement data. Please try again.');
            }
        });
    }

    // Function to confirm deletion of an announcement
    function confirmDeleteAnnouncement(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This announcement will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            position: 'top',
        }).then((result) => {
            if (result.isConfirmed) {
                deleteAnnouncement(id);
            }
        });
    }

    // Function to delete an announcement
    function deleteAnnouncement(id) {
        $.ajax({
            url: `/announcements/${id}`,
            type: 'DELETE',
            data: {
                _token: $('input[name="_token"]').val() // CSRF token
            },
            success: function() {
                fetchAnnouncements(); // Refresh the list after deletion
                Swal.fire('Deleted!', 'The announcement has been deleted.', 'success');
            },
            error: function(xhr, status, error) {
                console.error('Error deleting announcement:', error);
                Swal.fire('Error!', 'There was an error deleting the announcement.', 'error');
            }
        });
    }

    // Function to view announcement details
    function viewAnnouncement(id) {
        $.ajax({
            url: `/announcements/${id}`,
            type: 'GET',
            success: function(data) {
                $('#announcementModalLabel').text('View Announcement');
                $('#announcementTitle').val(data.title).prop('disabled', true);
                $('#announcementContent').val(data.content).prop('disabled', true);
                $('#announcementStatus').val(data.status).prop('disabled', true);
                $('#saveAnnouncement').hide();
                $('#announcementModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching announcement:', error);
            }
        });
    }

    // Function to clear the announcement form
    function clearAnnouncementForm() {
        $('#announcementTitle').val('');
        $('#announcementContent').val('');
        $('#announcementStatus').val('draft');
    }

    $('#announcementModal').on('hidden.bs.modal', function() {
        clearAnnouncementForm();
        $('#announcementTitle, #announcementContent, #announcementStatus').prop('disabled', false);
        $('#saveAnnouncement').show();
    });
</script>
                
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const surveyChartCanvas = document.getElementById('survey-chart').getContext('2d');
            let surveyChart;
            let pollingInterval = 60000; // Polling interval in milliseconds (e.g., 60000ms = 1 minute)
            let selectedPeriod = document.getElementById('period-filter').value;


            function fetchSurveyData(period) {
                fetch(`/survey-data?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        const surveyData = {
                            labels: data.map(survey => survey.period), // Periods from the data
                            datasets: [
                                {
                                    label: 'Feedback Responses',
                                    backgroundColor: 'rgba(60,141,188,0.9)',
                                    borderColor: 'rgba(60,141,188,0.8)',
                                    data: data.map(survey => survey.total) // Total Feedback responses per period
                                }
                            ]
                        };

                        if (surveyChart) {
                            surveyChart.destroy();
                        }

                        surveyChart = new Chart(surveyChartCanvas, {
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
                    })
                    .catch(error => console.error('Error fetching survey data:', error));
            }

            function fetchSurveyCount(period) {
                fetch(`/survey-count?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('survey-count').innerText = data.count;
                    })
                    .catch(error => console.error('Error fetching survey count:', error));
            }

            function updateSurveyData() {
                fetchSurveyData(selectedPeriod);
                fetchSurveyCount(selectedPeriod);
            }

            // Initial fetch
            updateSurveyData();

            // Update on filter change
            document.getElementById('period-filter').addEventListener('change', function () {
                selectedPeriod = this.value;
                updateSurveyData();
            });

            // Polling to update data every minute
            setInterval(updateSurveyData, pollingInterval);
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

        setInterval(updateVisitorChart, 5000); // Update chart every 1 seconds
        setInterval(updateVisitorCount, 5000); // Update count every 1 seconds
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
