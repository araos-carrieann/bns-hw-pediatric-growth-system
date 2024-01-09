<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content -->
</head>
<body>

<div class="container mt-4">
    <h1>Registered Users</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Profile Picture</th>
                <th>ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->profile_picture }}</td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->lastname }}</td>
                    <td>{{ $user->firstname }}</td>
                    <td>{{ $user->middle_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->contact_number }}</td>
                    <td>
                        <!-- Edit button -->
                        <button class="btn btn-primary" onclick="openEditModal('{{ $user->id }}', '{{ $user->firstname }}', '{{ $user->lastname }}', '{{ $user->email }}' /* Add other parameters */)">Edit</button>
                        
                        <!-- Delete button -->
                        <form action="{{ route('deleteUser', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Include the edit modal -->
@include('editUserModal')

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Other scripts -->

<script>
    // Function to open edit modal and populate user data
    function openEditModal(userId, firstName, lastName, email /* Add other parameters */) {
        $('#editUserId').val(userId);
        $('#editFirstName').val(firstName);
        $('#editLastName').val(lastName);
        $('#editEmail').val(email);
        /* Populate other input fields with user data */
        $('#editUserModal').modal('show');
    }
</script>

</body>
</html>
