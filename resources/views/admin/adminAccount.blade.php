<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Admin Account</title>
    <!-- Add necessary meta tags and stylesheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            justify-content: space-between;
        }

        .sidebar {
            width: 25%;
            background-color: #f0f0f0;
            padding: 20px;
        }

        /* Adjustments for the "Add Admin Account" button */
        .login-btn {

            margin-bottom: 20px;
            margin-left: 200px;
        }

        /* Additional styles for the table */
        .table th,
        .table td {
            text-align: center;
        }

        .wholetb {
            margin-top: 100px;
            margin-right: 50px;
        }
    </style>
</head>

<body>
    <div class="sidebar-container">
       
    <a class="nav-link login-btn" href="#" data-toggle="modal" data-target="#addBHWAccountModal">
        <i class="fas fa-plus-circle"></i> BHW Account
    </a>
    <!-- admin_accounts.blade.php -->

    <!-- Table to display admin accounts -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Profile Picture</th>
                <th>ID</th>
                <th>Status</th>
                <th>Role</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Municipality</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bhwAccounts as $bhwAccount)
            @if ($bhwAccount->status === 'active')
            <tr>
                <td>
                <img src="{{ asset($bhwAccount->profile_picture) }}" width="50" height="50" class="img img-responsive">
                </td>
                <td>{{ $bhwAccount->id }}</td>
                <td>{{ $bhwAccount->status }}</td>
                <td>{{ $bhwAccount->role }}</td>
                <td>{{ $bhwAccount->last_name }}</td>
                <td>{{ $bhwAccount->first_name }}</td>
                <td>{{ $bhwAccount->municipality }}</td>
                <td>{{ $bhwAccount->email }}</td>
                <td>{{ $bhwAccount->contact_number }}</td>
                <td>
                <a hhref="#" data-toggle="modal" data-target="#eeitBHWAccountModal{{$bhwAccount->id}}" title="Edit BHW Account">
                        <button class="btn btn-primary">
                            <i class="fas fa-pencil-alt" aria-hidden="true"></i> Edit
                        </button>
                    </a>

                    <form method="POST" action="{{ url('/bhw-user/delete/' . $bhwAccount->id) }}" accept-charset="UTF-8"
                        style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>


    <!-- Include the modal -->
    @include('modal.addBHWAccountmodal')

    <!-- Bootstrap JS and jQuery -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>