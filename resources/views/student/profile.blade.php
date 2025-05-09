<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Student Profile</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Success message alert (copied from first page) -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md z-50" 
             role="alert" id="alert-message">
            <div class="flex">
                <div class="py-1"><i class="fas fa-check-circle text-green-500 mr-3"></i></div>
                <div>
                    <p>{{ session('success') }}</p>
                </div>
                <div class="ml-auto">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-green-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('alert-message').remove();
            }, 5000);
        </script>
    @endif

    <div class="min-h-screen flex">
        <!-- Include the sidebar -->
        @include('layouts.studentsidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow flex items-center justify-between p-4">
                <div class="flex items-center">
                    <button id="mobile-sidebar-button" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">My Profile</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..."
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
                <!-- Profile Overview Section -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/4 flex justify-center">
                            <div class="relative">
                                <img src="{{ Auth::user()->img ? asset('storage/' . Auth::user()->img) : asset('images/default-profile.png') }}"
                                    alt="Student profile"
                                    class="h-36 w-36 rounded-full object-cover">
                                <button class="absolute bottom-0 right-0 bg-blue-500 text-white p-2 rounded-full shadow hover:bg-blue-600">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                        </div>
                        <div class="md:w-3/4 mt-6 md:mt-0 md:pl-8">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                                <a href="{{ route('student.profile.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm flex items-center">
                                    <i class="fas fa-edit mr-2"></i> Edit Profile
                                </a>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-500 text-sm">Student ID</p>
                                    <p class="text-gray-900">ST-{{ Auth::user()->student->student_id }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Email</p>
                                    <p class="text-gray-900">{{ Auth::user()->email }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Department</p>
                                    <p class="text-gray-900">{{ Auth::user()->student->department }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Year</p>
                                    <p class="text-gray-900">{{ Auth::user()->student->year }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Semester</p>
                                    <p class="text-gray-900">{{ Auth::user()->student->semester }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Phone</p>
                                    <p class="text-gray-900">{{ Auth::user()->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Member Since</p>
                                    <p class="text-gray-900">{{ Auth::user()->student->created_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Library Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <i class="fas fa-book text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Currently Borrowed</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ $currently_borrowed }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <i class="fas fa-history text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Total Borrowed</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ $total_borrowed }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <i class="fas fa-exclamation-circle text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Pending Fines</h3>
                                <p class="text-2xl font-bold text-gray-800">${{ $pending_fee }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reading Preferences -->
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Reading Preferences</h3>
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Science Fiction</span>
                        <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Mystery</span>
                        <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Biography</span>
                        <a href="#" class="inline-block bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full hover:bg-gray-200">
                            <i class="fas fa-plus mr-1"></i> Edit Preferences
                        </a>
                    </div>
                </div>

                <!-- Account Settings -->
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Account Settings</h3>
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-800 mb-2">Change Password</h4>
                            <a href="#" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                                Update Password
                            </a>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800 mb-2">Notification Preferences</h4>
                            <a href="#" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                                Manage Notifications
                            </a>
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
        // Mobile sidebar toggle script (copied from first page)
        document.addEventListener('DOMContentLoaded', function() {
            const mobileButton = document.getElementById('mobile-sidebar-button');
            if (mobileButton) {
                mobileButton.addEventListener('click', function() {
                    // Find the sidebar toggle button from the sidebar component and trigger it
                    const sidebarToggle = document.getElementById('sidebar-toggle');
                    if (sidebarToggle) {
                        sidebarToggle.click();
                    }
                });
            }
        });
    </script>
</body>

</html>