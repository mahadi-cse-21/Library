<!DOCTYPE html>
<html>

<head>
    <title>Request Canceled</title>
</head>

<body>
    <h2>Hello {{ $details['student']->user->name }},</h2>

    @if ($details['request']->status === 'approved')
        <p>Your request  has been approved</p>
        <h2>Details</h2>
        <p>Book Name: {{ $details['book']->title }} </p>
        <p>Atuhor Name: {{ $details['book']->author }} </p>
        
        
        <p>Borrow Date: {{ \Carbon\Carbon::parse($details['borrow']->issue_date ?? now())->format('F j, Y') }}</p>
        <p>Due Date: {{ \Carbon\Carbon::parse($details['borrow']->due_date ?? now())->format('F j, Y') }}</p>
        <p>Librarian: {{ Auth::user()->name }} </p>
    @elseif ($details['status'] === 'rejected')
        <p>We're sorry. Your request for the book <strong>{{ $details['book']->title }}</strong> was
            <strong>rejected</strong>.</p>
   @elseif ($details['status'] === 'canceled')
        <p>You canceled  your request for the book <strong>{{ $details['book']->title }}</strong>.</p>
   
     @endif

    <p>Thank you,<br>Library Management System</p>
   
</body>

</html>