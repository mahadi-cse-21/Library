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
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Edit Book</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('books.show', $book->id) }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Book Details
                    </a>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Please fix the following errors:</p>
                        <ul class="list-disc ml-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-lg shadow-md p-6">
                    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                            </div>
                            <div>
                                <label for="author" class="block text-gray-700 font-medium mb-2">Author</label>
                                <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                                <select id="category_id" name="category_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                             <div>
                                <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                                <select id="status" name="status"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="1 Copy Left" {{ old('status', $book->status) == '1 Copy Left' ? 'selected' : '' }}>1 Copy Left</option>
                                    <option value="All Copies Borrowed" {{ old('status', $book->status) == 'All Copies Borrowed' ? 'selected' : '' }}>All Copies Borrowed</option>
                                    <option value="processing" {{ old('status', $book->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                </select>
                            </div>
                        
                        </div>

                       

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="quantity" class="block text-gray-700 font-medium mb-2">Total Copies</label>
                                <input type="number" min="0" id="quantity" name="quantity" value="{{ old('quantity', $book->quantity) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="available_quantity" class="block text-gray-700 font-medium mb-2">Available Copies</label>
                                <input type="number" min="0" id="available_quantity" name="available_quantity" value="{{ old('available_quantity', $book->available_quantity) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $book->description) }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Cover Image</label>
                            <div class="flex items-center">
                                @if($book->cover)
                                    <div class="w-32 h-32 mr-4 relative">
                                        <img src="{{ asset('storage/' . $book->cover) }}" alt="Current cover" class="w-full h-full object-cover rounded">
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <input type="file" id="cover" name="cover" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <p class="text-gray-500 text-sm mt-1">Leave empty to keep the current image</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('books.show', $book->id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md mr-2">
                                Cancel
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                                Update Book
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Add this script to make sure the sidebar functions properly
        document.addEventListener('DOMContentLoaded', function() {
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
                sidebarToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }
            
            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', toggleSidebar);
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
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