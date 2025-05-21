<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
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
        
        /* Print-specific styles */
        @media print {
            body * {
                visibility: hidden;
            }
            
            #print-receipt, #print-receipt * {
                visibility: visible;
            }
            
            #print-receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            
            .no-print {
                display: none !important;
            }
        }
        
        /* Receipt modal styles */
        .receipt-modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .receipt-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
        }
        
        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close-modal:hover {
            color: black;
        }
    </style>
</head>

<body class="bg-gray-100">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Sidebar Overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay"></div>

    <!-- Receipt Modal -->
    <div id="receipt-modal" class="receipt-modal">
        <div class="receipt-modal-content">
            <span class="close-modal">&times;</span>
            <div id="print-receipt" class="p-4">
                <!-- Receipt content will be dynamically inserted here -->
            </div>
            <div class="flex justify-end mt-4 no-print">
                <button id="print-button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md mr-2">
                    <i class="fas fa-print mr-2"></i> Print
                </button>
                <button id="close-modal-button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-times mr-2"></i> Close
                </button>
            </div>
        </div>
    </div>

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
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Borrowing Details</h2>
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
                <!-- Breadcrumb navigation -->
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin') }}" class="text-gray-700 hover:text-indigo-600">
                                    <i class="fas fa-home mr-2"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <a href="{{ route('borrows.index') }}" class="text-gray-700 hover:text-indigo-600">Book Borrowing</a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <span class="text-gray-500">BR-{{ $borrow->id }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <!-- Action buttons -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                    
                    @if($borrow->status == 'borrowed')
                    <a href="{{ route('borrow.return', $borrow->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-check-circle mr-2"></i> Mark as Returned
                    </a>
                    
                    <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-clock mr-2"></i> Extend Due Date
                    </a>
                    
                    <a href="#" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Report Lost
                    </a>
                    @endif
                    
                    <a href="#" id="print-receipt-button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-print mr-2"></i> Print Receipt
                    </a>
                </div>

                <!-- Borrowing Details Card -->
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <div class="p-6">
                        <div class="flex flex-wrap justify-between items-start">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Borrowing Record BR-{{ $borrow->id }}</h3>
                                
                                <!-- Status Badge -->
                                @if($borrow->status == 'borrowed')
                                    <span class="inline-block px-3 py-1 text-sm font-semibold bg-blue-100 text-blue-800 rounded-full mb-4">
                                        <i class="fas fa-bookmark mr-1"></i> Active
                                    </span>
                                @elseif($borrow->status == 'Overdue')
                                    <span class="inline-block px-3 py-1 text-sm font-semibold bg-red-100 text-red-800 rounded-full mb-4">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Overdue
                                    </span>
                                @elseif($borrow->status == 'returned')
                                    <span class="inline-block px-3 py-1 text-sm font-semibold bg-green-100 text-green-800 rounded-full mb-4">
                                        <i class="fas fa-check-circle mr-1"></i> Returned
                                    </span>
                                @elseif($borrow->status == 'Lost')
                                    <span class="inline-block px-3 py-1 text-sm font-semibold bg-gray-100 text-gray-800 rounded-full mb-4">
                                        <i class="fas fa-times-circle mr-1"></i> Lost
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Due Date Indicator -->
                            @if($borrow->status == 'borrowed')
                                @php
                                    $dueDate = strtotime($borrow->due_date);
                                    $today = strtotime(date('Y-m-d'));
                                    $daysLeft = round(($dueDate - $today) / (60 * 60 * 24));
                                @endphp
                                
                                <div class="bg-gray-100 p-4 rounded-lg text-center">
                                    @if($daysLeft < 0)
                                        <p class="text-red-600 font-bold text-xl">{{ abs($daysLeft) }} days overdue</p>
                                    @elseif($daysLeft == 0)
                                        <p class="text-yellow-600 font-bold text-xl">Due today</p>
                                    @elseif($daysLeft == 1)
                                        <p class="text-yellow-600 font-bold text-xl">Due tomorrow</p>
                                    @else
                                        <p class="text-blue-600 font-bold text-xl">{{ $daysLeft }} days left</p>
                                    @endif
                                    <p class="text-gray-500 text-sm">Due on {{ date('M d, Y', strtotime($borrow->due_date)) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                            <!-- Book Details -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-700 mb-4">Book Information</h4>
                                <div class="flex mb-6">
                                    <div class="mr-4">
                                        @if($borrow->book->cover)
                                            <img src="{{ asset('storage/' . $borrow->book->cover) }}" alt="{{ $borrow->book->title }}" class="w-24 h-32 object-cover rounded-md shadow-md">
                                        @else
                                            <div class="w-24 h-32 bg-gray-200 flex items-center justify-center rounded-md shadow-md">
                                                <i class="fas fa-book text-gray-400 text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="text-lg font-semibold">{{ $borrow->book->title }}</h5>
                                        <p class="text-gray-600">{{ $borrow->book->author }}</p>
                                        <p class="text-sm text-gray-500 mt-1">Book ID: BK-{{ $borrow->book->id }}</p>

                                        <a href="{{ route('books.show', $borrow->book->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mt-2 inline-block">
                                            <i class="fas fa-info-circle mr-1"></i> View Book Details
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Category</p>
                                        <p class="font-medium">{{ $borrow->book->category->name ?? 'N/A' }}</p>
                                    </div>
                                 
                                </div>
                            </div>
                            
                            <!-- Student Details -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-700 mb-4">Student Information</h4>
                                <div class="flex items-start mb-6">
                                    <div class="mr-4">
                                        @if($borrow->student->user->img)
                                            <img src="{{ asset('storage/' . $borrow->student->user->img) }}" alt="{{ $borrow->student->name }}" class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="text-lg font-semibold">{{ $borrow->student->user->name }}</h5>
                                        <p class="text-sm text-gray-500">Student ID: {{ $borrow->student->student_id }}</p>
                                        <p class="text-sm text-gray-500">Email: {{ $borrow->student->user->email }}</p>
                                        <a href="{{ route('students.show', $borrow->student->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mt-2 inline-block">
                                            <i class="fas fa-info-circle mr-1"></i> View Student Profile
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Year</p>
                                        <p class="font-medium">{{ $borrow->student->year ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Contact</p>
                                        <p class="font-medium">{{ $borrow->student->user->phone ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Books Currently Borrowed</p>
                                        <p class="font-medium">{{ $borrow->student->current_borrows ?? '0' }}</p>
                                    </div>
                                    <div>
                                       
                                        <p class="text-sm text-gray-500">Overdue Books</p>
                                        <p class="font-medium">{{ $overdues_book }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Transaction Timeline -->
                    <div class="border-t border-gray-200 p-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-4">Transaction Timeline</h4>
                        
                        <div class="relative">
                            <!-- Timeline Line -->
                            <div class="absolute h-full w-0.5 bg-gray-200 left-6 top-0"></div>
                            
                            <!-- Borrow Event -->
                            <div class="relative flex items-start mb-6 pl-16">
                                <div class="absolute left-0 bg-indigo-500 rounded-full w-12 h-12 flex items-center justify-center text-white">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                                <div class="bg-indigo-50 rounded-lg p-4 w-full">
                                    <div class="flex justify-between items-center mb-2">
                                        <h5 class="font-semibold text-indigo-800">Book Borrowed</h5>
                                        <span class="text-sm text-gray-500">{{ date('M d, Y h:i A', strtotime($borrow->issue_date)) }}</span>
                                    </div>
                                    <p class="text-gray-600">Book was borrowed by {{ $borrow->student->user->name }}</p>
                                    <div class="text-sm text-gray-500 mt-2">
                                        <span>Issued by: {{ $borrow->issued_by_librarian_id ?? 'System' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Due Date Event -->
                            <div class="relative flex items-start mb-6 pl-16">
                                <div class="absolute left-0 bg-yellow-500 rounded-full w-12 h-12 flex items-center justify-center text-white">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="bg-yellow-50 rounded-lg p-4 w-full">
                                    <div class="flex justify-between items-center mb-2">
                                        <h5 class="font-semibold text-yellow-800">Due Date</h5>
                                        <span class="text-sm text-gray-500">{{ date('M d, Y', strtotime($borrow->due_date)) }}</span>
                                    </div>
                                    <p class="text-gray-600">Book is due to be returned by this date</p>
                                </div>
                            </div>
                            
                            @if($borrow->status == 'returned')
                            <!-- Return Event -->
                            <div class="relative flex items-start mb-6 pl-16">
                                <div class="absolute left-0 bg-green-500 rounded-full w-12 h-12 flex items-center justify-center text-white">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4 w-full">
                                    <div class="flex justify-between items-center mb-2">
                                        <h5 class="font-semibold text-green-800">Book Returned</h5>
                                        <span class="text-sm text-gray-500">{{ date('M d, Y h:i A', strtotime($borrow->return_date)) }}</span>
                                    </div>
                                    <p class="text-gray-600">Book was returned by {{ $borrow->student->name }}</p>
                                    <div class="text-sm text-gray-500 mt-2">
                                        <span>Received by: {{ $borrow->received_by_librarian_id ?? 'System' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($borrow->status == 'Lost')
                            <!-- Lost Event -->
                            <div class="relative flex items-start mb-6 pl-16">
                                <div class="absolute left-0 bg-red-500 rounded-full w-12 h-12 flex items-center justify-center text-white">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="bg-red-50 rounded-lg p-4 w-full">
                                    <div class="flex justify-between items-center mb-2">
                                        <h5 class="font-semibold text-red-800">Book Reported Lost</h5>
                                        <span class="text-sm text-gray-500">{{ date('M d, Y h:i A', strtotime($borrow->lost_date)) }}</span>
                                    </div>
                                    <p class="text-gray-600">Book was reported as lost by {{ $borrow->student->name }}</p>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <strong>Fine Amount:</strong> ${{ number_format($borrow->fine_amount, 2) }}
                                    </div>
                                    <div class="text-sm text-gray-500 mt-2">
                                        <span>Reported by: {{ $borrow->reported_by_user->name ?? 'System' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($borrow->extended_date)
                            <!-- Extension Event -->
                            <div class="relative flex items-start mb-6 pl-16">
                                <div class="absolute left-0 bg-blue-500 rounded-full w-12 h-12 flex items-center justify-center text-white">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="bg-blue-50 rounded-lg p-4 w-full">
                                    <div class="flex justify-between items-center mb-2">
                                        <h5 class="font-semibold text-blue-800">Due Date Extended</h5>
                                        <span class="text-sm text-gray-500">{{ date('M d, Y h:i A', strtotime($borrow->extended_date)) }}</span>
                                    </div>
                                    <p class="text-gray-600">Due date was extended from {{ date('M d, Y', strtotime($borrow->original_due_date)) }} to {{ date('M d, Y', strtotime($borrow->due_date)) }}</p>
                                    <div class="text-sm text-gray-500 mt-2">
                                        <span>Extended by: {{ $borrow->extended_by_user->name ?? 'System' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Notes and Comments Section -->
                    <div class="border-t border-gray-200 p-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-4">Notes and Comments</h4>
                        
                        @if(count($borrow->notes ?? []) > 0)
                            <div class="space-y-4 mb-6">
                                @foreach($borrow->notes as $note)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-start">
                                                <div class="mr-3">
                                                    @if($note->user->profile_image)
                                                        <img src="{{ asset('storage/' . $note->user->profile_image) }}" class="w-8 h-8 rounded-full object-cover">
                                                    @else
                                                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                            <i class="fas fa-user text-gray-500"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium">{{ $note->user->name }}</p>
                                                    <p class="text-gray-600 text-sm">{{ $note->content }}</p>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $note->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-lg text-center text-gray-500">
                                No notes or comments have been added yet.
                            </div>
                        @endif
                        
                        <!-- Add Note Form -->
                        <form action="" method="POST" class="mt-6">
                            @csrf
                            <div class="mb-4">
                                <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Add a Note</label>
                                <textarea id="note" name="note" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" placeholder="Enter your note or comment here..."></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                                    <i class="fas fa-plus mr-2"></i> Add Note
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
<div id="borrow-data" 
    data-borrow="{{ json_encode([
        'id' => $borrow->id,
        'status' => $borrow->status,
        'issue_date' => $borrow->issue_date,
        'due_date' => $borrow->due_date,
        'return_date' => $borrow->return_date ?? null,
        'extended_date' => $borrow->extended_date ?? null,
        'original_due_date' => $borrow->original_due_date ?? null,
        'book' => [
            'id' => $borrow->book->id,
            'title' => $borrow->book->title,
            'author' => $borrow->book->author,
            'category' => $borrow->book->category ? ['name' => $borrow->book->category->name] : null
        ],
        'student' => [
            'id' => $borrow->student->id,
            'student_id' => $borrow->student->student_id,
            'user' => [
                'name' => $borrow->student->user->name,
                'email' => $borrow->student->user->email
            ]
        ]
    ]) }}"
    style="display: none;">
</div>
    <script>
// Add this script to make sure the sidebar functions properly
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    // Receipt Modal Elements
    const receiptModal = document.getElementById('receipt-modal');
    const printReceiptButton = document.getElementById('print-receipt-button');
    const closeModalButton = document.querySelector('.close-modal');
    const closeModalBtn = document.getElementById('close-modal-button');
    const printButton = document.getElementById('print-button');
    const printReceiptContainer = document.getElementById('print-receipt');

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

    // Receipt Modal Functions
    function openReceiptModal() {
        generateReceipt();
        receiptModal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeReceiptModal() {
        receiptModal.style.display = 'none';
        document.body.style.overflow = '';
    }

    function printReceipt() {
        window.print();
    }

    function generateReceipt() {
        // Get PHP data from data attributes (we'll add these to the HTML)
        const borrowData = JSON.parse(document.getElementById('borrow-data').getAttribute('data-borrow'));
        
        // Format the current date
        const currentDate = new Date();
        const formattedDate = currentDate.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        // Calculate days left if the status is borrowed
        let daysLeftText = '';
        let daysLeftClass = '';
        
        if (borrowData.status === 'borrowed') {
            const dueDate = new Date(borrowData.due_date);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            dueDate.setHours(0, 0, 0, 0);
            
            const diffTime = dueDate - today;
            const daysLeft = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (daysLeft < 0) {
                daysLeftText = `${Math.abs(daysLeft)} days overdue`;
                daysLeftClass = 'text-red-600 font-bold';
            } else if (daysLeft === 0) {
                daysLeftText = 'Due today';
                daysLeftClass = 'text-yellow-600 font-bold';
            } else if (daysLeft === 1) {
                daysLeftText = 'Due tomorrow';
                daysLeftClass = 'text-yellow-600 font-bold';
            } else {
                daysLeftText = `${daysLeft} days left`;
                daysLeftClass = 'text-green-600';
            }
        }

        // Generate receipt HTML
        const receiptHTML = `
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold">Library Borrowing Receipt</h2>
                <p class="text-gray-500">Receipt generated on ${formattedDate}</p>
            </div>
            
            <div class="border-t border-b border-gray-200 py-4 mb-4">
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Transaction ID:</span>
                    <span>BR-${borrowData.id}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Status:</span>
                    <span class="font-medium ${borrowData.status === 'borrowed' ? 'text-blue-600' : borrowData.status === 'returned' ? 'text-green-600' : 'text-red-600'}">
                        ${borrowData.status.charAt(0).toUpperCase() + borrowData.status.slice(1)}
                    </span>
                </div>
            </div>
            
            <div class="mb-4">
                <h3 class="font-semibold text-lg mb-2">Book Details</h3>
                <div class="pl-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Title:</span>
                        <span class="font-medium">${borrowData.book.title}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Author:</span>
                        <span>${borrowData.book.author}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Book ID:</span>
                        <span>BK-${borrowData.book.id}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Category:</span>
                        <span>${borrowData.book.category ? borrowData.book.category.name : 'N/A'}</span>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <h3 class="font-semibold text-lg mb-2">Student Details</h3>
                <div class="pl-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Name:</span>
                        <span class="font-medium">${borrowData.student.user.name}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Student ID:</span>
                        <span>${borrowData.student.student_id}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Email:</span>
                        <span>${borrowData.student.user.email}</span>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <h3 class="font-semibold text-lg mb-2">Transaction Details</h3>
                <div class="pl-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Issue Date:</span>
                        <span>${new Date(borrowData.issue_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Due Date:</span>
                        <span>${new Date(borrowData.due_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                    </div>
                    ${borrowData.status === 'returned' ? `
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Return Date:</span>
                        <span>${new Date(borrowData.return_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                    </div>
                    ` : ''}
                    ${borrowData.extended_date ? `
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Extended On:</span>
                        <span>${new Date(borrowData.extended_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Original Due Date:</span>
                        <span>${new Date(borrowData.original_due_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                    </div>
                    ` : ''}
                    ${borrowData.status === 'borrowed' ? `
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Days Remaining:</span>
                        <span class="${daysLeftClass}">
                            ${daysLeftText}
                        </span>
                    </div>
                    ` : ''}
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4 mt-6">
                <div class="text-center">
                    <p class="text-sm text-gray-500">This is an electronically generated receipt.</p>
                    <p class="text-sm text-gray-500">Please keep this receipt for your records.</p>
                </div>
            </div>
        `;
        
        // Set receipt HTML to the print container
        printReceiptContainer.innerHTML = receiptHTML;
    }

    // Event listeners for receipt modal
    if (printReceiptButton) {
        printReceiptButton.addEventListener('click', openReceiptModal);
    }
    
    if (closeModalButton) {
        closeModalButton.addEventListener('click', closeReceiptModal);
    }
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeReceiptModal);
    }
    
    if (printButton) {
        printButton.addEventListener('click', printReceipt);
    }
    
    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target === receiptModal) {
            closeReceiptModal();
        }
    });
});
 </script>
</body>
</html>