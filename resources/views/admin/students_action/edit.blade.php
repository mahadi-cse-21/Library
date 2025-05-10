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
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Edit Student</h2>
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
                    <a href="{{ route('students.show', $student->id) }}" class="flex items-center text-indigo-600 hover:text-indigo-900">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Student Details
                    </a>
                </div>

                <!-- Header -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Student Information</h3>
                    <p class="text-sm text-gray-500">Update the student's profile information and settings</p>
                </div>

                <!-- Form -->
                <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Alert for validation errors -->
                    @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700 font-medium">
                                    Please correct the following errors:
                                </p>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Success message -->
                    @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Use a single Alpine component for the entire tabs section -->
                    <div class="bg-white rounded-lg shadow overflow-hidden" x-data="{ tab: 'personal' }">
                        <!-- Tabs -->
                        <div class="border-b border-gray-200">
                            <nav class="flex -mb-px">
                                <button type="button" @click="tab = 'personal'" :class="{ 'border-indigo-500 text-indigo-600': tab === 'personal', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'personal' }" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                                    Personal Information
                                </button>
                                <button type="button" @click="tab = 'academic'" :class="{ 'border-indigo-500 text-indigo-600': tab === 'academic', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'academic' }" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                                    Academic Information
                                </button>
                                <button type="button" @click="tab = 'library'" :class="{ 'border-indigo-500 text-indigo-600': tab === 'library', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'library' }" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                                    Library Settings
                                </button>
                            </nav>
                        </div>

                        <!-- Tab Content -->
                        <div class="p-6">
                            <!-- Personal Information -->
                            <div x-show="tab === 'personal'">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Profile Image -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                                        <div class="flex items-center">
                                            <div class="mr-4">
                                                @if($student->user->img)
                                                <img class="h-20 w-20 rounded-full object-cover" 
                                                    src="{{ asset('storage/' . $student->user->img) }}" 
                                                    alt="{{ $student->user->name }}">
                                                @else
                                                <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-500 text-2xl"></i>
                                                </div>
                                                @endif
                                            </div>
                                            <div>
                                                <input type="file" name="profile_image" id="profile_image" class="hidden">
                                                <label for="profile_image" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 cursor-pointer">
                                                    Change Photo
                                                </label>
                                                <p class="text-xs text-gray-500 mt-1">JPG, GIF or PNG. Max size 2MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $student->user->name) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                        <input type="email" name="email" id="email" value="{{ old('email', $student->user->email) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <!-- Phone Number -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $student->user->phone) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                  

                                    <!-- Address -->
                                    <div class="md:col-span-2">
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                        <textarea name="address" id="address" rows="3" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('address', $student->user->address) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Information -->
                            <div x-show="tab === 'academic'" x-cloak>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Student ID -->
                                    <div>
                                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Student ID</label>
                                        <input type="text" name="student_id" id="student_id" value="{{ old('student_id', $student->student_id) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>
                                        <p class="text-xs text-gray-500 mt-1">Student ID cannot be changed</p>
                                    </div>

                                    <!-- Year -->
                                    <div>
                                        <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                                        <select name="year" id="year" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="">Select Year</option>
                                            <option value="1st year" {{ old('year', $student->year) == '1st year' ? 'selected' : '' }}>1st Year</option>
                                            <option value="2nd year" {{ old('year', $student->year) == '2nd year' ? 'selected' : '' }}>2nd Year</option>
                                            <option value="3rd year" {{ old('year', $student->year) == '3rd year' ? 'selected' : '' }}>3rd Year</option>
                                            <option value="4th year" {{ old('year', $student->year) == '4th year' ? 'selected' : '' }}>4th Year</option>
                                           
                                        </select>
                                    </div>

                                    <!-- Semester -->
                                    <div>
                                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                                        <select name="semester" id="semester" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="">Select Semester</option>
                                            <option value="1st" {{ old('semester', $student->semester) == '1st' ? 'selected' : '' }}>1st Semester</option>
                                            <option value="2nd" {{ old('semester', $student->semester) == '2nd' ? 'selected' : '' }}>2nd Semester</option>
                                         </select>
                                    </div>

                                    <!-- Roll Number -->
                                    <div>
                                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Roll Number</label>
                                        <input type="text" name="student_id" id="student_id" value="{{ old('student_id', $student->student_id) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                        <select name="status" id="status" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                            <option value="transferred" {{ old('status', $student->status) == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                        </select>
                                    </div>

                                    {{-- <!-- Guardian Information -->
                                    <div class="md:col-span-2 mt-4">
                                        <h4 class="font-medium text-gray-700 mb-4">Guardian Information</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Guardian Name -->
                                            <div>
                                                <label for="guardian_name" class="block text-sm font-medium text-gray-700 mb-2">Guardian Name</label>
                                                <input type="text" name="guardian_name" id="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>

                                            <!-- Guardian Relationship -->
                                            <div>
                                                <label for="guardian_relation" class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                                                <select name="guardian_relation" id="guardian_relation" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option value="">Select Relationship</option>
                                                    <option value="father" {{ old('guardian_relation', $student->guardian_relation) == 'father' ? 'selected' : '' }}>Father</option>
                                                    <option value="mother" {{ old('guardian_relation', $student->guardian_relation) == 'mother' ? 'selected' : '' }}>Mother</option>
                                                    <option value="brother" {{ old('guardian_relation', $student->guardian_relation) == 'brother' ? 'selected' : '' }}>Brother</option>
                                                    <option value="sister" {{ old('guardian_relation', $student->guardian_relation) == 'sister' ? 'selected' : '' }}>Sister</option>
                                                    <option value="uncle" {{ old('guardian_relation', $student->guardian_relation) == 'uncle' ? 'selected' : '' }}>Uncle</option>
                                                    <option value="aunt" {{ old('guardian_relation', $student->guardian_relation) == 'aunt' ? 'selected' : '' }}>Aunt</option>
                                                    <option value="other" {{ old('guardian_relation', $student->guardian_relation) == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>

                                            <!-- Guardian Phone -->
                                            <div>
                                                <label for="guardian_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                                <input type="tel" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>

                                            <!-- Guardian Email -->
                                            <div>
                                                <label for="guardian_email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                                <input type="email" name="guardian_email" id="guardian_email" value="{{ old('guardian_email', $student->guardian_email) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <!-- Library Settings -->
                            <div x-show="tab === 'library'" x-cloak>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Library Card Number -->
                                    <div>
                                        <label for="library_card_number" class="block text-sm font-medium text-gray-700 mb-2">Library Card Number</label>
                                        <input type="text" name="library_card_number" id="library_card_number" value="{{ old('library_card_number', $student->student_id) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <!-- Card Issue Date -->
                                    <div>
                                        <label for="card_issue_date" class="block text-sm font-medium text-gray-700 mb-2">Card Issue Date</label>
                                        <input type="date" name="card_issue_date" id="card_issue_date" value="{{ old('card_issue_date', $student->card_issue_date) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <!-- Card Expiry Date -->
                                    <div>
                                        <label for="card_expiry_date" class="block text-sm font-medium text-gray-700 mb-2">Card Expiry Date</label>
                                        <input type="date" name="card_expiry_date" id="card_expiry_date" value="{{ old('card_expiry_date', $student->card_expiry_date) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <!-- Max Books Allowed -->
                                    <div>
                                        <label for="max_allowed_books" class="block text-sm font-medium text-gray-700 mb-2">Max Books Allowed</label>
                                        <input type="number" name="max_allowed_books" id="max_allowed_books" value="{{ old('max_allowed_books', $student->max_allowed_books) }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <!-- Current Books Issued -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Books Issued</label>
                                        <div class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
                                            {{ $student->current_borrows ?? 0 }}
                                        </div>
                                    </div>

                                    <!-- Library Access Status -->
                                    {{-- <div>
                                        <label for="library_access" class="block text-sm font-medium text-gray-700 mb-2">Library Access</label>
                                        <select name="library_access" id="library_access" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="enabled" {{ old('library_access', $student->library_access) == 'enabled' ? 'selected' : '' }}>Enabled</option>
                                            <option value="disabled" {{ old('library_access', $student->library_access) == 'disabled' ? 'selected' : '' }}>Disabled</option>
                                        </select>
                                    </div>

                                    <!-- Notes -->
                                    <div class="md:col-span-2">
                                        <label for="library_notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                        <textarea name="library_notes" id="library_notes" rows="3" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('library_notes', $student->library_notes) }}</textarea>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-4">
                            <a href="{{ route('students.show', $student->id) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="md:hidden mobile-sidebar transform -translate-x-full transition-transform duration-300 ease-in-out">
        @include('layouts.adminsidebar')
    </div>

    <script>
        // Handle sidebar toggle
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            
            mobileSidebar.classList.toggle('transform-none');
            mobileSidebar.classList.toggle('-translate-x-full');
            
            sidebarOverlay.classList.toggle('active');
        });

        // Close sidebar when clicking overlay
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            
            mobileSidebar.classList.remove('transform-none');
            mobileSidebar.classList.add('-translate-x-full');
            
            sidebarOverlay.classList.remove('active');
        });
    </script>
</body>
</html>