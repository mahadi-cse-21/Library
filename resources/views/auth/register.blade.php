<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.head')
    <title>Join Our Library</title>
    <style>
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .image-upload-preview {
            transition: all 0.3s ease;
        }

        .image-upload-preview:hover {
            opacity: 0.8;
        }

        .image-upload-label {
            overflow: hidden;
            position: relative;
        }

        .image-upload-label input[type="file"] {
            cursor: pointer;
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
            height: 100%;
            font-size: 100px;
        }

        .gradient-border {
            position: relative;
            border-radius: 1rem;
            background: linear-gradient(to right, #4f46e5, #3b82f6, #8b5cf6);
            padding: 3px;
        }

        .animated-bg {
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body
    class="antialiased bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-50 animated-bg min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    @if ($errors->has('registration_error'))
        <div class="alert alert-danger">
            {{ $errors->first('registration_error') }}
        </div>
    @endif
    <div class="w-full max-w-4xl fade-in">
        <!-- Outer gradient border -->
        <div class="gradient-border">
            <!-- Main card container -->
            <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
                <!-- Header with animated gradient -->
                <div
                    class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 animated-bg px-6 sm:px-10 py-10 relative overflow-hidden">
                    <!-- Abstract decorative shapes -->
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 rounded-full bg-white opacity-10"></div>
                    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-32 h-32 rounded-full bg-white opacity-10">
                    </div>

                    <div class="relative z-10">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white text-center tracking-tight">
                            Join Our Library Community
                        </h1>
                        <p class="text-indigo-100 text-center mt-3 text-lg max-w-2xl mx-auto">
                            Create your account to access our collection of knowledge and resources
                        </p>
                    </div>
                </div>

                <!-- Form section -->
                <div class="px-6 sm:px-10 py-8 sm:py-10">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                    <ul class="mt-2 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li class="text-sm text-red-700">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
                        class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                                        </path>
                                    </svg>
                                    Personal Information
                                </h2>

                                <div class="space-y-5">
                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full
                                            Name</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <input id="name" name="name" type="text" required autofocus
                                                value="{{ old('name') }}"
                                                class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="John Doe">
                                        </div>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                            Address</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                </svg>
                                            </div>
                                            <input id="email" name="email" type="email" required
                                                value="{{ old('email') }}"
                                                class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="you@example.com">
                                        </div>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                            Number</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                </svg>
                                            </div>
                                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                                                class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="+1 (555) 123-4567">
                                        </div>
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div>
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <textarea id="address" name="address" rows="3"
                                                class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="123 Library Street, Bookville, BK 12345">{{ old('address') }}</textarea>
                                        </div>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div>
                                <!-- User Type and Profile Image -->
                                <div class="space-y-5">
                                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Account Details
                                    </h2>

                                    <!-- User Type with toggle animation -->
                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">I am
                                            a</label>
                                        <div class="relative">
                                            <select id="role" name="role" required onchange="toggleUserTypeFields()"
                                                class="form-input block w-full pr-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                                                {{-- <option value="librarian" {{ old('role')=='librarian' ? 'selected'
                                                    : '' }}>Librarian</option> --}}
                                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>
                                                    Student</option>
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('role')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Profile Image Upload with preview -->
                                    <div>
                                        <label for="img" class="block text-sm font-medium text-gray-700 mb-3">Profile
                                            Image</label>
                                        <div class="flex flex-col items-center">
                                            <div class="mb-3 overflow-hidden rounded-full h-32 w-32 bg-gray-100 border-4 border-white shadow-lg"
                                                id="image-preview">
                                                <img id="preview-img" src="#" alt="Profile preview"
                                                    class="h-full w-full object-cover object-center hidden">
                                                <div id="default-preview"
                                                    class="h-full w-full flex items-center justify-center">
                                                    <svg class="h-16 w-16 text-gray-300" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <label
                                                class="image-upload-label cursor-pointer mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Upload Photo
                                                <input type="file" name="img" id="img" class="sr-only" accept="image/*"
                                                    required>
                                            </label>
                                            <p class="mt-1 text-xs text-gray-500">JPG, PNG, or GIF up to 2MB</p>
                                        </div>
                                        @error('img')
                                            <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Role-specific information section -->
                                    <div class="mt-6">
                                        <!-- Student Fields -->
                                        <div id="student_fields" class="space-y-5 hidden">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Student Information
                                            </h3>

                                            <!-- Student ID -->
                                            <div>
                                                <label for="student_id"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Student
                                                    ID</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v-1l1-1 1-1-0.257-0.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <input id="student_id" name="student_id" type="text"
                                                        value="{{ old('student_id') }}"
                                                        class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                        placeholder="S12345678">
                                                </div>
                                                @error('student_id')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Department -->
                                            <div>
                                                <label for="department"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                                <div class="relative">
                                                    <select id="department" name="department"
                                                        class="form-input block w-full pr-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                                                        <option value="">Select Department</option>
                                                        <option value="Computer Science and Engineering" {{ old('department') == 'Computer Science and Engineering' ? 'selected' : '' }}>
                                                            Computer Science and Engineering
                                                        </option>
                                                        <option value="Accounting" {{ old('department') == 'Accounting' ? 'selected' : '' }}>
                                                            Accounting
                                                        </option>
                                                        <option value="English" {{ old('department') == 'English' ? 'selected' : '' }}>
                                                            English
                                                        </option>
                                                        <option value="Mathematics" {{ old('department') == 'Mathematics' ? 'selected' : '' }}>
                                                            Mathematics
                                                        </option>
                                                    </select>
                                                    <div
                                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                @error('department')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Year & Semester in 2 columns -->
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="year"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                                                    <div class="relative">
                                                        <select id="year" name="year"
                                                            class="form-input block w-full pr-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                                                            <option value="">Select Year</option>
                                                            <option value="1st year" {{ old('year') == '1st year' ? 'selected' : '' }}>1st Year</option>
                                                            <option value="2nd year" {{ old('year') == '2nd year' ? 'selected' : '' }}>2nd Year</option>
                                                            <option value="3rd year" {{ old('year') == '3rd year' ? 'selected' : '' }}>3rd Year</option>
                                                            <option value="4th year" {{ old('year') == '4th year' ? 'selected' : '' }}>4th Year</option>
                                                            <option value="5th year" {{ old('year') == '5th year' ? 'selected' : '' }}>5th Year</option>
                                                        </select>
                                                        <div
                                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                            <svg class="h-5 w-5 text-gray-400"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    @error('year')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label for="semester"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                                                    <div class="relative">
                                                        <select id="semester" name="semester"
                                                            class="form-input block w-full pr-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                                                            <option value="">Select Semester</option>
                                                            <option value="1st" {{ old('semester') == '1st' ? 'selected' : '' }}>1st Semester</option>
                                                            <option value="2nd" {{ old('semester') == '2nd' ? 'selected' : '' }}>2nd Semester</option>
                                                        </select>
                                                        <div
                                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                            <svg class="h-5 w-5 text-gray-400"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    @error('semester')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Librarian Fields -->
                                        <div id="librarian_fields" class="space-y-5 hidden">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Librarian Information
                                            </h3>

                                            <!-- Employee ID -->
                                            <div>
                                                <label for="employee_id"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Employee
                                                    ID</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <input id="employee_id" name="employee_id" type="text"
                                                        value="{{ old('employee_id') }}"
                                                        class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                        placeholder="LIB12345">
                                                </div>
                                                @error('employee_id')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Designation -->
                                            <div>
                                                <label for="designation"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                                clip-rule="evenodd" />
                                                            <path
                                                                d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                                        </svg>
                                                    </div>
                                                    <input id="designation" name="designation" type="text"
                                                        value="{{ old('designation') }}"
                                                        class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                        placeholder="Senior Librarian">
                                                </div>
                                                @error('designation')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Specialization -->
                                            <div>
                                                <label for="specialization"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Specialization</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path
                                                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                                        </svg>
                                                    </div>
                                                    <input id="specialization" name="specialization" type="text"
                                                        value="{{ old('specialization') }}"
                                                        class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                        placeholder="Digital Archives">
                                                </div>
                                                @error('specialization')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Security Section (Password Fields) -->
                                    <div class="mt-8">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Security Credentials
                                        </h3>

                                        <!-- Password -->
                                        <div class="mb-4">
                                            <label for="password"
                                                class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <input id="password" name="password" type="password" required
                                                    autocomplete="new-password"
                                                    class="form-input block w-full pl-10 pr-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="••••••••">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                    <button type="button" id="togglePassword"
                                                        class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                        <!-- Eye icon (show password) -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            id="showPasswordIcon" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            <path fill-rule="evenodd"
                                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <!-- Eye-off icon (hide password) -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                                            id="hidePasswordIcon" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                                                clip-rule="evenodd" />
                                                            <path
                                                                d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters with
                                                mixed case and numbers</p>
                                            @error('password')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Confirm Password -->
                                        <div>
                                            <label for="password_confirmation"
                                                class="block text-sm font-medium text-gray-700 mb-1">Confirm
                                                Password</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <input id="password_confirmation" name="password_confirmation"
                                                    type="password" required autocomplete="new-password"
                                                    class="form-input block w-full pl-10 pr-10 sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="••••••••">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                    <button type="button" id="toggleConfirmPassword"
                                                        class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                        <!-- Eye icon (show password) -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            id="showConfirmPasswordIcon" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            <path fill-rule="evenodd"
                                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <!-- Eye-off icon (hide password) -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                                            id="hideConfirmPasswordIcon" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                                                clip-rule="evenodd" />
                                                            <path
                                                                d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('password_confirmation')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Footer -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex flex-col-reverse sm:flex-row items-center justify-between">
                                <a href="{{ route('login') }}"
                                    class="mt-3 sm:mt-0 text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
                                    <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Already have an account? Log in
                                </a>

                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150 transform hover:scale-[1.02]">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Create My Account
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle display of fields based on user type
        function toggleUserTypeFields() {
            const userType = document.getElementById('role').value;
            const studentFields = document.getElementById('student_fields');
            const librarianFields = document.getElementById('librarian_fields');

            // First hide all with animation
            if (studentFields.classList.contains('block')) {
                studentFields.classList.replace('block', 'hidden');
            } else {
                studentFields.classList.add('hidden');
            }

            if (librarianFields.classList.contains('block')) {
                librarianFields.classList.replace('block', 'hidden');
            } else {
                librarianFields.classList.add('hidden');
            }

            // Then show relevant one with animation
            setTimeout(() => {
                if (userType === 'student') {
                    studentFields.classList.replace('hidden', 'block');
                } else if (userType === 'librarian') {
                    librarianFields.classList.replace('hidden', 'block');
                }
            }, 150);
        }

        // Preview image before upload
        document.addEventListener('DOMContentLoaded', function () {
            const imgInput = document.getElementById('img');
            const previewImg = document.getElementById('preview-img');
            const defaultPreview = document.getElementById('default-preview');

            // Handle initial state
            toggleUserTypeFields();

            // Handle image preview
            imgInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('hidden');
                        defaultPreview.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            // For first password field
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const showPasswordIcon = document.getElementById('showPasswordIcon');
            const hidePasswordIcon = document.getElementById('hidePasswordIcon');

            togglePassword.addEventListener('click', function () {
                // Toggle input type
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icons
                showPasswordIcon.classList.toggle('hidden');
                hidePasswordIcon.classList.toggle('hidden');
            });

            // For confirm password field
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const showConfirmPasswordIcon = document.getElementById('showConfirmPasswordIcon');
            const hideConfirmPasswordIcon = document.getElementById('hideConfirmPasswordIcon');

            toggleConfirmPassword.addEventListener('click', function () {
                // Toggle input type
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);

                // Toggle icons
                showConfirmPasswordIcon.classList.toggle('hidden');
                hideConfirmPasswordIcon.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>