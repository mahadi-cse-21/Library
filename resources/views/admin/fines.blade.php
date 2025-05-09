<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <!-- Other head elements... -->
    <!-- React and ReactDOM from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/18.2.0/umd/react.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/18.2.0/umd/react-dom.production.min.js"></script>
    <!-- Make sure to use the FULL Recharts library, not the minified version that might be missing components -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/recharts/2.5.0/recharts.min.js"></script>
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
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div id="sidebar" class="md:w-64 w-full md:block hidden">
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
                    <h2 class="text-xl font-bold text-gray-700 ml-4">Fines Management</h2>
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

            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <!-- Dashboard Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Total Outstanding</p>
                                <h4 class="text-2xl font-bold text-gray-800">${{ $total_outstandings }}</h4>
                            </div>
                            <div class="bg-red-100 p-3 rounded-full">
                                <i class="fas fa-money-bill-wave text-red-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-red-500 text-xs font-semibold">+8.2%</span>
                            <span class="text-gray-400 text-xs">from last month</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Collected This Month</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $this_month }}</h4>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-hand-holding-usd text-green-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-500 text-xs font-semibold">+15.3%</span>
                            <span class="text-gray-400 text-xs">from last month</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Students with Fines</p>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $student_with_fines }}</h4>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <i class="fas fa-users text-yellow-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-yellow-500 text-xs font-semibold">+3.7%</span>
                            <span class="text-gray-400 text-xs">from last week</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Waived Fines</p>
                                <h4 class="text-2xl font-bold text-gray-800">$152.75</h4>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-ban text-blue-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-blue-500 text-xs font-semibold">-1.8%</span>
                            <span class="text-gray-400 text-xs">from last month</span>
                        </div>
                    </div>
                </div>

                <!-- Fines Actions Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h4>
                        <div class="space-y-4">
                            <button
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded flex items-center justify-center">
                                <i class="fas fa-bell mr-2"></i>
                                Send Overdue Reminders
                            </button>
                            <button
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded flex items-center justify-center">
                                <i class="fas fa-file-export mr-2"></i>
                                Generate Fine Report
                            </button>
                            <button
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded flex items-center justify-center">
                                <i class="fas fa-search mr-2"></i>
                                Find Student Fines
                            </button>
                            <button
                                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded flex items-center justify-center">
                                <i class="fas fa-trash-alt mr-2"></i>
                                Clear All Paid Fines
                            </button>
                        </div>
                    </div>

                    <!-- Fine Statistics -->
                    <div id="monthly-fine-collection-chart" class="col-span-2"></div>
                </div>

                <!-- Outstanding Fines Table -->
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h4 class="text-lg font-semibold text-gray-800">Outstanding Fines</h4>
                        <div>
                            <button class="text-sm text-indigo-600 hover:text-indigo-800">Export</button>
                            <button class="text-sm text-indigo-600 hover:text-indigo-800 ml-3">Send Reminders</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Book</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Days Overdue</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fine Amount</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($fines as $fine)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img src="" alt="Student"
                                                     class="h-10 w-10 rounded-full">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $fine->student->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $fine->student->student_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $fine->borrow->book_copy->book->title ?? 'Unknown Book' }}</div>
                                        <div class="text-sm text-gray-500">{{ $fine->borrow->book->author ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $fine->borrow->due_date }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $daysLate = now()->diffInDays($fine->borrow->due_date);
                                        @endphp
                                        <div class="text-sm text-red-600">{{ $daysLate }} days</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">${{ number_format($fine->amount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="" class="text-green-600 hover:text-green-900 mr-3">Collect</a>
                                        <a href="" class="text-red-600 hover:text-red-900">Waive</a>
                                    
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex justify-between">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of
                                <span class="font-medium">42</span> results
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">Previous</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-indigo-600 text-white">1</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">2</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">3</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">Next</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fine Payment History -->
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800">Payment History</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Book</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fine Amount</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment Method</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Olivia Parker</div>
                                                <div class="text-sm text-gray-500">ST20345</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Brave New World</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">$14.00</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">27 Apr 2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Credit Card</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-file-invoice mr-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Noah Patel</div>
                                                <div class="text-sm text-gray-500">ST18764</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">The Hobbit</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">$32.50</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">26 Apr 2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">PayPal</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-file-invoice mr-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Emma Wilson</div>
                                                <div class="text-sm text-gray-500">ST22109</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Fahrenheit 451</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">$9.75</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">25 Apr 2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Cash</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-file-invoice mr-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Ethan Brown</div>
                                                <div class="text-sm text-gray-500">ST19876</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Lord of the Flies</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">$21.25</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">23 Apr 2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Debit Card</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-file-invoice mr-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Sophia Martinez</div>
                                                <div class="text-sm text-gray-500">ST21567</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Animal Farm</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">$16.50</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">22 Apr 2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Mobile Payment</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-file-invoice mr-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex justify-between">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of
                                <span class="font-medium">28</span> results
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">Previous</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-indigo-600 text-white">1</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">2</button>
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-700">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script type="text/javascript">
        // Monthly fine collection data
        document.addEventListener('DOMContentLoaded', function () {
            // Get the container element
            const container = document.getElementById('monthly-fine-collection-chart');

            if (container && React && ReactDOM && Recharts) {
                const { useState } = React;
                const {
                    LineChart, Line, XAxis, YAxis, CartesianGrid,
                    Tooltip, Legend, ResponsiveContainer
                } = Recharts;

                // Monthly fine collection data
                const fineCollectionData = [
                    { month: 'Nov', amount: 580.25 },
                    { month: 'Dec', amount: 620.75 },
                    { month: 'Jan', amount: 590.50 },
                    { month: 'Feb', amount: 640.25 },
                    { month: 'Mar', amount: 680.00 },
                    { month: 'Apr', amount: 734.25 }
                ];

                // Calculate percentage change
                const percentChange = ((fineCollectionData[fineCollectionData.length - 1].amount -
                    fineCollectionData[fineCollectionData.length - 2].amount) /
                    fineCollectionData[fineCollectionData.length - 2].amount * 100).toFixed(1);
                const isIncrease = percentChange > 0;

                // Define the React component
                function MonthlyFineCollectionChart() {
                    const [activeTab, setActiveTab] = React.useState('chart');

                    return React.createElement('div', {
                        className: 'bg-white rounded-lg shadow p-6 col-span-2'
                    }, [
                        // Header with title and controls
                        React.createElement('div', {
                            className: 'flex justify-between items-center mb-6',
                            key: 'header'
                        }, [
                            React.createElement('h4', {
                                className: 'text-lg font-semibold text-gray-800',
                                key: 'title'
                            }, 'Monthly Fine Collection'),
                            React.createElement('div', {
                                className: 'flex items-center',
                                key: 'controls'
                            }, [
                                React.createElement('span', {
                                    className: `flex items-center text-sm font-medium ${isIncrease ? 'text-green-500' : 'text-red-500'}`,
                                    key: 'percent-change'
                                }, [
                                    React.createElement('i', {
                                        className: `fas fa-arrow-${isIncrease ? 'up' : 'down'} mr-1`,
                                        key: 'arrow'
                                    }),
                                    `${Math.abs(percentChange)}% from last month`
                                ]),
                                React.createElement('div', {
                                    className: 'ml-4 bg-gray-100 rounded-lg p-1 flex',
                                    key: 'tabs'
                                }, [
                                    React.createElement('button', {
                                        onClick: () => setActiveTab('chart'),
                                        className: `px-3 py-1 text-sm rounded-md ${activeTab === 'chart' ? 'bg-indigo-600 text-white' : 'text-gray-700'}`,
                                        key: 'chart-tab'
                                    }, 'Chart'),
                                    React.createElement('button', {
                                        onClick: () => setActiveTab('table'),
                                        className: `px-3 py-1 text-sm rounded-md ${activeTab === 'table' ? 'bg-indigo-600 text-white' : 'text-gray-700'}`,
                                        key: 'table-tab'
                                    }, 'Table')
                                ])
                            ])
                        ]),

                        // Content area - either chart or table
                        activeTab === 'chart' ?
                            React.createElement('div', {
                                className: 'h-64',
                                key: 'chart-container'
                            },
                                React.createElement(ResponsiveContainer, {
                                    width: '100%',
                                    height: '100%'
                                },
                                    React.createElement(LineChart, {
                                        data: fineCollectionData,
                                        margin: { top: 5, right: 30, left: 20, bottom: 5 }
                                    }, [
                                        React.createElement(CartesianGrid, {
                                            strokeDasharray: '3 3',
                                            key: 'grid'
                                        }),
                                        React.createElement(XAxis, {
                                            dataKey: 'month',
                                            key: 'xaxis'
                                        }),
                                        React.createElement(YAxis, {
                                            key: 'yaxis'
                                        }),
                                        React.createElement(Tooltip, {
                                            formatter: (value) => ['$' + value, 'Amount'],
                                            labelFormatter: (label) => `Month: ${label}`,
                                            key: 'tooltip'
                                        }),
                                        React.createElement(Legend, {
                                            key: 'legend'
                                        }),
                                        React.createElement(Line, {
                                            type: 'monotone',
                                            dataKey: 'amount',
                                            name: 'Fine Amount',
                                            stroke: '#4f46e5',
                                            activeDot: { r: 8 },
                                            strokeWidth: 2,
                                            key: 'line'
                                        })
                                    ])
                                )
                            ) :
                            // Table view
                            React.createElement('div', {
                                className: 'overflow-x-auto',
                                key: 'table-container'
                            },
                                React.createElement('table', {
                                    className: 'min-w-full divide-y divide-gray-200'
                                }, [
                                    React.createElement('thead', {
                                        className: 'bg-gray-50',
                                        key: 'thead'
                                    },
                                        React.createElement('tr', {}, [
                                            React.createElement('th', {
                                                scope: 'col',
                                                className: 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider',
                                                key: 'th-month'
                                            }, 'Month'),
                                            React.createElement('th', {
                                                scope: 'col',
                                                className: 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider',
                                                key: 'th-amount'
                                            }, 'Amount Collected'),
                                            React.createElement('th', {
                                                scope: 'col',
                                                className: 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider',
                                                key: 'th-change'
                                            }, 'Change')
                                        ])
                                    ),
                                    React.createElement('tbody', {
                                        className: 'bg-white divide-y divide-gray-200',
                                        key: 'tbody'
                                    },
                                        fineCollectionData.map((month, index) => {
                                            const prevMonth = index > 0 ? fineCollectionData[index - 1].amount : null;
                                            const changePercent = prevMonth ? ((month.amount - prevMonth) / prevMonth * 100).toFixed(1) : null;
                                            const isPositive = changePercent > 0;

                                            return React.createElement('tr', {
                                                key: month.month
                                            }, [
                                                React.createElement('td', {
                                                    className: 'px-6 py-4 whitespace-nowrap',
                                                    key: `td-month-${index}`
                                                },
                                                    React.createElement('div', {
                                                        className: 'text-sm font-medium text-gray-900'
                                                    }, month.month)
                                                ),
                                                React.createElement('td', {
                                                    className: 'px-6 py-4 whitespace-nowrap',
                                                    key: `td-amount-${index}`
                                                },
                                                    React.createElement('div', {
                                                        className: 'text-sm font-medium text-gray-900'
                                                    }, `$${month.amount.toFixed(2)}`)
                                                ),
                                                React.createElement('td', {
                                                    className: 'px-6 py-4 whitespace-nowrap',
                                                    key: `td-change-${index}`
                                                },
                                                    changePercent !== null ?
                                                        React.createElement('div', {
                                                            className: `text-sm font-medium flex items-center ${isPositive ? 'text-green-500' : 'text-red-500'}`
                                                        }, [
                                                            React.createElement('i', {
                                                                className: `fas fa-arrow-${isPositive ? 'up' : 'down'} mr-1`,
                                                                key: `arrow-${index}`
                                                            }),
                                                            `${Math.abs(changePercent)}%`
                                                        ]) :
                                                        React.createElement('div', {
                                                            className: 'text-sm font-medium text-gray-400'
                                                        }, '-')
                                                )
                                            ]);
                                        })
                                    )
                                ])
                            ),

                        // Footer with total and export button
                        React.createElement('div', {
                            className: 'mt-6 pt-4 border-t border-gray-200',
                            key: 'footer'
                        },
                            React.createElement('div', {
                                className: 'flex justify-between items-center'
                            }, [
                                React.createElement('div', {
                                    className: 'text-sm text-gray-500',
                                    key: 'total'
                                }, [
                                    'Total collected this year: ',
                                    React.createElement('span', {
                                        className: 'font-medium text-gray-900'
                                    }, `$${fineCollectionData.reduce((sum, month) => sum + month.amount, 0).toFixed(2)}`)
                                ]),
                                React.createElement('button', {
                                    className: 'text-sm text-indigo-600 hover:text-indigo-800 flex items-center',
                                    key: 'download'
                                }, [
                                    'Download Report',
                                    React.createElement('i', {
                                        className: 'fas fa-download ml-1'
                                    })
                                ])
                            ])
                        )
                    ]);
                }

                // Render the component
                ReactDOM.render(React.createElement(MonthlyFineCollectionChart), container);
            } else {
                console.error('Required libraries or container not loaded for the Monthly Fine Collection chart');
                if (container) {
                    container.innerHTML = '<div class="bg-white rounded-lg shadow p-6"><p class="text-red-500">Chart could not be loaded. Please check console for errors.</p></div>';
                }
            }
        });
        console.log('React loaded:', typeof React !== 'undefined');
        console.log('ReactDOM loaded:', typeof ReactDOM !== 'undefined');
        console.log('Recharts loaded:', typeof Recharts !== 'undefined');
    </script>
</body>

</html>