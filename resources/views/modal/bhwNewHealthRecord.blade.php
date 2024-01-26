<!-- Modal for details -->
<div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertModalLabel">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><span id="municipality"></span></p>
                <p><span id="barangay"></span></p>
                <p><span id="sitio"></span></p>
                <p><span id="lastname"></span></p>
                <p><span id="firstname"></span></p>
                <p><span id="middlename"></span></p>
                <p><span id="birthday"></span></p>
                <div class="form-group">
                    <label for="age">Age (Month):</label>
                    <input class="form-control" type="text" id="age" name="age" readonly>
                </div>

                < <div class="row">
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
                        <input class="form-control" type="text" id="bmi_classification" name="bmi_classification"
                            readonly>
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


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal"
                data-bs-target="#exampleModal">Insert New Record</button>
        </div>
    </div>
</div>
</div>
<script>
        function newHealthRecordDetailModal(childRecord) {
            // Extract values from the childRecord object
            var personalInfo = childRecord.personalInfo;
            var healthRecords = childRecord.healthRecords;
            console.log(healthRecords);
            console.log('Health Records:', healthRecords);
            console.log('Age:', healthRecords.age);

            // Set modal content based on the clicked row's data
          

            document.getElementById('lastname').innerText = 'Last Name: ' + personalInfo.lastname;
            document.getElementById('firstname').innerText = 'First Name: ' + personalInfo.firstname;
            document.getElementById('middlename').innerText = 'Middle Name: ' + personalInfo.middlename;
            document.getElementById('birthday').innerText = 'Birthday: ' + personalInfo.birthday;
            document.getElementById('age').innerText = 'Age: ' + healthRecords.age;

            document.getElementById('weight').innerText = 'Weight: ' + healthRecords.weight + ' kg';
            document.getElementById('height').innerText = 'Height: ' + healthRecords.height + ' cm';
            document.getElementById('bmi').innerText = 'BMI: ' + healthRecords.bmi + ' (' + healthRecords.bmi_classification + ')';
            document.getElementById('medical_condition').innerText = 'Medical Condition: ' + (healthRecords.medical_condition ? healthRecords.medical_condition : 'N/A');
            document.getElementById('vaccine_received').innerText = 'Vaccine Received: ' + (healthRecords.vaccine_received ? healthRecords.vaccine_received : 'N/A');
            // Show the modal
            $('#insertModal').modal('show');
        }
    </script>