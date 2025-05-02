$(document).ready(function () {
    loadStudents(1); // load first page initially

    // Pagination click handler
    $(document).on('click', '.pagination-btn', function () {
        const page = $(this).data('page');
        loadStudents(page);
    });
    dropdowns()
    studentSummary()
    fetchChartData()
});

function getParentByStudentID(studentId) {
    let parentContainer = document.getElementById("studentParentInfo");
    parentContainer.innerHTML = '';
    $.ajax({
        url: `/api/students/${studentId}/parent`,
        method: 'GET',
        success: function (data) {
            console.log("parent data", data)
            parentContainer.innerHTML = `
            <h4 class="text-lg font-medium text-gray-900 mb-4">Parent/Guardian Information</h4>
                <div class="space-y-4">
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                        <img class="w-10 h-10 rounded-full mr-4 object-cover" src="${data.profile_image}" alt="Parent">
                        <div>
                            <h5 class="text-sm font-medium text-gray-900">${data.name} (${data.relationship})</h5>
                            <p class="text-sm text-gray-500">${data.email}</p>
                            <p class="text-sm text-gray-500">${data.phone_number}</p>
                            <div class="mt-2">
                                <button class="inline-flex items-center px-2 py-1 text-xs font-medium text-primary bg-primary/10 rounded-full !rounded-button whitespace-nowrap">
                                    <div class="w-3 h-3 mr-1 flex items-center justify-center">
                                        <i class="ri-message-2-line"></i>
                                    </div>
                                    Message
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
           `
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    })
}

function studentSummary() {
    $.ajax({
        url: '/api/student-summary',
        method: 'GET',
        success: function (data) {
            // Update Total Students Card
            $('#totalStudents').text(data.total_students);
            $('#totalStudentsPercentage').text(data.percentage_change_total_students + '%');

            // Update Average Performance Card
            $('#averagePerformance').text(data.average_performance + '%');
            $('#averagePerformancePercentage').text(data.percentage_change_average_performance + '%');

            // Update Attendance Rate Card
            $('#attendanceRate').text(data.average_attendance + '%');
            $('#attendanceRatePercentage').text(data.percentage_change_average_attendance + '%');

            // Update At-Risk Students Card
            $('#atRiskStudents').text(data.at_risk_students);
            $('#atRiskStudentsPercentage').text(data.percentage_change_at_risk_students + '%');
        },
        error: function () {
            alert('Failed to load student summary.');
        }
    });
}

function addOrUpdateFilter(type, label, colorClass = 'bg-primary/10 text-primary') {
    const filterId = `filter-${type}`;
    const html = `
        <div id="${filterId}" class="inline-flex items-center px-3 py-1 rounded-full text-sm ${colorClass}">
            ${label}
            <button class="ml-2 close-filter" data-filter="${filterId}">
                <div class="w-4 h-4 flex items-center justify-center">
                    <i class="ri-close-line"></i>
                </div>
            </button>
        </div>
    `;
    const existing = $(`#${filterId}`);
    if (existing.length) {
        existing.replaceWith(html);
    } else {
        $('#activeFilters').append(html);
    }
}
function dropdowns() {
    // Toggle dropdown
    $('#classFilterBtn').click(() => $('#classDropdown').toggle());
    $('#statusFilterBtn').click(() => $('#statusDropdown').toggle());
    $('#performanceFilterBtn').click(() => $('#performanceDropdown').toggle());

    // Function to add or update filter
    function addOrUpdateFilter(type, label, colorClass = 'bg-primary/10 text-primary') {
        const filterId = `filter-${type}`;
        const html = `
        <div id="${filterId}" class="inline-flex items-center px-3 py-1 rounded-full text-sm ${colorClass}">
            ${label}
            <button class="ml-2 close-filter" data-filter="${filterId}">
                <i class="ri-close-line"></i>
            </button>
        </div>
    `;
        const existing = $(`#${filterId}`);
        if (existing.length) {
            existing.replaceWith(html);
        } else {
            $('#activeFilters').append(html);
        }
        updateClearAllButton();
    }

    // Remove a filter badge
    $(document).on('click', '.close-filter', function () {
        const filterId = $(this).data('filter');
        $(`#${filterId}`).remove();
        updateClearAllButton();
    });

    // Clear all filters
    $(document).on('click', '#clearAllBtn', function () {
        $('#activeFilters').empty();
    });

    // Add Clear All button dynamically
    function updateClearAllButton() {
        $('#clearAllBtn').remove();
        if ($('#activeFilters').children().length > 0) {
            $('#activeFilters').append(`
            <button id="clearAllBtn" class="text-sm text-primary hover:text-primary/80 ml-2">
                Clear All Filters
            </button>
        `);
        }
    }

    // Dropdown selections
    $('#classDropdown li').click(function () {
        const selected = $(this).text();
        addOrUpdateFilter('class', `Class: ${selected}`);
        $('#classDropdown').hide();
    });

    $('#statusDropdown li').click(function () {
        const selected = $(this).text();
        addOrUpdateFilter('status', `Status: ${selected}`, 'bg-green-100 text-green-800');
        $('#statusDropdown').hide();
    });

    $('#performanceDropdown li').click(function () {
        const selected = $(this).text();
        addOrUpdateFilter('performance', `Performance: ${selected}`, 'bg-blue-100 text-blue-800');
        $('#performanceDropdown').hide();
    });

    // Hide dropdowns when clicking outside
    $(document).click(function (e) {
        if (!$(e.target).closest('button, ul').length) {
            $('.dropdown-menu').hide();
        }
    });
}

let currentPage = 1;
let filters = {
    name: '',
    student_id: '',
    class: '',
    email: '',
    status: '',
    performance: ''
}


function loadStudents(page = 1) {
    $.ajax({
        url: `/api/students?page=${page}`, // pass page to backend
        type: 'GET',
        data: filters,
        success: function (response) {
            //All Students
            renderStudents(response.data)
            //Total count
            totalStudents(response.total)
            // Render pagination
            renderPagination(response.current_page, response.last_page, response.per_page || 5, response.total);
            renderActiveFilters()
        },
        error: function (xhr) {
            alert('Failed to fetch students!');
            console.error(xhr);
        }
    });
}

$('#searchInput').on('input', function () {
    const val = $(this).val().trim();
    filters.name = val;
    filters.email = val;
    filters.student_id = val;
    filters.class = val;
    loadStudents(1);
});

$('#classFilterBtn').on('click', function () {
    filters.class = $(this).data('value');
    loadStudents(1);
});

$('#statusFilterBtn').on('click', function () {
    filters.status = $(this).data('value');
    loadStudents(1);
});

$('#performanceFilterBtn').on('click', function () {
    filters.performance = $(this).data('value');
    loadStudents(1);
});



function renderPagination(currentPage, lastPage, perPage, total) {
    const $nav = $('#pagination-buttons');
    $nav.empty(); // Clear old buttons

    // Previous button
    const prevDisabled = currentPage === 1 ? 'opacity-50 cursor-not-allowed' : '';
    $nav.append(`
        <button ${currentPage > 1 ? `data-page="${currentPage - 1}"` : ''} 
            class="pagination-btn relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 ${prevDisabled}">
            <span class="sr-only">Previous</span>
            <div class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-left-s-line"></i></div>
        </button>
    `);

    // Numbered buttons (max 5 shown)
    const delta = 2;
    let range = [];

    for (let i = Math.max(1, currentPage - delta); i <= Math.min(lastPage, currentPage + delta); i++) {
        range.push(i);
    }

    if (range[0] > 1) {
        $nav.append(pageButton(1, currentPage));
        if (range[0] > 2) {
            $nav.append(ellipsis());
        }
    }

    range.forEach(i => $nav.append(pageButton(i, currentPage)));

    if (range[range.length - 1] < lastPage) {
        if (range[range.length - 1] < lastPage - 1) {
            $nav.append(ellipsis());
        }
        $nav.append(pageButton(lastPage, currentPage));
    }

    // Next button
    const nextDisabled = currentPage === lastPage ? 'opacity-50 cursor-not-allowed' : '';
    $nav.append(`
        <button ${currentPage < lastPage ? `data-page="${currentPage + 1}"` : ''} 
            class="pagination-btn relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 ${nextDisabled}">
            <span class="sr-only">Next</span>
            <div class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-right-s-line"></i></div>
        </button>
    `);

    // Update summary
    const from = (currentPage - 1) * perPage + 1;
    const to = Math.min(currentPage * perPage, total);
    $('#pagination-summary').html(`Showing <span class="font-medium">${from}</span> to <span class="font-medium">${to}</span> of <span class="font-medium">${total}</span> students`);
}

function pageButton(page, currentPage) {
    const isActive = page === currentPage;
    return `
        <button data-page="${page}" class="pagination-btn ${isActive ? 'z-10 bg-primary text-white' : 'bg-white text-gray-500 hover:bg-gray-50'} relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium">
            ${page}
        </button>
    `;
}

let currentStudents = [];

function ellipsis() {
    return `
        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
    `;
}

function totalStudents(count) {
    let totalStudent = document.getElementById("total-student");
    totalStudent.innerText = `(${count})`
}

function renderStudents(students) {
    $('#student-list tbody').empty(); // clear table
    currentStudents = students;
    students.forEach(function (student) {
        $('#student-list tbody').append(`
            <tr class="hover:bg-gray-50 cursor-pointer">
                <td class="px-6 py-4 whitespace-nowrap">
                    <label class="custom-checkbox">
                        <input type="checkbox" class="custom-checkbox-input student-checkbox">
                        <span class="sr-only">Select student</span>
                    </label>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full object-cover" src="${student.profile_image}" alt="Student">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${student.first_name} ${student.last_name}</div>
                            <div class="text-sm text-gray-500">${student.email}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${student.student_id}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${student.class}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2 max-w-[100px]">
                            <div class="bg-primary h-2.5 rounded-full" style="width: ${student.performance}"></div>
                        </div>
                        <span class="text-sm text-gray-900">${student.performance}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${student.attendance}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${student.contact}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${student.status === "Active" ? ' bg-green-100 text-green-800 ' : 'bg-yellow-100 text-yellow-800'} ">
                    ${student.status === "Inactive" ? "On Leave" : student.status}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-2">
                        <button class="text-gray-500 hover:text-primary" title="Edit">
                            <div class="w-6 h-6 flex items-center justify-center"><i class="ri-edit-line"></i></div>
                        </button>
                        <button class="text-gray-500 hover:text-primary" title="Message">
                            <div class="w-6 h-6 flex items-center justify-center"><i class="ri-message-2-line"></i></div>
                        </button>
                        <button class="text-gray-500 hover:text-gray-700" title="More">
                            <div class="w-6 h-6 flex items-center justify-center"><i class="ri-more-2-line"></i></div>
                        </button>
                    </div>
                </td>
            </tr>
        `);
    });
}


function renderActiveFilters() {
    const $container = $('#activeFilters');
    $container.empty();

    Object.entries(filters).forEach(([key, value]) => {
        if (value) {
            $container.append(`
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary/10 text-primary">
                    ${capitalize(key)}: ${value}
                    <button data-filter="${key}" class="ml-2 text-primary remove-filter">
                        <div class="w-4 h-4 flex items-center justify-center">
                            <i class="ri-close-line"></i>
                        </div>
                    </button>
                </div>
            `);
        }
    });
}

$(document).on('click', '.remove-filter', function () {
    const key = $(this).data('filter');
    filters[key] = '';
    loadStudents(1);
});

$('#student-list').on('click', 'tbody tr', function () {
    const index = $(this).index();
    const student = currentStudents[index];
    
    openStudentModal(student)
})

function openStudentModal(student) {
    getParentByStudentID(student.id)
    renderStudentPerformanceChart(student.id)
    marksCardRender(student.id)
    studentAttendanceChart(student.id)
    const studentModal = document.getElementById('studentProfileModal');
    const studentModalOverlay = document.getElementById('studentModalOverlay');
    const closeStudentModalBtn = document.getElementById('closeStudentModal');

    studentModal.style.display = 'block';
    studentModalOverlay.style.display = 'block';
    document.body.style.overflow = 'hidden';

    let profileContainer = document.getElementById("studentBasicInfo");
    let studentPersonalInfo = document.getElementById("studentPersonalInfo");
    profileContainer.innerHTML = `
     <img class="w-24 h-24 rounded-full mb-4 object-cover" src="${student.profile_image}" alt="Student">
                <h3 class="text-xl font-bold text-gray-900">${student.first_name} ${student.last_name}</h3>
                <p class="text-gray-500">${student.student_id}</p>
                <div class="flex mt-2 space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                    ${student.class}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium${student.status === "Active" ? ' bg-green-100 text-green-800 ' : ' bg-yellow-100 text-yellow-800'}">
                    ${student.status === "Active" ? student.status : "On Leave"}
                    </span>
                </div>
                <div class="flex mt-4 space-x-3">
                    <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary/90 !rounded-button whitespace-nowrap">
                        <div class="w-4 h-4 mr-2 flex items-center justify-center">
                            <i class="ri-message-2-line"></i>
                        </div>
                        Message
                    </button>
                    <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 !rounded-button whitespace-nowrap">
                        <div class="w-4 h-4 mr-2 flex items-center justify-center">
                            <i class="ri-edit-line"></i>
                        </div>
                        Edit
                    </button>
                </div>
    `
    studentPersonalInfo.innerHTML = `
    <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Date of Birth</p>
                        <p class="text-sm font-medium text-gray-900">${student.date_of_birth}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="text-sm font-medium text-gray-900">${student.gender}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-sm font-medium text-gray-900">${student.email}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="text-sm font-medium text-gray-900">${student.contact}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="text-sm font-medium text-gray-900">${student.address}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Enrollment Date</p>
                        <p class="text-sm font-medium text-gray-900">${student.enrollment_date}</p>
                    </div>
                </div>
    `
}

//Add students and parents infromation
function addStudents(e) {
    e.preventDefault();

    let isValid = true;
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Reset error styles
    $('input').removeClass('border-red-500');

    // Validate required fields
    const requiredFields = ['#firstName', '#lastName', '#studentEmail', '#dateOfBirth', '#enrollmentDate', '#parentName1'];
    requiredFields.forEach(function (field) {
        if ($(field).val().trim() === '') {
            isValid = false;
            $(field).addClass('border-red-500');
        }
    });

    // Email validation
    const studentEmail = $('#studentEmail').val().trim();
    if (studentEmail && !emailPattern.test(studentEmail)) {
        isValid = false;
        showToast("Invalid student email format.","error")
    }

    const parentEmail = $('#parentEmail1').val().trim();
    if (parentEmail && !emailPattern.test(parentEmail)) {
        isValid = false;
        showToast("Invalid parent email format.","error")
    }

    if (!isValid) {
        showToast("Please correct the errors and try again.","error")
        return;
    }

    const formData = {
        student_id: $('#studentId').val(), // Make sure this field exists
        first_name: $('#firstName').val(),
        last_name: $('#lastName').val(),
        email: $('#studentEmail').val(),
        phone: $('#studentPhone').val(),
        date_of_birth: $('#dateOfBirth').val(),
        gender: $('#gender').val(),
        class: $('#classStudent').val(),
        performance: "81%", // Add performance field if it's required
        attendance: "90%", // Add attendance field if it's required
        contact: $('#studentPhone').val(), // Add contact field if it's required
        status: "Active", // Add status field if it's required
        enrollment_date: $('#enrollmentDate').val(),
        address: $('#address').val(),
        profile_image:"https://i.pravatar.cc/150?img=44",
        parent: {
            name: $('#parentName1').val(),
            relationship: $('#studentRelation').val(),
            email: $('#parentEmail1').val(),
            phone_number: $('#parentPhone1').val(),
            profile_image:"https://i.pravatar.cc/150?img=69",
        }
    };

    $.ajax({
        url: "/api/students", // Update this endpoint if needed
        method: "POST",
        data: formData,
        success: function (response) {
            showToast("Student and parent added successfully!","success")
            $('#addStudentForm')[0].reset(); // Reset form
            $('#addStudentModal').hide(); // Optionally close modal
            $('#addStudentModalOverlay').hide();
            // Refresh student list if needed
        },
        error: function (xhr) {
            console.log(xhr.responseJSON);
            showToast("Something went wrong. Please try again.","error")
        }
    })
}


//Export CSV
function downloadCSV(csv, filename) {
    const csvFile = new Blob([csv], { type: "text/csv" });
    const downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}

function exportTableToCSV(filename) {
    const rows = document.querySelectorAll("#student-list tr");
    let csv = [];

    rows.forEach(row => {
        const cols = row.querySelectorAll("td, th");
        const rowData = Array.from(cols).map(col => `"${col.innerText.trim()}"`);
        csv.push(rowData.join(","));
    });

    downloadCSV(csv.join("\n"), filename);
}

document.getElementById("exportBtn").addEventListener("click", function () {
    exportTableToCSV("allStudents.csv");
});


function showToast(message, type = "success") {
    let background;
    switch (type) {
        case "success":
            background = "linear-gradient(to right, #00b09b, #96c93d)";
            break;
        case "error":
            background = "linear-gradient(to right, #e52d27, #b31217)";
            break;
        case "info":
            background = "linear-gradient(to right, #2193b0, #6dd5ed)";
            break;
        case "warning":
            background = "linear-gradient(to right, #f7971e, #ffd200)";
            break;
        default:
            background = "linear-gradient(to right, #00b09b, #96c93d)";
    }

    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: background,
        }
    }).showToast();
}


// function performanceChart(){
//     const chart=echarts.init(document.getElementById('performance-distribution-chart'));
//     $.ajax({
//         url:"/api/students/performance-distribution",
//         method:"GET",
//         success: function (response) {
//             const chartData = response.series.map(series => {
//                 // Filter out zero values and their corresponding categories
//                 const filteredData = [];
//                 const filteredLabels = [];
        
//                 series.data.forEach((value, index) => {
//                     if (value !== 0) {
//                         filteredData.push(value);
//                         filteredLabels.push(response.ranges[index]);
//                     }
//                 });
        
//                 return {
//                     name: series.name,
//                     type: 'bar',
//                     data: filteredData,
//                     xAxisData: filteredLabels,
//                     itemStyle: {
//                         borderRadius: [4, 4, 0, 0]
//                     },
//                     emphasis: {
//                         itemStyle: {
//                             opacity: 0.8
//                         }
//                     }
//                 };
//             });
        
//             // Create unique xAxis categories from all classes
//             const xAxisCategories = [...new Set(chartData.flatMap(s => s.xAxisData))];
        
//             const finalSeries = chartData.map(s => ({
//                 name: s.name,
//                 type: 'bar',
//                 data: xAxisCategories.map(label => {
//                     const index = s.xAxisData.indexOf(label);
//                     return index !== -1 ? s.data[index] : '-';
//                 }),
//                 itemStyle: s.itemStyle,
//                 emphasis: s.emphasis
//             }));
        
//             const option = {
//                 animation: true,
//                 tooltip: { trigger: 'axis' },
//                 legend: {
//                     data: finalSeries.map(item => item.name),
//                     bottom: 0
//                 },
//                 grid: {
//                     left: '3%',
//                     right: '3%',
//                     top: '3%',
//                     bottom: '15%',
//                     containLabel: true
//                 },
//                 xAxis: {
//                     type: 'category',
//                     data: xAxisCategories
//                 },
//                 yAxis: {
//                     type: 'value',
//                     name: 'Number of Students'
//                 },
//                 series: finalSeries
//             };
        
//             chart.setOption(option);
//         },
        
//         error:function(err){
//             showToast("error loading chart Data","error");
//             console.log(err)
//         }
//     })

// }
const chart = echarts.init(document.getElementById('performance-distribution-chart'));
let rawData = null; // hold the original data

function renderChart(data, ranges) {
    // Find which indexes have any non-zero value across all classes
    const activeIndexes = ranges.map((_, i) =>
        data.some(series => series.data[i] > 0)
    );

    const filteredRanges = ranges.filter((_, i) => activeIndexes[i]);

    const filteredSeries = data.map(item => ({
        name: item.name,
        type: 'bar',
        data: item.data.filter((_, i) => activeIndexes[i]),
        itemStyle: {
            borderRadius: [4, 4, 0, 0]
        },
        emphasis: {
            itemStyle: {
                opacity: 0.8
            }
        }
    }));

    const option = {
        animation: true,
        tooltip: { trigger: 'axis' },
        legend: {
            data: filteredSeries.map(s => s.name),
            bottom: 0
        },
        grid: {
            left: '3%',
            right: '3%',
            top: '3%',
            bottom: '15%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            data: filteredRanges
        },
        yAxis: {
            type: 'value',
            name: 'Number of Students'
        },
        series: filteredSeries
    };

    chart.setOption(option);
}

function fetchChartData() {
    $.ajax({
        url: '/api/students/performance-distribution',
        method: 'GET',
        success: function (response) {
            rawData = response;
            populateDropdown(response.series);
            renderChart(response.series, response.ranges);
        }
    });
}

function populateDropdown(series) {
    const $filter = $('#classFilter');
    $filter.find('option:not([value="all"])').remove();

    series.forEach(item => {
        $filter.append(`<option value="${item.name}">${item.name}</option>`);
    });
}

$('#classFilter').on('change', function () {
    const selected = $(this).val();
    if (selected === 'all') {
        renderChart(rawData.series, rawData.ranges);
    } else {
        const filtered = rawData.series.filter(s => s.name === selected);
        renderChart(filtered, rawData.ranges);
    }
});

function renderStudentPerformanceChart(studentId) {
    $.ajax({
        url:`/api/student/${studentId}/performance`,
        method:"GET",
        success:function(data){
            console.log("student",data)
            const chartDom = document.getElementById('student-performance-chart');
            const chart = echarts.init(chartDom);
            const option = {
                animation: false,
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    borderColor: '#E5E7EB',
                    textStyle: { color: '#1F2937' }
                },
                legend: {
                    data: ['Current Term', 'Previous Term'],
                    bottom: 0,
                    textStyle: { color: '#1F2937' }
                },
                grid: {
                    left: '3%',
                    right: '3%',
                    top: '3%',
                    bottom: '15%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    data: data.subjects,
                    axisLine: { lineStyle: { color: '#E5E7EB' } },
                    axisLabel: { color: '#6B7280' }
                },
                yAxis: {
                    type: 'value',
                    max: 100,
                    axisLine: { show: false },
                    axisLabel: {
                        color: '#6B7280',
                        formatter: '{value}%'
                    },
                    splitLine: {
                        lineStyle: { color: '#F3F4F6' }
                    }
                },
                series: [
                    {
                        name: 'Current Term',
                        type: 'bar',
                        data: data.current,
                        itemStyle: {
                            color: 'rgba(87, 181, 231, 1)',
                            borderRadius: [4, 4, 0, 0]
                        }
                    },
                    {
                        name: 'Previous Term',
                        type: 'bar',
                        data: data.previous,
                        itemStyle: {
                            color: 'rgba(251, 191, 114, 1)',
                            borderRadius: [4, 4, 0, 0]
                        }
                    }
                ]
            };
            chart.setOption(option);
        },error: function (xhr) {
            showToast("Something went wrong!","error")
        }
    })
    
}


function marksCardRender(studentId){
    const container = document.getElementById('subject-cards');
    container.innerHTML = '';
    $.ajax({
        url:`api/student/${studentId}/subject-marks`,
        method:"GET",
        success:function(response){
            response.forEach(subject=>{
                const diff = subject.current_term_mark - subject.previous_term_mark;
                const diffText = (diff >= 0 ? `+${diff}` : `${diff}`) + '%';
                const diffColor = diff >= 0 ? 'text-green-500' : 'text-red-500';
                const icon = diff >= 0 ? 'ri-arrow-up-line' : 'ri-arrow-down-line';

                container.innerHTML += `
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">${subject.name}</p>
                        <p class="text-lg font-medium text-gray-900">${subject.current_term_mark}%</p>
                        <div class="flex items-center text-xs mt-1">
                            <div class="w-3 h-3 flex items-center justify-center ${diffColor} mr-1">
                                <i class="${icon}"></i>
                            </div>
                            <span class="${diffColor}">${diffText}</span>
                        </div>
                    </div>
                `;
            })
        },
        error:function(err){

        }
    })
}

function studentAttendanceChart(studentId){
    const studentAttendanceChart = echarts.init(document.getElementById('student-attendance-chart'));
    $.ajax({
        url:`api/student/${studentId}/attendance-stats`,
        method:"GET",
        success:function(data){
            const studentAttendanceOption = {
                animation: false,
                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    borderColor: '#E5E7EB',
                    textStyle: {
                        color: '#1F2937'
                    }
                },
                legend: {
                    orient: 'horizontal',
                    bottom: 0,
                    textStyle: {
                        color: '#1F2937'
                    }
                },
                series: [
                    {
                        name: 'Attendance',
                        type: 'pie',
                        radius: ['40%', '70%'],
                        avoidLabelOverlap: false,
                        itemStyle: {
                            borderRadius: 8,
                            borderColor: '#fff',
                            borderWidth: 2
                        },
                        label: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: '16',
                                fontWeight: 'bold'
                            }
                        },
                        labelLine: {
                            show: false
                        },
                        data: [
                            { value: data.present, name: 'Present', itemStyle: { color: 'rgba(87, 181, 231, 1)' } },
                            { value: data.absent, name: 'Absent', itemStyle: { color: 'rgba(252, 141, 98, 1)' } },
                            { value: data.late, name: 'Late', itemStyle: { color: 'rgba(251, 191, 114, 1)' } }
                        ]
                    }
                ]
            };
    
            studentAttendanceChart.setOption(studentAttendanceOption);
    
            // Update the card values
            document.querySelector('#presentPercent').innerText = data.present + '%';
            document.querySelector('#absentPercent').innerText = data.absent + '%';
            document.querySelector('#latePercent').innerText = data.late + '%';
        },
        error:function(err){
            console.log("attendace-error",err)
        }
    })
}