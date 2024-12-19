<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; /* Light background for better contrast */
        }
        .card {
            border: 1px solid #007bff; /* Bootstrap primary color */
            border-radius: 0.5rem;
        }
        .card-header {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            font-size: 1.25rem;
            text-align: center;
            padding: 1rem;
        }
        .card-body {
            padding: 1.5rem;
        }

            /* Professional Button Styles */
    .form-navigation button {
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    /* Next Button - Muted Professional Blue */
    #nextBtn {
        background-color: #007bff; /* Bootstrap primary blue */
    }

    #nextBtn:hover {
        background-color: #0056b3; /* Darker blue on hover */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow on hover */
    }

    /* Back Button - Subtle Gray */
    #prevBtn {
        background-color: #6c757d; /* Bootstrap secondary gray */
    }

    #prevBtn:hover {
        background-color: #5a6268; /* Darker gray on hover */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow on hover */
    }

    /* Add subtle fade-in animation */
    .fade-in {
        opacity: 0;
        animation: fadeIn 0.5s forwards ease-in;
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }
    
    .smoky-shadow {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
    }

    #loadingSpinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            display: none; /* Initially hidden */
            text-align: center;
        }

        /* Optional: Modern text style for the spinner text */
        .spinner-text {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 20px;
            color: #007bff;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
</head>
<body class="text-sm" style="background-color: #cecece;">
    <header class="py-3" style="background: #084262;">
        <div class="container-fluid d-flex justify-content-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height: 100px;">
            </div>
        </div>
    </header>

    <div class="container-fluid mx-auto py-5">
        <div class="row justify-content-center"> <!-- Center the row -->
            <div class="col-md-3 mb-4"> <!-- Adjust width as needed -->
                <div class="smoky-shadow card">
                    <div class="card-header" style="background: rgb(21, 99, 82);">
                        Your Guide to Simplified Procedures
                    </div>
                    <div class="card-body" style="line-height: 1.5; padding: 1.5rem; background-color: #f0f8ff;">
                        <ol class="list-unstyled">
                            <li class="mb-3">
                                <strong>Step #1 Instructions:</strong> 
                                Carefully read the instructions provided before beginning the survey.
                                <hr>
                            </li>
                            <li class="mb-3">
                                <strong>Step #2 Answer:</strong> 
                                Respond to each question honestly.
                                <hr>
                            </li>
                            <li class="mb-3">
                                <strong>Step #3 Review:</strong> 
                                Double-check your answers.
                                <hr>
                            </li>
                            <li class="mb-3">
                                <strong>Step #4 Submit:</strong> 
                                Submit the survey.
                            </li>
                        </ol>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-7 mb-4"> <!-- Adjust width as needed -->
                <div class="smoky-shadow card">
                    <div class="card-header" style="background: rgb(49, 40, 100);">
                        Feedback Form
                    </div>
                    <div class="card-body">
                        <form id="slideshowForm" action="{{ route('feedback.storeForm') }}" method="POST">
                                @csrf
                                <!-- Slide 1 -->
                                <div class="slide" id="slide1">
                                    <div class="mb-3">
                                        <h5><strong>Slide #1 :</strong> Profile Information</h5>
                                        <span class="badge badge-warning text-left text-sm mb-2 py-1" style="font-weight: 600; font-size: 10px"><strong>Note: </strong>
                                            Fill in all the required information.</span><br>            
                                        </div>
                                        <div id="error-message" class="alert alert-danger" role="alert" style="display: none;">
                                            Please fill in all the fields before proceeding.
                                        </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <select class="form-control" id="office" name="Office" required>
                                                <option value="">Office transacted</option>
                                                <option {{old('Office') == '1' ? 'selected' : ''}} value="Emis/Records">Emis/Records</option>
                                                <option {{old('Office') == '2' ? 'selected' : ''}} value="Accounting">Accounting</option>
                                                <option {{old('Office') == '3' ? 'selected' : ''}} value="Admin">Admin</option>
                                                <option {{old('Office') == '4' ? 'selected' : ''}} value="Guidance">Guidance</option>
                                                <option {{old('Office') == '5' ? 'selected' : ''}} value="Clinic">Clinic</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3" id="additionalOptions">
                                            <select name="Service" id="additional_option" class="form-select form-control d-block" required></select>
                                        </div>
                                    </div>
                                </div>
                                                      
                                <!-- Slide 2 -->
                                <div class="slide" id="slide2" style="display:none;">
                                    <h5><strong>Slide #2 :</strong> Answer the questions    </h5>
                                    <p mt-2><strong>INSTRUCTIONS:</strong> For SQD 0-7, please choose the column that best corresponds to your answer. Thank you!</p>

                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle text-center">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Strongly Disagree</th>
                                                    <th>Disagree</th>
                                                    <th>Neither</th>
                                                    <th>Agree</th>
                                                    <th>Strongly Agree</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-left"><strong>SQD0.</strong> I am satisfied with the service that I availed.</td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_0" value="Strongly Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_0" value="Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_0" value="Neither"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_0" value="Agree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_0" value="Strongly Agree"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>SQD1.</strong> I spent a reasonable amount of time for my transaction.</td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_1" value="Strongly Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_1" value="Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_1" value="Neither"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_1" value="Agree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_1" value="Strongly Agree"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>SQD2.</strong> The office followed the transaction's requirements and steps based on the information provided.</td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_2" value="Strongly Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_2" value="Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_2" value="Neither"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_2" value="Agree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_2" value="Strongly Agree"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>SQD3.</strong> The steps (including payment) I needed to do for my transaction were easy and simple.</td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_3" value="Strongly Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_3" value="Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_3" value="Neither"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_3" value="Agree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_3" value="Strongly Agree"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>SQD4.</strong> I easily found information about my transaction from the office or its website.</td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_4" value="Strongly Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_4" value="Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_4" value="Neither"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_4" value="Agree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_4" value="Strongly Agree"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>SQD5.</strong> I feel the office was fair to everyone or "walang palakasan" during the transaction.</td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_5" value="Strongly Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_5" value="Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_5" value="Neither"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_5" value="Agree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_5" value="Strongly Agree"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>SQD6.</strong> I was treated courteously by the staff and (if asked for help) the staff was helpful.</td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_6" value="Strongly Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_6" value="Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_6" value="Neither"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_6" value="Agree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_6" value="Strongly Agree"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>SQD7.</strong> I got what I needed from the government office, or (if denied) denial of request was sufficiently explained to me.</td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_7" value="Strongly Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_7" value="Disagree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_7" value="Neither"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_7" value="Agree"></td>
                                                    <td><input class="form-check-input" type="radio" name="SQD_7" value="Strongly Agree"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- slide 3 --}}

                                <div class="slide" id="slide3" style="display:none;">
                                    <!-- Start Feedback -->
                                    <div class="mb-3">
                                        <h5><strong>Slide #3 :</strong> Write a feedbacks</h5>

                                        <label for="message" class="form-label">
                                            <strong>Suggestions/Feedback/Comments on how we can further improve our services:</strong>
                                        </label>
                                        <textarea id="message" name="Feedback" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            
                                <!-- Navigation Buttons -->
                                <div class="form-navigation d-flex justify-content-center my-4">
                                    <button type="button" id="prevBtn" class="fade-in w-100 mr-1" onclick="nextPrev(-1)" style="display:none;">Back</button>
                                    <button type="button" id="nextBtn" class="fade-in w-100 ml-1" onclick="nextPrev(1)">Next</button>
                                </div>
                        </form>
                        
                                <!-- Modernized Loading Spinner with Bootstrap (Initially hidden) -->
                                <div id="loadingSpinner">
                                    <div class="spinner-border spinner-border-lg text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-text">Please wait, submitting your form...</div>
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>


    <script>
        document.getElementById('office').addEventListener('change', function() {
            var department = this.value;
            var additionalOptions = document.getElementById('additionalOptions');
            var additionalOptionSelect = document.getElementById('additional_option');
            
            if (department === 'Emis/Records') {
                // Change options for Registrar
                additionalOptionSelect.innerHTML = `
                    <option value="">Service Available</option>
                    <option value="Certification">Certification</option>
                    <option value="Transmittal">Transmittal</option>
                    <option value="Form 137">Form 137 (F137)</option>
                    <option value="Certificate of Graduation">Certificate of Graduation (CG)</option>
                    <option value="Certificate of Good Moral">Certificate of Good Moral (CGM)</option>
                    <option value="Certified True Copy">Certified True Copy (CTC)</option>
                    <option value="Certificate of Enrollment">Certificate of Enrollment (CE)</option>
                    <option value="Certification, Authentication, and Verification">Certification, Authentication, and Verification (CAV)</option>
                `;
                additionalOptions.style.display = 'block';
            } else if (department === 'Accounting') {
                // Change options for Library
                additionalOptionSelect.innerHTML = `
                    <option value="">Service Available</option>
                    <option value="Loan">Loan</option>
                    <option value="Paycheck">Paycheck</option>
                `;
                additionalOptions.style.display = 'block';
            } else if (department === 'Clinic') {
                // Change options for Library
                additionalOptionSelect.innerHTML = `
                    <option value="">Service Available</option>
                    <option value="Visit">Visit</option>
                `;
                additionalOptions.style.display = 'block';
            } else if (department === 'Guidance') {
                // Change options for Library
                additionalOptionSelect.innerHTML = `
                    <option value="">Service Available</option>
                    <option value="Visit">Visit</option>
                `;
                additionalOptions.style.display = 'block';
            } else if (department === 'Admin') {
                // Change options for Library
                additionalOptionSelect.innerHTML = `
                    <option value="">Service Available  </option>
                    <option value="Inquiries">Inquiries</option>
                `;
                additionalOptions.style.display = 'block';
            } else {
                additionalOptions.style.display = 'none';
            }
        });
    </script>




<script>
    let currentSlide = 0; // Current slide index (0-based)
    showSlide(currentSlide); // Display the first slide

    function showSlide(n) {
        let slides = document.getElementsByClassName("slide");
        slides[n].style.display = "block";
        document.getElementById("prevBtn").style.display = (n === 0) ? "none" : "inline";
        document.getElementById("nextBtn").innerHTML = (n === slides.length - 1) ? "Submit" : "Next";
    }

    function nextPrev(n) {
        let slides = document.getElementsByClassName("slide");

        // Validate Slide #1 if moving from it
        if (currentSlide === 0 && n === 1) {
            const office = document.getElementById("office").value.trim();
            const service = document.getElementById("additional_option").value.trim();

            if (!office || !service) {
                document.getElementById("error-message").style.display = "block";
                return false; // Stop from moving to the next slide
            } else {
                document.getElementById("error-message").style.display = "none";
            }
        }

        // Hide the current slide
        slides[currentSlide].style.display = "none";

        // Update the current slide index
        currentSlide += n;

        // Submit the form if reached the end
        if (currentSlide >= slides.length) {
            showLoadingSpinner(); // Show the loading spinner
            document.getElementById("slideshowForm").submit();
            return false;
        }

        // Show the new slide
        showSlide(currentSlide);
    }

    // Function to show the loading spinner
    function showLoadingSpinner() {
        document.getElementById("loadingSpinner").style.display = "block";
    }
</script>

        
        
</body>
</html>
