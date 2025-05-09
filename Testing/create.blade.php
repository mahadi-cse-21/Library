<!-- create.blade.php -->
@extends('layouts.app')

@section('content')
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
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Student's basic information</p>
                    </div>

                    <!-- Alert for errors -->
                    @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                            <div class="mt-1">
                                <input type="text" name="student_id" id="student_id" value="{{ old('student_id') }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <div class="mt-1">
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input type="password" name="password" id="password" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                            <div class="mt-1">
                                <select id="department" name="department" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Select Department</option>
                                    <option value="CS" {{ old('department') == 'CS' ? 'selected' : '' }}>Computer Science</option>
                                    <option value="ENG" {{ old('department') == 'ENG' ? 'selected' : '' }}>Engineering</option>
                                    <option value="BUS" {{ old('department') == 'BUS' ? 'selected' : '' }}>Business</option>
                                    <option value="ART" {{ old('department') == 'ART' ? 'selected' : '' }}>Arts</option>
                                    <option value="SCI" {{ old('department') == 'SCI' ? 'selected' : '' }}>Sciences</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="year" class="block text-sm font-medium text-gray-700">Year Level</label>
                            <div class="mt-1">
                                <select id="year" name="year" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Select Year</option>
                                    <option value="1" {{ old('year') == '1' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2" {{ old('year') == '2' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3" {{ old('year') == '3' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4" {{ old('year') == '4' ? 'selected' : '' }}>4th Year</option>
                                    <option value="5" {{ old('year') == '5' ? 'selected' : '' }}>5th Year</option>
                                    <option value="G" {{ old('year') == 'G' ? 'selected' : '' }}>Graduate</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="profile_image" class="block text-sm font-medium text-gray-700">
                                Profile Image
                            </label>
                            <div class="mt-1 flex items-center">
                                <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                                <input type="file" name="profile_image" id="profile_image" 
                                    class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('students.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection

<!-- import.blade.php -->
@extends('layouts.app')

@section('content')
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
                <h2 class="text-xl font-bold text-gray-700 ml-4">Import Students</h2>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
            <div class="bg-white rounded-lg shadow p-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-md p-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Import Students</h3>
                        <p class="mt-1 text-sm text-gray-500">Upload Excel or CSV file with student data</p>
                    </div>

                    <!-- Alert for errors -->
                    @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-6">
                        <label for="file" class="block text-sm font-medium text-gray-700">File (Excel/CSV)</label>
                        <div class="mt-1">
                            <input type="file" name="file" id="file" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            File must include columns: name, email, student_id, department, year. Optional columns: password, status, book_borrowed, current_borrows.
                        </p>
                    </div>

                    <div class="mb-6">
                        <a href="{{ asset('templates/student_import_template.xlsx') }}" class="text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-download mr-1"></i>Download Template
                        </a>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700">Sample Format</h4>
                        <div class="mt-2 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">student_id</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">year</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">password</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">John Doe</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">john@example.com</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">STU001</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">CS</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">password123</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">active</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('students.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection

<!-- edit.blade.php -->
@extends('layouts.app')

@section('content')
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
                <h2 class="text-xl font-bold text-gray-700 ml-4">Edit Student</h2>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Student's basic information</p>
                    </div>

                    <!-- Alert for errors -->
                    @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                            <div class="mt-1">
                                <input type="text" name="student_id" id="student_id" value="{{ $student->student_id }}" readonly
                                    class="bg-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">Student ID cannot be changed</p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ $student->user->name }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <div class="mt-1">
                                <input type="email" name="email" id="email" value="{{ $student->user->email }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input type="password" name="password" id="password" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password</p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                            <div class="mt-1">
                                <select id="department" name="department" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Select Department</option>
                                    <option value="CS" {{ $student->department == 'CS' ? 'selected' : '' }}>Computer Science</option>
                                    <option value="ENG" {{ $student->department == 'ENG' ? 'selected' : '' }}>Engineering</option>
                                    <option value="BUS" {{ $student->department == 'BUS' ? 'selected' : '' }}>Business</option>
                                    <option value="ART" {{ $student->department == 'ART' ? 'selected' : '' }}>Arts</option>
                                    <option value="SCI" {{ $student->department == 'SCI' ? 'selected' : '' }}>Sciences</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="year" class="block text-sm font-medium text-gray-700">Year Level</label>
                            <div class="mt-1">
                                <select id="year" name="year" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Select Year</option>
                                    <option value="1" {{ $student->year == '1' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2" {{ $student->year == '2' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3" {{ $student->year == '3' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4" {{ $student->year == '4' ? 'selected' : '' }}>4th Year</option>
                                    <option value="5" {{ $student->year == '5' ? 'selected' : '' }}>5th Year</option>
                                    <option value="G" {{ $student->year == 'G' ? 'selected' : '' }}>Graduate</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="profile_image" class="block text-sm font-medium text-gray-700">
                                Profile Image
                            </label>
                            <div class="mt-1 flex items-center">
                                @if($student->user->img)
                                    <img src="{{ asset('storage/' . $student->user->img) }}" class="h-12 w-12 rounded-full object-cover" alt="{{ $student->user->name }}">
                                @else
                                    <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </span>
                                @endif
                                <input type="file" name="profile_image" id="profile_image" 
                                    class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Leave blank to keep current image</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('students.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection

<!-- show.blade.php -->
@extends('layouts.app')

@section('content')
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
                <h2 class="text-xl font-bold text-gray-700 ml-4">Student Details</h2>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Header with Actions -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Student Information</h3>
                    <div class="flex space-x-3">
                        <a href="{{ route('students.edit', $student->id) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <form action="{{ route('students.toggle-status', $student->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            @if($student->status == 'suspended')
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                                    <i class="fas fa-check-circle mr-2"></i>Reactivate
                                </button>
                            @else
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700">
                                    <i class="fas fa-ban mr-2"></i>Suspend
                                </button>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Student Details -->
                <div class="px-6 py-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-24 w-24">
                            @if($student->user->img)
                                <img class="h-full w-full rounded-full object-cover" src="{{ asset('storage/' . $student->user->img) }}" alt="{{ $student->user->name }}">
                            @else
                                <span class="h-full w-full rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                    <svg class="h-16 w-16 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                        
                        <div class="ml-6">
                            <h4 class="text-xl font-bold text-gray-900">{{ $student->user->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $student->user->email }}</p>
                            
                            <div class="mt-2">
                                @if($student->status == 'active')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @elseif($student->status == 'suspended')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Suspended
                                    </span>
                                @elseif($student->status == 'inactive')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @elseif($student->status == 'graduated')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Graduated
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <h5 class="text-sm font-medium text-gray-500">Basic Information</h5>
                            <div class="mt-2 border-t border-gray-200">
                                <dl class="divide-y divide-gray-200">
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Student ID</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->student_id }}</dd>
                                    </div>
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                                        <dd class="text-sm text-gray-900">
                                            @switch($student->department)
                                                @case('CS')
                                                    Computer Science
                                                    @break
                                                @case('ENG')
                                                    Engineering
                                                    @break
                                                @case('BUS')
                                                    Business
                                                    @break
                                                @case('ART')
                                                    Arts
                                                    @break
                                                @case('SCI')
                                                    Sciences
                                                    @break
                                                @default
                                                    {{ $student->department }}
                                            @endswitch
                                        </dd>
                                    </div>
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Year Level</dt>
                                        <dd class="text-sm text-gray-900">
                                            @switch($student->year)
                                                @case('1')
                                                    1st Year
                                                    @break
                                                @case('2')
                                                    2nd Year
                                                    @break
                                                @case('3')
                                                    3rd Year
                                                    @break
                                                @case('4')
                                                    4th Year
                                                    @break
                                                @case('5')
                                                    5th Year
                                                    @break
                                                @case('G')
                                                    Graduate
                                                    @break
                                                @default
                                                    {{ $student->year }}
                                            @endswitch
                                        </dd>
                                    </div>
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Registration Date</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->created_at->format('M d, Y') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        
                        <div>
                            <h5 class="text-sm font-medium text-gray-500">Library Activity</h5>
                            <div class="mt-2 border-t border-gray-200">
                                <dl class="divide-y divide-gray-200">
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Books Borrowed (Total)</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->book_borrowed }}</dd>
                                    </div>
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Current Borrows</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->current_borrows }}</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            @if($student->current_borrows > 0)
                            <div class="mt-4">
                                <h5 class="text-sm font-medium text-gray-500">Currently Borrowed Books</h5>
                                <div class="mt-2 border-t border-gray-200">
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($student->borrows as $borrow)
                                        <li class="py-3">
                                            <div class="flex justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $borrow->book->title }}</p>
                                                    <p class="text-xs text-gray-500">Due: {{ $borrow->due_date->format('M d, Y') }}</p>
                                                </div>
                                                <div>
                                                    @if($borrow->due_date < now())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Overdue
                                                    </span>
                                                    @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        On time
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection