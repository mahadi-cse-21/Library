<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Student Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">

        @include('layouts.studentsidebar')
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow flex items-center justify-between p-4">
                <div class="flex items-center">
                    <button class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Student Dashboard</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search for books..."
                            class="w-64 pr-8 pl-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button class="absolute right-2 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <button class="flex items-center text-gray-500 focus:outline-none relative">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute h-2 w-2 top-0 right-0 bg-red-500 rounded-full"></span>
                    </button>
                </div>
            </header>

            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <!-- Welcome Message & Status -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h2>
                            <p class="text-gray-600 mt-1">Here's what's happening with your library account today.</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="bg-blue-100 text-blue-800 py-2 px-4 rounded-lg font-medium text-sm">
                                <span>You can borrow </span>
                                <span class="font-bold">3 more books</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Currently Borrowed</p>
                                <h4 class="text-xl font-bold text-gray-700">{{ $currently }} Books</h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Next Due Date</p>
                                <h4 class="text-xl font-bold text-gray-700">{{ $nextdue ?? 'Not Borrowed Yet' }}</h4>

                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                <i class="fas fa-bookmark"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Reserved Books</p>
                                <h4 class="text-xl font-bold text-gray-700">{{ $reservedBook }} Book</h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Outstanding Fines</p>
                                <h4 class="text-xl font-bold text-gray-700">$0.00</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Currently Borrowed Books -->
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Currently Borrowed Books</h3>
                <!-- Borrowing Records Table -->
                <div class="bg-white rounded-lg shadow-md">
                    <!-- Add max-h to enable vertical scrolling and overflow-auto for both directions -->
                    <div class="overflow-auto max-h-[500px]">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-50 border-b border-gray-200 sticky top-0 z-10">
                                <tr>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Borrow ID</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Student ID</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Student Name</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Book ID</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Book Title</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Borrow Date</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Due Date</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Status</th>
                                    <th class="px-4 py-3 text-right text-gray-500 uppercase font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($currentlyBorrows as $currentBorrow)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">BR-{{ $currentBorrow->id }}</td>
                                        <td class="px-4 py-3">ST-{{ $currentBorrow->student->student_id }}</td>
                                        <td class="px-4 py-3">{{ $currentBorrow->student->name }}</td>
                                        <td class="px-4 py-3">BK-{{ $currentBorrow->book_copy_id }}</td>
                                        <td class="px-4 py-3">{{ $currentBorrow->book_copy->book->title }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $currentBorrow->issue_date }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $currentBorrow->due_date}}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">{{ $currentBorrow->status }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-right space-x-2">
                                            <a href=" " class="text-indigo-600 hover:text-indigo-900"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('borrow.return', $currentBorrow) }}"
                                                class="text-green-600 hover:text-green-900"><i
                                                    class="fas fa-check-circle"></i></a>
                                            <a href="#" class="text-red-600 hover:text-red-900"><i
                                                    class="fas fa-exclamation-circle"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        class="bg-white px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between border-t border-gray-200 text-sm">
                        <div class="text-gray-700 mb-2 sm:mb-0">
                            Showing <strong>{{ $currentlyBorrows->firstItem() }}</strong> to
                            <strong>{{ $currentlyBorrows->lastItem() }}</strong> of
                            <strong>{{ $currentlyBorrows->total() }}</strong> results
                        </div>

                        {{-- Show paginated items --}}
@foreach ($currentlyBorrows as $borrow)
<!-- Render each borrow item here -->
@endforeach

{{-- Pagination Controls --}}
<nav class="flex space-x-1 items-center mt-4">
{{-- Previous Page Link --}}
@if ($currentlyBorrows->onFirstPage())
    <span class="px-3 py-1.5 border border-gray-300 text-gray-400 rounded-md">
        <i class="fas fa-chevron-left"></i>
    </span>
@else
    <a href="{{ $currentlyBorrows->previousPageUrl() }}"
       class="px-3 py-1.5 border border-gray-300 text-gray-600 hover:bg-gray-100 rounded-md">
        <i class="fas fa-chevron-left"></i>
    </a>
@endif

{{-- Pagination Elements --}}
@foreach ($currentlyBorrows->getUrlRange(1, $currentlyBorrows->lastPage()) as $page => $url)
    @if ($page == $currentlyBorrows->currentPage())
        <span class="px-3 py-1.5 border border-indigo-600 bg-indigo-50 text-indigo-600 font-medium rounded-md">
            {{ $page }}
        </span>
    @else
        <a href="{{ $url }}"
           class="px-3 py-1.5 border border-gray-300 text-gray-600 hover:bg-gray-100 rounded-md">
            {{ $page }}
        </a>
    @endif
@endforeach

{{-- Next Page Link --}}
@if ($currentlyBorrows->hasMorePages())
    <a href="{{ $currentlyBorrows->nextPageUrl() }}"
       class="px-3 py-1.5 border border-gray-300 text-gray-600 hover:bg-gray-100 rounded-md">
        <i class="fas fa-chevron-right"></i>
    </a>
@else
    <span class="px-3 py-1.5 border border-gray-300 text-gray-400 rounded-md">
        <i class="fas fa-chevron-right"></i>
    </span>
@endif
</nav>

                    </div>
                </div>

                <!-- Recent Activities & Recommended Books -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Activities -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-700">Recent Activities</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                            <i class="fas fa-book-open text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-700">You borrowed <span class="font-medium">Data
                                                Structures and Algorithms</span></p>
                                        <p class="text-xs text-gray-500">Apr 15, 2025</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                            <i class="fas fa-check text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-700">You returned <span
                                                class="font-medium">Introduction to Database Systems</span></p>
                                        <p class="text-xs text-gray-500">Apr 8, 2025</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500">
                                            <i class="fas fa-bookmark text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-700">You reserved <span
                                                class="font-medium">Artificial Intelligence: A Modern Approach</span>
                                        </p>
                                        <p class="text-xs text-gray-500">Apr 5, 2025</p>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="block text-center mt-4 text-sm text-blue-600 hover:text-blue-800">View
                                All Activities</a>
                        </div>
                    </div>

                    <!-- Recommended Books -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-700">Recommended Books</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex">
                                    <img src="/api/placeholder/80/100" alt="Book cover" class="w-20 h-24 object-cover">
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Clean Code</h4>
                                        <p class="text-xs text-gray-500">Robert C. Martin</p>
                                        <div class="flex items-center mt-1">
                                            <div class="flex text-yellow-400 text-xs">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <span class="text-xs text-gray-500 ml-1">4.5</span>
                                        </div>
                                        <button class="mt-2 text-xs text-blue-600 hover:text-blue-800">Reserve</button>
                                    </div>
                                </div>
                                <div class="flex">
                                    <img src="/api/placeholder/80/100" alt="Book cover" class="w-20 h-24 object-cover">
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Design Patterns</h4>
                                        <p class="text-xs text-gray-500">Erich Gamma et al.</p>
                                        <div class="flex items-center mt-1">
                                            <div class="flex text-yellow-400 text-xs">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <span class="text-xs text-gray-500 ml-1">4.0</span>
                                        </div>
                                        <button class="mt-2 text-xs text-blue-600 hover:text-blue-800">Reserve</button>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="block text-center mt-4 text-sm text-blue-600 hover:text-blue-800">View
                                More Recommendations</a>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white p-4 shadow mt-auto">
                <div class="text-center text-sm text-gray-500">
                    &copy; 2025 University Library Management System. All rights reserved.
                </div>
            </footer>
        </div>
    </div>
</body>

</html>