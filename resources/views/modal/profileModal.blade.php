<div class="modal fade" id="editProfileModal{{$profile->id}}" tabindex="-1" role="dialog"
    aria-labelledby="$editProfileModalLabel{{$profile->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('bhw-user.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <div class="text-center">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                        <!-- Show the current profile picture -->
                        <img src="{{ asset($profile->profile_picture) }}" alt="Current Profile Picture"
                            class="img-fluid rounded-circle mx-auto d-block" style="width: 150px; height: 150px;">
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="{{ $profile->last_name }}">
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="{{ $profile->first_name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $profile->email }}">
                    </div>
                    <div class="form-group">
                        <label for="muni-dd">Municipality</label>
                        <select class="form-control" id="muni-dd" name="muni-dd">
                            <option value="">Select Municipality</option>
                            @foreach($muni as $data)
                            <option value="{{$data->id}}" @if($data->name == $profile->municipality) selected
                                @endif>
                                {{$data->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brgy-dd">Barangay</label>
                        <select id="brgy-dd" class="form-control" name="brgy-dd">
                            <!-- Options will be populated using AJAX -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number"
                            value="{{ $profile->contact_number }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" value="Update">Update Account</button>
                </div>
            </form>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                // Your existing script for populating barangays

                $(document).ready(function () {
                    var selectedBarangay = "{{ $bhwAccount->barangay }}";

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
                                        var option = $('<option></option>').attr('value', value.name).text(value.name);
                                        if (value.name === selectedBarangay) {
                                            option.prop('selected', true);
                                        }
                                        $('#brgy-dd').append(option);
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

                    // Trigger change event on document ready to load barangays if a municipality is already selected
                    $('#muni-dd').trigger('change');
                });
            </script>
        </div>
    </div>
</div>
