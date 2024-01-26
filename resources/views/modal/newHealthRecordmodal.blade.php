<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('HealthWorker.store') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">               

                        <div class="form-group">
                        <label for="birthday" class="form-control-label">Birthday</label>
                        <input class="form-control" type="date" id="birthdate" name="birthday"
                            value="{{ $childRecords->isEmpty() ? '' : $childRecords[0]->birthday }}">
                    </div>


                        <div class="form-group">
                            <label for="age">Age (Month):</label>
                            <input class="form-control" type="text" id="age" name="age" value ="recalculatedAge" readonly>
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
                                        <input type="text" id="weight" name="weight" class="form-control"
                                            placeholder="Weight">
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
                                        <input type="text" id="height" name="height" class="form-control"
                                            placeholder="Weight">
                                        <select class="btn btn-outline-primary mb-0" id="height-unit">
                                            <option value="cm">cm</option>
                                            <option value="ft">ft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bmi_classification">BMI Classification:</label>
                                    <input class="form-control" type="text" id="bmi_classification"
                                        name="bmi_classification" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="medical_condition">Medical Condition:</label>
                                    <input class="form-control" type="text" id="medical_condition"
                                        name="medical_condition">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vaccine_received">Vaccine Received:</label>
                                    <input class="form-control" type="text" id="vaccine_received"
                                        name="vaccine_received">
                                </div>
                            </div>
                        </div>


                 
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-gradient-primary">Save changes</button>
                </div>
            </form>
<!-- Include jQuery once -->

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    // Function to calculate age
    function calculateAge(birthdate) {
        var birthDate = new Date(birthdate);
        var today = new Date();

        var ageInMonths = (today.getFullYear() - birthDate.getFullYear()) * 12 + (today.getMonth() - birthDate.getMonth());

        // Check if the birthday for this year has occurred or not
        if (today.getDate() < birthDate.getDate()) {
            ageInMonths--;
        }

        // Display the age in the input field
        return ageInMonths; // Make sure to return the calculated age
    }

    // Trigger the calculateAge function when the modal for inserting a new record is shown
    $('#exampleModal').on('shown.bs.modal', function () {
        // Assuming you have the date of birth already selected when opening the modal
        var birthdate = $('#birthdate').val();
        var recalculatedAge = calculateAge(birthdate);

        console.log('Calculated Age:', recalculatedAge);

        // Set the calculated age in the input field
        document.getElementById('age').value = recalculatedAge;
        console.log('age changed');
    });

    // Bind age calculation to the date of birth change event
    $('#birthdate').on('change', function () {
        calculateAge(this.value);
    });
});
</script>
