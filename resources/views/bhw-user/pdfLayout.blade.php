<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            text-align: center;
        }

        table {
            width: 80%; /* Adjust the width as needed */
            margin: auto;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Child Records</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item->lastname }}</td>
                <td>{{ $item->firstname }}</td>
                <td>{{ $item->middlename }}</td>
                <td>{{ $item->municipality }}</td>
                <td>{{ $item->barangay }}</td>
                <td>{{ $item->sitio }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
