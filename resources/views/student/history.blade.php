<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Borrowing History</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    @if (session('status'))
    <div class="mb-4 p-4 rounded text-green-800 bg-green-100 border border-green-200">
        {{ session('status') }}
    </div>
@endif

    <div class="min-h-screen flex flex-col">
        <!-- Main Layout -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            @include('layouts.studentsidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Navigation -->
                <header class="bg-white shadow-md px-6 py-4 flex items-center justify-between sticky top-0 z-10">
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-700 hover:text-indigo-600 focus:outline-none lg:hidden transition-colors duration-300">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-2xl font-bold text-gray-800">My Borrowing History</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search for books..."
                                class="w-64 md:w-80 pr-10 pl-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm transition-all duration-300">
                            <button class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-600 transition-colors duration-300">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <button class="relative p-2 rounded-full hover:bg-gray-100 focus:outline-none transition-colors duration-300">
                            <i class="fas fa-bell text-gray-600 text-lg"></i>
                            <span class="absolute h-2.5 w-2.5 top-1.5 right-1.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                    </div>
                </header>

                <!-- Main Dashboard Content -->
                <main class="flex-1 overflow-y-auto bg-gray-100 p-4 md:p-6 lg:p-8">
                    <!-- Overview Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Currently Borrowed</p>
                                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ count($currentBorrows) }}</h3>
                                </div>
                                <div class="h-14 w-14 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-indigo-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Pending Requests</p>
                                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ count($requests) }}</h3>
                                </div>
                                <div class="h-14 w-14 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Returned This Month</p>
                                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $return_this_month }}</h3>
                                </div>
                                <div class="h-14 w-14 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Outstanding Fines</p>
                                    <h3 class="text-3xl font-bold text-gray-800 mt-1">$2.50</h3>
                                </div>
                                <div class="h-14 w-14 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-dollar-sign text-red-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <form method="GET" action="#">
                        <div class="bg-white rounded-xl shadow-md p-6 mb-8 transition-all duration-300 hover:shadow-lg">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="mb-4 md:mb-0">
                                    <h2 class="text-xl font-bold text-gray-800">Borrowing History</h2>
                                    <p class="text-gray-600 mt-1">View your complete library interaction history.</p>
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    <select name="status" onchange="this.form.submit()"
                                        class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 shadow-sm">
                                        <option value="">All Status</option>
                                        <option value="requested">Requested</option>
                                        <option value="approved">Approved</option>
                                        <option value="borrowed" selected>Currently Borrowed</option>
                                        <option value="returned">Returned</option>
                                        <option value="overdue">Overdue</option>
                                        <option value="rejected">Rejected</option>
                                    </select>

                                    <select name="sort" onchange="this.form.submit()"
                                        class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 shadow-sm">
                                        <option value="latest" selected>Most Recent</option>
                                        <option value="oldest">Oldest First</option>
                                    </select>

                                    <select name="time" onchange="this.form.submit()"
                                        class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 shadow-sm">
                                        <option value="all">All Time</option>
                                        <option value="month" selected>Last Month</option>
                                        <option value="semester">This Semester</option>
                                        <option value="year">This Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Current Borrows Section -->
                    <div class="mb-10">
                        <div class="flex items-center mb-4">
                            <div class="w-1 h-8 bg-indigo-500 rounded-full mr-3"></div>
                            <h3 class="text-xl font-bold text-gray-800">Currently Borrowed Books</h3>
                        </div>
                        <div class="overflow-x-auto border rounded-xl shadow-md bg-white">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SI NO</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowed</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>

                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach ($currentBorrows as $book)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-4 py-4">
                                                <?php echo $cnt;
                                                $cnt++;
                                                ?>
                                            </td>
                                            <td class="px-4 py-4 font-semibold text-gray-800">{{ $book->book->title }}</td>
                                            <td class="px-4 py-4">{{ $book->book->author }}</td>
                                            <td class="px-4 py-4">
                                                <span class="px-3 py-1 text-xs rounded-full font-medium
                                                    @if ($book->status == 'borrowed')
                                                        bg-blue-100 text-blue-800
                                                    @elseif ($book->status == 'overdue')
                                                        bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($book->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4">{{ \Carbon\Carbon::parse($book->issue_date)->format('M d, Y') }}</td>
                                            <td class="px-4 py-4">
                                                <span class="
                                                    @if ($book->status == 'borrowed' && \Carbon\Carbon::parse($book->due_date)->isToday())
                                                        text-green-600
                                                    @elseif ($book->status == 'overdue')
                                                        text-red-600
                                                    @endif
                                                    font-medium">
                                                    {{ \Carbon\Carbon::parse($book->due_date)->format('M d, Y') }}
                                                    ({{ \Carbon\Carbon::parse($book->due_date)->diffInDays(\Carbon\Carbon::today()) }}
                                                    @if($book->status == 'borrowed') days left
                                                    @elseif($book->status == 'overdue') overdue
                                                    @else days left
                                                    @endif)
                                                </span>
                                            </td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $currentBorrows->links() }}
                        </div>
                    </div>

                    <!-- Pending Requests Section -->
                    <div class="mb-10">
                        <div class="flex items-center mb-4">
                            <div class="w-1 h-8 bg-yellow-500 rounded-full mr-3"></div>
                            <h3 class="text-xl font-bold text-gray-800">Pending Requests</h3>
                        </div>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Book</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Requested Date</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($requests as $request)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-12 w-12">
                                                            <img class="h-12 w-12 rounded-lg object-cover shadow-sm"
                                                                src="{{ asset('storage/'.$request->book->cover) }}" alt="Book cover">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $request->book->title }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">{{ $request->book->author }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $request->requested_date }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Requested
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('student.history.cancel', $request->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this request?');" style="display:inline;">
    @csrf
    <button type="submit" class="text-red-600 hover:text-red-900 inline-block px-3 py-1 rounded hover:bg-red-50 transition-colors duration-200">
        Cancel
    </button>
</form> </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Borrowing History Section -->
                    <div class="mb-10">
                        <div class="flex items-center mb-4">
                            <div class="w-1 h-8 bg-green-500 rounded-full mr-3"></div>
                            <h3 class="text-xl font-bold text-gray-800">Complete History</h3>
                        </div>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <!-- Add a wrapper div for scrollable table -->
                            <div class="overflow-x-auto max-w-full">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Book</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Borrowed Date</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Returned Date</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Fine</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($borrows as $borrow)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-12 w-12">
                                                            <img class="h-12 w-12 rounded-lg object-cover shadow-sm" 
                                                                src="{{ asset('storage/'.$borrow->book->cover) }} " 
                                                                alt="Book cover">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $borrow->book->title }}</div>
                                                            <div class="text-sm text-gray-500">{{ $borrow->book->author }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($borrow->issue_date)->format('M d, Y') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($borrow->return_date)->format('M d, Y') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $today = \Carbon\Carbon::today();
                                                    @endphp
                                                
                                                    @if($borrow->status === 'returned')
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Returned
                                                        </span>
                                                    @elseif($borrow->due_date < $today)
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Overdue
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            {{ ucfirst($borrow->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if(false)
                                                        <span class="text-sm text-red-600 font-medium">$ (Unpaid)</span>
                                                    @else
                                                        <span class="text-sm text-gray-500">No fine</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white rounded-xl shadow-md p-4 flex flex-col sm:flex-row items-center justify-between">
                        <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                            Showing <span class="font-medium">{{ $borrows->firstItem() }}</span> to <span class="font-medium">{{ $borrows->lastItem() }}</span> of <span class="font-medium">{{ $borrows->total() }}</span> results
                        </div>
                        <div class="flex space-x-1">
                            {{ $borrows->links() }}
                        </div>
                    </div>
                </main>

                <!-- Footer -->
                <footer class="bg-white shadow-md py-6 mt-auto">
                    <div class="container mx-auto px-6">
                        <div class="flex flex-col md:flex-row items-center justify-between">
                            <div class="text-center md:text-left text-sm text-gray-600 mb-4 md:mb-0">
                                &copy; 2025 University Library Management System. All rights reserved.
                            </div>
                            <div class="flex space-x-6">
                                <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors duration-300" aria-label="Facebook">
                                    <i class="fab fa-facebook-f text-lg"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors duration-300" aria-label="Twitter">
                                    <i class="fab fa-twitter text-lg"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors duration-300" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in text-lg"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors duration-300" aria-label="Instagram">
                                    <i class="fab fa-instagram text-lg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.querySelector('button i.fa-bars');
            const sidebar = document.getElementById('sidebar');
    
            toggleButton?.parentElement?.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>