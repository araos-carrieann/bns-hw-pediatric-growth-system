<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Soft UI Dashboard by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

</head>

<body>
    <div>
        <h1>Children Record Form</h1>
        <form method="POST" action="{{ route('ChildRecord.store') }}">
            @csrf <!-- Add CSRF token for Laravel forms -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="dropdown">
                            <select id="muni-dd" class="btn bg-gradient-primary dropdown-toggle" name="municipality"
                                aria-expanded="false">
                                <option class="dropdown-item" value="">Select Municipality</option>
                                @foreach($muni as $data)
                                <option class="dropdown-item" value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select id="brgy-dd" class="btn bg-gradient-primary dropdown-toggle" name="barangay">
                            <option class="dropdown-item" value="">Select Barangay</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sitio">Sitio:</label>
                        <input type="text" class="form-control" id="sitio" name="sitio" placeholder="Sitio">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname" placeholder="First Name"
                            class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="middlename">Middle Name:</label>
                        <input type="text" id="middlename" name="middlename" placeholder="Middle Name"
                            class="form-control" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="birthday" class="form-control-label">Birthday</label>
                <input class="form-control" type="date" id="birthday" name="birthday"
                    onchange="calculateAge(this.value)">
            </div>

            <div class="form-group">
                <label for="age">Age (Month):</label>
                <input class="form-control" type="text" id="age" name="age" readonly>
            </div>

            <div>
                <label for="sex">Sex:</label>
                <select class="form-control" id="sex" name="sex">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select><br><br>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="weight">Weight:</label>
                        <div class="input-group mb-3">
                            <input type="text" id="weight" name="weight" class="form-control" placeholder="Weight">
                            <select class="btn btn-outline-primary mb-0" id="weight-unit">
                                <option value="kg">kg</option>
                                <option value="lbs">lbs</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="height">Height:</label>
                        <div class="input-group mb-3">
                            <input type="text" id="height" name="height" class="form-control" placeholder="Height">
                            <select class="btn btn-outline-primary mb-0" id="height-unit">
                                <option value="cm">cm</option>
                                <option value="ft">ft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                        <label for="bmi">BMI:</label>
                        <input class="form-control" type="text" id="bmi" name="bmi" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="bmi_classification">BMI Classification:</label>
                    <input class="form-control" type="text" id="bmi_classification" name="bmi_classification" readonly>
                </div>
                </div>
            </div>
            
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="medical_condition">Medical Condition:</label>
                <input class="form-control" type="text" id="medical_condition" name="medical_condition">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="vaccine_received">Vaccine Received:</label>
                <input class="form-control" type="text" id="vaccine_received" name="vaccine_received">
            </div>
        </div>
    </div>

    <div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mother_lastname">Mother's Last Name:</label>
                    <input class="form-control" type="text" id="mother_lastname" name="mother_lastname">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mother_firstname">Mother's First Name:</label>
                    <input class="form-control" type="text" id="mother_firstname" name="mother_firstname">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mother_middlename">Mother's Middle Name:</label>
                    <input class="form-control" type="text" id="mother_middlename" name="mother_middlename">
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mother_birthday">Mother's Birthday:</label>
                    <input class="form-control" type="date" id="mother_birthday" name="mother_birthday">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mother_occupation">Mother's Occupation:</label>
                    <input class="form-control" type="text" id="mother_occupation" name="mother_occupation">
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="father_lastname">Father's Last Name:</label>
                    <input class="form-control" type="text" id="father_lastname" name="father_lastname">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="father_firstname">Father's First Name:</label>
                    <input class="form-control" type="text" id="father_firstname" name="father_firstname">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="father_middlename">Father's Middle Name:</label>
                    <input class="form-control" type="text" id="father_middlename" name="father_middlename">
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="father_birthday">Father's Birthday:</label>
                    <input class="form-control" type="date" id="father_birthday" name="father_birthday">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="father_occupation">Father's Occupation:</label>
                    <input class="form-control" type="text" id="father_occupation" name="father_occupation">
                </div>
            </div>
        </div>


        <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input class="form-control" type="text" id="contact_number" name="contact_number">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>

    </div>

    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function calculateBMI() {
            // Log to check if the function is called
            console.log('calculateBMI function called');

            // Get values from the form
            var height = parseFloat(document.getElementById('height').value);
            var weight = parseFloat(document.getElementById('weight').value);
            var heightUnit = document.getElementById('height-unit').value;
            var weightUnit = document.getElementById('weight-unit').value;

            // Log to check the values
            console.log('Height:', height);
            console.log('Weight:', weight);
            console.log('Height Unit:', heightUnit);
            console.log('Weight Unit:', weightUnit);

            // Convert height to meters
            if (heightUnit === 'cm') {
                height = height / 100; // Convert cm to meters
            } else if (heightUnit === 'ft') {
                height = height * 0.3048; // Convert feet to meters
            }

            // Convert weight to kilograms
            if (weightUnit === 'lbs') {
                weight = weight * 0.453592; // Convert pounds to kilograms
            }

            // Log to check the converted values
            console.log('Converted Height:', height);
            console.log('Converted Weight:', weight);

            // Calculate BMI
            var BMI = weight / (height * height);

            // Log to check the calculated BMI
            console.log('Calculated BMI:', BMI);

            // Display BMI
            document.getElementById('bmi').value = BMI.toFixed(2);

            // Determine BMI classification
            var classification;
            if (BMI < 18.5) {
                classification = 'Underweight';
            } else if (BMI >= 18.5 && BMI < 24.9) {
                classification = 'Normal weight';
            } else if (BMI >= 25 && BMI < 29.9) {
                classification = 'Overweight';
            } else {
                classification = 'Obese';
            }

            // Log to check the classification
            console.log('BMI Classification:', classification);

            // Display BMI classification
            document.getElementById('bmi_classification').value = classification;

        }

        // Attach event listeners to height and weight inputs
        document.getElementById('height').addEventListener('input', calculateBMI);
        document.getElementById('weight').addEventListener('input', calculateBMI);
        document.getElementById('height-unit').addEventListener('change', calculateBMI);
        document.getElementById('weight-unit').addEventListener('change', calculateBMI);
    </script>
    <script>
        $(document).ready(function () {
            $('#muni-dd').on('change', function () {
                var municipalityId = $(this).val();
                if (municipalityId) {
                    $.ajax({
                        url: '/getBrgy/' + municipalityId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#brgy-dd').empty();
                            $.each(data.barangays, function (key, value) {
                                $('#brgy-dd').append('<option value="' + value.name + '">' + value.name + '</option>');
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    $('#brgy-dd').empty();
                }
            });
        });
    </script>


    <script>
        function calculateAge(birthdate) {
            var birthDate = new Date(birthdate);
            var today = new Date();

            var ageInMonths = (today.getMonth() - birthDate.getMonth()) +
                (12 * (today.getFullYear() - birthDate.getFullYear()));

            // Display the age in the input field
            document.getElementById('age').value = ageInMonths;
        }
    </script>
</body>

</html>