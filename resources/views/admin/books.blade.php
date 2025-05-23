<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <style>
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
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Books Management</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('addnewbook') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md hidden md:flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add New Book
                    </a>
                    <button type="button" onclick="openCategoryModal()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md hidden md:flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add Category
                    </button>
                </div>
            </header>

            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <!-- Mobile-only Actions -->
                <div class="flex flex-col gap-4 md:hidden mb-6">
                    <a href="{{ route('addnewbook') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i> Add New Book
                    </a>
                    <button type="button" onclick="openCategoryModal()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i> Add New Category
                    </button>
                </div>

                <!-- Search and Filters -->
                <form method="GET" action="{{ route('books.index') }}">
                    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6">
                        <div class="flex flex-col lg:flex-row gap-4">
                            <!-- Search Input -->
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search books..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    <div class="absolute left-3 top-2.5 text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <select name="category"
                                class="w-full lg:w-48 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="">All Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Status Filter -->
                            <select name="status"
                                class="w-full lg:w-48 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="">All Statuses</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>
                                    Available</option>
                                <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed
                                </option>
                                <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved
                                </option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                            </select>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-md text-gray-700 w-full lg:w-auto">
                                <i class="fas fa-filter mr-2"></i> Apply Filters
                            </button>
                        </div>
                    </div>
                </form>


                <!-- Books Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Book ID</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Title</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Author</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Category</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Total Copy</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Available copy</th>
                                    <th class="px-4 py-3 text-gray-500 uppercase font-medium">Status</th>
                                    <th class="px-4 py-3 text-right text-gray-500 uppercase font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                  @php
                                    $cnt =1;
                                @endphp
                                @foreach ($books as $book)
                              
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">BK-@php
                                        echo $cnt;
                                        $cnt++;
                                        @endphp</td>
                                        <td class="px-4 py-3"> {{ $book->title }} </td>
                                        <td class="px-4 py-3 text-gray-600">{{ $book->author }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $book->category->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $book->quantity }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $book->available_quantity }}</td>
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

                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $bgClass }}">
                                                {{ $book->status }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3 text-right space-x-2">
                                            <a href="{{ route('books.show', $book->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('books.edit', $book->id) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- Dynamic Pagination -->
                    <div
                        class="bg-white px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between border-t border-gray-200 text-sm">
                        <!-- Result Count -->
                        <div class="text-gray-700 mb-2 sm:mb-0">
                            Showing <strong>{{ $books->firstItem() }}</strong> to
                            <strong>{{ $books->lastItem() }}</strong> of
                            <strong>{{ $books->total() }}</strong> results
                        </div>

                        <!-- Pagination Links -->
                        <div>
                            {{ $books->links() }}
                        </div>
                    </div>


                </div>
            </main>
        </div>
    </div>

    <!-- Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white ">

            <div class="mt-3">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="text-lg font-medium text-gray-900">Add New Category</h3>
                    <button type="button" onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="categoryForm" action="{{ route('category.store') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Category Name</label>
                        <input type="text" name="name" id="name"
                            class="w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="parent_id" class="block text-gray-700 font-medium mb-2">Parent Category
                            (Optional)</label>
                        <select name="parent_id" id="parent_id"
                            class="w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">-- None --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Description
                            (Optional)</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>

                    <div class="flex items-center justify-end pt-3 border-t mt-4">
                        <button type="button" onclick="closeCategoryModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 mr-2 px-4 py-2 rounded-md">
                            Cancel
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                            Save Category
                        </button>
                    </div>
                </form>
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

        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            // Reset form
            document.getElementById('categoryForm').reset();
        }
    </script>
</body>

</html>