<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Student Enrollments Report</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .title {
        font-size: 18px;
        font-weight: bold;
    }

    .date {
        font-size: 12px;
        color: #666;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background-color: #f8f8f8;
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
        font-size: 12px;
    }

    td {
        padding: 8px;
        border: 1px solid #ddd;
        font-size: 12px;
    }

    .footer {
        margin-top: 20px;
        text-align: right;
        font-size: 10px;
        color: #666;
    }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Student Enrollments Report</div>
        <div class="date">Generated on: {{ now()->format('F j, Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Section</th>
                <th>Enrollment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($enrollments as $enrollment)
            <tr>
                <td>{{ $enrollment->user->name }}</td>
                <td>{{ $enrollment->user->email }}</td>
                <td>{{ $enrollment->section->name ?? 'N/A' }}</td>
                <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total Enrollments: {{ $enrollments->count() }}
    </div>
</body>

</html>