<!-- Enhanced Student Sidebar with Toggle Functionality -->
<div id="sidebar" class="bg-gradient-to-b from-indigo-900 to-indigo-800 text-white w-64 min-h-screen flex flex-col justify-between transition-all duration-300 shadow-lg ">
    <!-- Logo and Brand Section -->
    <div class="px-6 py-8">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-white rounded-lg">
                <i class="fas fa-book-reader text-indigo-800 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-wider">LMS</h1>
                <p class="text-indigo-200 text-xs tracking-wide">Library Management</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-2">
        <div class="mb-4">
            <p class="text-xs font-semibold text-indigo-300 uppercase tracking-wider ml-4 mb-2">Main</p>
            @php
                $navLinks = [
                    ['route' => 'student.dashboard', 'icon' => 'tachometer-alt', 'label' => 'Dashboard'],
                    ['route' => 'student.browse.index', 'icon' => 'book', 'label' => 'Browse Books'],
                    ['route' => 'student.history.index', 'icon' => 'history', 'label' => 'Borrowing History'],
                    ['route' => 'student.notification.index', 'icon' => 'notification', 'label' => 'Notifications'],
                ];
            @endphp
            
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                    class="flex items-center py-3 px-4 mb-1 rounded-lg transition-all duration-200 {{ Route::is($link['route'] . '*') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-100 hover:bg-indigo-700/50' }}">
                    <div class="flex items-center justify-center w-8 h-8 {{ Route::is($link['route'] . '*') ? 'bg-indigo-600 text-white' : 'bg-indigo-800/50 text-indigo-300' }} rounded-lg mr-3">
                        <i class="fas fa-{{ $link['icon'] }}"></i>
                    </div>
                    <span>{{ $link['label'] }}</span>
                    @if (Route::is($link['route'] . '*'))
                        <div class="ml-auto w-1.5 h-6 bg-indigo-400 rounded-full"></div>
                    @endif
                </a>
            @endforeach
        </div>
        
        <div class="mb-4">
            <p class="text-xs font-semibold text-indigo-300 uppercase tracking-wider ml-4 mb-2">Account</p>
            <a href="{{ route('student.profile.index') }}"
                class="flex items-center py-3 px-4 mb-1 rounded-lg transition-all duration-200 {{ Route::is('student.profile.index*') ? 'bg-indigo-700 text-white shadow-md' : 'text-indigo-100 hover:bg-indigo-700/50' }}">
                <div class="flex items-center justify-center w-8 h-8 {{ Route::is('student.profile.index*') ? 'bg-indigo-600 text-white' : 'bg-indigo-800/50 text-indigo-300' }} rounded-lg mr-3">
                    <i class="fas fa-user-cog"></i>
                </div>
                <span>Profile</span>
                @if (Route::is('student.profile.index*'))
                    <div class="ml-auto w-1.5 h-6 bg-indigo-400 rounded-full"></div>
                @endif
            </a>
        </div>
    </nav>
    
    <!-- User Profile Section -->
    <div class="mt-auto">
        <div class="border-t border-indigo-700/50 mx-4"></div>
        
        <div class="px-4 py-6">
            <div class="bg-indigo-800/70 p-4 rounded-xl">
                <div class="flex items-center">
                    <div class="relative">
                        <img src="{{ asset('storage/' . Auth::user()->img) }}" alt="Student profile" 
                             class="h-12 w-12 rounded-full object-cover border-2 border-indigo-400">
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-indigo-800"></div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-indigo-300">{{ Auth::user()->student->student_id ?? 'ID not available' }}</p>
                    </div>
                </div>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full py-2 bg-indigo-700 hover:bg-indigo-600 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i> 
                        <span class="text-sm font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Toggle Button -->
<div id="sidebar-toggle" class="fixed bottom-5 right-5 lg:hidden z-50 bg-indigo-700 text-white rounded-full p-3 shadow-lg cursor-pointer hover:bg-indigo-600 transition-all">
    <i id="sidebar-icon" class="fas fa-bars"></i>
</div>

<script>
    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarIcon = document.getElementById('sidebar-icon');
        let sidebarOpen = true;
        
        // Check if we're on mobile
        const isMobile = window.innerWidth < 1024;
        
        // If mobile, start with closed sidebar
        if (isMobile) {
            sidebar.classList.add('-translate-x-full');
            sidebarOpen = false;
        }
        
        sidebarToggle.addEventListener('click', function() {
            if (sidebarOpen) {
                sidebar.classList.add('-translate-x-full');
                sidebarIcon.classList.remove('fa-times');
                sidebarIcon.classList.add('fa-bars');
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebarIcon.classList.remove('fa-bars');
                sidebarIcon.classList.add('fa-times');
            }
            sidebarOpen = !sidebarOpen;
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (isMobile && sidebarOpen && !sidebar.contains(event.target) && event.target !== sidebarToggle && !sidebarToggle.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
                sidebarIcon.classList.remove('fa-times');
                sidebarIcon.classList.add('fa-bars');
                sidebarOpen = false;
            }
        });
    });
</script>