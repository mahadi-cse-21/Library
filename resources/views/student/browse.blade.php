<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Browse Books</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
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
        <!-- Include the enhanced sidebar -->
        @include('layouts.studentsidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow flex items-center justify-between p-4">
                <div class="flex items-center">
                    <button id="mobile-sidebar-button" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Browse Books</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <form action="{{ route('student.browse.index') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Search for books..." value="{{ request('search') }}"
                               class="w-64 pr-8 pl-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="absolute right-2 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <button class="flex items-center text-gray-500 focus:outline-none relative">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute h-2 w-2 top-0 right-0 bg-red-500 rounded-full"></span>
                    </button>
                </div>
            </header>

            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <!-- Filters & Categories Section -->
                <form method="GET" action="{{ route('student.browse.index') }}" id="filter-form">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Library Collection</h2>
                                <p class="text-gray-600 mt-1">Browse through our extensive collection of books.</p>
                            </div>
                            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                                <select name="category" onchange="this.form.submit()"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <select name="sort" onchange="this.form.submit()"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                                    <option value="">Sort By</option>
                                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                                    <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Author</option>
                                    <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularity</option>
                                </select>

                                <select name="availability" onchange="this.form.submit()"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                                    <option value="all" {{ request('availability') == 'all' ? 'selected' : '' }}>All Books</option>
                                    <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available Now</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Popular Categories Quick Access -->
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Popular Categories</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
                    @foreach ($categories as $category)
                        <a href="{{ route('student.browse.index', ['category' => $category->id]) }}" 
                           class="bg-white rounded-lg shadow p-4 flex flex-col items-center hover:bg-indigo-50 hover:shadow-md cursor-pointer transition-all">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 mb-2">
                                @php
                                    // Map category names to Font Awesome icons
                                    $iconMap = [
                                        'Fiction' => 'fa-book-open',
                                        'Non-Fiction' => 'fa-bookmark',
                                        'Science' => 'fa-flask',
                                        'Technology' => 'fa-microchip',
                                        'History' => 'fa-history',
                                        'Biography' => 'fa-user-alt',
                                        'Art' => 'fa-palette',
                                        'Computer Science' => 'fa-laptop-code',
                                        'Mathematics' => 'fa-square-root-alt',
                                        'Philosophy' => 'fa-brain',
                                        'Psychology' => 'fa-head-side-brain',
                                        'Business' => 'fa-briefcase',
                                        'Economics' => 'fa-chart-line',
                                        'Medicine' => 'fa-stethoscope',
                                        'Law' => 'fa-gavel',
                                    ];
                                    
                                    $icon = $iconMap[$category->name] ?? 'fa-book';
                                @endphp
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-800">{{ $category->name }}</span>
                            <span class="text-xs text-gray-500">{{ $category->books_count }} books</span>
                        </a>
                    @endforeach
                </div>

                <!-- Book Listing -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Available Books</h3>
                    <p class="text-sm text-gray-500">Showing {{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }} of {{ $books->total() }} books</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach ($books as $book)
                        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow">
                            <div class="flex p-4 border-b border-gray-200">
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }} cover"
                                    class="h-36 w-24 object-cover rounded-md shadow">
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">{{ $book->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $book->author }}</p>

                                    <!-- Rating -->
                                    @php
                                        $rating = round($book->rating ?? 0, 1);
                                        $fullStars = floor($rating);
                                        $halfStar = ($rating - $fullStars) >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                    @endphp
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-yellow-400 text-xs">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            @if ($halfStar)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-500 ml-1">{{ number_format($rating, 1) }}</span>
                                    </div>

                                    <!-- Categories -->
                                    <div class="mt-2 space-x-1">
                                        @if ($book->category)
                                            <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">
                                                {{ $book->category->name }}
                                            </span>
                                            @if ($book->category->parent)
                                                <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                                                    {{ $book->category->parent->name }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-gray-50 flex justify-between items-center">
                                <div>
                                    <span class="text-sm font-medium text-gray-800">Status:</span>
                                    @php
                                        $statusColor = match ($book->status) {
                                            'Available' => 'text-green-600',
                                            'All Copies Borrowed' => 'text-red-600',
                                            '1 Copy Left' => 'text-orange-600',
                                            default => 'text-gray-600',
                                        };
                                        
                                        $statusIcon = match ($book->status) {
                                            'Available' => '<i class="fas fa-check-circle mr-1"></i>',
                                            'All Copies Borrowed' => '<i class="fas fa-times-circle mr-1"></i>',
                                            '1 Copy Left' => '<i class="fas fa-exclamation-circle mr-1"></i>',
                                            default => '',
                                        };
                                    @endphp
                                    <span class="text-sm {{ $statusColor }}">
                                        {!! $statusIcon !!}{{ $book->status }}
                                    </span>
                                </div>

                                @if (in_array($book->id, $bookIds))
                                    <!-- Already requested/borrowed by this user -->
                                    <span class="bg-gray-300 text-white text-sm py-1.5 px-3 rounded-md cursor-not-allowed">
                                        <i class="fas fa-clock mr-1"></i> Requested
                                    </span>
                                @else
                                    @if ($book->available_quantity > 0)
                                        <!-- Request Button for Available Books -->
                                        <form action="{{ route('student.borrows.store', [Auth::user()->id, $book]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="hidden" name="student_id" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm py-1.5 px-3 rounded-md transition-colors">
                                                <i class="fas fa-bookmark mr-1"></i> Request
                                            </button>
                                        </form>
                                    @else
                                        @if (in_array($book->id, $reserveBookIds))
                                            <!-- Already reserved by this user -->
                                            <span class="bg-gray-300 text-white text-sm py-1.5 px-3 rounded-md cursor-not-allowed">
                                                <i class="fas fa-calendar-check mr-1"></i> Reserved
                                            </span>
                                        @else
                                            <!-- Reserve Button for Out of Stock Books -->
                                            <form action="{{ route('student.reserve') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <input type="hidden" name="student_id" value="{{ auth()->user()->id }}">
                                                <input type="hidden" name="status" value="reserve">
                                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1.5 px-3 rounded-md transition-colors">
                                                    <i class="fas fa-clock mr-1"></i> Reserve
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Empty State when no books are found -->
                @if(count($books) == 0)
                <div class="bg-white rounded-lg shadow p-8 flex flex-col items-center justify-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-500 mb-4">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Books Found</h3>
                    <p class="text-gray-500 text-center mb-4">We couldn't find any books matching your criteria.</p>
                    <a href="{{ route('student.browse.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        <i class="fas fa-arrow-left mr-1"></i> Reset Filters
                    </a>
                </div>
                @endif

                <!-- Pagination -->
                @if($books->hasPages())
                <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between">
                    {{-- Previous --}}
                    @if ($books->onFirstPage())
                        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 border border-gray-300 rounded-md cursor-not-allowed">
                            <i class="fas fa-chevron-left mr-2"></i> Previous
                        </span>
                    @else
                        <a href="{{ $books->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <i class="fas fa-chevron-left mr-2"></i> Previous
                        </a>
                    @endif
                
                    {{-- Page Numbers --}}
                    <div class="hidden md:flex space-x-1">
                        @foreach ($books->getUrlRange(max(1, $books->currentPage() - 2), min($books->lastPage(), $books->currentPage() + 2)) as $page => $url)
                            @if ($page == $books->currentPage())
                                <span class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 rounded-md">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>
                
                    {{-- Next --}}
                    @if ($books->hasMorePages())
                        <a href="{{ $books->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Next <i class="fas fa-chevron-right ml-2"></i>
                        </a>
                    @else
                        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 border border-gray-300 rounded-md cursor-not-allowed">
                            Next <i class="fas fa-chevron-right ml-2"></i>
                        </span>
                    @endif
                </div>
                @endif
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
        // Mobile sidebar toggle script
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
   
        document.addEventListener('DOMContentLoaded', function () {
          const toggleButton = document.querySelector('button i.fa-bars');
          const sidebar = document.getElementById('sidebar');
  
          toggleButton?.parentElement?.addEventListener('click', function () {
              sidebar.classList.toggle('hidden');
          });
      });
      </script>
</body>

</html>