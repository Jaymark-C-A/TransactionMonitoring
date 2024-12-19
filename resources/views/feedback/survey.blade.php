<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCNHS Feedback Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src= "https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js">
    </script>
    <style>
        body {
            font-size: 10pt;
        }
        .container {
            width: 90%;
        }
        .form-input,
        .form-textarea {
            width: 100%;
        }
    </style>
</head>

<body class="bg-gray-100">
    <header class="bg-blue-600 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Olongapo City National High School</a>
            <nav class="hidden md:block">
                {{-- <a href="#" class="mr-4">Home</a>
                <a href="#" class="mr-4">Courses</a>
                <a href="#" class="mr-4">About</a>
                <a href="#" class="mr-4">Contact</a> --}}
            </nav>
        </div>
    </header>

    <main class="container mx-auto mt-8 flex flex-col md:flex-row md:items-start">
        <section class="flex flex-col w-full md:w-2/3 mt-8 md:mr-10">
            <h1 class="text-3xl mb-4 font-extrabold text-purple-900">Simple <br> Procesure Steps</h1>
            <p class="text-sm mb-6"><strong>Step #1 Instructions:</strong> Carefully read the instructions provided before beginning the survey.</p>
            <p class="text-sm mb-6"><strong>Step #2 Answer:</strong> Respond to each question honestly.</p>
            <p class="text-sm mb-6"><strong>Step #3 Review:</strong> Double-check your answers.</p>
            <p class="text-sm mb-6"><strong>Step #4 Submit:</strong> Submit the survey.</p>
        </section>
        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 w-full md:w-3/3">
            <h2 class="text-2xl font-bold mb-4 text-center">Feedback Form</h2>
            <form id="surveyForm" action="{{ route('survey.storeForm') }}" method="POST">
                {{-- <form id="surveyForm"> --}}
                @csrf
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Client type:</label>
                        <div class="flex flex-wrap mx-2">
                            <div class="px-2 w-1/6">
                                <label for="client-type" class="block text-gray-700 font-medium mb-2">
                                    <input type="radio" id="color-red" name="client_type" value="Client" class="mr-2">Client
                                </label>
                            </div>
                            <div class="px-2 w-1/6">
                                <label for="client-type" class="block text-gray-700 font-medium mb-2">
                                    <input type="radio" id="color-blue" name="client_type" value="Citizen" class="mr-2">Citizen
                                </label>
                            </div>
                            <div class="px-2 w-2/3">
                                <label for="client-type" class="block text-gray-700 font-medium mb-2">
                                    <input type="radio" id="color-green" name="client_type" value="Government" class="mr-2">Government (Employee or another agency)
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <input type="text" id="name" name="Name"
                            class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" placeholder="Enter your fullname:">
                    </div>
                    <div class="mb-4 space-x-5  flex items-center justify-between">
                        <input type="number" id="age" name="Age"
                            class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" placeholder="Age:">
                        <select id="gender" name="Gender"
                            class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
                            <option value="">Select gender</option>
                            <option {{old('Gender') == '1' ? 'selected' : ''}} value="Male">Male</option>
                            <option {{old('Gender') == '2' ? 'selected' : ''}} value="Female">Female</option>
                            <option  value="">Other</option>
                        </select>
                    </div>
                    <div class="mb-4 space-x-5  flex items-center justify-between">
                        <input type="text" id="office" name="Office" class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required placeholder="Office transacted:">
                        <input type="text" id="service" name="Service" class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required placeholder="Service availed:">
                    </div>
                    
                    {{-- CC1 --}}
                    <div class="mb-4">
                        <br><label for="message" class="block text-gray-700 text-xs mb-2"><strong>INSTRUCTIONS: </strong>Choose and answer the Citizen's Charter (CC) questions. The Citizen's charter is an official document that reflects the services <br>
                        of a government agency/office including it's requirementm, fees and processing times among others.</label>
                        <label class="block text-gray-700 font-medium mb-2">CC1: Which of the following best describes your awareness of a CC?</label>
                        <div class=" mx-2">
                            <div class="px-2 w-full">
                                <label for="CC1-1" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC1-1" name="CC1" value="I know what a CC is and i saw this office's CC." class="mr-2">I know what a CC is and i saw this office's CC.
                                </label>
                            </div>
                            <div class="px-2 w-full">
                                <label for="CC1-2" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC1-2" name="CC1" value="I know what a CC is but i did NOT see the office's CC."
                                        class="mr-2">I know what a CC is but i did NOT see the office's CC.
                                </label>
                            </div>
                            <div class="px-2 w-full">
                                <label for="CC1-3" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC1-3" name="CC1" value="I learned of the CC only when i saw this office's CC." class="mr-2">I learned of the CC only when i saw this office's CC.
                                </label>
                            </div>
                            <div class="px-2 w-full">
                                <label for="CC1-4" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC1-4" name="CC1" value="I do not know what a CC is and i did not see on this office." class="mr-2">I do not know what a CC is and i did not see on this office. (Answer "N/A" on CC2 and CC3)
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- CC2 --}}
                    <div class="mb-1">
                        <label class="block text-gray-700 font-medium mb-2">CC2: If aware of CC (answered 1-3 in CC1), would you say the CC of this was...?</label>
                        <div class="flex flex-wrap mx-2">
                            <div class="px-2 w-1/3">
                                <label for="CC2-1" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC2-1" name="CC2" value="Easy to see" class="mr-2">Easy to see
                                </label>
                            </div>
                            <div class="px-2 w-1/2">
                                <label for="CC2-2" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC2-2" name="CC2" value="Somewhat easy to see"
                                        class="mr-2">Somewhat easy to see
                                </label>
                            </div>
                            <div class="px-2 w-1/3">
                                <label for="CC2-3" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC2-3" name="CC2" value="Difficult to see" class="mr-2">Difficult to see
                            </div>
                            <div class="px-2 w-1/2">
                                <label for="CC2-4" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC2-4" name="CC2" value="Not available at all" class="mr-2">Not available at all
                                </label>
                            </div>
                            <div class="px-2 w-full">
                                <label for="CC2-5" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC2-5" name="CC2" value="N/A" class="mr-2">N/A
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- CC3 --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">CC3: If aware of CC (answered 1-3 in CC1), how much did the CC help you in your transaction?</label>
                        <div class="flex flex-wrap mx-2">
                            <div class="px-2 w-1/3">
                                <label for="CC3-1" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC3-1" name="CC3" value="Helped very much" class="mr-2">Helped very much
                                </label>
                            </div>
                            <div class="px-2 w-2/3">
                                <label for="CC3-2" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC3-2" name="CC3" value="Somewhat helped" class="mr-2">Somewhat helped
                                </label>
                            </div>
                            <div class="px-2 w-1/3">
                                <label for="CC3-3" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC3-3" name="CC3" value="Did not Helped" class="mr-2">Did not Helped
                                </label>
                            </div>
                            <div class="px-2 w-full">
                                <label for="CC3-4" class="block text-gray-700 font-small mb-2">
                                    <input type="radio" id="CC3-4" name="CC3" value="N/A" class="mr-2">N/A
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- table question --}}
                    <div class="overflow-x-auto">
                        <label for="message" class="block text-gray-700 text-xs mb-2"><strong>INSTRUCTIONS: </strong>For SQD 0-7, pleasae choose on the column that best corresponds your answer. Thank you!</label>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Strongly Disagree
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Disagree
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Neither
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Agree
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Strongly Agree
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Q0 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-small">
                                        SQDO. I am satisfied with the <br> service that i availed
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_0" value="strongly_disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_0" value="disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_0" value="neither">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_0" value="agree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_0" value="strongly_agree">
                                    </td>
                                </tr>
                                {{-- Q1 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-small">
                                        SQD1. I spent a reasonable <br> amount of time for my transaction
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_1" value="strongly_disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_1" value="disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_1" value="neither">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_1" value="agree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_1" value="strongly_agree">
                                    </td>
                                </tr>
                                {{-- Q2 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-small">
                                        SQD2. The office followed the <br> transaction's requiremnts 
                                        and steps <br> based on the information provided.
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_2" value="strongly_disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_2" value="disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_2" value="neither">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_2" value="agree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_2" value="strongly_agree">
                                    </td>
                                </tr>
                                {{-- Q3 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-small">
                                        SQD3. The steps (including payment) <br>
                                        I needed to do for my transaction <br> 
                                        were easy and simple.
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_3" value="strongly_disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_3" value="disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_3" value="neither">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_3" value="agree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_3" value="strongly_agree">
                                    </td>
                                </tr>
                                {{-- Q4 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-small">
                                        SQD4. I easily found information <br> 
                                        about my transaction from <br>
                                        the office or its website.
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_4" value="strongly_disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_4" value="disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_4" value="neither">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_4" value="agree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_4" value="strongly_agree">
                                    </td>
                                </tr>
                                {{-- Q5 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-small">
                                        SQD5. I feel the office was fair <br>
                                        to everyone or "walang palakasan" <br>
                                        during transaction.
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_5" value="strongly_disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_5" value="disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_5" value="neither">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_5" value="agree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_5" value="strongly_agree">
                                    </td>
                                </tr>
                                {{-- Q6 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-small">
                                        SQD6. I was treated courteously by <br>
                                        the staff and (if asked for help) <br>
                                        the staff was helpful.
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_6" value="strongly_disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_6" value="disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_6" value="neither">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_6" value="agree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_6" value="strongly_agree">
                                    </td>
                                </tr>
                                {{-- Q7 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-small">
                                        SQD7. I got what i needed from the <br>
                                        government office, or (if denied) <br>
                                        denial of request was sufficiently <br>
                                        explained to me.
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_7" value="strongly_disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_7" value="disagree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_7" value="neither">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_7" value="agree">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="radio" name="SQD_7" value="strongly_agree">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- start feedback --}}
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 text-xs mb-2"><strong>Suggestions/feedback/comments on how we can further improve our services:</strong></label>
                        <textarea id="message" name="Feedback"
                            class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" rows="5"></textarea>
                    </div>
                    <div>
                        <button type="submit" onclick="generatePDF()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit</button>
                    </div>
                </form>
        </div>
    </main>


{{-- working --}}
{{-- <script>
    async function generatePDF() {
        console.log("Generating PDF...");
        const formData = new FormData(document.getElementById('surveyForm'));

        // Create a new jsPDF document
        const doc = new jsPDF();

        // Set up fonts
        doc.setFont('helvetica');

        // Set font size
        const fontSize = 10;

        // Set initial y position
        let yPos = 20;

        // Add background color to the entire page
        doc.setFillColor(240, 240, 240); // Light gray background color
        doc.rect(0, 0, doc.internal.pageSize.width, doc.internal.pageSize.height, 'F');

        // Draw border around the page
        doc.setDrawColor(0); // Black color for border
        doc.setLineWidth(0.5); // Border width
        doc.rect(5, 5, doc.internal.pageSize.width - 10, doc.internal.pageSize.height - 10); // Adjust margin

        // Add title with modern layout
        doc.setFontSize(20);
        doc.setTextColor(0, 102, 204); // Blue color for title text
        doc.text('Survey Response', 75, yPos, { align: 'center' });
        yPos += 20;

        // Draw form elements with styling
        for (const [key, value] of formData.entries()) {
            doc.setFontSize(fontSize);
            doc.setTextColor(0); // Black color for text
            doc.text(`${key}:`, 20, yPos);
            doc.setTextColor(50, 50, 50); // Gray color for form value
            doc.text(value, 40, yPos);
            yPos += 10;
        }

        // Add decorative elements and styling
        const decorationY = yPos + 5;
        doc.setDrawColor(0); // Black color for lines
        doc.setLineWidth(0.5);
        doc.line(20, decorationY, 190, decorationY);

        // Save the PDF
        doc.save('survey_response.pdf');
    }
</script> --}}

<script>
    async function generatePDF() {
        const form = document.getElementById('surveyForm');

        // Validate if the form is filled completely
        if (!form.checkValidity()) {
            alert('Please fill out all fields before submitting.');
            return;
        }

        console.log("Generating PDF...");
        const formData = new FormData(form);

        const doc = new jsPDF();
        doc.setFont('helvetica');
        const fontSize = 10;
        let yPos = 20;

        doc.setFillColor(240, 240, 240);
        doc.rect(0, 0, doc.internal.pageSize.width, doc.internal.pageSize.height, 'F');

        doc.setDrawColor(0);
        doc.setLineWidth(0.5);
        doc.rect(5, 5, doc.internal.pageSize.width - 10, doc.internal.pageSize.height - 10);

        doc.setFontSize(20);
        doc.setTextColor(0, 102, 204);
        doc.text('Survey Response', 75, yPos, { align: 'center' });
        yPos += 20;

        doc.setFontSize(fontSize);
        doc.setTextColor(0); 
        doc.text('Field', 20, yPos);
        doc.text('Value', 60, yPos);
        yPos += 10;

        for (const [key, value] of formData.entries()) {
            doc.setTextColor(0);
            doc.text(key, 20, yPos);
            doc.text(value, 60, yPos);
            yPos += 10;
        }

        const decorationY = yPos + 5;
        doc.setDrawColor(0);
        doc.setLineWidth(0.5);
        doc.line(20, decorationY, 190, decorationY);

        // Get the current date
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const year = now.getFullYear();
        const formattedDate = `${year}-${month}-${day}`;

        // Set the file name with the current date
        const fileName = `feedback_response_${formattedDate}.pdf`;

        doc.save(fileName);
    }
</script>



</body>
</html>
