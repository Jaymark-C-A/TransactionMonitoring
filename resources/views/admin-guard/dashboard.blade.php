<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .smoky-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
        }

    .current-ticket {
        text-align: center;
    }
    body {
        background-color: rgb(90, 164, 233) !important;
    }
    </style>
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
</head>
<body class="text-sm" style="background-color: #cecece">
    <div class="wrapper" style="background-color: transparent">
        <nav class="header navbar navbar-expand-lg navbar-light" style="background-color: #084262;">
            @include('includes.nav-offices')
        </nav>
        <div class="wrapper" style="background-color: transparent">

            <div class="text-right m-3">
                <a class="btn text-white smoky-shadow" style="background-color: #4CAF50;" href="/feedback"> <!-- Custom green background -->
                    <i class="fa fa-clipboard-list"></i> <!-- Clipboard icon representing a form -->
                    Feedback Form
                </a>
            </div>
            <!-- Main content -->
            <div class="container-fluid flex flex-col md:flex-row justify-between w-full ">
                
                <div class="smoky-shadow rounded-lg mb-4 w-full bg-light" style="border: 1px solid rgb(6, 193, 255);">
                    <div class="card-header text-center text-white pt-4" style="background-color: #20639B;">
                        <h2>VISITOR FORM</h2>
                    </div>
                    <form id="visitor-form" action="{{ route('visitors.store') }}" method="POST" class="flex flex-col px-4 py-4 bg-white" onsubmit="handlePurposeField()">                        
                        @csrf
                        <div class="mb-4">
                            <label for="name">Full Name<span style="color: red;"> *</span></label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label for="contact" class="form-label">Contact Number (Mobile)<span style="color: red;"> *</span></label>
                            <input type="text" 
                            id="contact" 
                            name="contact" 
                            class="form-control" 
                            pattern="09\d{9}" 
                            maxlength="11" 
                            required 
                            placeholder="09XXXXXXXXX"
                            title="Phone number must start with 09 and be followed by 9 digits."
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>                        
                        <div class="mb-4">
                            <label for="department" class="form-label">Department <span style="color: red;"> *</span></label>
                            <select name="department" id="department" class="form-select form-control" required>
                                <option value="">Select department</option>
                                <option {{ old('department') == '0' ? 'selected' : '' }} value="Clinic">Clinic</option>
                                <option {{ old('department') == '1' ? 'selected' : '' }} value="Guidance">Guidance</option>
                                <option {{ old('department') == '2' ? 'selected' : '' }} value="Accounting">Accounting</option>
                                <option {{ old('department') == '3' ? 'selected' : '' }} value="Records">Records</option>
                                <option {{ old('department') == '4' ? 'selected' : '' }} value="Admin">Admin</option>
                            </select>                        
                        </div>
                        <div id="additionalOptions" style="display: none;" class="mb-4">
                            <label for="purpose" class="form-label">Purpose<span style="color: red;"> *</span></label>
                            <select name="purpose" id="additional_option" class="form-select form-control" required></select> 
                        </div>

                        <div id="additionalOptionss" style="display: none;" class="mb-4">
                            <label for="purpose_other" class="form-label">Please Specify<span style="color: red;"> *</span></label>
                            <input type="text" id="purpose_other" class="form-control" required>
                        </div>
                    
                        <!-- Hidden input to store the final purpose value -->
                        <input type="hidden" name="purpose" id="final_purpose" required>

                        <button type="submit" class="form-control  self-center text-dark font-bold" style="background: rgb(6, 193, 255);">Submit</button>
                    </form>
                </div>

                <!-- Current Ticket Info -->
                <div class="current-ticket ml-md-5 ml-lg-5 bg-transparent">
                    <div class="container-fluid"    >
                        <div class="row">
                            <!-- DEPARTMENT NAME -->
                            <audio id="ticket-notification-sound" src="../audio/Recording.mp4" preload="auto"></audio>
                            <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                                <div class="card-body" style="background: #e69430; color: white;">
                                    <h3 class="card-text text-white">Now Serving!</h3>
                                </div>
                                <div class="card-body" style="background: #d68725; color: white;">
                                    <div style="font-size:35px; font-weight:bolder;" class="ticket-number pb-2 m-0"  id="records-ticket">---</div>
                                    <h5 class="text-white">Records Office</h5> 
                                    <div id="ticket-purpose-container5"></div>
                                </div>
                            </div>
                            
                            
                            <!-- DEPARTMENT NAME -->
                            <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                                <div class="card-body" style="background: #20b6bb; color: white;">
                                    <h3 class="card-text text-white">Now Serving!</h3>
                                </div>
                                <div class="card-body" style="background: #1eaaaf; color: white">
                                    <div style="font-size:35px; font-weight:bolder;" class="ticket-number pb-2 m-0" id="admin-ticket">---</div>
                                    <h5 class="text-white">Admin Office</h5>
                                    <div id="ticket-purpose-container1"></div>
                                </div>
                            </div>
                            <!-- DEPARTMENT NAME -->
                            <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                                <div class="card-body" style="background: #097969; color: white;">
                                    <h3 class="card-text text-white">Now Serving!</h3>
                                </div>
                                <div class="card-body" style="background: #076e5e; color: white">
                                    <div style="font-size:35px; font-weight:bolder;" class="ticket-number pb-2 m-0" id="accounting-ticket">---</div>
                                    <h5 class="text-white">Accounting Office</h2> 
                                    <div id="ticket-purpose-container2"></div>
                                </div>
                            </div>
                            <!-- DEPARTMENT NAME -->
                            <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                                <div class="card-body" style="background: #844eb1; color: white;">
                                    <h3 class="card-text text-white">Now Serving!</h3>
                                </div>
                                <div class="card-body" style="background: #7c49a7; color: white">
                                    <div style="font-size:35px; font-weight:bolder;" class="ticket-number pb-2 m-0" id="principal-ticket">---</div>
                                    <h5 class="text-white">Medical Clinic Office</h5> 
                                    <div id="ticket-purpose-container3"></div>
                                </div>
                            </div>
                            <!-- DEPARTMENT NAME -->
                            <div class="card col-md-4 col-sm-12 col-xs-13 p-0">
                                <div class="card-body" style="background: #0f74a3; color: white;">
                                    <h5>Department Queue Overview</h5>
                                </div>
                                <div class="card-body" style="background: #0c648d; color: white">
                                    <div>
                                        <div class="row text-left">
                                            <div class="col-md-7">
                                                <p>Records: <span id="records-count">0</span></p>
                                                <p>Accounting: <span id="accounting-count">0</span></p>
                                                <p>Guidance: <span id="guidance-count">0</span></p>
                                            </div>
                                            <div class="col-md-5">
                                                <p>Admin: <span id="admin-count">0</span></p>
                                                <p>Clinic: <span id="clinic-count">0</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- DEPARTMENT NAME -->
                            <div class="card col-md-4 col-sm-12 col-xs-12 p-0">
                                <div class="card-body" style="background: #c4436e; color: white;">
                                    <h3 class="card-text text-white">Now Serving!</h3>
                                </div>
                                <div class="card-body" style="background: #a8395e; color: white">
                                    <div style="font-size:35px; font-weight:bolder;" class="ticket-number pb-2 m-0" id="guidance-ticket">---</div>
                                    <h5 class="text-white">Guidance Office</h5> 
                                    <div id="ticket-purpose-container4"></div>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div>
            </div><br>
        </div>
    </div>
    <script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('../js/jquery.min.js') }}"></script>
    <script src="{{ asset('../js/sweetalert2.min.js') }}"></script>

<!-- Hidden iframe for printing -->
{{-- <iframe id="print-iframe" style="display:none;"></iframe> --}}

<script>
    document.getElementById('visitor-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
    
        // Fetch form values
        var name = document.getElementById('name').value;
        var contact = document.getElementById('contact').value;
        var department = document.getElementById('department').value;
        var purpose = document.getElementById('additional_option').value;
    
        // Validation checks
        var errors = [];
        if (!name) errors.push("Name is required.");
        if (!contact) errors.push("Contact is required.");
        if (!department) errors.push("Department is required.");
    
        if (errors.length > 0) {
            alert(errors.join("\n"));
            return; // Exit if there are validation errors
        }
    
        // Confirm submission with Swal
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to submit this form?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed to submit the form data
                var formData = new FormData(this);
    
                fetch('{{ route("visitor.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Check if ticket_number is present in response
                        var ticketNumber = data.ticket_number;
                        if (!ticketNumber) {
                            console.error('Ticket number is missing in the response:', data);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Ticket number could not be retrieved. Please try again later.',
                                icon: 'error',
                                confirmButtonColor: '#d33'
                            });
                            return;
                        }
    
                        var currentDate = new Date().toLocaleString('en-US', {
                            year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit'
                        });
    
                        // Conditional background and text color based on department selection
                        var backgroundColor = '';
                        var color = ''; // Default text color
                        if (department === 'Guidance') {
                            backgroundColor = '#a8395e'; // Guidance color
                            color = '#fff'; // White text for Guidance
                        } else if (department === 'Records') {
                            backgroundColor = '#d68725'; // Records color
                            color = '#fff'; // White text for Records
                        } else if (department === 'Accounting') {
                            backgroundColor = '#d49932'; // Records color
                            color = '#fff'; // White text for Records
                        } else if (department === 'Admin') {
                            backgroundColor = '#1eaaaf'; // Records color
                            color = '#fff'; // White text for Records
                        } else if (department === 'Clinic') {
                            backgroundColor = '#7c49a7'; // Records color
                            color = '#fff'; // White text for Records
                        }
    
                        // Ticket content to be displayed
                        var ticketContent = `
                            <div style="font-family: 'Courier New', monospace; text-align: center; width: 100%; padding: 10px; background-color: ${backgroundColor}; color: ${color};">
                                <h2 style="font-size: 16px; margin: 0; text-transform: uppercase;">Queueing Ticket</h2>
                                <p style="font-size: 12px; margin: 5px 0;">${currentDate}</p>
                                <hr style="border: 1px dashed #000; margin: 20px;">
                                <p style="margin: 5px 0;"><strong>Name:</strong> ${name}</p>
                                <p style="margin: 5px 0;"><strong>Department:</strong> ${department}</p>
                                <p style="margin: 5px 0; font-size: 18px;"><strong>Ticket #</strong><br><span style="font-size: 46px">${ticketNumber}</span></p>
                                <hr style="border: 1px dashed #000; margin: 20px;">
                                <p style="font-size: 12px; margin: 10px 0;">Thank you for visiting!</p>
                            </div>
                        `;
    
                        // Show success message with ticket content
                        Swal.fire({
                            title: 'Success!',
                            html: ticketContent,
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            // Refresh the page after success message
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'There was an issue with submission.',
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Submission Failed',
                        text: 'Please try again later.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                });
            }
        });
    });
</script>
    
    

    

    <script>
        document.getElementById('department').addEventListener('change', function() {
            var department = this.value;
            var additionalOptions = document.getElementById('additionalOptions');
            var additionalOptionss = document.getElementById('additionalOptionss');
            var additionalOptionSelect = document.getElementById('additional_option');

            additionalOptionss.style.display = 'none'; // Hide custom input initially

            if (department === 'Records') {
                additionalOptionSelect.innerHTML = `
                    <option value="">Select additional option</option>
                    <option value="Certification">Certification</option>
                    <option value="Transmittal">Transmittal</option>
                    <option value="Form 137">Form 137 (F137)</option>
                    <option value="Certificate of Graduation">Certificate of Graduation (CG)</option>
                    <option value="Certificate of Good Moral">Certificate of Good Moral (CGM)</option>
                    <option value="Certified True Copy">Certified True Copy (CTC)</option>
                    <option value="Certificate of Enrollment">Certificate of Enrollment (CE)</option>
                    <option value="Certification, Authentication, and Verification">Certification, Authentication, and Verification (CAV)</option>
                    <option value="Other">Other</option>
                `;
                additionalOptions.style.display = 'block';
            } else if (department === 'Accounting') {
                // Change options for Library
                additionalOptionSelect.innerHTML = `
                    <option value="">Select additional option</option>
                    <option value="Loan">Loan</option>
                    <option value="Paycheck">Paycheck</option>
                    <option value="Other">Other</option>
                `;
                additionalOptions.style.display = 'block';
            } else if (department === 'Clinic') {
                // Change options for Library
                additionalOptionSelect.innerHTML = `
                    <option value="">Select additional option</option>
                    <option value="Visit">Visit</option>
                    <option value="Emergency">Emergency</option>
                    <option value="Health Concerns">Health Concerns</option>
                    <option value="Injury">Injury</option>
                    <option value="Other">Other</option>
                `;
                additionalOptions.style.display = 'block';
            } else if (department === 'Guidance') {
                // Change options for Library
                additionalOptionSelect.innerHTML = `
                    <option value="">Select additional option</option>
                    <option value="Visit">Visit</option>
                    <option value="Other">Other</option>
                `;
                additionalOptions.style.display = 'block';
            } else if (department === 'Admin') {
                // Change options for Library
                additionalOptionSelect.innerHTML = `
                    <option value="">Select additional option</option>
                    <option value="Submit A Letter">Submit A Letter</option>
                    <option value="Inquiries">Inquiries</option>
                    <option value="Other">Other</option>
                `;
                additionalOptions.style.display = 'block';
            } else {
                additionalOptions.style.display = 'none';
                additionalOptionss.style.display = 'none';
            }
        });

        document.getElementById('additional_option').addEventListener('change', function() {
            var additionalOptionss = document.getElementById('additionalOptionss');
            if (this.value === 'Other') {
                additionalOptionss.style.display = 'block';
                document.getElementById('purpose_other').setAttribute('required', 'required'); // Make "Specify" field required
            } else {
                additionalOptionss.style.display = 'none';
                document.getElementById('purpose_other').removeAttribute('required');
            }
        });

        function handlePurposeField() {
            var selectedPurpose = document.getElementById('additional_option').value;
            var otherPurpose = document.getElementById('purpose_other').value;
            var finalPurpose = document.getElementById('final_purpose');

            if (selectedPurpose === 'Other' && otherPurpose.trim() !== '') {
                finalPurpose.value = otherPurpose; // Set with custom input if "Other" is selected
            } else {
                finalPurpose.value = selectedPurpose; // Set with selected dropdown value
            }

            // Debugging check
            console.log("Final purpose value:", finalPurpose.value);
        }
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

{{-- QUEUE PREVIEW --}}


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
                        return item.status !== 'completed' && item.status !== 'canceled';
                    });
                    
                    var waitingTickets = data.filter(function(item) {
                        return item.status === 'waiting';
                    });

                    // Group tickets by department
                    var departmentCounts = {};
                    waitingTickets.forEach(function(ticket) {
                        if (!departmentCounts[ticket.department]) {
                            departmentCounts[ticket.department] = 0;
                        }
                        departmentCounts[ticket.department]++;
                    });

                    // Update counts for each department in the HTML
                    Object.keys(departmentCounts).forEach(function(department) {
                        var countElement = $(`#${department.toLowerCase()}-count`);
                        if (countElement.length) {
                            countElement.text(departmentCounts[department]);
                        }
                    });

                    // Reset counts for departments with no waiting tickets
                    var allDepartments = ["Records", "Accounting", "Clinic", "Admin", "Guidance"];
                    allDepartments.forEach(function(department) {
                        if (!departmentCounts[department]) {
                            $(`#${department.toLowerCase()}-count`).text('0');
                        }
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
                        'Clinic': '#principal-ticket',
                        'Admin': '#admin-ticket',
                        'Guidance': '#guidance-ticket'
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

                    // Additional functionality to update Records Office ticket purpose
                    if (departmentTickets['Records'] && departmentTickets['Records'].length > 0) {
                    var firstTicket = departmentTickets['Records'][0];
                    var purposeHtml = `<p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>`;
                    $('#ticket-purpose-container5').html(purposeHtml);
                } else {
                    $('#records-ticket').text('---');
                    $('#ticket-purpose-container5').html('<p class="mb-0">No active transactions in progress.</p>');
                }   

                    // The rest of your existing code for updating queue lists remains unchanged...
                    // Update the queue list display with the second ticket per department
                    var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                    var displayedTickets = new Set();
                    var hasTickets = false; // Flag to track if any ticket is displayed

                    for (var i = 1; i < filteredData.length; i++) { // Start from index 1 (the second ticket)
                        var visitor = filteredData[i];
                        if (visitor.department === "Records") {
                            var tickets = departmentTickets[visitor.department];
                            
                            // Display only if more than one ticket is available
                            if (tickets && tickets.length > 1) {
                                tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                    if (!displayedTickets.has(ticket.ticket_number)) {
                                        hasTickets = true; // Set flag to true if at least one ticket is displayed
                                        html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                        html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                        html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                        html += '</div>';
                                        displayedTickets.add(ticket.ticket_number);
                                    }
                                });
                            }
                        }
                    }

                    // If no tickets were added, show "No queueing list" message
                    if (!hasTickets) {
                        html += `
                            <div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">
                                <div class="card-body p-0">
                                    <p class="card-text text-muted">Currently, there are no visitors in the queue.</p>
                                </div>
                            </div>`;
                    }

                    html += '</div>';
                    $('#data-container').html(html);

                    // Admin List
                    if (departmentTickets['Admin'] && departmentTickets['Admin'].length > 0) {
                        var firstTicket = departmentTickets['Admin'][0];

                        // Update the purpose container with the first ticket's purpose
                        var purposeHtml = `
                            <p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>
                        `;
                        $('#ticket-purpose-container1').html(purposeHtml);
                    } else {
                        // Reset display if there are no tickets
                        $('#admin-ticket').text('---');
                        $('#ticket-purpose-container1').html('<p class="mb-0">No active transactions in progress.</p>');
                    }

                    var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                    var displayedTickets = new Set();
                    var hasTickets = false; // Flag to track if any ticket is displayed

                    // Start loop from index 1 to skip the first ticket
                    for (var i = 1; i < filteredData.length; i++) {
                        var visitor = filteredData[i];
                        if (visitor.department === "Admin") {
                            var tickets = departmentTickets[visitor.department];

                            // Display only if more than one ticket is available
                            if (tickets && tickets.length > 1) {
                                tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                    if (!displayedTickets.has(ticket.ticket_number)) {
                                        hasTickets = true; // Set flag to true if at least one ticket is displayed
                                        html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                        html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                        html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                        html += '</div>';
                                        displayedTickets.add(ticket.ticket_number);
                                    }
                                });
                            }
                        }
                    }

                    // If no tickets were added, show "No queueing list" message
                    if (!hasTickets) {
                        html += 
                            '<div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">' +
                                '<div class="card-body p-0">' +
                                    '<p class="card-text text-muted">Currently, there are no visitors in the queue.</p>' +
                                '</div>' +
                            '</div>';
                    }

                    html += '</div>';
                    $('#data-container1').html(html);

                    // Accounting List
                    if (departmentTickets['Accounting'] && departmentTickets['Accounting'].length > 0) {
                        var firstTicket = departmentTickets['Accounting'][0];

                        // Update the purpose container with the first ticket's purpose
                        var purposeHtml = `
                            <p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>
                        `;
                        $('#ticket-purpose-container2').html(purposeHtml);
                    } else {
                        // Reset display if there are no tickets
                        $('#accounting-ticket').text('---');
                        $('#ticket-purpose-container2').html('<p class="mb-0">No active transactions in progress.</p>');
                    }


                    var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                    var displayedTickets = new Set();
                    var hasTickets = false; // Flag to track if any ticket is displayed

                    for (var i = 1; i < filteredData.length; i++) { // Start from index 1 (the second ticket)
                        var visitor = filteredData[i];
                        if (visitor.department === "Accounting") {
                            var tickets = departmentTickets[visitor.department];

                            // Display only if more than one ticket is available
                            if (tickets && tickets.length > 1) {
                                tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                    if (!displayedTickets.has(ticket.ticket_number)) {
                                        hasTickets = true; // Set flag to true if at least one ticket is displayed
                                        html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                        html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                        html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                        html += '</div>';
                                        displayedTickets.add(ticket.ticket_number);
                                    }
                                });
                            }
                        }
                    }

                    // If no tickets were added, show "No queueing list" message
                    if (!hasTickets) {
                        html += 
                            '<div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">' +
                                '<div class="card-body p-0">' +
                                    '<p class="card-text text-muted">Currently, there are no visitors in the queue.</p>' +
                                '</div>' +
                            '</div>';
                    }

                    html += '</div>';
                    $('#data-container2').html(html);

                    // Clinic List
                    if (departmentTickets['Clinic'] && departmentTickets['Clinic'].length > 0) {
                        var firstTicket = departmentTickets['Clinic'][0];

                        // Update the purpose container with the first ticket's purpose
                        var purposeHtml = `
                            <p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>
                        `;
                        $('#ticket-purpose-container3').html(purposeHtml);
                    } else {
                        // Reset display if there are no tickets
                        $('#principal-ticket').text('---');
                        $('#ticket-purpose-container3').html('<p class="mb-0">No active transactions in progress.</p>');
                    }

                    var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                    var displayedTickets = new Set();
                    var hasTickets = false; // Flag to track if any ticket is displayed

                    for (var i = 1; i < filteredData.length; i++) { // Start from index 1 (the second ticket)
                        var visitor = filteredData[i];
                        if (visitor.department === "Clinic") {
                            var tickets = departmentTickets[visitor.department];

                            // Display only if more than one ticket is available
                            if (tickets && tickets.length > 1) {
                                tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                    if (!displayedTickets.has(ticket.ticket_number)) {
                                        hasTickets = true; // Set flag to true if at least one ticket is displayed
                                        html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                        html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                        html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                        html += '</div>';
                                        displayedTickets.add(ticket.ticket_number);
                                    }
                                });
                            }
                        }
                    }

                    // If no tickets were added, show "No queueing list" message
                    if (!hasTickets) {
                        html += 
                            '<div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">' +
                                '<div class="card-body p-0">' +
                                    '<p class="card-text text-muted">Currently, there are no visitors in the queue.</p>' +
                                '</div>' +
                            '</div>';
                    }

                    html += '</div>';
                    $('#data-container3').html(html);

                    // Guidance List
                    if (departmentTickets['Guidance'] && departmentTickets['Guidance'].length > 0) {
                        var firstTicket = departmentTickets['Guidance'][0];

                        // Update the purpose container with the first ticket's purpose
                        var purposeHtml = `
                            <p class="mb-0"><strong>Purpose:</strong> ${firstTicket.purpose}</p>
                        `;
                        $('#ticket-purpose-container4').html(purposeHtml);
                    } else {
                        // Reset display if there are no tickets
                        $('#guidance-ticket').text('---');
                        $('#ticket-purpose-container4').html('<p class="mb-0">No active transactions in progress.</p>');
                    }

                    var html = '<div class="w-65 pl-2 pr-2 pb-3">';
                    var displayedTickets = new Set();
                    var hasTickets = false; // Flag to track if any ticket is displayed

                    for (var i = 1; i < filteredData.length; i++) { // Start from index 1 (the second ticket)
                        var visitor = filteredData[i];
                        if (visitor.department === "Guidance") {
                            var tickets = departmentTickets[visitor.department];

                            // Display only if more than one ticket is available
                            if (tickets && tickets.length > 1) {
                                tickets.slice(1).forEach(function(ticket) { // Skip the first ticket
                                    if (!displayedTickets.has(ticket.ticket_number)) {
                                        hasTickets = true; // Set flag to true if at least one ticket is displayed
                                        html += '<div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">';
                                        html += '<p class="mb-0" style="font-size:20px;font-weight:bolder;"><strong>' + ticket.ticket_number + '</strong></p>';
                                        html += '<p class="mb-0"><strong>Purpose:</strong> ' + ticket.purpose + '</p>';
                                        html += '</div>';
                                        displayedTickets.add(ticket.ticket_number);
                                    }
                                });
                            }
                        }
                    }

                    // If no tickets were added, show "No queueing list" message
                    if (!hasTickets) {
                        html += 
                            '<div class="card mb-3 p-3 shadow-sm border-secondary text-left" style="border-radius: 8px;">' +
                                '<div class="card-body p-0">' +
                                    '<p class="card-text text-muted">Currently, there are no visitors in the queue.</p>' +
                                '</div>' +
                            '</div>';
                    }

                    html += '</div>';
                    $('#data-container4').html(html);
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