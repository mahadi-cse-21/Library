<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Settings</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        
        /* Tab styles */
        .settings-tab {
            padding: 0.5rem 1rem;
            font-medium;
            font-size: 0.875rem;
            border-radius: 0.375rem;
        }
        
        .settings-tab.active {
            background-color: #4f46e5;
            color: white;
        }
        
        .settings-tab:not(.active) {
            color: #374151;
        }
        
        .settings-tab:not(.active):hover {
            background-color: #f3f4f6;
        }
        
        .settings-panel {
            display: none;
        }
        
        .settings-panel.active {
            display: block;
        }
    </style>
    @include('layouts.head')
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col md:flex-row ">
        <!-- Sidebar -->
        <div class="md:w-64 w-full md:block hidden">
            <!-- Sidebar content would go here -->

            @include('layouts.adminsidebar')
        </div>
        <!-- Sidebar Overlay -->
        <div id="sidebar-overlay" class="sidebar-overlay"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow flex items-center justify-between p-4">
                <div class="flex items-center">
                    <button id="sidebar-toggle" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">System Settings</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="flex items-center text-gray-500 focus:outline-none">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute top-0 right-0 h-2 w-2 mt-1 mr-2 bg-red-500 rounded-full"></span>
                    </button>
                    <button class="flex items-center text-gray-500 focus:outline-none">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-700 focus:outline-none">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User avatar" class="h-8 w-8 rounded-full">
                            <span>Jane Smith</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Settings Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <!-- Settings Tabs and Panels -->
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="border-b border-gray-200">
                        <div class="flex overflow-x-auto p-4 space-x-4">
                            <button class="settings-tab active" data-target="general">General</button>
                            <button class="settings-tab" data-target="loan">Loan Settings</button>
                            <button class="settings-tab" data-target="notifications">Notifications</button>
                            <button class="settings-tab" data-target="users">User Management</button>
                            <button class="settings-tab" data-target="backup">Backup & Restore</button>
                            <button class="settings-tab" data-target="fines">Fine Rules</button>
                            <button class="settings-tab" data-target="system">System</button>
                        </div>
                    </div>

                    <!-- General Settings -->
                    <div id="general-panel" class="settings-panel active p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">General Settings</h3>
                        
                        <form action="/settings/update" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Library Information -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Library Information</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="library_name" class="block text-sm font-medium text-gray-700">Library Name</label>
                                            <input type="text" name="library_name" id="library_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="Baitul Kitab">
                                        </div>
                                        
                                        <div>
                                            <label for="library_address" class="block text-sm font-medium text-gray-700">Address</label>
                                            <textarea name="library_address" id="library_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">Kishoreganj</textarea>
                                        </div>
                                        
                                        <div>
                                            <label for="library_email" class="block text-sm font-medium text-gray-700">Contact Email</label>
                                            <input type="email" name="library_email" id="library_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="mahadi.cse.21@gmail.com">
                                        </div>
                                        
                                        <div>
                                            <label for="library_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                                            <input type="text" name="library_phone" id="library_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="+8801780689788">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- System Preferences -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">System Preferences</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="default_language" class="block text-sm font-medium text-gray-700">Default Language</label>
                                            <select id="default_language" name="default_language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option selected value="en">English</option>
                                                <option value="es">Spanish</option>
                                                <option value="fr">French</option>
                                                <option value="bn">Bangla</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                                            <select id="timezone" name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="UTC">UTC</option>
                                                <option selected value="Dhaka">Dhaka</option>
                                                <option value="Kishoreganj">Kishoreganj</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="date_format" class="block text-sm font-medium text-gray-700">Date Format</label>
                                            <select id="date_format" name="date_format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="Y-m-d">YYYY-MM-DD</option>
                                                <option selected value="m/d/Y">MM/DD/YYYY</option>
                                                <option value="d/m/Y">DD/MM/YYYY</option>
                                            </select>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="enable_public_catalog" name="enable_public_catalog" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="enable_public_catalog" class="font-medium text-gray-700">Enable Public Catalog</label>
                                                <p class="text-gray-500">Allow visitors to browse the catalog without logging in</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-end">
                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Loan Settings -->
                    <div id="loan-panel" class="settings-panel p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Loan Settings</h3>
                        
                        <form action="/settings/loan/update" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Loan Durations -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Loan Durations</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="default_loan_days" class="block text-sm font-medium text-gray-700">Default Loan Period (Days)</label>
                                            <input type="number" name="default_loan_days" id="default_loan_days" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="14">
                                        </div>
                                        
                                        <div>
                                            <label for="max_loan_days" class="block text-sm font-medium text-gray-700">Maximum Loan Period (Days)</label>
                                            <input type="number" name="max_loan_days" id="max_loan_days" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="30">
                                        </div>
                                        
                                        <div>
                                            <label for="staff_loan_days" class="block text-sm font-medium text-gray-700">Staff Loan Period (Days)</label>
                                            <input type="number" name="staff_loan_days" id="staff_loan_days" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="60">
                                        </div>
                                        
                                        <div>
                                            <label for="reserve_days" class="block text-sm font-medium text-gray-700">Reservation Hold Period (Days)</label>
                                            <input type="number" name="reserve_days" id="reserve_days" min="1" max="14" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="3">
                                            <p class="mt-1 text-sm text-gray-500">Number of days a reserved book will be held</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Loan Limits -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Loan Limits</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="max_books_per_student" class="block text-sm font-medium text-gray-700">Maximum Books Per Student</label>
                                            <input type="number" name="max_books_per_student" id="max_books_per_student" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="5">
                                        </div>
                                        
                                        <div>
                                            <label for="max_books_per_faculty" class="block text-sm font-medium text-gray-700">Maximum Books Per Faculty</label>
                                            <input type="number" name="max_books_per_faculty" id="max_books_per_faculty" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="10">
                                        </div>
                                        
                                        <div>
                                            <label for="max_renewals" class="block text-sm font-medium text-gray-700">Maximum Renewals Allowed</label>
                                            <input type="number" name="max_renewals" id="max_renewals" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="2">
                                        </div>
                                        
                                        <div>
                                            <label for="renewal_period" class="block text-sm font-medium text-gray-700">Renewal Period (Days)</label>
                                            <input type="number" name="renewal_period" id="renewal_period" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="7">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-end">
                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Notifications Settings -->
                    <div id="notifications-panel" class="settings-panel p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Notification Settings</h3>
                        
                        <form action="/settings/notifications/update" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Email Notifications -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Email Notifications</h4>
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="send_due_reminder" name="send_due_reminder" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="send_due_reminder" class="font-medium text-gray-700">Due Date Reminders</label>
                                                <p class="text-gray-500">Send reminders before books are due</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="due_reminder_days" class="block text-sm font-medium text-gray-700">Days Before Due Date</label>
                                            <input type="number" name="due_reminder_days" id="due_reminder_days" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="3">
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="send_overdue_notice" name="send_overdue_notice" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="send_overdue_notice" class="font-medium text-gray-700">Overdue Notices</label>
                                                <p class="text-gray-500">Send notifications for overdue books</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="send_reservation_notice" name="send_reservation_notice" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="send_reservation_notice" class="font-medium text-gray-700">Reservation Notifications</label>
                                                <p class="text-gray-500">Notify when reserved books are available</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- SMS Notifications -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">SMS Notifications</h4>
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="enable_sms" name="enable_sms" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="enable_sms" class="font-medium text-gray-700">Enable SMS Notifications</label>
                                                <p class="text-gray-500">Send important notices via SMS</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="sms_provider" class="block text-sm font-medium text-gray-700">SMS Provider</label>
                                            <select id="sms_provider" name="sms_provider" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option selected value="twilio">Twilio</option>
                                                <option value="nexmo">Nexmo</option>
                                                <option value="aws_sns">AWS SNS</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="sms_api_key" class="block text-sm font-medium text-gray-700">API Key</label>
                                            <input type="password" name="sms_api_key" id="sms_api_key" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="****************************">
                                        </div>
                                        
                                        <div>
                                            <label for="sms_from_number" class="block text-sm font-medium text-gray-700">From Number</label>
                                            <input type="text" name="sms_from_number" id="sms_from_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="+15551234567">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-end">
                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- User Management Settings -->
                    <div id="users-panel" class="settings-panel p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">User Management Settings</h3>
                        
                        <form action="/settings/users/update" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Account Settings -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Account Settings</h4>
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="allow_self_registration" name="allow_self_registration" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="allow_self_registration" class="font-medium text-gray-700">Allow Self Registration</label>
                                                <p class="text-gray-500">Users can create their own accounts</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="require_email_verification" name="require_email_verification" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="require_email_verification" class="font-medium text-gray-700">Require Email Verification</label>
                                                <p class="text-gray-500">New users must verify their email</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="password_min_length" class="block text-sm font-medium text-gray-700">Minimum Password Length</label>
                                            <input type="number" name="password_min_length" id="password_min_length" min="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="8">
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="require_strong_password" name="require_strong_password" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="require_strong_password" class="font-medium text-gray-700">Require Strong Passwords</label>
                                                <p class="text-gray-500">Passwords must contain letters, numbers, and symbols</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- User Roles -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">User Roles</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="default_role" class="block text-sm font-medium text-gray-700">Default Role for New Users</label>
                                            <select id="default_role" name="default_role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option selected value="member">Member</option>
                                                <option value="student">Student</option>
                                                <option value="faculty">Faculty</option>
                                            </select>
                                        </div>
                                        
                                                                                    <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="allow_role_requests" name="allow_role_requests" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="allow_role_requests" class="font-medium text-gray-700">Allow Role Requests</label>
                                                <p class="text-gray-500">Users can request role changes</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="admin_approval_roles" class="block text-sm font-medium text-gray-700">Roles Requiring Admin Approval</label>
                                            <select id="admin_approval_roles" name="admin_approval_roles[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option selected value="staff">Staff</option>
                                                <option selected value="librarian">Librarian</option>
                                                <option selected value="admin">Administrator</option>
                                            </select>
                                            <p class="mt-1 text-sm text-gray-500">Hold Ctrl/Cmd to select multiple</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-end">
                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Backup & Restore Settings -->
                    <div id="backup-panel" class="settings-panel p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Backup & Restore Settings</h3>
                        
                        <form action="/settings/backup/update" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Automatic Backups -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Automatic Backups</h4>
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="enable_auto_backup" name="enable_auto_backup" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="enable_auto_backup" class="font-medium text-gray-700">Enable Automatic Backups</label>
                                                <p class="text-gray-500">System will back up data automatically</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="backup_frequency" class="block text-sm font-medium text-gray-700">Backup Frequency</label>
                                            <select id="backup_frequency" name="backup_frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="daily">Daily</option>
                                                <option selected value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="backup_time" class="block text-sm font-medium text-gray-700">Backup Time</label>
                                            <input type="time" name="backup_time" id="backup_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="02:00">
                                            <p class="mt-1 text-sm text-gray-500">Server time (24-hour format)</p>
                                        </div>
                                        
                                        <div>
                                            <label for="backup_retention" class="block text-sm font-medium text-gray-700">Retention Period (Days)</label>
                                            <input type="number" name="backup_retention" id="backup_retention" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="30">
                                            <p class="mt-1 text-sm text-gray-500">How long to keep backups</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Backup Storage -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Storage Settings</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="backup_location" class="block text-sm font-medium text-gray-700">Backup Storage</label>
                                            <select id="backup_location" name="backup_location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="local">Local Storage</option>
                                                <option selected value="s3">Amazon S3</option>
                                                <option value="dropbox">Dropbox</option>
                                                <option value="gdrive">Google Drive</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="backup_bucket" class="block text-sm font-medium text-gray-700">S3 Bucket Name</label>
                                            <input type="text" name="backup_bucket" id="backup_bucket" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="library-system-backups">
                                        </div>
                                        
                                        <div>
                                            <label for="backup_region" class="block text-sm font-medium text-gray-700">AWS Region</label>
                                            <input type="text" name="backup_region" id="backup_region" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="us-east-1">
                                        </div>
                                        
                                        <div>
                                            <label for="backup_path" class="block text-sm font-medium text-gray-700">Backup Path</label>
                                            <input type="text" name="backup_path" id="backup_path" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="/backups/library">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <button type="button" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Create Manual Backup
                                    </button>
                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Fine Rules Settings -->
                    <div id="fines-panel" class="settings-panel p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Fine Rules Settings</h3>
                        
                        <form action="/settings/fines/update" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Fine Configuration -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Fine Configuration</h4>
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="enable_fines" name="enable_fines" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="enable_fines" class="font-medium text-gray-700">Enable Fine System</label>
                                                <p class="text-gray-500">Charge fines for overdue items</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="fine_grace_period" class="block text-sm font-medium text-gray-700">Grace Period (Days)</label>
                                            <input type="number" name="fine_grace_period" id="fine_grace_period" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="2">
                                            <p class="mt-1 text-sm text-gray-500">Days after due date before fines begin</p>
                                        </div>
                                        
                                        <div>
                                            <label for="fine_amount_per_day" class="block text-sm font-medium text-gray-700">Fine Amount Per Day</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" name="fine_amount_per_day" id="fine_amount_per_day" min="0" step="0.01" class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="0.25">
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="max_fine_amount" class="block text-sm font-medium text-gray-700">Maximum Fine Amount</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" name="max_fine_amount" id="max_fine_amount" min="0" step="0.01" class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="25.00">
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">Maximum fine per item</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Payment Settings -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Payment Settings</h4>
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="allow_online_payment" name="allow_online_payment" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="allow_online_payment" class="font-medium text-gray-700">Allow Online Payments</label>
                                                <p class="text-gray-500">Users can pay fines online</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="payment_gateway" class="block text-sm font-medium text-gray-700">Payment Gateway</label>
                                            <select id="payment_gateway" name="payment_gateway" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option selected value="stripe">Stripe</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="square">Square</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="payment_api_key" class="block text-sm font-medium text-gray-700">API Key</label>
                                            <input type="password" name="payment_api_key" id="payment_api_key" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="sk_test_*****************************">
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="block_borrowing_with_fines" name="block_borrowing_with_fines" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="block_borrowing_with_fines" class="font-medium text-gray-700">Block Borrowing With Unpaid Fines</label>
                                                <p class="text-gray-500">Prevent users with unpaid fines from borrowing</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-end">
                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- System Settings -->
                    <div id="system-panel" class="settings-panel p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">System Settings</h3>
                        
                        <form action="/settings/system/update" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- System Configuration -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">System Configuration</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="app_url" class="block text-sm font-medium text-gray-700">Application URL</label>
                                            <input type="url" name="app_url" id="app_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="https://library.university.edu">
                                        </div>
                                        
                                        <div>
                                            <label for="log_level" class="block text-sm font-medium text-gray-700">Log Level</label>
                                            <select id="log_level" name="log_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="debug">Debug</option>
                                                <option selected value="info">Info</option>
                                                <option value="warning">Warning</option>
                                                <option value="error">Error</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="session_lifetime" class="block text-sm font-medium text-gray-700">Session Lifetime (Minutes)</label>
                                            <input type="number" name="session_lifetime" id="session_lifetime" min="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="120">
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="maintenance_mode" name="maintenance_mode" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="maintenance_mode" class="font-medium text-gray-700">Maintenance Mode</label>
                                                <p class="text-gray-500">Only administrators can access the system</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Mail Configuration -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-4">Mail Configuration</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="mail_driver" class="block text-sm font-medium text-gray-700">Mail Driver</label>
                                            <select id="mail_driver" name="mail_driver" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="sendmail">Sendmail</option>
                                                <option selected value="smtp">SMTP</option>
                                                <option value="mailgun">Mailgun</option>
                                                <option value="ses">Amazon SES</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="mail_host" class="block text-sm font-medium text-gray-700">SMTP Host</label>
                                            <input type="text" name="mail_host" id="mail_host" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="smtp.university.edu">
                                        </div>
                                        
                                        <div>
                                            <label for="mail_port" class="block text-sm font-medium text-gray-700">SMTP Port</label>
                                            <input type="number" name="mail_port" id="mail_port" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="587">
                                        </div>
                                        
                                        <div>
                                            <label for="mail_username" class="block text-sm font-medium text-gray-700">SMTP Username</label>
                                            <input type="text" name="mail_username" id="mail_username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="library@university.edu">
                                        </div>
                                        
                                        <div>
                                            <label for="mail_password" class="block text-sm font-medium text-gray-700">SMTP Password</label>
                                            <input type="password" name="mail_password" id="mail_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="********">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-end">
                                    <button type="button" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                                        Test Mail Configuration
                                    </button>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript for tab switching -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            const tabs = document.querySelectorAll('.settings-tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs and panels
                    document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
                    
                    // Add active class to the clicked tab and its corresponding panel
                    this.classList.add('active');
                    const target = this.getAttribute('data-target');
                    document.getElementById(target + '-panel').classList.add('active');
                });
            });
            
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    sidebar.classList.toggle('mobile-sidebar');
                    sidebarOverlay.classList.toggle('active');
                });
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('mobile-sidebar');
                    sidebarOverlay.classList.remove('active');
                });
            }
        });
    </script>
</body>

</html>