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
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
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

    @page {
        size: landscape;
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
            <th>Municipality</th>
            <th>Barangay</th>
            <th>Sitio</th>
            <th>Birthday</th>
            <th>Age (Month)</th>
            <th>Sex</th>
            <th>Mother's Middle Name</th>
            <th>Mother's First Name</th>
            <th>Mother's Last Name</th>
            <th>Mother's Birthday</th>
            <th>Mother's Occupation</th>
            <th>Father's Last Name</th>
            <th>Father's First Name</th>
            <th>Father's Middle Name</th>
            <th>Father's Birthday</th>
            <th>Father's Occupation</th>
            <th>Contact Number</th>
            <th>Date Measured</th>
            <th>Height</th>
            <th>Weight</th>
            <th>BMI</th>
            <th>BMI Classification</th>
            <th>Medical Condition</th>
            <th>Vaccine Received</th>
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
                <td>{{ $item-> birthday }}</td>
                <td>{{ $item-> age}}</td>
                <td>{{ $item->sex }}</td>
                <td>{{ $item->mother_lastname }}</td>
                <td>{{ $item->mother_firstname }}</td>
                <td>{{ $item->mother_middlename }}</td>
                <td>{{ $item->mother_birthday }}</td>
                <td>{{ $item->mother_occupation }}</td>
                <td>{{ $item->father_lastname }}</td>
                <td>{{ $item->father_firstname }}</td>
                <td>{{ $item->father_middlename }}</td>
                <td>{{ $item->father_birthday }}</td>
                <td>{{ $item->father_occupation }}</td>
                <td>{{ $item->contact_number }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->height }}</td>
                <td>{{ $item->weight }}</td>
                <td>{{ $item->bmi }}</td>
                <td>{{ $item->bmi_classification }}</td>
                <td>{{ $item->medical_condition }}</td>
                <td>{{ $item->vaccine_received }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
