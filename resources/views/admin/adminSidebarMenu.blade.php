<!DOCTYPE html>
<html>

<head>
    <title>Beautiful Sidebar</title>
    <style>
        .sidebar {
            /* Define your sidebar styles here */
            background-color: #f0f0f0;
            width: 200px;
            padding: 20px;
            position: fixed;
            height: 100%;
        }

        .sidebar a {
            /* Define your link styles here */
            display: block;
            color: #000;
            text-decoration: none;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>My Sidebar</h2>
        <a href="{{ url('/adminDash') }}">DASHBOARD</a>
        <a href="{{ url('/adminAccount') }}">ACCOUNT</a>
        <a href="{{ url('/adminRecord') }}">RECORDS</a>
    </div>

</body>

</html>
