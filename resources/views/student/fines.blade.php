<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - My Fines</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 hidden lg:block">
            <!-- Sidebar content -->
            <div class="p-6 font-bold text-lg">Student Menu</div>
            <ul class="space-y-4 p-6">
                <li><a href="#" class="hover:text-gray-300"><i class="fas fa-home mr-2"></i> Dashboard</a></li>
                <li><a href="#" class="hover:text-gray-300"><i class="fas fa-book mr-2"></i> My Books</a></li>
                <li><a href="#" class="hover:text-gray-300"><i class="fas fa-money-bill-wave mr-2"></i> My Fines</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow flex items-center justify-between p-4">
                <div class="flex items-center">
                    <button class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-700 ml-4">My Fines</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="w-64 pr-8 pl-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button class="absolute right-2 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <button class="flex items-center text-gray-500 focus:outline-none relative">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute h-2 w-2 top-0 right-0 bg-red-500 rounded-full"></span>
                    </button>
                </div>
            </header>

            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">

                <!-- Fines Summary Section -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Fines & Payments</h2>
                            <p class="text-gray-600 mt-1">View and manage your library fines and payments.</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-md">
                                <i class="fas fa-credit-card mr-2"></i>
                                Pay All Fines
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Fines Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <i class="fas fa-exclamation-circle text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Unpaid Fines</h3>
                                <p class="text-2xl font-bold text-gray-800">$12.50</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Paid Fines</h3>
                                <p class="text-2xl font-bold text-gray-800">$25.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <i class="fas fa-history text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Recent Activity</h3>
                                <p class="text-2xl font-bold text-gray-800">3 items</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <form method="GET" action="">
                    <!-- Filtering form skipped for now -->
                </form>

                <!-- Unpaid Fines Section -->
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Unpaid Fines</h3>
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fine Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-md object-cover" src="https://covers.openlibrary.org/b/id/10531578-L.jpg" alt="Book Cover">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Introduction to Algorithms</div>
                                            <div class="text-sm text-gray-500">Thomas H. Cormen</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">Overdue Fine</div>
                                    <div class="text-sm text-gray-500">Issued on Feb 1, 2025</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Mar 1, 2025</div>
                                    <div class="text-sm text-red-500">5 days overdue</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-red-600">$7.50</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white text-xs py-1 px-3 rounded-md">
                                        Pay Now
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-md object-cover" src="https://covers.openlibrary.org/b/id/11153245-L.jpg" alt="Book Cover">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Clean Code</div>
                                            <div class="text-sm text-gray-500">Robert C. Martin</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">Overdue Fine</div>
                                    <div class="text-sm text-gray-500">Issued on Jan 25, 2025</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Feb 25, 2025</div>
                                    <div class="text-sm text-red-500">10 days overdue</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-red-600">$5.00</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white text-xs py-1 px-3 rounded-md">
                                        Pay Now
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Payment History Section -->
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Payment History</h3>
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">TXN-987654</td>
                                <td class="px-6 py-4">Fine Payment - Database Systems</td>
                                <td class="px-6 py-4">Apr 5, 2025</td>
                                <td class="px-6 py-4">$12.00</td>
                                <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 px-2 inline-flex text-xs leading-5 font-semibold rounded-full">Credit Card</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-blue-600 hover:text-blue-900"><i class="fas fa-download mr-1"></i>Receipt</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Fine Policy -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Library Fine Policy</h3>
                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-2">
                        <li>Overdue books incur a fine of $0.50 per day.</li>
                        <li>Damaged books fined depending on severity.</li>
                        <li>Lost books require replacement + $10 processing fee.</li>
                        <li>Borrowing blocked if fines exceed $20.</li>
                        <li>All dues must be cleared before new semester.</li>
                    </ul>
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
</body>

</html>
