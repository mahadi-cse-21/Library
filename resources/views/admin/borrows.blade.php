<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Create a specific mobile-sidebar class that handles the visibility */
        .mobile-sidebar {
            position: fixed !important;
            z-index: 50 !important;
            top: 0 !important;
            left: 0 !important;
            height: 100vh !important;
            width: 100% !important;
            max-width: 250px !important;
            background-color: white !important;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease !important;
        }

        /* Overlay for when the sidebar is open */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-100">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Sidebar Overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div id="sidebar" class="md:w-64 w-full md:block hidden">
            @include('layouts.adminsidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow flex items-center justify-between p-4">
                <div class="flex items-center">
                    <button id="sidebar-toggle" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Book Borrowing</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="flex items-center text-gray-500 focus:outline-none">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute top-0 right-0 h-2 w-2 mt-1 mr-2 bg-red-500 rounded-full"></span>
                    </button>
                    <button class="flex items-center text-gray-500 focus:outline-none">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <!-- Quick Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-blue-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Active Borrowings</p>
                                <p class="text-xl font-bold">{{ $activeborrow }}</p>
                            </div>
                            <div class="text-blue-500 text-2xl">
                                <i class="fas fa-book-reader"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-red-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Overdue Books</p>
                                <p class="text-xl font-bold">{{ $overduebooks }}</p>
                            </div>
                            <div class="text-red-500 text-2xl">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-green-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Returned Today</p>
                                <p class="text-xl font-bold">{{ $returnbook }}</p>
                            </div>
                            <div class="text-green-500 text-2xl">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-yellow-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Due Today</p>
                                <p class="text-xl font-bold">{{ $duetoday }}</p>
                            </div>
                            <div class="text-yellow-500 text-2xl">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Header with Actions -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 md:mb-0">Book Borrowing</h3>
                    <a href="#"
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 text-center w-full md:w-auto">
                        <i class="fas fa-plus mr-2"></i>New Borrowing
                    </a>
                </div>

                <!-- Search and Filters -->
                <div class="bg-white rounded-lg shadow mb-6 p-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <input type="text" placeholder="Search by book title or student ID..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <div class="absolute left-3 top-2.5 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status"
                                class="form-select w-full px-4 py-2 border border-gray-300 rounded-md">
                                <option>All Statuses</option>
                                <option>Active</option>
                                <option>Overdue</option>
                                <option>Returned</option>
                                <option>Lost</option>
                            </select>
                        </div>
                        <!-- Date Range -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                            <select id="date" name="date"
                                class="form-select w-full px-4 py-2 border border-gray-300 rounded-md">
                                <option>Date Range</option>
                                <option>Today</option>
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>This month</option>
                                <option>Custom range</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md text-white">
                            <i class="fas fa-filter mr-2"></i> Apply Filters
                        </button>
                    </div>
                </div>

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
                                @foreach ($borrows as $borrow)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">BR-{{ $borrow->id }}</td>
                                        <td class="px-4 py-3">ST-{{ $borrow->student->student_id }}</td>
                                        <td class="px-4 py-3">{{ $borrow->student->user->name }}</td>
                                        <td class="px-4 py-3">BK-{{ $borrow->book_id }}</td>
                                        <td class="px-4 py-3">{{ $borrow->book->title }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $borrow->issue_date }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $borrow->due_date}}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">{{ $borrow->status }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-right space-x-2">
                                            <!-- View Borrow Details -->
                                            <a href="{{ route('borrow.show', $borrow->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Return Book -->
                                            <a href="{{ route('borrow.return', $borrow->id) }}"
                                                class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-check-circle"></i>
                                            </a>

                                            <!-- Report Issue -->
                                            <a href=""
                                                class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </a>
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
                            Showing <strong>{{ $borrows->firstItem() }}</strong> to
                            <strong>{{ $borrows->lastItem() }}</strong> of
                            <strong>{{ $borrows->total() }}</strong> results
                        </div>

                        <nav class="flex space-x-1 items-center">
                            {{-- Previous Page Link --}}
                            @if ($borrows->onFirstPage())
                                <span class="px-3 py-1.5 border border-gray-300 text-gray-400 rounded-md">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $borrows->previousPageUrl() }}"
                                    class="px-3 py-1.5 border border-gray-300 text-gray-600 hover:bg-gray-100 rounded-md">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($borrows->getUrlRange(1, $borrows->lastPage()) as $page => $url)
                                @if ($page == $borrows->currentPage())
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
                            @if ($borrows->hasMorePages())
                                <a href="{{ $borrows->nextPageUrl() }}"
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
            </main>
        </div>
    </div>

    <script>
        // Add this script to make sure the sidebar functions properly
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            // Check if we're on mobile
            const isMobile = window.innerWidth < 768;

            // Function to toggle sidebar
            function toggleSidebar() {
                if (window.innerWidth < 768) {
                    sidebar.classList.toggle('hidden');
                    sidebar.classList.toggle('mobile-sidebar');
                    sidebarOverlay.classList.toggle('active');

                    // Prevent body scrolling when sidebar is open
                    if (sidebar.classList.contains('mobile-sidebar')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                }
            }

            // Hide sidebar initially on mobile
            if (isMobile && sidebar) {
                sidebar.classList.add('hidden');
            }

            // Toggle sidebar on button click
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function (e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', toggleSidebar);
            }

            // Handle window resize
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) {
                    if (sidebar) {
                        sidebar.classList.remove('mobile-sidebar');
                        sidebar.classList.remove('hidden');
                        sidebar.classList.add('md:block');

                        if (sidebarOverlay) {
                            sidebarOverlay.classList.remove('active');
                        }

                        document.body.style.overflow = '';
                    }
                } else if (window.innerWidth < 768) {
                    if (sidebar && !sidebar.classList.contains('mobile-sidebar')) {
                        sidebar.classList.add('hidden');
                    }
                }
            });
        });
    </script>
</body>

</html>