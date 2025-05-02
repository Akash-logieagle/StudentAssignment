<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - EduConnect</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#4f46e5',secondary:'#f97316'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background-color: #f3f4f6;
        }
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .switch-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e5e7eb;
            transition: .4s;
            border-radius: 34px;
        }
        .switch-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .switch-slider {
            background-color: #4f46e5;
        }
        input:checked + .switch-slider:before {
            transform: translateX(20px);
        }
        .custom-radio {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .custom-radio-input {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            margin-right: 8px;
            position: relative;
            cursor: pointer;
        }
        .custom-radio-input:checked {
            border-color: #4f46e5;
        }
        .custom-radio-input:checked::after {
            content: "";
            position: absolute;
            top: 3px;
            left: 3px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #4f46e5;
        }
        .custom-checkbox {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .custom-checkbox-input {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            margin-right: 8px;
            position: relative;
            cursor: pointer;
        }
        .custom-checkbox-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        .custom-checkbox-input:checked::after {
            content: "";
            position: absolute;
            top: 2px;
            left: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        .custom-range {
            -webkit-appearance: none;
            width: 100%;
            height: 6px;
            border-radius: 5px;
            background: #e5e7eb;
            outline: none;
        }
        .custom-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #4f46e5;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .custom-range::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #4f46e5;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .student-modal {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            max-width: 600px;
            background-color: white;
            z-index: 50;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        .add-student-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 500px;
            background-color: white;
            z-index: 50;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-height: calc(100vh - 100px);
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-col md:w-64 bg-white shadow-sm">
            <div class="p-4 flex items-center">
                <span class="font-['Pacifico'] text-primary text-2xl">EduConnect</span>
            </div>
            <div class="p-4">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                        <i class="ri-user-line text-primary ri-lg"></i>
                    </div>
                    <div>
                        <p class="font-medium">Emily Johnson</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">Teacher</span>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto custom-scrollbar">
                <a href="https://readdy.ai/home/b8e20487-1c5f-4382-bb15-ebd7a3c4d48a/c7194a38-0291-4ef5-acc3-195b70ab57d1" data-readdy="true" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg">
                    <div class="w-6 h-6 mr-3 flex items-center justify-center">
                        <i class="ri-dashboard-line"></i>
                    </div>
                    Dashboard
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-primary bg-primary/10 rounded-lg">
                    <div class="w-6 h-6 mr-3 flex items-center justify-center">
                        <i class="ri-user-line"></i>
                    </div>
                    Students
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg">
                    <div class="w-6 h-6 mr-3 flex items-center justify-center">
                        <i class="ri-calendar-line"></i>
                    </div>
                    Attendance
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg">
                    <div class="w-6 h-6 mr-3 flex items-center justify-center">
                        <i class="ri-book-open-line"></i>
                    </div>
                    Assignments
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg">
                    <div class="w-6 h-6 mr-3 flex items-center justify-center">
                        <i class="ri-bar-chart-line"></i>
                    </div>
                    Grades
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg">
                    <div class="w-6 h-6 mr-3 flex items-center justify-center">
                        <i class="ri-message-2-line"></i>
                    </div>
                    Messages
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg">
                    <div class="w-6 h-6 mr-3 flex items-center justify-center">
                        <i class="ri-calendar-event-line"></i>
                    </div>
                    Events
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg">
                    <div class="w-6 h-6 mr-3 flex items-center justify-center">
                        <i class="ri-settings-line"></i>
                    </div>
                    Settings
                </a>
            </nav>
            <div class="p-4 border-t">
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg">
                    <div class="w-6 h-6 mr-3 flex items-center justify-center">
                        <i class="ri-logout-box-line"></i>
                    </div>
                    Logout
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center md:hidden">
                        <button type="button" class="text-gray-500 hover:text-gray-600 p-2 rounded-md">
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="ri-menu-line"></i>
                            </div>
                        </button>
                        <span class="font-['Pacifico'] text-primary text-xl ml-2">EduConnect</span>
                    </div>
                    <div class="hidden md:flex items-center flex-1 px-4">
                        <div class="relative max-w-md w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <div class="w-5 h-5 flex items-center justify-center text-gray-400">
                                    <i class="ri-search-line"></i>
                                </div>
                            </div>
                            <input type="text" class="bg-gray-50 border-none text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5 focus:ring-2 focus:ring-primary/20 focus:outline-none" placeholder="Search students, classes, or activities...">
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button type="button" class="relative p-2 text-gray-500 hover:text-gray-600 rounded-full">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <i class="ri-notification-3-line"></i>
                                </div>
                                <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center text-xs text-white">3</span>
                            </button>
                        </div>
                        <div class="relative">
                            <button type="button" class="relative p-2 text-gray-500 hover:text-gray-600 rounded-full">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <i class="ri-message-2-line"></i>
                                </div>
                                <span class="absolute top-0 right-0 h-4 w-4 bg-primary rounded-full flex items-center justify-center text-xs text-white">5</span>
                            </button>
                        </div>
                        <div class="relative ml-2">
                            <button type="button" class="flex items-center text-sm rounded-full focus:outline-none">
                                <img class="h-8 w-8 rounded-full object-cover" src="https://readdy.ai/api/search-image?query=professional%2520portrait%2520of%2520a%2520female%2520teacher%2520with%2520brown%2520hair%252C%2520warm%2520smile%252C%2520business%2520casual%2520attire%252C%2520neutral%2520background%252C%2520high%2520quality%252C%2520photorealistic&width=200&height=200&seq=teacher1&orientation=squarish" alt="User">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="border-b border-gray-200 px-4 py-2 flex items-center overflow-x-auto custom-scrollbar">
                    <div class="flex space-x-4">
                        <a href="https://readdy.ai/home/b8e20487-1c5f-4382-bb15-ebd7a3c4d48a/c7194a38-0291-4ef5-acc3-195b70ab57d1" data-readdy="true" class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Overview</a>
                        <button class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Class 8A</button>
                        <button class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Class 9B</button>
                        <button class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Class 10C</button>
                        <button class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Class 11A</button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 custom-scrollbar">
                <div class="max-w-7xl mx-auto">
                    <!-- Breadcrumb -->
                    <nav class="flex mb-5" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="https://readdy.ai/home/b8e20487-1c5f-4382-bb15-ebd7a3c4d48a/c7194a38-0291-4ef5-acc3-195b70ab57d1" data-readdy="true" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary">
                                    <div class="w-4 h-4 mr-2 flex items-center justify-center">
                                        <i class="ri-dashboard-line"></i>
                                    </div>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 text-gray-400 mx-1 flex items-center justify-center">
                                        <i class="ri-arrow-right-s-line"></i>
                                    </div>
                                    <span class="text-sm font-medium text-primary">Students</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <!-- Students Header -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Students</h1>
                            <p class="text-gray-600">Manage all your students in one place</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
                            <button id="importBtn" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 !rounded-button whitespace-nowrap">
                                <div class="w-4 h-4 mr-2 flex items-center justify-center">
                                    <i class="ri-upload-2-line"></i>
                                </div>
                                Import
                            </button>
                            <button id="exportBtn" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 !rounded-button whitespace-nowrap">
                                <div class="w-4 h-4 mr-2 flex items-center justify-center">
                                    <i class="ri-download-2-line"></i>
                                </div>
                                Export
                            </button>
                            <button id="addStudentBtn" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary/90 !rounded-button whitespace-nowrap">
                                <div class="w-4 h-4 mr-2 flex items-center justify-center">
                                    <i class="ri-user-add-line"></i>
                                </div>
                                Add New Student
                            </button>
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-6 border border-gray-100">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <div class="w-5 h-5 flex items-center justify-center text-gray-400">
                                            <i class="ri-search-line"></i>
                                        </div>
                                    </div>
                                    <input id="searchInput" name="search" type="text" class="bg-gray-50 border-none text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5 focus:ring-2 focus:ring-primary/20 focus:outline-none" placeholder="Search by name, ID, class, or email...">
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <div class="relative">
                                    <button id="classFilterBtn" data-value="*A" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 !rounded-button whitespace-nowrap">
                                        <div class="w-4 h-4 mr-2 flex items-center justify-center">
                                            <i class="ri-group-line"></i>
                                        </div>
                                        Class
                                        <div class="w-4 h-4 ml-2 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </button>
                                    <div id="classDropdown" class="absolute hidden bg-white shadow-lg rounded-lg mt-2 w-48 z-10">
                                        <ul>
                                            <li class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100">Class A</li>
                                            <li class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100">Class B</li>
                                            <li class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100">Class C</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="relative">
                                    <button id="statusFilterBtn" data-value="Active" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 !rounded-button whitespace-nowrap">
                                        <div class="w-4 h-4 mr-2 flex items-center justify-center">
                                            <i class="ri-filter-line"></i>
                                        </div>
                                        Status
                                        <div class="w-4 h-4 ml-2 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </button>
                                     <!-- Status Dropdown -->
                                    <div id="statusDropdown" class="absolute hidden bg-white shadow-lg rounded-lg mt-2 w-48 z-10">
                                        <ul>
                                            <li class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100">Active</li>

                                            <li class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100">On Leave</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="relative">
                                    <button id="performanceFilterBtn" data-value="Excellent" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 !rounded-button whitespace-nowrap">
                                        <div class="w-4 h-4 mr-2 flex items-center justify-center">
                                            <i class="ri-bar-chart-line"></i>
                                        </div>
                                        Performance
                                        <div class="w-4 h-4 ml-2 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </button>
                                     <!-- Performance Dropdown -->
                                    <div id="performanceDropdown" class="absolute hidden bg-white shadow-lg rounded-lg mt-2 w-48 z-10">
                                        <ul>
                                            <li class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100">Excellent</li>
                                            <li class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100">Good</li>
                                            <li class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100">Average</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Active Filters -->
                        <div class="flex flex-wrap gap-2 mt-4" id="activeFilters">
                            <!-- <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary/10 text-primary">
                                Class: 8A
                                <button class="ml-2 text-primary">
                                    <div class="w-4 h-4 flex items-center justify-center">
                                        <i class="ri-close-line"></i>
                                    </div>
                                </button>
                            </div>
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                Status: Active
                                <button class="ml-2 text-green-800">
                                    <div class="w-4 h-4 flex items-center justify-center">
                                        <i class="ri-close-line"></i>
                                    </div>
                                </button>
                            </div> -->
                            <button class="text-sm text-primary hover:text-primary/80" click="clearAllFilters()">
                                Clear All Filters
                            </button>
                        </div>
                    </div>

                    <!-- Students List -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 mb-6">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-lg font-medium text-gray-900">All Students <span class="text-gray-500 text-sm" id="total-student"></span></h2>
                            <div class="flex items-center">
                                <label class="custom-checkbox mr-4">
                                    <input type="checkbox" class="custom-checkbox-input" id="selectAllStudents">
                                    <span class="text-sm text-gray-700">Select All</span>
                                </label>
                                <div class="relative">
                                    <button id="bulkActionsBtn" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 !rounded-button whitespace-nowrap">
                                        Bulk Actions
                                        <div class="w-4 h-4 ml-2 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="student-list">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                            <span class="sr-only">Select</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Class
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Performance
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Attendance
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody   class="bg-white divide-y divide-gray-200">

                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div id="pagination" class="px-6 py-3 flex items-center justify-between border-t border-gray-200">
    <div class="flex-1 flex justify-between sm:hidden">
        <button id="mobile-prev" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 !rounded-button whitespace-nowrap">
            Previous
        </button>
        <button id="mobile-next" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 !rounded-button whitespace-nowrap">
            Next
        </button>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p id="pagination-summary" class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">7</span> of <span class="font-medium">128</span> students
            </p>
        </div>
        <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination" id="pagination-buttons">
                <!-- JS will inject buttons here -->
            </nav>
        </div>
    </div>
</div>

                    </div>

                    <!-- Quick Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Students Card -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100" id="totalStudentsCard">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mr-4">
                <div class="w-6 h-6 flex items-center justify-center text-primary">
                    <i class="ri-user-line"></i>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Students</p>
                <h3 class="text-2xl font-bold text-gray-900" id="totalStudents">128</h3>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <div class="w-4 h-4 flex items-center justify-center text-green-500 mr-1">
                <i class="ri-arrow-up-line"></i>
            </div>
            <span class="text-green-500 font-medium" id="totalStudentsPercentage">3.2%</span>
            <span class="text-gray-500 ml-1">from last month</span>
        </div>
    </div>

    <!-- Average Performance Card -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100" id="averagePerformanceCard">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                <div class="w-6 h-6 flex items-center justify-center text-blue-600">
                    <i class="ri-bar-chart-line"></i>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Average Performance</p>
                <h3 class="text-2xl font-bold text-gray-900" id="averagePerformance">76%</h3>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <div class="w-4 h-4 flex items-center justify-center text-green-500 mr-1">
                <i class="ri-arrow-up-line"></i>
            </div>
            <span class="text-green-500 font-medium" id="averagePerformancePercentage">2.5%</span>
            <span class="text-gray-500 ml-1">from last semester</span>
        </div>
    </div>

    <!-- Attendance Rate Card -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100" id="attendanceRateCard">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                <div class="w-6 h-6 flex items-center justify-center text-green-600">
                    <i class="ri-calendar-check-line"></i>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Attendance Rate</p>
                <h3 class="text-2xl font-bold text-gray-900" id="attendanceRate">92%</h3>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <div class="w-4 h-4 flex items-center justify-center text-green-500 mr-1">
                <i class="ri-arrow-up-line"></i>
            </div>
            <span class="text-green-500 font-medium" id="attendanceRatePercentage">1.8%</span>
            <span class="text-gray-500 ml-1">from last month</span>
        </div>
    </div>

    <!-- At-Risk Students Card -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100" id="atRiskStudentsCard">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mr-4">
                <div class="w-6 h-6 flex items-center justify-center text-amber-600">
                    <i class="ri-flag-line"></i>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">At-Risk Students</p>
                <h3 class="text-2xl font-bold text-gray-900" id="atRiskStudents">12</h3>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <div class="w-4 h-4 flex items-center justify-center text-red-500 mr-1">
                <i class="ri-arrow-up-line"></i>
            </div>
            <span class="text-red-500 font-medium" id="atRiskStudentsPercentage">2.1%</span>
            <span class="text-gray-500 ml-1">from last month</span>
        </div>
    </div>
</div>


                    <!-- Performance Distribution Chart -->
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-medium text-gray-900">Performance Distribution</h2>
                            <div class="relative">
                                <button class="text-gray-400 hover:text-gray-500 flex items-center text-sm">
                                    All Classes
                                    <div class="w-4 h-4 ml-1 flex items-center justify-center">
                                        <i class="ri-arrow-down-s-line"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="h-80" id="performance-distribution-chart"></div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-10">
        <div class="flex justify-around">
            <a href="https://readdy.ai/home/b8e20487-1c5f-4382-bb15-ebd7a3c4d48a/c7194a38-0291-4ef5-acc3-195b70ab57d1" data-readdy="true" class="flex flex-col items-center py-2 px-3 text-gray-500">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-dashboard-line"></i>
                </div>
                <span class="text-xs mt-1">Dashboard</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 px-3 text-primary">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-user-line"></i>
                </div>
                <span class="text-xs mt-1">Students</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 px-3 text-gray-500">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-calendar-line"></i>
                </div>
                <span class="text-xs mt-1">Schedule</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 px-3 text-gray-500">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-message-2-line"></i>
                </div>
                <span class="text-xs mt-1">Messages</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 px-3 text-gray-500">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-menu-line"></i>
                </div>
                <span class="text-xs mt-1">More</span>
            </a>
        </div>
    </div>

    <!-- Student Profile Modal -->
    <div class="modal-overlay" id="studentModalOverlay"></div>
    <div class="student-modal custom-scrollbar" id="studentProfileModal">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">Student Profile</h2>
            <button id="closeStudentModal" class="text-gray-500 hover:text-gray-700">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-close-line"></i>
                </div>
            </button>
        </div>
        <div class="p-6">
            <!-- Student Basic Info -->
            <div class="flex flex-col items-center mb-6" id="studentBasicInfo">
               
            </div>

            <!-- Student Details Tabs -->
            <div class="border-b border-gray-200 mb-6">
                <div class="flex space-x-8">
                    <button class="px-1 py-4 text-sm font-medium text-primary border-b-2 border-primary">Overview</button>
                    <button class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Academics</button>
                    <button class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Attendance</button>
                    <button class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Notes</button>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="mb-8" id="studentPersonalInfo">
                
            </div>

            <!-- Parent/Guardian Information -->
            <div class="mb-8" id="studentParentInfo">
               
            </div>

            <!-- Academic Performance -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-medium text-gray-900">Academic Performance</h4>
                    <button class="text-sm font-medium text-primary">View Full Report</button>
                </div>
                <div class="h-64" id="student-performance-chart"></div>
                <div id="subject-cards" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Mathematics</p>
                        <p class="text-lg font-medium text-gray-900">85%</p>
                        <div class="flex items-center text-xs mt-1">
                            <div class="w-3 h-3 flex items-center justify-center text-green-500 mr-1">
                                <i class="ri-arrow-up-line"></i>
                            </div>
                            <span class="text-green-500">+15%</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Science</p>
                        <p class="text-lg font-medium text-gray-900">78%</p>
                        <div class="flex items-center text-xs mt-1">
                            <div class="w-3 h-3 flex items-center justify-center text-green-500 mr-1">
                                <i class="ri-arrow-up-line"></i>
                            </div>
                            <span class="text-green-500">+5%</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">English</p>
                        <p class="text-lg font-medium text-gray-900">92%</p>
                        <div class="flex items-center text-xs mt-1">
                            <div class="w-3 h-3 flex items-center justify-center text-green-500 mr-1">
                                <i class="ri-arrow-up-line"></i>
                            </div>
                            <span class="text-green-500">+3%</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">History</p>
                        <p class="text-lg font-medium text-gray-900">75%</p>
                        <div class="flex items-center text-xs mt-1">
                            <div class="w-3 h-3 flex items-center justify-center text-red-500 mr-1">
                                <i class="ri-arrow-down-line"></i>
                            </div>
                            <span class="text-red-500">-2%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Record -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-medium text-gray-900">Attendance Record</h4>
                    <button class="text-sm font-medium text-primary">View Full Record</button>
                </div>
                <div class="h-48" id="student-attendance-chart"></div>
                <div class="flex justify-between mt-4">
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Present</p>
                        <p class="text-lg font-medium text-gray-900" id="presentPercent">--%</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Absent</p>
                        <p class="text-lg font-medium text-gray-900" id="absentPercent">--%</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Late</p>
                        <p class="text-lg font-medium text-gray-900" id="latePercent">--%</p>
                    </div>
                </div>
            </div>

            <!-- Recent Notes -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-medium text-gray-900">Recent Notes</h4>
                    <button class="text-sm font-medium text-primary">Add Note</button>
                </div>
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-gray-900">Math Progress</h5>
                            <p class="text-xs text-gray-500">April 25, 2025</p>
                        </div>
                        <p class="text-sm text-gray-700">Michael has shown significant improvement in his math problem-solving skills. His approach to complex problems is becoming more methodical.</p>
                        <p class="text-xs text-gray-500 mt-2">Added by: Emily Johnson</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-gray-900">Science Project</h5>
                            <p class="text-xs text-gray-500">April 15, 2025</p>
                        </div>
                        <p class="text-sm text-gray-700">Michael demonstrated excellent teamwork skills during the group science project. He took initiative in coordinating tasks and helped other team members.</p>
                        <p class="text-xs text-gray-500 mt-2">Added by: Robert Chen</p>
                    </div>
                </div>
            </div>

            <!-- Back to Dashboard -->
            <div class="mt-8 text-center">
                <a href="https://readdy.ai/home/b8e20487-1c5f-4382-bb15-ebd7a3c4d48a/c7194a38-0291-4ef5-acc3-195b70ab57d1" data-readdy="true" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 !rounded-button whitespace-nowrap">
                    <div class="w-4 h-4 mr-2 flex items-center justify-center">
                        <i class="ri-arrow-left-line"></i>
                    </div>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal-overlay" id="addStudentModalOverlay"></div>
    <div class="add-student-modal" id="addStudentModal">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">Add New Student</h2>
            <button id="closeAddStudentModal" class="text-gray-500 hover:text-gray-700">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-close-line"></i>
                </div>
            </button>
        </div>
        <div class="p-6">
            <form id="addStudentForm" onsubmit="addStudents(event)">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" id="firstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" placeholder="Enter first name" required>
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" id="lastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" placeholder="Enter last name" required>
                    </div>
                    <div>
                        <label for="studentEmail" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="studentEmail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" placeholder="Enter email address" required>
                    </div>
                    <div>
                        <label for="studentPhone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" id="studentPhone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" placeholder="Enter phone number">
                    </div>
                    <div>
                        <label for="studentId" class="block text-sm font-medium text-gray-700 mb-1">Student ID</label>
                        <input type="tel" id="studentId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" placeholder="Enter student ID">
                    </div>
                    <div>
                        <label for="dateOfBirth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                        <input type="date" id="dateOfBirth" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <div class="relative">
                            <div id="genderButton" class="flex items-center justify-between bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                <span>Select gender</span>
                                <div class="w-4 h-4 flex items-center justify-center">
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                            <div id="genderDropdown" class="absolute z-10 left-0 right-0 bg-white border border-gray-300 rounded-lg hidden mt-1">
                            <ul class="text-sm">
                                <li data-value="male" class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Male</li>
                                <li data-value="female" class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Female</li>
                                <li data-value="other" class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Other</li>
                            </ul>
                        </div>
                        <input type="hidden" id="gender" name="gender">
                        </div>
                    </div>
                    <div>
                        <label for="classStudentButton" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                        <div class="relative">
                            <div id="classStudentButton" class="flex items-center justify-between bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                <span>Select Class</span>
                                <div class="w-4 h-4 flex items-center justify-center">
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                            <div id="classStudentDropdown" class="absolute z-10 left-0 right-0 bg-white border border-gray-300 rounded-lg hidden mt-1">
                            <ul class="text-sm">
                                <li data-value="Class 10A" class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Class 10A</li>
                                <li data-value="Class 10B" class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Class 10B</li>
                                <li data-value="Class 9A" class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Class 9A</li>
                            </ul>
                        </div>
                        <input type="hidden" id="classStudent" name="classStudent">
                        </div>
                    </div>
                    <div>
                        <label for="enrollmentDate" class="block text-sm font-medium text-gray-700 mb-1">Enrollment Date</label>
                        <input type="date" id="enrollmentDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" placeholder="Enter full address">
                </div>

                <div class="mb-6">
                    <h3 class="text-md font-medium text-gray-900 mb-3">Parent/Guardian Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="parentName1" class="block text-sm font-medium text-gray-700 mb-1">Parent/Guardian 1 Name</label>
                            <input type="text" id="parentName1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" placeholder="Enter name">
                        </div>
                        <div>
                            <label for="relationship1" class="block text-sm font-medium text-gray-700 mb-1">Relationship</label>
                            <div class="relative">
                                <div id="studentRelationButton" class="flex items-center justify-between bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                    <span>Select relationship</span>
                                    <div class="w-4 h-4 flex items-center justify-center">
                                        <i class="ri-arrow-down-s-line"></i>
                                    </div>
                                </div>
                                <div id="studentRelationDropdown" class="absolute z-10 left-0 right-0 bg-white border border-gray-300 rounded-lg hidden mt-1">
                                    <ul class="text-sm">
                                        <li data-value="Father" class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Father</li>
                                        <li data-value="Mother" class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Mother</li>
                                        <li data-value="Guardian" class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Guardian</li>
                                    </ul>
                             </div>
                             <input type="hidden" id="studentRelation" name="studentRelation">
                            </div>
                        </div>
                        <div>
                            <label for="parentEmail1" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="parentEmail1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" placeholder="Enter email address">
                        </div>
                        <div>
                            <label for="parentPhone1" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="parentPhone1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" placeholder="Enter phone number">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelAddStudent" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 !rounded-button whitespace-nowrap">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary/90 !rounded-button whitespace-nowrap">Add Student</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Performance Distribution Chart
            // const performanceDistributionChart = echarts.init(document.getElementById('performance-distribution-chart'));
            // const performanceDistributionOption = {
            //     animation: false,
            //     tooltip: {
            //         trigger: 'axis',
            //         backgroundColor: 'rgba(255, 255, 255, 0.8)',
            //         borderColor: '#E5E7EB',
            //         textStyle: {
            //             color: '#1F2937'
            //         }
            //     },
            //     legend: {
            //         data: ['Class 8A', 'Class 9B', 'Class 10C', 'Class 11A'],
            //         bottom: 0,
            //         textStyle: {
            //             color: '#1F2937'
            //         }
            //     },
            //     grid: {
            //         left: '3%',
            //         right: '3%',
            //         top: '3%',
            //         bottom: '15%',
            //         containLabel: true
            //     },
            //     xAxis: {
            //         type: 'category',
            //         data: ['<60%', '60-70%', '70-80%', '80-90%', '90-100%'],
            //         axisLine: {
            //             lineStyle: {
            //                 color: '#E5E7EB'
            //             }
            //         },
            //         axisLabel: {
            //             color: '#6B7280'
            //         }
            //     },
            //     yAxis: {
            //         type: 'value',
            //         name: 'Number of Students',
            //         nameTextStyle: {
            //             color: '#6B7280'
            //         },
            //         axisLine: {
            //             show: false
            //         },
            //         axisLabel: {
            //             color: '#6B7280'
            //         },
            //         splitLine: {
            //             lineStyle: {
            //                 color: '#F3F4F6'
            //             }
            //         }
            //     },
            //     series: [
            //         {
            //             name: 'Class 8A',
            //             type: 'bar',
            //             data: [2, 5, 12, 8, 5],
            //             itemStyle: {
            //                 color: 'rgba(87, 181, 231, 1)',
            //                 borderRadius: [4, 4, 0, 0]
            //             },
            //             emphasis: {
            //                 itemStyle: {
            //                     opacity: 0.8
            //                 }
            //             }
            //         },
            //         {
            //             name: 'Class 9B',
            //             type: 'bar',
            //             data: [3, 7, 10, 6, 4],
            //             itemStyle: {
            //                 color: 'rgba(141, 211, 199, 1)',
            //                 borderRadius: [4, 4, 0, 0]
            //             },
            //             emphasis: {
            //                 itemStyle: {
            //                     opacity: 0.8
            //                 }
            //             }
            //         },
            //         {
            //             name: 'Class 10C',
            //             type: 'bar',
            //             data: [1, 6, 9, 10, 6],
            //             itemStyle: {
            //                 color: 'rgba(251, 191, 114, 1)',
            //                 borderRadius: [4, 4, 0, 0]
            //             },
            //             emphasis: {
            //                 itemStyle: {
            //                     opacity: 0.8
            //                 }
            //             }
            //         },
            //         {
            //             name: 'Class 11A',
            //             type: 'bar',
            //             data: [0, 4, 8, 12, 10],
            //             itemStyle: {
            //                 color: 'rgba(252, 141, 98, 1)',
            //                 borderRadius: [4, 4, 0, 0]
            //             },
            //             emphasis: {
            //                 itemStyle: {
            //                     opacity: 0.8
            //                 }
            //             }
            //         }
            //     ]
            // };
            // performanceDistributionChart.setOption(performanceDistributionOption);

            // Student Performance Chart (for modal)
            // if (document.getElementById('student-performance-chart')) {
            //     const studentPerformanceChart = echarts.init(document.getElementById('student-performance-chart'));
            //     const studentPerformanceOption = {
            //         animation: false,
            //         tooltip: {
            //             trigger: 'axis',
            //             backgroundColor: 'rgba(255, 255, 255, 0.8)',
            //             borderColor: '#E5E7EB',
            //             textStyle: {
            //                 color: '#1F2937'
            //             }
            //         },
            //         legend: {
            //             data: ['Current Term', 'Previous Term'],
            //             bottom: 0,
            //             textStyle: {
            //                 color: '#1F2937'
            //             }
            //         },
            //         grid: {
            //             left: '3%',
            //             right: '3%',
            //             top: '3%',
            //             bottom: '15%',
            //             containLabel: true
            //         },
            //         xAxis: {
            //             type: 'category',
            //             data: ['Math', 'Science', 'English', 'History', 'Geography'],
            //             axisLine: {
            //                 lineStyle: {
            //                     color: '#E5E7EB'
            //                 }
            //             },
            //             axisLabel: {
            //                 color: '#6B7280'
            //             }
            //         },
            //         yAxis: {
            //             type: 'value',
            //             max: 100,
            //             axisLine: {
            //                 show: false
            //             },
            //             axisLabel: {
            //                 color: '#6B7280',
            //                 formatter: '{value}%'
            //             },
            //             splitLine: {
            //                 lineStyle: {
            //                     color: '#F3F4F6'
            //                 }
            //             }
            //         },
            //         series: [
            //             {
            //                 name: 'Current Term',
            //                 type: 'bar',
            //                 data: [85, 78, 92, 75, 80, 88],
            //                 itemStyle: {
            //                     color: 'rgba(87, 181, 231, 1)',
            //                     borderRadius: [4, 4, 0, 0]
            //                 },
            //                 emphasis: {
            //                     itemStyle: {
            //                         opacity: 0.8
            //                     }
            //                 }
            //             },
            //             {
            //                 name: 'Previous Term',
            //                 type: 'bar',
            //                 data: [70, 73, 89, 77, 75, 85],
            //                 itemStyle: {
            //                     color: 'rgba(251, 191, 114, 1)',
            //                     borderRadius: [4, 4, 0, 0]
            //                 },
            //                 emphasis: {
            //                     itemStyle: {
            //                         opacity: 0.8
            //                     }
            //                 }
            //             }
            //         ]
            //     };
            //     studentPerformanceChart.setOption(studentPerformanceOption);
            // }

            // Student Attendance Chart (for modal)
            // if (document.getElementById('student-attendance-chart')) {
            //     const studentAttendanceChart = echarts.init(document.getElementById('student-attendance-chart'));
            //     const studentAttendanceOption = {
            //         animation: false,
            //         tooltip: {
            //             trigger: 'item',
            //             backgroundColor: 'rgba(255, 255, 255, 0.8)',
            //             borderColor: '#E5E7EB',
            //             textStyle: {
            //                 color: '#1F2937'
            //             }
            //         },
            //         legend: {
            //             orient: 'horizontal',
            //             bottom: 0,
            //             textStyle: {
            //                 color: '#1F2937'
            //             }
            //         },
            //         series: [
            //             {
            //                 name: 'Attendance',
            //                 type: 'pie',
            //                 radius: ['40%', '70%'],
            //                 avoidLabelOverlap: false,
            //                 itemStyle: {
            //                     borderRadius: 8,
            //                     borderColor: '#fff',
            //                     borderWidth: 2
            //                 },
            //                 label: {
            //                     show: false,
            //                     position: 'center'
            //                 },
            //                 emphasis: {
            //                     label: {
            //                         show: true,
            //                         fontSize: '16',
            //                         fontWeight: 'bold'
            //                     }
            //                 },
            //                 labelLine: {
            //                     show: false
            //                 },
            //                 data: [
            //                     { value: 92, name: 'Present', itemStyle: { color: 'rgba(87, 181, 231, 1)' } },
            //                     { value: 5, name: 'Absent', itemStyle: { color: 'rgba(252, 141, 98, 1)' } },
            //                     { value: 3, name: 'Late', itemStyle: { color: 'rgba(251, 191, 114, 1)' } }
            //                 ]
            //             }
            //         ]
            //     };
            //     studentAttendanceChart.setOption(studentAttendanceOption);
            // }

        
        });

        // Custom Checkbox Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const customCheckboxes = document.querySelectorAll('.custom-checkbox-input');
            customCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function() {
                    this.checked = !this.checked;
                });
            });

            // Select All Students checkbox
            const selectAllCheckbox = document.getElementById('selectAllStudents');
            const studentCheckboxes = document.querySelectorAll('.student-checkbox');
            
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('click', function() {
                    const isChecked = this.checked;
                    studentCheckboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                });
            }
        });

        // Student Profile Modal
        document.addEventListener('DOMContentLoaded', function() {
            const studentRows = document.querySelectorAll('tr[data-student-id]');
            const studentModal = document.getElementById('studentProfileModal');
            const studentModalOverlay = document.getElementById('studentModalOverlay');
            const closeStudentModalBtn = document.getElementById('closeStudentModal');
            
            studentRows.forEach(row => {
                row.addEventListener('click', function(e) {
                    // Don't open modal if clicking on checkboxes or action buttons
                    if (e.target.closest('.custom-checkbox') || e.target.closest('button')) {
                        return;
                    }
                    
                    studentModal.style.display = 'block';
                    studentModalOverlay.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                    
                    // Initialize charts if they exist
                    if (window.echarts) {
                        if (document.getElementById('student-performance-chart')) {
                            window.echarts.getInstanceByDom(document.getElementById('student-performance-chart')).resize();
                        }
                        if (document.getElementById('student-attendance-chart')) {
                            window.echarts.getInstanceByDom(document.getElementById('student-attendance-chart')).resize();
                        }
                    }
                });
            });
            
            if (closeStudentModalBtn) {
                closeStudentModalBtn.addEventListener('click', function() {
                    studentModal.style.display = 'none';
                    studentModalOverlay.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }
            
            if (studentModalOverlay) {
                studentModalOverlay.addEventListener('click', function() {
                    studentModal.style.display = 'none';
                    studentModalOverlay.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }
        });

        // Add Student Modal
        document.addEventListener('DOMContentLoaded', function() {
            const addStudentBtn = document.getElementById('addStudentBtn');
            const addStudentModal = document.getElementById('addStudentModal');
            const addStudentModalOverlay = document.getElementById('addStudentModalOverlay');
            const closeAddStudentModalBtn = document.getElementById('closeAddStudentModal');
            const cancelAddStudentBtn = document.getElementById('cancelAddStudent');
            
            if (addStudentBtn) {
                addStudentBtn.addEventListener('click', function() {
                    // Toggle the dropdown on button click
    $('#genderButton').click(function() {
        $('#genderDropdown').toggleClass('hidden');
    });
    $('#classStudentButton').click(function() {
        $('#classStudentDropdown').toggleClass('hidden');
    });
    $('#studentRelationButton').click(function() {
        $('#studentRelationDropdown').toggleClass('hidden');
    });

  

    $('#genderDropdown li').click(function () {
        const val = $(this).data('value');
        $('#genderButton span').text($(this).text());
        $('#gender').val(val);
        $('#genderDropdown').addClass('hidden');
    });

    $('#classStudentDropdown li').click(function () {
        const val = $(this).data('value');
        $('#classStudentButton span').text($(this).text());
        $('#classStudent').val(val);
        $('#classStudentDropdown').addClass('hidden');
    });

    $('#studentRelationDropdown li').click(function () {
        const val = $(this).data('value');
        $('#studentRelationButton span').text($(this).text());
        $('#studentRelation').val(val);
        $('#studentRelationDropdown').addClass('hidden');
    });
                    addStudentModal.style.display = 'block';
                    addStudentModalOverlay.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                });
            }
            
            if (closeAddStudentModalBtn) {
                closeAddStudentModalBtn.addEventListener('click', function() {
                    addStudentModal.style.display = 'none';
                    addStudentModalOverlay.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }
            
            if (cancelAddStudentBtn) {
                cancelAddStudentBtn.addEventListener('click', function() {
                    addStudentModal.style.display = 'none';
                    addStudentModalOverlay.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }
            
            if (addStudentModalOverlay) {
                addStudentModalOverlay.addEventListener('click', function() {
                    addStudentModal.style.display = 'none';
                    addStudentModalOverlay.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }
        });
    </script>

    <!-- Link external JS file -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ asset('js/students.js') }}"></script>
</body>
</html>
