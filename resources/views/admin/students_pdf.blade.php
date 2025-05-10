<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
        }
        table th {
            background-color: #f2f2f2;
        }
        img.profile {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        h1{
            text-align: center;
           
            font-family: 'Times New Roman', Times, serif;
            font-size: 36px;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Students List</h1>
    <table>
        <thead>
            <tr>
                <th>Profile Image</th>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Department</th>
                <th>Year</th>
                <th>Semester</th>
                <th>Status</th>
                <th>Books Borrowed</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                     <td>
                        @php
                            $imagePath = public_path('storage/' . $student->user->img);
                        @endphp
                        @if(file_exists($imagePath))
                            <img src="file://{{ $imagePath }}" class="profile" alt="Profile">
                        @else
                            <span>No image</span>
                        @endif
                    </td>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $student->department }}</td>
                    <td>{{ $student->year }}</td>
                    <td>{{ $student->semester }}</td>
                    <td>{{ $student->status }}</td>
                    <td>{{ $student->book_borrowed }}</td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
