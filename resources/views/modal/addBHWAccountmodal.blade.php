<div class="modal fade" id="addAdminAccountModal" tabindex="-1" role="dialog"
    aria-labelledby="addAdminAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('healthWorker.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminAccountModalLabel">Add Admin Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="role" class="form-control">
                            <option value="bhw">BHW</option>
                            <!-- Add more role options if needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" class="form-control-file" id="profilePicture" name="profile_picture">
                    </div>
                    <div class="form-group">
                        <label for="worker_id">ID</label>
                        <input type="text" class="form-control" id="worker_id" name="worker_id">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name">
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name">
                    </div>
                    <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name">
                    </div>
                    <div>
                        <select id="muni-dd" class="form-control custom-dropdown">
                            <option value="">Select Municipality</option>
                            @foreach($muni as $data)
                            <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <select id="brgy-dd" class="form-control custom-dropdown"></select>

                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" value="Register">Add Account</button>
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
                                $('#brgy-dd').append('<option value="' + value.id + '">' + value.name + '</option>');
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
        </div>
    </div>
</div>