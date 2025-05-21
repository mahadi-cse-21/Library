<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Borrowing History</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Main Layout -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            @include('layouts.studentsidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden"> <!-- Top Navigation -->
                <header class="bg-white shadow-sm px-6 py-3 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 focus:outline-none lg:hidden">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2 class="text-xl font-bold text-gray-800">My Borrowing History</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search for books..."
                                class="w-72 pr-10 pl-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <button class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <button class="relative p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                            <i class="fas fa-bell text-gray-500"></i>
                            <span class="absolute h-2 w-2 top-2 right-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </header>

                <!-- Main Dashboard Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                    <!-- Overview Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Currently Borrowed</p>
                                    <h3 class="text-2xl font-bold text-gray-800 mt-1">3</h3>
                                </div>
                                <div class="h-12 w-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-indigo-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Pending Requests</p>
                                    <h3 class="text-2xl font-bold text-gray-800 mt-1">1</h3>
                                </div>
                                <div class="h-12 w-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Returned This Month</p>
                                    <h3 class="text-2xl font-bold text-gray-800 mt-1">7</h3>
                                </div>
                                <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Outstanding Fines</p>
                                    <h3 class="text-2xl font-bold text-gray-800 mt-1">$2.50</h3>
                                </div>
                                <div class="h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-dollar-sign text-red-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <form method="GET" action="#">
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800">Borrowing History</h2>
                                    <p class="text-gray-600 mt-1">View your complete library interaction history.</p>
                                </div>
                                <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
                                    <select name="status" onchange="this.form.submit()"
                                        class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                                        <option value="">All Status</option>
                                        <option value="requested">Requested</option>
                                        <option value="approved">Approved</option>
                                        <option value="borrowed" selected>Currently Borrowed</option>
                                        <option value="returned">Returned</option>
                                        <option value="overdue">Overdue</option>
                                        <option value="rejected">Rejected</option>
                                    </select>

                                    <select name="sort" onchange="this.form.submit()"
                                        class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                                        <option value="latest" selected>Most Recent</option>
                                        <option value="oldest">Oldest First</option>
                                    </select>

                                    <select name="time" onchange="this.form.submit()"
                                        class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
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
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Currently Borrowed Books</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                        @foreach ($currentBorrows as $book)
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden transition transform hover:shadow-md hover:-translate-y-1">
                                <div class="flex border-b border-gray-100">
                                    <div class="w-28 h-32 bg-gray-200 flex-shrink-0">
                                        <img src="{{ asset('storage/' . $book->book->cover) }}" alt="Book Cover" class="w-full h-full object-cover">
                                    </div>
                                    <div class="p-4 flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-semibold text-gray-800 mb-1">{{ $book->book->title }}</h4>
                                                <p class="text-sm text-gray-600">{{ $book->book->author }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if ($book->status == 'borrowed')
                                                    bg-blue-100 text-blue-800
                                                @elseif ($book->status == 'overdue')
                                                    bg-red-100 text-red-800
                                              
                                                @endif
                                                font-medium">
                                                {{ ucfirst($book->status) }}
                                            </span>
                                        </div>
                                        <div class="mt-3 text-xs text-gray-500">
                                            <div class="flex justify-between mb-1">
                                                <span>Borrowed:</span>
                                                <span class="font-medium">{{ \Carbon\Carbon::parse($book->issue_date)->format('M d, Y') }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Due Date:</span>
                                                <span class="font-medium 
                                                    @if ($book->status == 'borrowed' && \Carbon\Carbon::parse($book->due_date)->isToday())
                                                        text-green-600
                                                    @elseif ($book->status == 'overdue')
                                                        text-red-600
                                                   
                                                    @endif
                                                    ">
                                                    {{ \Carbon\Carbon::parse($book->due_date)->format('M d, Y') }} 
                                                    ({{ \Carbon\Carbon::parse($book->due_date)->diffInDays(\Carbon\Carbon::today()) }} 
                                                    @if($book->status == 'borrowed') days left @elseif($book->status == 'overdue') overdue @else days left @endif)
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 flex justify-between items-center">
                                    <div class="flex items-center">
                                        <i class="fas fa-barcode text-gray-400 mr-2"></i>
                                        <span class="text-xs text-gray-500">CODE: {{$book->book->barcode }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View</a>
                                        @if($book->status == 'borrowed')
                                            <button class="text-sm text-green-600 hover:text-green-800 font-medium">Renew</button>
                                        @elseif($book->status == 'overdue')
                                            <button class="text-sm text-red-600 hover:text-red-800 font-medium">Return</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination Links -->
                    <div class="mt-6">
                        {{ $currentBorrows->links() }}
                    </div>
                    
                    

                    <!-- Pending Requests Section -->
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Pending Requests</h3>
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
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
                                @foreach ($requests as $request )
                                    

                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-md object-cover"
                                                    src="{{ asset('storage/'.$request->bookCopy->book->cover) }}" alt="Book cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $request->bookCopy->book->title }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $request->bookCopy->book->author }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $request->requested_date }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Requested
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">View Book</a>
                                        <button class="text-red-600 hover:text-red-900">Cancel</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Borrowing History Section -->
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Complete History</h3>
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
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
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-md object-cover" 
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
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Returned
                                                    </span>
                                                @elseif($borrow->due_date < $today)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Overdue
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        {{ $borrow->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    
                                                @endphp
                                                @if(false)
                                                    <span class="text-sm text-red-600">$ (Unpaid)</span>
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
                    

                    <!-- Pagination -->
                    <div class="bg-white rounded-xl shadow-sm p-4 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $borrows->firstItem() }}</span> to <span class="font-medium">{{ $borrows->lastItem() }}</span> of <span class="font-medium">{{ $borrows->total() }}</span> results
                        </div>
                        <div class="flex space-x-1">
                            {{ $borrows->links() }}
                        </div>
                    </div>
                </main>

                <!-- Footer -->
                <footer class="bg-white p-4 shadow mt-auto">
                    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
                        <div class="text-center md:text-left text-sm text-gray-500">
                            &copy; 2025 University Library Management System. All rights reserved.
                        </div>
                        <div class="mt-2 md:mt-0 flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-indigo-600" aria-label="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600" aria-label="LinkedIn">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </footer>
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