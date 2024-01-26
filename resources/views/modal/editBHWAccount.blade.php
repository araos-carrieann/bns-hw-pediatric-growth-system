<div class="modal fade" id="editBHWAccountModal{{$bhwAccount->id}}" tabindex="-1" role="dialog"
    aria-labelledby="$bhwAccountAccountModalLabel{{$bhwAccount->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('bhw-user.update', $bhwAccount->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="$bhwAccountAccountModalLabel{{$bhwAccount->id}}">Edit Admin Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="status" value="active">
                        <input type="hidden" name="role" value="admin">
                    </div>
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                        <!-- Show the current profile picture -->
                        <img src="{{ asset($bhwAccount->profile_picture) }}" alt="Current Profile Picture" width="100"
                            height="100">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="{{ $bhwAccount->last_name }}">
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="{{ $bhwAccount->first_name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $bhwAccount->email }}">
                    </div>
                    <div class="form-group">
                        <label for="muni-dd">Municipality</label>
                        <select class="form-control" id="muni-dd" name="muni-dd">
                            <option value="">Select Municipality</option>
                            @foreach($muni as $data)
                            <option value="{{$data->id}}" @if($data->name == $adminAccount->municipality) selected
                                @endif>
                                {{$data->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brgy-dd">Barangay</label>
                        <select id="brgy-dd" class="form-control" name="brgy-dd">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number"
                            value="{{ $bhwAccount->contact_number }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" value="Update">Update Account</button>
                </div>
            </form>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
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