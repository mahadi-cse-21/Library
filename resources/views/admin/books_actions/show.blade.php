<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <style>
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
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Book Details</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('books.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Books
                    </a>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="flex flex-wrap md:flex-nowrap">
                        <!-- Book Cover Image -->
                        <div class="w-full md:w-1/3 p-6 flex justify-center items-start">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}"
                                    class="w-full max-w-xs rounded shadow">
                            @else
                                <div class="w-full max-w-xs h-64 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400 text-5xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Book Details -->
                        <div class="w-full md:w-2/3 p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h1 class="text-2xl font-bold text-gray-800">{{ $book->title }}</h1>
                                <div class="flex space-x-2">
                                    <a href="{{ route('books.edit', $book->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </a>
                                    <button onclick="openDeleteModal()"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-gray-600 mb-2"><span class="font-semibold">Author:</span>
                                        {{ $book->author }}</p>
                                    <p class="text-gray-600 mb-2"><span class="font-semibold">Category:</span>
                                        {{ $book->category->name }}</p>
                                </div>
                                <div>

                                    <p class="text-gray-600 mb-2"><span class="font-semibold">Total Copies:</span>
                                        {{ $book->quantity }}</p>
                                    <p class="text-gray-600 mb-2"><span class="font-semibold">Available Copies:</span>
                                        {{ $book->available_quantity }}</p>
                                    <p class="text-gray-600 mb-2">
                                        <span class="font-semibold">Status:</span>
                                        @php
                                            switch ($book->status) {
                                                case 'available':
                                                    $bgClass = 'bg-green-100 text-green-800';
                                                    break;
                                                case '1 Copy Left':
                                                    $bgClass = 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'All Copies Borrowed':
                                                    $bgClass = 'bg-red-100 text-red-800';
                                                    break;
                                                case 'processing':
                                                    $bgClass = 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    $bgClass = 'bg-gray-100 text-gray-800';
                                            }
                                        @endphp
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $bgClass }}">
                                            {{ $book->status }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h3 class="font-semibold text-gray-800 mb-2">Description</h3>
                                <p class="text-gray-600">{{ $book->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Borrowing History -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-800">Borrowing History</h3>
                    </div>
                    <div class="overflow-x-auto w-full">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-gray-500 uppercase font-medium whitespace-nowrap">Borrower
                                    </th>
                                    <th class="px-6 py-3 text-gray-500 uppercase font-medium whitespace-nowrap">Borrowed
                                        Date</th>
                                    <th class="px-6 py-3 text-gray-500 uppercase font-medium whitespace-nowrap">Due Date
                                    </th>
                                    <th class="px-6 py-3 text-gray-500 uppercase font-medium whitespace-nowrap">Return
                                        Date</th>
                                    <th class="px-6 py-3 text-gray-500 uppercase font-medium whitespace-nowrap">Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @if($borrows->count() > 0)
                                    @foreach($borrows as $borrowing)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $borrowing->student->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $borrowing->issue_date }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $borrowing->due_date }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $borrowing->return_date ?? 'Not returned' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($borrowing->status === 'returned')
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Returned</span>
                                                @elseif($borrowing->status === 'overdue')
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Overdue</span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Borrowed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No borrowing records
                                            found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="text-lg font-medium text-gray-900">Confirm Deletion</h3>
                    <button type="button" onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mt-4">
                    <p class="text-gray-600">Are you sure you want to delete this book? This action cannot be undone.
                    </p>
                </div>

                <div class="flex items-center justify-end pt-3 border-t mt-4">
                    <button type="button" onclick="closeDeleteModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 mr-2 px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                            Delete Book
                        </button>
                    </form>
                </div>
            </div>
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

        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</body>

</html>