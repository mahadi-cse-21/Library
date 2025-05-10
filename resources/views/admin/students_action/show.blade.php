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
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Student Details</h2>
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
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('students.index') }}" class="flex items-center text-indigo-600 hover:text-indigo-900">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Students List
                    </a>
                </div>

                <!-- Header with Actions -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 md:mb-0">Student Information</h3>
                    <div class="flex space-x-3">
                        <a href="{{ route('students.edit', $student->id) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            <i class="fas fa-edit mr-2"></i>Edit Student
                        </a>
                        @if($student->status == 'suspended')
                            <form action="{{ route('students.reactivate', $student->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                                    <i class="fas fa-user-check mr-2"></i>Reactivate Student
                                </button>
                            </form>
                        @else
                            {{-- <form action="{{ route('students.suspend', $student->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700">
                                    <i class="fas fa-user-slash mr-2"></i>Suspend Student
                                </button>
                            </form> --}}
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Student Profile Card -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="bg-indigo-600 p-4 text-white">
                            <h4 class="text-lg font-medium">Profile Information</h4>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-center mb-6">
                                @if($student->user->img)
                                    <img class="h-32 w-32 rounded-full object-cover border-4 border-indigo-100" 
                                        src="{{ asset('storage/' . $student->user->img) }}" 
                                        alt="{{ $student->user->name }}">
                                @else
                                    <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-indigo-100">
                                        <i class="fas fa-user text-gray-500 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="text-center mb-6">
                                <h5 class="text-xl font-semibold text-gray-800">{{ $student->user->name }}</h5>
                                <p class="text-sm text-gray-500">{{ $student->student_id }}</p>
                                
                                @php
                                    $statusClasses = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'suspended' => 'bg-red-100 text-red-800',
                                        'inactive' => 'bg-gray-100 text-gray-800',
                                        'graduated' => 'bg-blue-100 text-blue-800'
                                    ];
                                    $statusClass = $statusClasses[$student->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }} mt-2">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Email: </span>
                                    <span class="text-sm text-gray-900">{{ $student->user->email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Phone: </span>
                                    <span class="text-sm text-gray-900">{{ $student->user->phone ?? 'Not provided' }}</span>
                                </div>
                                {{-- <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Gender</span>
                                    <span class="text-sm text-gray-900">{{ ucfirst($student->gender) ?? 'Not specified' }}</span>
                                </div> --}}
                                {{-- <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Date of Birth</span>
                                    <span class="text-sm text-gray-900">{{ $student->dob ? date('M d, Y', strtotime($student->dob)) : 'Not provided' }}</span>
                                </div> --}}
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Registered: </span>
                                    <span class="text-sm text-gray-900">{{ $student->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="bg-indigo-600 p-4 text-white">
                            <h4 class="text-lg font-medium">Academic Information</h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500">Department</h5>
                                    <p class="text-gray-900">{{ $student->department }}</p>
                                </div>
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500">Year Level</h5>
                                    <p class="text-gray-900">{{ $student->year }}</p>
                                </div>
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500">Semester</h5>
                                    <p class="text-gray-900">{{ $student->semester ?? 'Not specified' }}</p>
                                </div>
                                {{-- <div>
                                    <h5 class="text-sm font-medium text-gray-500">Academic Status</h5>
                                    @php
                                        $academicStatusClasses = [
                                            'good standing' => 'bg-green-100 text-green-800',
                                            'probation' => 'bg-yellow-100 text-yellow-800',
                                            'warning' => 'bg-orange-100 text-orange-800'
                                        ];
                                        $academicStatusClass = $academicStatusClasses[$student->academic_status ?? ''] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded-full {{ $academicStatusClass }}">
                                        {{ ucfirst($student->academic_status ?? 'Not specified') }}
                                    </span>
                                </div> --}}
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500">Current GPA</h5>
                                    <p class="text-gray-900">{{ $student->gpa ?? 'Not available' }}</p>
                                </div>
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500">Advisor</h5>
                                    <p class="text-gray-900">{{ $student->advisor ?? 'Not assigned' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Library Activities -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="bg-indigo-600 p-4 text-white">
                            <h4 class="text-lg font-medium">Library Activities</h4>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg text-center">
                                    <span class="block text-2xl font-bold text-indigo-600">{{ $student->book_borrowed }}</span>
                                    <span class="text-sm text-gray-500">Total Borrowed</span>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg text-center">
                                    <span class="block text-2xl font-bold text-indigo-600">{{ $student->current_borrows }}</span>
                                    <span class="text-sm text-gray-500">Current Borrows</span>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg text-center">
                                    <span class="block text-2xl font-bold text-indigo-600">{{ $student->overdue_books ?? 0 }}</span>
                                    <span class="text-sm text-gray-500">Overdue Books</span>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg text-center">
                                    <span class="block text-2xl font-bold text-indigo-600">${{ $student->fines ?? '0.00' }}</span>
                                    <span class="text-sm text-gray-500">Total Fines</span>
                                </div>
                            </div>

                            <!-- Library Card Status -->
                            <div class="mb-6">
                                <h5 class="text-sm font-medium text-gray-500 mb-2">Library Card Status</h5>
                                @php
                                    $cardStatusClasses = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'expired' => 'bg-red-100 text-red-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                    $cardStatusClass = $cardStatusClasses[$student->library_card_status ?? 'active'] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 text-sm rounded-full {{ $cardStatusClass }}">
                                    {{ ucfirst($student->library_card_status ?? 'Active') }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">
                                    Expires: {{ $student->library_card_expiry ? date('M d, Y', strtotime($student->library_card_expiry)) : 'Not set' }}
                                </p>
                            </div>

                            <!-- Actions -->
                            {{-- <div class="space-y-2">
                                <a href="{{ route('students.library.history', $student->id) }}" class="block w-full px-4 py-2 bg-indigo-100 text-indigo-700 text-sm font-medium rounded-md hover:bg-indigo-200 text-center">
                                    <i class="fas fa-history mr-2"></i>View Borrowing History
                                </a>
                                <a href="{{ route('students.library.current', $student->id) }}" class="block w-full px-4 py-2 bg-indigo-100 text-indigo-700 text-sm font-medium rounded-md hover:bg-indigo-200 text-center">
                                    <i class="fas fa-book mr-2"></i>Current Borrowed Books
                                </a>
                                @if($student->fines > 0)
                                <a href="{{ route('students.library.fines', $student->id) }}" class="block w-full px-4 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-md hover:bg-red-200 text-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>Manage Fines
                                </a>
                                @endif
                            </div> --}}
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                {{-- <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($activities as $activity)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $activity->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $activity->type }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $activity->details }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $activityStatusClasses = [
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'overdue' => 'bg-red-100 text-red-800',
                                                    'cancelled' => 'bg-gray-100 text-gray-800'
                                                ];
                                                $activityStatusClass = $activityStatusClasses[$activity->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activityStatusClass }}">
                                                {{ ucfirst($activity->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-sm text-gray-500 text-center">No recent activities found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if(isset($activities) && count($activities) > 0)
                        <!-- Pagination -->
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $activities->links() }}
                        </div>
                        @endif
                    </div>
                </div> --}}
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
                    sidebar.classList.toggle('');
                    sidebar.classList.toggle('mobile-sidebar');
                    sidebarOverlay.classList.toggle('active');

                    // Prevent body scrolling when sidebar is open
                    if (sidebar.classList.contains('mobile-sidebar')) {
                        document.body.style.overflow = '';
                    } else {
                        document.body.style.overflow = '';
                    }
                }
            }

            // Hide sidebar initially on mobile
            if (isMobile && sidebar) {
                sidebar.classList.add('');
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