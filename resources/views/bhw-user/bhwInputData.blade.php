<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Children Record Form</title>
    <style>
        body {
            display: flex;
            justify-content: space-between;
            /* Arrange content with space between */
        }

        form {
            /* Adjust the width of the form as needed */
            margin-right: 350px;
            /* Provide a margin between form and sidebar */
        }

        .sidebar {
            width: 25%;
            /* Adjust the width of the sidebar as needed */
            background-color: #f0f0f0;
            padding: 20px;
        }
        .custom-dropdown {
    width: 100%; /* Set the same width for both dropdowns */
}

    </style>
</head>

<body>
    <div class="sidebar-container">
        @include('bhw-user.bhwSidebarMenu') <!-- Include your sidebar content here -->
    </div class="content">
    <div>
        <h1>Children Record Form</h1>
        <form method="POST" action="{{ route('ChildRecord.store') }}">
            @csrf <!-- Add CSRF token for Laravel forms -->
            <div>
                <select id="muni-dd" class="form-control custom-dropdown" name = "municipal">
                    <option value="">Select Municipality</option>
                    @foreach($muni as $data)
                    <option value="{{$data->name}}">{{$data->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <select id="brgy-dd" class="form-control custom-dropdown" name="barangay"></select>
                
            </div>

            <div>
                <label for="sitio">Sitio:</label>
                <input type="text" id="sitio" name="sitio"><br><br>
            </div>


            <div>
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname"><br><br>
            </div>

            <div>
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname"><br><br>
            </div>

            <div>
                <label for="middlename">Middle Name:</label>
                <input type="text" id="middlename" name="middlename"><br><br>
            </div>

            <div>
                <label for="birthday">Birthday:</label>
                <input type="date" id="birthday" name="birthday"><br><br>
            </div>

            <div>
                <label for="sex">Sex:</label>
                <select id="sex" name="sex">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select><br><br>
            </div>

            <div>
                <label for="weight">Weight:</label>
                <input type="text" id="weight" name="weight"><br><br>
            </div>

            <div>
                <label for="height">Height:</label>
                <input type="text" id="height" name="height"><br><br>
            </div>

            <div>
                <label for="bmi">BMI:</label>
                <input type="text" id="bmi" name="bmi"><br><br>
            </div>

            <div>
                <label for="bmi_classification">BMI Classification:</label>
                <input type="text" id="bmi_classification" name="bmi_classification"><br><br>
            </div>

            <div>
                <label for="medical_condition">Medical Condition:</label>
                <input type="text" id="medical_condition" name="medical_condition"><br><br>
            </div>

            <div>
                <label for="vaccine_received">Vaccine Received:</label>
                <input type="text" id="vaccine_received" name="vaccine_received"><br><br>
            </div>

            <div>
                <label for="mother_lastname">Mother's Last Name:</label>
                <input type="text" id="mother_lastname" name="mother_lastname"><br><br>
            </div>

            <div>
                <label for="mother_firstname">Mother's First Name:</label>
                <input type="text" id="mother_firstname" name="mother_firstname"><br><br>
            </div>

            <div>
                <label for="mother_middlename">Mother's Middle Name:</label>
                <input type="text" id="mother_middlename" name="mother_middlename"><br><br>
            </div>

            <div>
                <label for="mother_birthday">Mother's Birthday:</label>
                <input type="date" id="mother_birthday" name="mother_birthday"><br><br>
            </div>

            <div>
                <label for="mother_occupation">Mother's Occupation:</label>
                <input type="text" id="mother_occupation" name="mother_occupation"><br><br>
            </div>

            <div>
                <label for="father_lastname">Father's Last Name:</label>
                <input type="text" id="father_lastname" name="father_lastname"><br><br>
            </div>

            <div>
                <label for="father_firstname">Father's First Name:</label>
                <input type="text" id="father_firstname" name="father_firstname"><br><br>
            </div>

            <div>
                <label for="father_middlename">Father's Middle Name:</label>
                <input type="text" id="father_middlename" name="father_middlename"><br><br>
            </div>

            <div>
                <label for="father_birthday">Father's Birthday:</label>
                <input type="date" id="father_birthday" name="father_birthday"><br><br>
            </div>

            <div>
                <label for="father_occupation">Father's Occupation:</label>
                <input type="text" id="father_occupation" name="father_occupation"><br><br>
            </div>

            <div>
                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number"><br><br>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>

    </div>

    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

</body>

</html>