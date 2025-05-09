<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Edit Profile</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 hidden lg:block">
            <!-- Sidebar content -->
            @include('layouts.studentsidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow flex items-center justify-between p-4">
                <div class="flex items-center">
                    <button class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Edit Profile</h2>
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

            <!-- Main Form Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <!-- Form Section -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        
                        <!-- Profile Picture -->
                        <div class="mb-6 flex flex-col items-center">
                            <div class="relative mb-4">
                                <img id="preview-image" src="{{ Auth::user()->img ? asset('storage/' . Auth::user()->img) : asset('images/default-profile.png') }}"
                                    alt="Profile picture" class="h-36 w-36 rounded-full object-cover">
                                <label for="profile_image" class="absolute bottom-0 right-0 bg-blue-500 text-white p-2 rounded-full shadow hover:bg-blue-600 cursor-pointer">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="profile_image" name="profile_image" class="hidden" accept="image/*" onchange="previewImage()">
                            </div>
                            <p class="text-sm text-gray-500">Click the camera icon to upload a new profile picture</p>
                        </div>

                        <!-- Personal Information -->
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                     
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>

                                <select id="year" name="year"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="1st year" {{ Auth::user()->student->year == '1st year' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2nd year" {{ Auth::user()->student->year == '2nd year' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3rd year" {{ Auth::user()->student->year == '3rd year' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4th year" {{ Auth::user()->student->year == '4th year' ? 'selected' : '' }}>4th Year</option>
                                    <option value="Graduate" {{ Auth::user()->student->year == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                                </select>
                                @error('year')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>

                                <select id="semester" name="semester"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="1st" {{ Auth::user()->student->semester == '1st' ? 'selected' : '' }}>1st Semester</option>
                                    <option value="2nd" {{ Auth::user()->student->semester == '2nd' ? 'selected' : '' }}>2nd Semester</option>
                                </select>
                                @error('semester')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" id="address" name="address" value="{{ Auth::user()->address }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>



                        {{-- <!-- Notification Preferences -->
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Notification Preferences</h3>
                        <div class="mb-6">
                            <label class="flex items-center space-x-2 mb-2">
                                <input type="checkbox" name="notifications[]" value="due_date" class="form-checkbox h-5 w-5 text-blue-500">
                                <span class="text-gray-700">Due Date Reminders</span>
                            </label>
                            <label class="flex items-center space-x-2 mb-2">
                                <input type="checkbox" name="notifications[]" value="new_arrivals" class="form-checkbox h-5 w-5 text-blue-500">
                                <span class="text-gray-700">New Book Arrivals</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="notifications[]" value="events" class="form-checkbox h-5 w-5 text-blue-500">
                                <span class="text-gray-700">Library Events</span>
                            </label>
                        </div> --}}

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('student.profile.index') }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 rounded-md text-gray-800">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 rounded-md text-white">
                                Save Changes
                            </button>
                        </div>
                    </form>
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
        function previewImage() {
            const input = document.getElementById('profile_image');
            const preview = document.getElementById('preview-image');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>