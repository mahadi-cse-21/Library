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
                    <button class="text-gray-500 focus:outline-none     ">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Student Dashboard</h2>
                </div>
                
            </header>

            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
               

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

                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($currentlyBorrows as $currentBorrow)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">BR-{{ $currentBorrow->id }}</td>
                                        <td class="px-4 py-3">ST-{{ $currentBorrow->student->student_id }}</td>
                                        <td class="px-4 py-3">{{ $currentBorrow->student->user->name }}</td>
                                        <td class="px-4 py-3">BK-{{ $currentBorrow->book_id }}</td>
                                        <td class="px-4 py-3">{{ $currentBorrow->book->title }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $currentBorrow->issue_date }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $currentBorrow->due_date}}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">{{ $currentBorrow->status }}</span>
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
                                    <span
                                        class="px-3 py-1.5 border border-indigo-600 bg-indigo-50 text-indigo-600 font-medium rounded-md">
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
                       
                       @foreach ($recentActivities as $activity)
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <div class="w-8 h-8 rounded-full 
                @if($activity->type == 'borrow') bg-blue-100 text-blue-500
                @elseif($activity->type == 'return') bg-green-100 text-green-500
                @elseif($activity->type == 'reserve') bg-yellow-100 text-yellow-500
                @else bg-gray-100 text-gray-500
                @endif
                flex items-center justify-center">
                <i class="fas 
                    @if($activity->type == 'borrow') fa-book-open
                    @elseif($activity->type == 'return') fa-check
                    @elseif($activity->type == 'reserve') fa-bookmark
                    @else fa-info-circle
                    @endif text-sm"></i>
            </div>
        </div>
        <div class="ml-4">
            <p class="text-sm text-gray-700">{{ $activity->description }}</p>
            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($activity->created_at)->format('M d, Y') }}</p>
        </div>
    </div>
@endforeach

                    </div>

                    <!-- Recommended Books -->
                   <div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-700">Recommended Books</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($recommendedBooks as $book)
                <div class="flex">
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Book cover" class="w-20 h-24 object-cover">
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-gray-900">{{ $book->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $book->author }}</p>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400 text-xs">
                                @php
                                    $fullStars = floor($book->rating);
                                    $halfStar = $book->rating - $fullStars >= 0.5;
                                @endphp
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @if ($halfStar)
                                    <i class="fas fa-star-half-alt"></i>
                                @endif
                                @for ($i = 0; $i < (5 - $fullStars - ($halfStar ? 1 : 0)); $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-1">{{ $book->rating }}</span>
                        </div>
                        <button class="mt-2 text-xs text-blue-600 hover:text-blue-800">Reserve</button>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="#" class="block text-center mt-4 text-sm text-blue-600 hover:text-blue-800">View More Recommendations</a>
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