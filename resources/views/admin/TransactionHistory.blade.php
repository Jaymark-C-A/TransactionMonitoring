<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .smoky-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
        }
        .transaction-table th, .transaction-table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/dataTable.css') }}">
</head>
<body class="text-sm" style="background-color: #cecece">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light" style="background-color: #084262;">
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
                        <h4 class="m-0">Transaction History</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="dashboard" class="breadcrumb-item active">Dashboard</a>
                            <li class="breadcrumb-item"><a href="TransactionHistory">Transaction History</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="container-fluid">
                <!-- Recent Transactions Section -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card smoky-shadow">
                            <div class="card-header text-white" style="background-color: #1a6b49">
                                <h5 class="card-title mb-0">Recent Transactions</h5>
                            </div>
                            <div class="card-body">
                                @if($recentTransactions->isNotEmpty())
                                    @foreach($recentTransactions as $transaction)
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h5 class="card-title text-lg text-bold">{{ $transaction->name }}</h5>
                                                <p class="card-text">{{ $transaction->created_at }}</p>
                                            </div>
                                            <div>
                                                <a href="#" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" 
                                                    data-target="#transactionModal"
                                                    data-name="{{ $transaction->name }}"
                                                    data-contact="{{ $transaction->contact }}"
                                                    data-purpose="{{ $transaction->purpose }}"
                                                    data-ticket-number="{{ $transaction->ticket_number }}"
                                                    data-status="{{ $transaction->status }}"
                                                    data-date="{{ $transaction->created_at->format('m/d/Y h:i A') }}"
                                                >
                                                    <i class="fa fa-search"></i>
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @else
                                    <p class="text-muted">No recent transactions available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Transaction History Table -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card smoky-shadow">
                            <div class="card-header text-white" style="background-color: #4b5c1c">
                                <h5 class="card-title mb-0">Admin Department Transactions</h5>
                            </div>
                            <div class="card-body">
                                <table id="transactionTable" class="table table-bordered table-striped transaction-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Purpose</th>
                                            <th class="text-center">Ticket Number</th>
                                            <th class="text-center">Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($adminVisitors as $visitor)
                                            <tr>
                                                <td>{{ $visitor->name }}</td>
                                                <td>{{ $visitor->contact }}</td>
                                                <td>{{ $visitor->purpose }}</td>
                                                <td>{{ $visitor->ticket_number }}</td>
                                                <td>{{ $visitor->created_at->format('m/d/Y h:i A') }}</td>
                                                <td>
                                                    <a href="#" 
                                                        class="btn btn-sm btn-primary" 
                                                        data-toggle="modal" 
                                                        data-target="#transactionModal"
                                                        data-name="{{ $visitor->name }}"
                                                        data-contact="{{ $visitor->contact }}"
                                                        data-purpose="{{ $visitor->purpose }}"
                                                        data-ticket-number="{{ $visitor->ticket_number }}"
                                                        data-status="{{ $visitor->status }}"
                                                        data-date="{{ $visitor->created_at->format('m/d/Y h:i A') }}"
                                                    >
                                                        <i class="fa fa-search"></i>
                                                        View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Transaction Details Modal -->
                        <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content smoky-shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="transactionModalLabel">Transaction Details</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h1 id="modalName"></h1>
                                        <p class="py-2" style="font-size: 36px"># <span id="modalTicketNumber"></span></p>
                                        <p class="text-lg"><strong>Contact:</strong> <span id="modalContact"></span></p>
                                        <p class="text-lg"><strong>Purpose:</strong> <span id="modalPurpose"></span></p>
                                        <p class="text-lg"><strong>Status:</strong> <span id="modalStatus"></span></p>
                                        <p class="text-lg"><strong>Date:</strong> <span id="modalDate"></span></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->

<script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('../js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('../js/dataTable.js') }}"></script>

<script>
    // Handle dynamic data in the modal
    $('#transactionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        
        // Extract data attributes
        var ticketNumber = button.data('ticket-number');
        var name = button.data('name');
        var contact = button.data('contact');
        var purpose = button.data('purpose');
        var status = button.data('status');
        var date = button.data('date');

        // Update modal fields
        var modal = $(this);
        modal.find('#modalTicketNumber').text(ticketNumber);
        modal.find('#modalName').text(name);
        modal.find('#modalContact').text(contact);
        modal.find('#modalPurpose').text(purpose);
        modal.find('#modalStatus').text(status);
        modal.find('#modalDate').text(date);
    });

    // Initialize DataTable
    $(document).ready(function () {
        $('#transactionTable').DataTable();
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
