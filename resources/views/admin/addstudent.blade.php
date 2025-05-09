<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Add New Student - Library Management System</title>
    <style>
        .form-input,
        .form-select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .section-title {
            font-size: 0.875rem;
            text-transform: uppercase;
            font-weight: 500;
            color: #6B7280;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 0.5rem;
        }
    </style>
</head>

<body class="bg-gray-100">
    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

    <div class="min-h-screen flex">


        <!-- Sidebar -->
        <div class="md:w-64 w-full md:block hidden">
            @include('layouts.adminsidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow flex items-center justify-between p-4">
                <div class="flex items-center">
                    <button class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Add New Student</h2>
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
                <!-- Page Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Create New Student</h3>
                        <p class="text-sm text-gray-600">Enter student details to register them in the system</p>
                    </div>
                    <div>
                        <a href="{{ route('students.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Students
                        </a>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Form Header -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <h2 class="text-lg font-semibold text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Student Registration Form
                        </h2>
                        <p class=" text-indigo-50 text-sm">Complete all required fields marked with *</p>
                    </div>

                    <!-- Form Content -->
                    <div class="p-6">
                        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Basic Information -->
                            <div class="mb-8">
                                <h3 class="section-title">Basic Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name
                                            *</label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="form-input" placeholder="John Doe" required>
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                            Address *</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="form-input" placeholder="john.doe@example.com" required>
                                        @error('email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Contact
                                            Number *</label>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                            class="form-input" placeholder="e.g +8801xxx-xxxxxx" required>
                                        @error('phone')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                                            class="form-input" placeholder="e.g Dhaka, Bangladesh" required>
                                        @error('address')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Information -->
                            <div class="mb-8">
                                <h3 class="section-title">Academic Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="student_uid"
                                            class="block text-sm font-medium text-gray-700 mb-1">Student ID *</label>
                                        <input type="text" id="student_uid" name="student_uid"
                                            value="{{ old('student_uid') }}" class="form-input"
                                            placeholder="e.g. STU20xxxxxxxxxx" required autocomplete="student_uid">
                                        @error('student_uid')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="department"
                                            class="block text-sm font-medium text-gray-700 mb-1">Department *</label>
                                        <select id="department" name="department" class="form-select" required>
                                            <option value="">Select Department</option>
                                            <option value="Computer Science and Engineering" {{ old('department') == 'Computer Science and Engineering' ? 'selected' : '' }}>
                                                Computer Science and Engineering</option>
                                            <option value="Accounting" {{ old('department') == 'Accounting' ? 'selected' : '' }}>Accounting
                                            </option>
                                            <option value="English" {{ old('department') == 'English' ? 'selected' : '' }}>English</option>
                                            <option value="Mathematics" {{ old('department') == 'Mathematics' ? 'selected' : '' }}>Mathematics
                                            </option>
                                        </select>
                                        @error('department')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year
                                            Level *</label>
                                        <select id="year" name="year" class="form-select" required>
                                            <option value="">Select Year</option>
                                            <option value="1st year" {{ old('year') == '1st year' ? 'selected' : '' }}>1st
                                                Year</option>
                                            <option value="2nd year" {{ old('year') == '2nd year' ? 'selected' : '' }}>2nd
                                                Year</option>
                                            <option value="3rd year" {{ old('year') == '3rd year' ? 'selected' : '' }}>3rd
                                                Year</option>
                                            <option value="4th year" {{ old('year') == '4th year' ? 'selected' : '' }}>4th
                                                Year</option>
                                            <option value="5th year" {{ old('year') == '5th year' ? 'selected' : '' }}>5th
                                                Year</option>
                                        </select>
                                        @error('year')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Year
                                            Semester *</label>
                                        <select id="semester" name="semester" class="form-select" required>
                                            <option value="">Select Semester</option>
                                            <option value="1st" {{ old('semester') == '1st' ? 'selected' : '' }}>1st
                                                Semester</option>
                                            <option value="2nd" {{ old('semester') == '2nd' ? 'selected' : '' }}>2nd
                                                Semester</option>
                                        </select>
                                        @error('semester')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status
                                            *</label>
                                        <select id="status" name="status" class="form-select" required>
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="suspended">Suspended</option>
                                            <option value="graduated">Graduated</option>
                                        </select>
                                        @error('status')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="mb-8">
                                <h3 class="section-title">Additional Information</h3>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label for="img" class="block text-sm font-medium text-gray-700 mb-1">Profile
                                            Image</label>
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="flex-shrink-0 h-24 w-24 rounded-md bg-gray-100 flex items-center justify-center border">
                                                <img id="preview-image" src="#" alt="Preview"
                                                    class="h-full w-full object-cover rounded-md hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400"
                                                    id="preview-placeholder" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <label for="img"
                                                    class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer inline-block">
                                                    Choose File
                                                </label>
                                                <input type="file" id="img" name="img" class="hidden" accept="image/*"
                                                    onchange="previewImage(this)">
                                                <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF. Max size 2MB.</p>
                                                @error('img')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information -->
                            <div class="mb-8">
                                <h3 class="section-title">Account Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                                        <input type="password" id="password" name="password" class="form-input"
                                            placeholder="••••••••" required>
                                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters, at least one letter
                                            and one number.</p>
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-1">Confirm Password
                                            *</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-input" placeholder="••••••••" required>
                                        @error('password_confirmation')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Buttons -->
                            <div class="flex justify-end space-x-3 mt-8 pt-5 border-t border-gray-200">
                                <a href="{{ route('students.index') }}"
                                    class="px-6 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                    Save Student
                                </button>
                            </div>

                           
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview-image');
            const placeholder = document.getElementById('preview-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.setAttribute('src', e.target.result);
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }
    </script>
</body>

</html>