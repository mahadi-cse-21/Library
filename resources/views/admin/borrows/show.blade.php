
@section('title', 'Borrow Details - BR-' . $borrow->id)

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">

    <h1 class="text-2xl font-bold mb-6">Borrow Details (BR-{{ $borrow->id }})</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Student Info -->
        <div>
            <h2 class="text-xl font-semibold mb-2">Student Information</h2>
            <p><strong>ID:</strong> ST-{{ $borrow->student->student_id }}</p>
            <p><strong>Name:</strong> {{ $borrow->student->name }}</p>
            <p><strong>Email:</strong> {{ $borrow->student->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $borrow->student->phone ?? 'N/A' }}</p>
        </div>

        <!-- Book Info -->
        <div>
            <h2 class="text-xl font-semibold mb-2">Book Information</h2>
            <p><strong>ID:</strong> BK-{{ $borrow->book->id }}</p>
            <p><strong>Title:</strong> {{ $borrow->book->title }}</p>
            <p><strong>Author:</strong> {{ $borrow->book->author ?? 'Unknown' }}</p>
            <p><strong>Publisher:</strong> {{ $borrow->book->publisher ?? 'Unknown' }}</p>
        </div>
    </div>

    <!-- Borrowing Info -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Borrowing Details</h2>
        <p><strong>Issue Date:</strong> {{ $borrow->issue_date }}</p>
        <p><strong>Due Date:</strong> {{ $borrow->due_date }}</p>
        <p><strong>Return Date:</strong> {{ $borrow->return_date ? $borrow->return_date : 'Not Returned Yet' }}</p>
        <p><strong>Status:</strong>
            <span
                class="inline-block px-3 py-1 rounded-full text-white
                    {{ $borrow->status === 'Active' ? 'bg-blue-600' : '' }}
                    {{ $borrow->status === 'Overdue' ? 'bg-red-600' : '' }}
                    {{ $borrow->status === 'Returned' ? 'bg-green-600' : '' }}
                    {{ $borrow->status === 'Lost' ? 'bg-yellow-600' : '' }}
                ">
                {{ $borrow->status }}
            </span>
        </p>
        <p><strong>Notes:</strong> {{ $borrow->notes ?? 'No notes' }}</p>
    </div>

    <div class="flex space-x-4">
        <a href="{{ route('borrows.index') }}"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-700">
            Back to List
        </a>

        @if ($borrow->status === 'Active')
        <a href="{{ route('borrow.return', $borrow->id) }}"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Mark as Returned
        </a>
        @endif
    </div>
</div>
@endsection
