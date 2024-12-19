<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Satisfaction Survey Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* CSS to create a page break when printing */
        .page-break {
            page-break-before: always;
        }

        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            font-size: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
            }

            /* Hide the button when printing */
            @media print {
            .print-button {
                display: none;
            }
        }
    </style>

</head>
<body>

{{-- Records --}}
<div class="container-fluid p-0 m-0">

    <!-- Header Section -->
    <header class="text-center text-md pb-1 mb-1" style="line-height: 20px">
        <img src="{{ asset('img/printLogo.png') }}" alt="logo" style="width: 100px; height: auto;">
        <p class="lead mb-0 pb-0 pt-2" style="font-family: Old English Text MT">Republic of the Philippines</p>
        <h2 class="text-black py-0 my-0" style="font-family: Old English Text MT">Department of Education</h2>
        <p class="py-0 my-0" style="font-family: Trajan Pro; font-weight: 800; font-size: 18px">Region III</p>
        <p class="py-0 my-0" style="font-size: 20px; font-family: Trajan Pro;"><strong>SCHOOLS DIVISION OFFICE OF OLONGAPO CITY</strong></p>
        <strong style="font-size: 20px; font-family: Trajan Pro;">OLONGAPO CITY NATIONAL HIGH SCHOOL</strong>
        <hr class="my-3 w-75">
    </header>

    <!-- Floatable Print Button -->
    <button class="btn btn-primary print-button" onclick="window.print()">
        <i class="bi bi-printer"></i>
    </button>
      

    <!-- School and Date Information -->
    <div class="mb-2 px-4">
        <!-- First Page Header Section -->
        <p class="text-center font-weight-bold py-0 my-0">ANTI-RED TAPE ACT COMMITTEE</p>
        <p class="text-center">Client Satisfaction Survey Report</p>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>School:</strong> Olongapo City National High School</p>
                    <p><strong>Date Covered:</strong> <span id="dateRanges0">N/A</span></p>
                    <p><strong>Division:</strong> SDO Olongapo City</p>
                </div>                
                <div class="col-md-4">
                    <p><strong>Office Visited:</strong> EMIS/RECORDS UNIT</p>
                    <p><strong>School Year:</strong> 
                        <?php
                        $currentYear = date('Y');
                        $nextYear = $currentYear + 1;
                        echo "{$currentYear}-{$nextYear}";
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php
    use App\Models\SurveyResponse;

    // Fetch survey responses from the database
    $responses = SurveyResponse::where('Office', 'Emis/Records')->get(); // Adjust as needed
    $totalResponses = $responses->count(); // Initialize $totalResponses here


    // Define criteria with initial values
    $criteria = [
        "1. I am satisfied with the service that I availed." => [0, 0, 0, 0, 0],
        "2. I spent a reasonable amount of time for my transaction." => [0, 0, 0, 0, 0],
        "3. The office followed the transaction's requirements and steps based on the information provided." => [0, 0, 0, 0, 0],
        "4. The steps (including payment) I needed to do for my transaction were easy and simple." => [0, 0, 0, 0, 0],
        "5. I easily found information about my transaction from the office or its website." => [0, 0, 0, 0, 0],
        "6. I feel the office was fair to everyone or during the transaction." => [0, 0, 0, 0, 0],
        "7. I was treated courteously by the staff and (if asked for help) the staff was helpful." => [0, 0, 0, 0, 0],
        "8. I got what I needed from the government office, or (if denied) denial of request was sufficiently explained to me." => [0, 0, 0, 0, 0],
    ];

    // Define the mapping of responses
    $responseMapping = [
        "Strongly Disagree" => 1,
        "Disagree" => 2,
        "Neither" => 3,
        "Agree" => 4,
        "Strongly Agree" => 5,
    ];

    // Process the responses to count ratings
    if ($responses->isNotEmpty()) {
        foreach ($responses as $response) {
            for ($i = 0; $i < 8; $i++) {
                $rating = $response['SQD_' . $i];

                // Check if the rating is in the mapping
                if (isset($responseMapping[$rating])) {
                    $numericRating = $responseMapping[$rating];
                    // Increment the count for the corresponding rating
                    $criteria[array_keys($criteria)[$i]][$numericRating - 1]++;
                } else {
                    // Log or handle invalid ratings
                    \Log::info("Invalid rating for question " . ($i + 1) . ": $rating");
                }
            }
        }
    }

    // Calculate the total "Strongly Agree" responses across all criteria
    $totalStronglyAgree = 0;
    foreach ($criteria as $ratings) {
        $totalStronglyAgree += $ratings[4]; // Index 4 is "Strongly Agree"
    }

    // Calculate the overall satisfaction percentage
    $maxStronglyAgreeResponses = $totalResponses * count($criteria); // Maximum possible "Strongly Agree" responses
    $overallSatisfactionPercentage = $maxStronglyAgreeResponses > 0 
        ? round(($totalStronglyAgree / $maxStronglyAgreeResponses) * 100, 2) 
        : 0;
        
    ?>
    <!-- Satisfaction Survey Table -->
<!-- Satisfaction Survey Table -->
<table class="table table-bordered text-center mx-auto" style="width: 93%">
    <thead class="bg-warning">
        <tr>
            <th rowspan="2">Criteria</th>
            <th colspan="5">Ratings</th>
            <th rowspan="2">TOTAL</th>
        </tr>
        <tr>
            <th>Lubhang hindi nasiyahan</th>
            <th>Hindi nasiyahan</th>
            <th>Neutral</th>
            <th>Nasiyahan</th>
            <th>Lubhang nasiyahan</th>
        </tr>
    </thead>
    <tbody>
        @if($responses->isNotEmpty())
            @foreach($criteria as $question => $ratings)
            <tr data-date="{{ \Carbon\Carbon::parse($response->created_at)->format('Y-m-d') }}">
                <td class="text-left">{{ $question }}</td>
                @foreach($ratings as $rating)
                    <td>{{ $rating }}</td>
                @endforeach
                <td>{{ array_sum($ratings) }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">No feedback to display</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<hr class="mt-2 w-75">
<footer>
    <div class="container-fluid mb-4 px-5">
        <div class="row">
            <div class="col-md-9">
                <img src="{{ asset('img/footer.png') }}" alt="logo" style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</footer>

<div class="page-break"></div>

{{-- records analysis --}}
<div class="container-fluid p-0 m-0">

    <!-- Header Section -->
    <header class="text-center text-md pb-1 mb-1" style="line-height: 20px">
        <img src="{{ asset('img/printLogo.png') }}" alt="logo" style="width: 100px; height: auto;">
        <p class="lead mb-0 pb-0 pt-2" style="font-family: Old English Text MT">Republic of the Philippines</p>
        <h2 class="text-black py-0 my-0" style="font-family: Old English Text MT">Department of Education</h2>
        <p class="py-0 my-0" style="font-family: Trajan Pro; font-weight: 800; font-size: 18px">Region III</p>
        <p class="py-0 my-0" style="font-size: 20px; font-family: Trajan Pro;"><strong>SCHOOLS DIVISION OFFICE OF OLONGAPO CITY</strong></p>
        <strong style="font-size: 20px; font-family: Trajan Pro;">OLONGAPO CITY NATIONAL HIGH SCHOOL</strong>
        <hr class="my-3 w-75">
    </header>

    <!-- School and Date Information -->
    <div class="mb-2 px-4">

        <div class="container-fluid py-5">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-8">
                    <h1>Analysis:</h1>
                    <?php if ($totalResponses > 0): ?>
                        <p>The client satisfaction survey form was conducted on <span id="dateRanges1">N/A</span>, and there are <?= $totalResponses ?> respondents in total.</p>
                        <p>Based on the submitted survey form, <?= $overallSatisfactionPercentage ?>% of respondents were “Strongly Agree” across all criteria:
                            criteria no. 1 (Service Satisfaction), criteria no. 2 (Waiting Time Satisfaction), criteria no. 3 (Procedure Accuracy), criteria no. 4 (Ease of Process), criteria no. 5 (Clarity of Information), criteria no. 6 (Impartiality), criteria no. 7 (Customer Service Quality) and criteria no. 8 (Outcome Satisfaction).</p>
                    <?php else: ?>
                        <p>No survey data available for analysis.</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        
        <div class="container-fluid py-5" style="margin-bottom: 10%">
            <div class="row">
                <!-- Add extra spacing if needed -->
                <div class="col-md-1"></div>
        
                <!-- Prepared by Section -->
                <div class="col-md-3">
                    <p>Prepared by:</p>
                    <h5>{{ $preparedBy ? $preparedBy->name : 'N/A' }}</h5>
                    <p>{{ $preparedBy ? $preparedBy->position : 'N/A' }}</p>
                </div>
        
                <!-- Reviewed by Section -->
                <div class="col-md-4">
                    <p>Reviewed by:</p>
                    <h5>{{ $reviewedBy ? $reviewedBy->name : 'N/A' }}</h5>
                    <p>{{ $reviewedBy ? $reviewedBy->position : 'N/A' }}</p>
                </div>
        
                <!-- Noted by Section -->
                <div class="col-md-3">
                    <p>Noted by:</p>
                    <h5>{{ $notedBy ? $notedBy->name : 'N/A' }}</h5>
                    <p>{{ $notedBy ? $notedBy->position : 'N/A' }}</p>
                </div>
        
                <!-- Add extra spacing if needed -->
                <div class="col-md-1"></div>
            </div>
        </div>
        
    </div>

<hr class="mt-2 w-75">
<footer>
    <div class="container-fluid mb-4 px-5">
        <div class="row">
            <div class="col-md-9">
                <img src="{{ asset('img/footer.png') }}" alt="logo" style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</footer>


<!-- Modal for Date Range Selection -->
<!-- Date Range Modal -->
<div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="dateRangeModalLabel">Select Date Range</h5>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="startDate">Start Date</label>
            <input type="date" class="form-control" id="startDate">
          </div>
          <div class="form-group">
            <label for="endDate">End Date</label>
            <input type="date" class="form-control" id="endDate">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="applyDateRange">Apply</button>
        </div>
      </div>
    </div>
  </div>
  
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



<script>
    $(document).ready(function() {

        $('#dateRangeModal').modal({
            backdrop: 'static',  // Prevent closing by clicking outside
            keyboard: false      // Prevent closing with escape key
        });
    
        // Open the modal explicitly if it's not opening
        $('#dateRangeModal').modal('show');

        // Apply the date range filter and display the selected range
        $('#applyDateRange').on('click', function() {
            const startDateValue = $('#startDate').val();
            const endDateValue = $('#endDate').val();

            // Check if both dates are provided
            if (!startDateValue || !endDateValue) {
                alert('Please select both start and end dates.');
                return; // Exit if dates are not provided
            }

            // Create date objects
            const startDate = new Date(startDateValue);
            const endDate = new Date(endDateValue);

            // Extract month, day, and year for display
            const month = startDate.toLocaleString('default', { month: 'long' });
            const startDay = startDate.getDate().toString().padStart(2, '0');
            const endDay = endDate.getDate().toString().padStart(2, '0');
            const year = startDate.getFullYear();

            // Display the formatted date range in the new format
            const dateRange = `${month} ${startDay} to ${month} ${endDay}, ${year}`;
            for (let i = 0; i <= 10; i++) {
                $(`#dateRange${i}`).text(dateRange);
                $(`#dateRanges${i}`).text(dateRange);
            }

            // Filter the table based on selected date range
            var rows = document.querySelectorAll('table tbody tr');

            rows.forEach(function(row) {
                var rowDate = new Date(row.dataset.date); // Ensure each row has a 'data-date' attribute
                if (rowDate >= startDate && rowDate <= endDate) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });

            // Close the modal after applying the date range
            $('#dateRangeModal').modal('hide');
        });
    });
</script>




</body>
</html>
