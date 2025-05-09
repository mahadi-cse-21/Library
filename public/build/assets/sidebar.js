// scripts/sidebar.js
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    if (sidebarToggle && sidebar && overlay) {
        // Function to toggle sidebar visibility
        function toggleSidebar() {
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('mobile-sidebar');
                overlay.classList.toggle('active');

                // Prevent body scrolling when sidebar is open
                if (!sidebar.classList.contains('hidden')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
        }

        // Add click event for toggle button
        sidebarToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });

        // Close sidebar when clicking the overlay
        overlay.addEventListener('click', toggleSidebar);

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768 && sidebar.classList.contains('mobile-sidebar')) {
                sidebar.classList.remove('mobile-sidebar');
                sidebar.classList.add('hidden');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
});