
@isset($bhwAccount)
<div class="modal fade" id="editBHWAccountModal{{$bhwAccount->id}}" tabindex="-1" role="dialog"
    aria-labelledby="$bhwAccountAccountModalLabel{{$bhwAccount->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('bhw-user.update', $bhwAccount->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title" id="$bhwAccountAccountModalLabel{{$bhwAccount->id}}">Edit Admin Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="status" value="active">
                        <input type="hidden" name="role" value="bhw-user">
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
                            <option value="{{$data->id}}" @if($data->name == $bhwAccount->municipality) selected
                                @endif>
                                {{$data->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editbrgy-dd">Barangay</label>
                        <select id="editbrgy-dd" class="form-control" name="editbrgy-dd">
                            <option value="{{$bhwAccount->barangay}}" selected>{{$bhwAccount->barangay}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sitio">Sitio</label>
                        <input type="text" class="form-control" id="sitio" name="sitio"
                            value="{{ $bhwAccount->sitio }}">
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
                    $('#muni-dd').on('change', function () {
                        var municipalityId = $(this).val();

                        if (municipalityId) {
                            $.ajax({
                                url: '/getBrgy/' + municipalityId,
                                type: 'GET',
                                dataType: 'json',
                                success: function (data) {
                                    $('#editbrgy-dd').empty();

                                    // Append options for other barangays
                                    $.each(data.barangays, function (key, value) {
                                        $('#editbrgy-dd').append('<option value="' + value.name + '">' + value.name + '</option>');
                                    });
                                },
                                error: function (xhr, status, error) {
                                    console.error(error);
                                }
                            });
                        } else {
                            $('#editbrgy-dd').empty();
                        }
                    });
                });

            </script>
        </div>
    </div>
</div>
@else
    <!-- Handle the case where $bhwAccount is not set -->
@endisset