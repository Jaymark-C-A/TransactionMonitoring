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
            @include('includes.sidebar.sidebar-guard')  
        </aside>
        <div class="content-wrapper bg-light">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <p class="m-0 text-xl">Dashboard</p>
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
            <div class="container flex flex-col md:flex-row justify-between w-2/4">
                <div class="bg-white shadow-md rounded-lg px-4 py-4 mb-4 md:w-1/2" style="border:1px solid rgb(6, 193, 255);">
                    <h2 class="text-xl mb-4 text-center">Visitor Form</h2>
                    <form id="visitor-form" action="{{ route('visitors.store') }}" method="POST" class="flex flex-col">                        @csrf
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="number" id="contact" name="contact" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label for="department" class="form-label">Department</label>
                            <select name="department" id="department" class="form-select form-control" required>
                                <option value="">Select department</option>
                                <option {{ old('department') == '0' ? 'selected' : '' }} value="Principal">Principal</option>
                                <option {{ old('department') == '1' ? 'selected' : '' }} value="Department_Head">Department Head</option>
                                <option {{ old('department') == '2' ? 'selected' : '' }} value="Accounting">Accounting</option>
                                <option {{ old('department') == '3' ? 'selected' : '' }} value="Records">Records</option>
                                <option {{ old('department') == '4' ? 'selected' : '' }} value="Admin">Admin</option>
                                <option {{ old('department') == '5' ? 'selected' : '' }} value="others">others</option>
                            </select>                        
                        </div>

                        <div id="additionalOptions" style="display: none;" class="mb-4">
                            <label for="purpose" class="form-label">Purpose</label>
                            <select name="purpose" id="additional_option" class="form-select form-control">
                            </select> 
                        </div>

                        {{-- <div id="additionalOption" class="mb-4">
                            <label for="reason_textarea" class="form-label">Other Reason</label>
                            <textarea name="reason_textarea" id="additional_textarea" rows="2" class="form-control"></textarea>
                        </div> --}}

                        <button type="submit" class="btn self-center" style="background: rgb(6, 193, 255);">
                            Submit
                        </button>
                    </form>
                </div>
            </div><br>
            
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            @include('includes.footer')
        </footer>
    </div>
    <!-- ./wrapper -->

<!-- jQuery (local) -->
<script src="{{ asset('../js/jquery.min.js') }}"></script>

<script>
    // After submitting the form, open print dialog
    document.getElementById('visitor-form').addEventListener('submit', function() {
        var formData = new FormData(this);
            var ticketNumber = '{{ session('ticketNumber') }}';
            var visitorData = {
                name: formData.get('name'),
                department: formData.get('department'),
                ticket_number: ticketNumber
            };

        var ticketContent = `
            <div style="text-align: center; font-family: Arial, sans-serif;">
                <h3>Queuing Ticket</h3>
                <p><strong>Name:</strong> ${visitorData.name}</p>
                <p><strong>Department:</strong> ${visitorData.department}</p>
                <p><strong>Ticket Number:</strong> ${visitorData.ticket_number}</p>
            </div>
        `;

        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
                <title>Queuing Ticket</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .ticket {
                        width: 200px;
                        margin: 0 auto;
                        padding: 20px;
                        border: 2px solid #000;
                        border-radius: 10px;
                    }
                    .ticket h3 {
                        margin-top: 0;
                    }
                    .ticket p {
                        margin-bottom: 5px;
                    }
                </style>
            </head>
            <body onload="window.print();">
                <div class="ticket">
                    ${ticketContent}
                </div>
            </body>
            </html>
        `);
        printWindow.document.close();
    });
</script>





        <script>
            document.getElementById('department').addEventListener('change', function() {
                var department = this.value;
                var additionalOptions = document.getElementById('additionalOptions');
                var additionalOptionSelect = document.getElementById('additional_option');
                
                if (department === 'Records') {
                    // Change options for Registrar
                    additionalOptionSelect.innerHTML = `
                        <option value="">Select additional option</option>
                        <option value="Certification">Certification</option>
                        <option value="Transmittal">Transmittal</option>
                        <option value="F137">F137</option>
                        <option value="CG">CG</option>
                        <option value="CGM">CGM </option>
                        <option value="CTC">CTC</option>
                        <option value="CE">CE</option>
                        <option value="CAV">CAV</option>
                    `;
                    additionalOptions.style.display = 'block';
                } else if (department === 'Accounting') {
                    // Change options for Library
                    additionalOptionSelect.innerHTML = `
                        <option value="">Select additional option</option>
                        <option value="Loan">Loan</option>
                        <option value="Paycheck">Paycheck</option>
                    `;
                    additionalOptions.style.display = 'block';
                } else if (department === 'Principal') {
                    // Change options for Library
                    additionalOptionSelect.innerHTML = `
                        <option value="">Select additional option</option>
                        <option value="Visit">Visit</option>
                    `;
                    additionalOptions.style.display = 'block';
                } else if (department === 'Department_Head') {
                    // Change options for Library
                    additionalOptionSelect.innerHTML = `
                        <option value="">Select additional option</option>
                        <option value="Visit">Visit</option>
                    `;
                    additionalOptions.style.display = 'block';
                } else if (department === 'Admin') {
                    // Change options for Library
                    additionalOptionSelect.innerHTML = `
                        <option value="">Select additional option</option>
                        <option value="Inquiries">Inquiries</option>
                    `;
                    additionalOptions.style.display = 'block';
                } else {
                    additionalOptions.style.display = 'none';
                }
            });
        </script>

{{-- <script>
    document.getElementById('department').addEventListener('change', function() {
        var department = this.value;
        var additionalOption = document.getElementById('additionalOption');
        
        if (department === 'others') {
            // Change options for Registrar
            additionalOption.style.display = 'block';
        } else {

            additionalOption.style.display = 'none';

            }
        }); --}}
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