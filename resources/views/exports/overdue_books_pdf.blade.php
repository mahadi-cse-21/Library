<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Overdue Books Report</title>
   
    <style>
        body {
            font-family: 'notosansbengali', sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            font-family: 'notosansbengali', sans-serif;
        }
    </style>
</head>
<body>
    <h2>Overdue Books Report</h2>
    <table>
        <thead>
            <tr>
                <th>Student</th>
                <th>Book</th>
                <th>Issue Date</th>
                <th>Due Date</th>
                <th>Days Overdue</th>
                <th>Fine</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($overdue_books as $overdue)
                <tr>
                    <td>
                        {{ $overdue->student->user->name }}<br>
                        ID: {{ $overdue->student->student_id }}
                    </td>
                    <td>
                        {{ $overdue->book_copy->book->title }}<br>
                        Author: {{ $overdue->book_copy->book->author }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($overdue->issue_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($overdue->due_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($overdue->due_date)->diffInDays(\Carbon\Carbon::today()) }}</td>
                    <td>${{ \Carbon\Carbon::parse($overdue->due_date)->diffInDays(\Carbon\Carbon::today()) * 5 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
