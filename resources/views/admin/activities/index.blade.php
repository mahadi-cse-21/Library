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
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('Failed'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('Failed') }}</span>
        </div>
    @endif

    <!-- Add the overlay div here -->
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
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Library Activities</h2>
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

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Library Activities</h1>
                        <div class="flex space-x-4">
                            <select id="type-filter" name="type" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach ($types as $value => $label)
                                    <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <form action="{{ route('activities.index') }}" method="GET" class="flex">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Search activities..." 
                                    class="border-gray-300 rounded-l-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white shadow overflow-hidden rounded-lg">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Description
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Book
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Time
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($activities as $activity)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($activity->action_type == 'borrow')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Borrow
                                                    </span>
                                                @elseif($activity->action_type == 'return')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Return
                                                    </span>
                                                @elseif($activity->action_type == 'request')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                        Request
                                                    </span>
                                                @elseif($activity->action_type == 'overdue')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Overdue
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst($activity->action_type) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $activity->description }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($activity->user)
                                                    <div class="text-sm text-gray-900">{{ $activity->user->name }}</div>
                                                @else
                                                    <div class="text-sm text-gray-500">-</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($activity->book)
                                                    <div class="text-sm text-gray-900">{{ $activity->book->title }}</div>
                                                    <div class="text-xs text-gray-500">ID: {{ $activity->book->id }}</div>
                                                @else
                                                    <div class="text-sm text-gray-500">-</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($activity->student)
                                                    <div class="text-sm text-gray-900">{{ $activity->student->user->name }}</div>
                                                    <div class="text-xs text-gray-500">ID: {{ $activity->student->student_id }}</div>
                                                @else
                                                    <div class="text-sm text-gray-500">-</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $activity->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $activity->created_at->format('H:i A') }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No activities found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $activities->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Activity filter functionality
            const typeFilter = document.getElementById('type-filter');
            
            typeFilter.addEventListener('change', function() {
                const searchParams = new URLSearchParams(window.location.search);
                searchParams.set('type', this.value);
                
                // Preserve search parameter if it exists
                const searchValue = document.querySelector('input[name="search"]').value;
                if (searchValue) {
                    searchParams.set('search', searchValue);
                }
                
                window.location.href = `${window.location.pathname}?${searchParams.toString()}`;
            });

            // Sidebar toggle functionality
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            // Check if we're on mobile
            const isMobile = () => window.innerWidth < 768;

            // Function to toggle sidebar
            function toggleSidebar() {
                if (isMobile()) {
                    // Toggle the hidden class
                    sidebar.classList.toggle('hidden');

                    // Add/remove mobile-sidebar class
                    sidebar.classList.toggle('mobile-sidebar');

                    // Toggle the overlay
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.toggle('active');
                    }

                    // Prevent body scrolling when sidebar is open
                    if (sidebar.classList.contains('mobile-sidebar')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                }
            }

            // Initialize sidebar state on page load
            if (isMobile() && sidebar) {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('mobile-sidebar'); // Ensure it doesn't have the mobile classes initially
            }

            // Toggle sidebar on button click
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function () {
                    if (sidebar.classList.contains('mobile-sidebar')) {
                        toggleSidebar();
                    }
                });
            }

            // Handle window resize
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) {
                    // Desktop view
                    if (sidebar) {
                        sidebar.classList.remove('mobile-sidebar');
                        sidebar.classList.remove('hidden');
                        sidebar.classList.add('md:block');

                        if (sidebarOverlay) {
                            sidebarOverlay.classList.remove('active');
                        }

                        document.body.style.overflow = '';
                    }
                } else {
                    // Mobile view - hide if not explicitly shown
                    if (sidebar && !sidebar.classList.contains('mobile-sidebar')) {
                        sidebar.classList.add('hidden');
                    }
                }
            });
        });
    </script>
</body>

</html>