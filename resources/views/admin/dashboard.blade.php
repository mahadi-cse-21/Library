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
                    <button id="sidebar-toggle" class="text-gray-500 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Librarian Dashboard</h2>
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
                                <p class="text-gray-500 text-sm">Total Books</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $total_books }}</h4>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-full">
                                <i class="fas fa-book text-indigo-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-500 text-xs font-semibold">+4.8%</span>
                            <span class="text-gray-400 text-xs">from last month</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Borrowed Today</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $borrowed_today }}</h4>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-exchange-alt text-green-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-500 text-xs font-semibold">+12.5%</span>
                            <span class="text-gray-400 text-xs">from yesterday</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Overdue</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $overdue_book_total }}</h4>
                            </div>
                            <div class="bg-red-100 p-3 rounded-full">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-red-500 text-xs font-semibold">+5.2%</span>
                            <span class="text-gray-400 text-xs">from last week</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Pending Returns</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $pending_returns }}</h4>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <i class="fas fa-clock text-yellow-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-yellow-500 text-xs font-semibold">-2.3%</span>
                            <span class="text-gray-400 text-xs">from last week</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities and Quick Actions -->
                <div class="grid grid-cols-1 gap-6 mb-8">


                    <!-- All Request-->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-800">All Request</h4>
                        </div>
                        <div class="p-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student ID</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Book Title</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Book ID</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Requested Date</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($requests as $request)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                {{ $request->student->student_id }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                {{ $request->book->title }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                {{ $request->book->id }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                                {{ $request->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                @if($request->status == 'pending')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @elseif($request->status == 'approved')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Approved
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Unknown
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                @if($request->status == 'pending')
                                                    <form action="{{ route('requests.approve', $request->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-white bg-green-500 hover:bg-green-700 font-semibold py-1 px-4 rounded">
                                                            Approve
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('requests.reject', $request->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-white bg-red-500 hover:bg-red-700 font-semibold py-1 px-4 rounded">
                                                            Reject
                                                        </button>
                                                    </form>
                                                @elseif($request->status == 'approved')
                                                    <button
                                                        class="bg-gray-300 text-white text-sm py-1 px-3 rounded-md cursor-not-allowed"
                                                        disabled>
                                                        Approve
                                                    </button>

                                                    <button
                                                        class="bg-gray-300 text-white text-sm py-1 px-3 rounded-md cursor-not-allowed"
                                                        disabled>
                                                        Reject
                                                    </button>


                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- Recent Activities -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h4 class="text-lg font-semibold text-gray-800">Recent Activities</h4>
                            <div>
                                <select id="activity-filter"
                                    class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="all">All Activities</option>
                                    <option value="borrow">Borrowings</option>
                                    <option value="return">Returns</option>
                                    <option value="request">Requests</option>
                                    <option value="overdue">Overdue Notices</option>
                                </select>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flow-root">
                                <ul class="divide-y divide-gray-200" id="activities-list">
                                    @foreach ($activities as $activity)
                                        <li class="py-3 flex items-start activity-item"
                                            data-type="{{ $activity->action_type }}">
                                            <div class="flex-shrink-0 mt-1">
                                                @if($activity->action_type == 'borrow')
                                                    <div class="bg-blue-100 p-2 rounded-full">
                                                        <i class="fas fa-book-reader text-blue-500"></i>
                                                    </div>
                                                @elseif($activity->action_type == 'return')
                                                    <div class="bg-green-100 p-2 rounded-full">
                                                        <i class="fas fa-undo text-green-500"></i>
                                                    </div>
                                                @elseif($activity->action_type == 'request')
                                                    <div class="bg-purple-100 p-2 rounded-full">
                                                        <i class="fas fa-hand-paper text-purple-500"></i>
                                                    </div>
                                                @elseif($activity->action_type == 'overdue')
                                                    <div class="bg-red-100 p-2 rounded-full">
                                                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                                                    </div>
                                                @else
                                                    <div class="bg-gray-100 p-2 rounded-full">
                                                        <i class="fas fa-cog text-gray-500"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <div class="flex justify-between">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $activity->description }}
                                                    </p>
                                                    <span
                                                        class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    @if($activity->user)
                                                        By {{ $activity->user->name }}
                                                    @endif
                                                    @if($activity->book)
                                                        • Book: {{ $activity->book->title }}
                                                    @endif
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-6 flex justify-between items-center">
                                <a href="{{ route('activities.index') }}"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                    View all activities
                                </a>
                                <div class="text-sm text-gray-500">
                                    Showing {{ count($activities) }} of {{ $total_activities }} activities
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- Overdue Books Table -->
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h4 class="text-lg font-semibold text-gray-800">Overdue Books</h4>
                        <div>
                            <a href="{{ route('overdue_books.pdf') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-800">Export as PDF</a>


                            <a href="{{ route('send.email') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-800">Send Notifications</a>

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
                                        Issue Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Days Overdue</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fine</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">

                                @foreach ($overdue_books as $overdue_book)


                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img src="{{ asset('storage/' . $overdue_book->student->user->img) }}"
                                                        alt="Student" class="h-10 w-10 rounded-full">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $overdue_book->student->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $overdue_book->student->student_id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $overdue_book->book_copy->book->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $overdue_book->book_copy->book->author }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $overdue_book->issue_date }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $overdue_book->due_date }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-red-600">
                                                {{ \Carbon\Carbon::parse($overdue_book->due_date)->diffInDays(\Carbon\Carbon::today()) }}
                                                days
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                ${{  \Carbon\Carbon::parse($overdue_book->due_date)->diffInDays(\Carbon\Carbon::today()) * 5 }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('notify', $overdue_book->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Notify</a>
                                            <a href="{{ route('borrow.return', $overdue_book->id) }}"
                                                class="text-green-600 hover:text-green-900">Return</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $overdue_books->links() }}
                    </div>

                </div>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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