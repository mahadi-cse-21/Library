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
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Reservations</h2>
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

            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <!-- Dashboard Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Total Reservations</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $total_reservations }}</h4>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-bookmark text-purple-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-500 text-xs font-semibold">+3.2%</span>
                            <span class="text-gray-400 text-xs">from last month</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Active Reservations</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $active_reservations }}</h4>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-clock text-blue-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-500 text-xs font-semibold">+5.8%</span>
                            <span class="text-gray-400 text-xs">from last week</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Expired Reservations</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $expired_reservations }}</h4>
                            </div>
                            <div class="bg-red-100 p-3 rounded-full">
                                <i class="fas fa-calendar-times text-red-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-red-500 text-xs font-semibold">+2.7%</span>
                            <span class="text-gray-400 text-xs">from last week</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Converted to Borrows</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $converted_to_borrowed }}</h4>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-exchange-alt text-green-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-500 text-xs font-semibold">+8.3%</span>
                            <span class="text-gray-400 text-xs">from last month</span>
                        </div>
                    </div>
                </div>

                <!-- Active Reservations Table -->
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h4 class="text-lg font-semibold text-gray-800">Active Reservations</h4>
                        <div>
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                                <i class="fas fa-plus mr-2"></i>New Reservation
                            </button>
                            <button class="text-sm text-indigo-600 hover:text-indigo-800 ml-3">
                                <i class="fas fa-file-export mr-1"></i>Export
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Book</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reserved Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Expiry Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                             
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img src="{{ asset('storage/' . $reservation->student->user->img) }}"
                                                        alt="Student" class="h-10 w-10 rounded-full">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $reservation->student->user->name }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $reservation->student->student_id }} </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900"> {{ $reservation->book->title }} </div>
                                            <div class="text-sm text-gray-500">{{  $reservation->book->id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $reservation->reservation_date }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $reservation->expiry_date}}</div>
                                            <div class="text-sm text-gray-500"></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($reservation->status == 'pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                            @elseif($reservation->status == 'confirmed')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Confirmed
                                            </span>
                                            @elseif($reservation->status == 'cancelled')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Cancelled
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($reservation->status == 'pending')
                                            <a href="#"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Convert to Borrow</a>
                                            <a href="#"
                                                class="text-red-600 hover:text-red-900">Cancel</a>
                                            @elseif ($reservation->status=='cancelled')
                                            <button disabled
                                                class="bg-red-300 text-white text-sm py-1 px-3 rounded-md cursor-not-allowed">
                                                Cancelled
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex justify-between">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of
                                <span class="font-medium"></span> results
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">Previous</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-indigo-600 text-white">1</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">2</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">3</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">Next</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expired Reservations -->
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800">Expired Reservations</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Book</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reserved Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Expired On</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Days Expired</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($reservations as $reservation)
                                    @if ($reservation->expiry_date < \Carbon\Carbon::today())
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img src="{{ asset('storage/'.$reservation->student->user->img) }}" alt="Student" class="h-10 w-10 rounded-full">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $reservation->student->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">{{ $reservation->student->student_id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"> {{ $reservation->book->title }} </div>
                                                <div class="text-sm text-gray-500">{{  $reservation->book->id }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $reservation->reservation_date }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $reservation->expiry_date }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-red-600">
                                                    {{ \Carbon\Carbon::parse($reservation->expiry_date)->diffInDays(\Carbon\Carbon::today()) }} days
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex justify-between">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of
                                <span class="font-medium"></span> results
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">Previous</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-indigo-600 text-white">1</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">2</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">Next</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservation Statistics -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Reservation Statistics</h4>
                        <div class="h-64 flex items-center justify-center">
                            <!-- Chart would go here in a real implementation -->
                            <div class="text-gray-400">Reservation trends chart</div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Most Reserved Books</h4>
                        <div class="flow-root">
                            <ul class="divide-y divide-gray-200">
                                @foreach ($mostReservedBooks as $mostReservedBook)
                                <li class="py-3 flex justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-indigo-100 p-2 rounded-full">
                                            <i class="fas fa-book text-indigo-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $mostReservedBook->book->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $mostReservedBook->book->category->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $mostReservedBook->total }}
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
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