<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Admin Account</title>
    <!-- Add necessary meta tags and stylesheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
    </style>
</head>

<body>
    <div class="sidebar-container">
        @include('super-admin.superAdminSidebarMenu') <!-- Include your sidebar content here -->
    </div class="content">
    <a class="nav-link login-btn" href="#" data-toggle="modal" data-target="#addAdminAccountModal">
        <i class="fas fa-plus-circle"></i> Admin Account
    </a>
    <!-- admin_accounts.blade.php -->

    
       <!-- Table to display admin accounts -->
<table>
    <thead>
        <tr>
            <th>ID</th>
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
        @foreach ($adminAccounts as $adminAccount)
        <tr>
            <td>{{ $adminAccount->id }}</td>
            <td>{{ $adminAccount->role }}</td>
            <td>{{ $adminAccount->last_name }}</td>
            <td>{{ $adminAccount->first_name }}</td>
            <td>{{ $adminAccount->municipality }}</td>
            <td>{{ $adminAccount->email }}</td>
            <td>{{ $adminAccount->contact_number }}</td>
            <td>
                <a href="{{ route('admin.edit', $adminAccount->id) }}">Edit</a>
                <form method="post" action="{{ route('admin.delete', $adminAccount->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

    <!-- Include the modal -->
    @include('modal.addAdminAccountmodal')

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>