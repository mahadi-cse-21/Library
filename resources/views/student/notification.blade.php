<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Student Notifications</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">

    
            @include('layouts.studentsidebar')
        

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow flex items-center justify-between p-4">
                <div class="flex items-center">
                    <button class="text-gray-500 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Notifications</h2>
                </div>
                
                <!-- Notification Actions -->
                <div class="flex items-center space-x-3">
                    <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Mark All as Read
                    </button>
                    <div class="relative">
                        <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Notification Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                
                <!-- Notification Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-blue-100 text-blue-500">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">Total Notifications</p>
                                <h4 class="text-lg font-bold text-gray-700">2</h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-red-100 text-red-500">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">Unread</p>
                                <h4 class="text-lg font-bold text-gray-700">2</h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-yellow-100 text-yellow-500">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">Due Reminders</p>
                                <h4 class="text-lg font-bold text-gray-700">1</h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-green-100 text-green-500">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">Confirmations</p>
                                <h4 class="text-lg font-bold text-gray-700">0</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-8 px-6" aria-label="Tabs">
                            <button onclick="filterNotifications('all')" class="filter-tab active border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                All Notifications
                            </button>
                            <button onclick="filterNotifications('unread')" class="filter-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Unread
                            </button>
                            <button onclick="filterNotifications('overdue')" class="filter-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Overdue
                            </button>
                            <button onclick="filterNotifications('reservations')" class="filter-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Reservations
                            </button>
                            <button onclick="filterNotifications('announcements')" class="filter-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Announcements
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Notifications List -->
                <div class="bg-white rounded-lg shadow">
                    <div class="divide-y divide-gray-200">
                        
                        <!-- Sample Notification 1 - Overdue Book -->
                        <div class="notification-item p-6 hover:bg-gray-50 bg-red-50 border-l-4 border-red-500" data-type="overdue" data-read="false">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-500 flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">Book Overdue</h4>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-500">2 hours ago</span>
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Your book "Advanced Database Systems" is overdue. Please return it to avoid additional fines.</p>
                                    <div class="mt-2 text-xs text-gray-500">Due Date: March 20, 2025</div>
                                    <div class="mt-3 flex items-center space-x-3">
                                        <button onclick="markAsRead(1)" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Mark as Read</button>
                                        <button class="text-xs text-red-600 hover:text-red-800 font-medium">Renew Book</button>
                                        <button onclick="deleteNotification(1)" class="text-xs text-gray-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sample Notification 2 - Due Soon -->
                        <div class="notification-item p-6 hover:bg-gray-50 bg-yellow-50 border-l-4 border-yellow-500" data-type="due_soon" data-read="false">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">Book Due Tomorrow</h4>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-500">5 hours ago</span>
                                            <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Reminder: "Data Structures and Algorithms" is due tomorrow. Don't forget to return or renew it.</p>
                                    <div class="mt-2 text-xs text-gray-500">Due Date: March 24, 2025</div>
                                    <div class="mt-3 flex items-center space-x-3">
                                        <button onclick="markAsRead(2)" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Mark as Read</button>
                                        <button class="text-xs text-green-600 hover:text-green-800 font-medium">Renew Now</button>
                                        <button onclick="deleteNotification(2)" class="text-xs text-gray-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div id="empty-state" class="hidden p-12 text-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-bell-slash text-gray-400 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications found</h3>
                            <p class="text-gray-500">You're all caught up! Check back later for new notifications.</p>
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
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.querySelector('button i.fa-bars');
            const sidebar = document.querySelector('.w-64');

            toggleButton?.parentElement?.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
            });
        });

        // Filter notifications
        function filterNotifications(type) {
            const notifications = document.querySelectorAll('.notification-item');
            const tabs = document.querySelectorAll('.filter-tab');
            const emptyState = document.getElementById('empty-state');
            let visibleCount = 0;

            // Update active tab
            tabs.forEach(tab => {
                tab.classList.remove('active', 'border-blue-500', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-gray-500');
            });
            event.target.classList.add('active', 'border-blue-500', 'text-blue-600');
            event.target.classList.remove('border-transparent', 'text-gray-500');

            // Filter notifications
            notifications.forEach(notification => {
                const notificationType = notification.dataset.type;
                const isRead = notification.dataset.read === 'true';

                let shouldShow = false;
                
                if (type === 'all') {
                    shouldShow = true;
                } else if (type === 'unread') {
                    shouldShow = !isRead;
                } else if (type === 'overdue') {
                    shouldShow = notificationType === 'overdue';
                } else if (type === 'reservations') {
                    shouldShow = notificationType === 'reservation';
                } else if (type === 'announcements') {
                    shouldShow = notificationType === 'announcement';
                }

                if (shouldShow) {
                    notification.style.display = 'block';
                    visibleCount++;
                } else {
                    notification.style.display = 'none';
                }
            });

            // Show empty state if no notifications visible
            if (visibleCount === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        // Mark single notification as read
        function markAsRead(notificationId) {
            const notification = document.querySelector(`[onclick="markAsRead(${notificationId})"]`).closest('.notification-item');
            notification.classList.remove('bg-red-50', 'bg-yellow-50', 'bg-blue-50', 'border-l-4', 'border-red-500', 'border-yellow-500', 'border-blue-500');
            notification.dataset.read = 'true';
            
            // Remove unread indicator
            const unreadDot = notification.querySelector('.w-2.h-2');
            if (unreadDot) unreadDot.remove();
            
            // Remove mark as read button
            const markReadBtn = notification.querySelector('[onclick*="markAsRead"]');
            if (markReadBtn) markReadBtn.remove();
            
            console.log(`Marked notification ${notificationId} as read`);
        }

        // Mark all notifications as read
        function markAllAsRead() {
            const unreadNotifications = document.querySelectorAll('[data-read="false"]');
            unreadNotifications.forEach(notification => {
                notification.classList.remove('bg-red-50', 'bg-yellow-50', 'bg-blue-50', 'border-l-4', 'border-red-500', 'border-yellow-500', 'border-blue-500');
                notification.dataset.read = 'true';
                
                // Remove unread indicators
                const unreadDot = notification.querySelector('.w-2.h-2');
                if (unreadDot) unreadDot.remove();
                
                // Remove mark as read buttons
                const markReadBtn = notification.querySelector('[onclick*="markAsRead"]');
                if (markReadBtn) markReadBtn.remove();
            });
            
            console.log('Marked all notifications as read');
        }

        // Delete notification
        function deleteNotification(notificationId) {
            if (confirm('Are you sure you want to delete this notification?')) {
                const notification = document.querySelector(`[onclick="deleteNotification(${notificationId})"]`).closest('.notification-item');
                notification.style.transition = 'opacity 0.3s';
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                    
                    // Check if any notifications remain
                    const remainingNotifications = document.querySelectorAll('.notification-item').length;
                    if (remainingNotifications === 0) {
                        document.getElementById('empty-state').classList.remove('hidden');
                    }
                }, 300);
                
                console.log(`Deleted notification ${notificationId}`);
            }
        }
    </script>

</body>
</html>