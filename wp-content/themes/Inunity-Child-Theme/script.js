document.addEventListener("DOMContentLoaded", function () {
// DataTable initialization
let table = new DataTable('#timesheets-table', {
    dom: "Bfrtip", // Buttons for export
	lengthMenu: [10, 25, 50, 75, 100],
    order: [],
    buttons: [
        {
            extend: 'copy',
            text: 'Copy to Clipboard',
            exportOptions: {
                columns: ':visible:not(:last-child)' // Placeholder, will be updated later
            }
        },
        {
            extend: 'csv',
            text: 'Export to CSV',
            exportOptions: {
                columns: ':visible:not(:last-child)' // Placeholder, will be updated later
            }
        },
        {
            extend: 'excel',
            text: 'Export to Excel',
            exportOptions: {
                columns: ':visible:not(:last-child)' // Placeholder, will be updated later
            }
        },
        {
            extend: 'pdf',
            text: 'Export to PDF',
            exportOptions: {
                columns: ':visible:not(:last-child)' // Placeholder, will be updated later
            }
        },
        {
            extend: 'print',
            text: 'Print',
            exportOptions: {
                columns: ':visible:not(:last-child)' // Placeholder, will be updated later
            }
        }
    ]
});

// Find the index of the date column
let dateColumnIndex = -1; // Initialize with an invalid value

table.columns().every(function () {
    let columnHeader = this.header().textContent.trim().toLowerCase();

    // Adjust the condition based on your actual column header for the date
    if (columnHeader === 'date') {
        dateColumnIndex = this.index();
        return false; // Stop iterating through columns
    }
});

console.log('Date Column Index:', dateColumnIndex);
	
	// Handle dropdown filter change
jQuery('#date-filter').on('change', function () {
    let selectedValue = jQuery(this).val();
    // Update minDate and maxDate based on the selected dropdown value
    // You can modify this logic based on your requirements
    switch (selectedValue) {
        case '0':
            minDate = null;
            maxDate = null;
            break;
        case '7':
            minDate = moment().subtract(7, 'days').format("DD/MM/YYYY");
            maxDate = moment().format("DD/MM/YYYY");
            break;
        case '30':
            minDate = moment().subtract(30, 'days').format("DD/MM/YYYY");
            maxDate = moment().format("DD/MM/YYYY");
            break;
        case '60':
            minDate = moment().subtract(60, 'days').format("DD/MM/YYYY");
            maxDate = moment().format("DD/MM/YYYY");
            break;
        case '90':
            minDate = moment().subtract(90, 'days').format("DD/MM/YYYY");
            maxDate = moment().format("DD/MM/YYYY");
            break;
        // Add cases for other dropdown values as needed
        default:
            minDate = null;
            maxDate = null;
            break;
    }
    table.draw();
});

// Define minDate and maxDate variables
let minDate, maxDate;

// Initialize date pickers without time
flatpickr("#min", {
    dateFormat: "d/m/Y",
    onChange: function (selectedDates, dateStr, instance) {
        minDate = dateStr;
        table.draw();
    }
});

flatpickr("#max", {
    dateFormat: "d/m/Y",
    onChange: function (selectedDates, dateStr, instance) {
        maxDate = dateStr;
        table.draw();
    }
});

// Custom filtering function
DataTable.ext.search.push(function (settings, data, dataIndex) {
    let date = flatpickr.parseDate(data[dateColumnIndex], "d/m/Y");

    if (
        (!minDate || date >= flatpickr.parseDate(minDate, "d/m/Y")) &&
        (!maxDate || date <= flatpickr.parseDate(maxDate, "d/m/Y"))
    ) {
        return true;
    }
    return false;
});

// Refilter the table on date input change
document.querySelectorAll('#min, #max').forEach((el) => {
    el.addEventListener('change', () => table.draw());
});


	// Call bindDeleteButton after setting up the DataTable and date pickers
bindDeleteButton();

	
	// Function to re-bind delete button click event after pagination
jQuery('#timesheets-table').on('draw.dt', function() {
    // Re-bind delete button click event after table is redrawn (pagination)
    bindDeleteButton();
});

	
	


	
	
// DataTable initialization
let table2 = new DataTable('#projects_table', {
    dom: "Bfrtip", // Buttons for export
	order: [],
    buttons: [
        {
            extend: 'copy',
            text: 'Copy to Clipboard',
            exportOptions: {
                columns: ':visible:not(:eq(10))' // Exclude the 11th column (index 10)
            }
        },
        {
            extend: 'csv',
            text: 'Export to CSV',
            exportOptions: {
                columns: ':visible:not(:eq(10))' // Exclude the 11th column (index 10)
            }
        },
        {
            extend: 'excel',
            text: 'Export to Excel',
            exportOptions: {
                columns: ':visible:not(:eq(10))' // Exclude the 11th column (index 10)
            }
        },
        {
            extend: 'pdf',
            text: 'Export to PDF',
            exportOptions: {
                columns: ':visible:not(:eq(10))' // Exclude the 11th column (index 10)
            }
        },
        {
            extend: 'print',
            text: 'Print',
            exportOptions: {
                columns: ':visible:not(:eq(10))' // Exclude the 11th column (index 10)
            }
        }
    ]
});
	
	

    // Define minDate and maxDate variables
    let minDate2, maxDate2;

    // Initialize date pickers without time
    flatpickr("#min2", {
        dateFormat: "d/m/Y",
        onChange: function(selectedDates, dateStr, instance) {
            minDate2 = dateStr;
            table2.draw();
        }
    });

    flatpickr("#max2", {
        dateFormat: "d/m/Y",
        onChange: function(selectedDates, dateStr, instance) {
            maxDate2 = dateStr;
            table2.draw();
        }
    });

    // Custom filtering function
    DataTable.ext.search.push(function (settings, data, dataIndex) {
		let date2 = flatpickr.parseDate(data[1], "d/m/Y");


        if (
            (!minDate2 || date2 >= flatpickr.parseDate(minDate2, "d/m/Y")) &&
        (!maxDate2 || date2 <= flatpickr.parseDate(maxDate2, "d/m/Y"))
        ) {
        
            return true;
        }
        return false;
    });

    // Refilter the table on date input change
    document.querySelectorAll('#min2, #max2').forEach((el) => {
        el.addEventListener('change', () => table2.draw());
    });
});


// Function to bind the delete button click event
function bindDeleteButton() {
   jQuery('.delete-timesheet').off('click').on('click', function() {
        if (confirm('Are you sure you want to delete this entry?')) {
            var timesheetId = jQuery(this).data('timesheet-id');
            var timesheetType = jQuery(this).data('timesheet-type');
            jQuery.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: {
                    action: 'delete_timesheet',
                    timesheet_id: timesheetId,
                    timesheet_type: timesheetType,
                    security: ajax_object.security
                },
                success: function(response) {
                    alert(response);
                    if (response === 'Timesheet entry deleted successfully!') {
                        // Reload the page or update the UI as needed
                        location.reload();
                    }
                }
            });
        }
    });
}




//Code for Project Deletion--------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function ($) {
    // Handle delete button click using event delegation
    $(document).on('click', '.delete-project', function () {
        var projectId = $(this).data('project-id');
        var projectName = $(this).data('project-name');
        
        var confirmDelete = confirm('Are you sure you want to delete the project "' + projectName + '"?');

        if (confirmDelete) {
            // Send AJAX request to delete the project
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: {
                    action: 'delete_project',
                    project_id: projectId,
                },
                success: function (response) {
                    // Handle the response from the server
                    alert(projectName + ' deleted successfully!');
                    // Reload the page after successful deletion
                    if (response === 'Project deleted successfully!') {
                        location.reload();
                    }
                }
            });
        }
    });
});




// Add this code to the beginning of your script.js file to ensure the document is ready
jQuery(document).ready(function ($) {
    $('#submitFormButton').on('click', function () {
        // Validate project name
        var projectName = $('#projectName').val().trim();

        if (projectName === '') {
            alert('Please enter a project name.');
            return; // Stop form submission if validation fails
        }

        // Collect form data
        var formData = $('#projectForm').serialize();

        // Make AJAX request to submit form data
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: formData + '&action=save_project_form',
            success: function (response) {
                // Handle the response (success/failure)
                if (response.success) {
                    // Clear all fields after successful form submission
                    $('#projectName').val('');
                    $('#projectType').val('');
                    $('#startDate').val('');
                    $('#completionDate').val('');
                    $('#clientName').val('');
                    $('#contactDetails').val('');
                    $('#timeZone').val('');
                    $('#projectManager').val('');
                    $('#selectedEmployeesList').empty(); // Clear the selected employees list
                    $('#selectedEmployeeId').val(''); // Clear the hidden field
                    $('#timeConsumed').val('');
                    $('#status').val('');
                    $('#comment').val('');

                    alert('Project created successfully!');
					window.location.href="http://localhost/timetracking/your-projects/";
                    // You can also redirect or perform other actions on success
                } else {
                    alert('Error submitting project: ' + response.data);
                }
            },
            error: function (error) {
                console.error('AJAX error:', error);
            }
        });
    });
});
jQuery(document).ready(function ($) {

    var selectedEmployees = [];

    $(document).on('click', '.list-group-item', function () {
        console.log("hello")
        var employeeId = $(this).data('employee-id');
        var employeeName = $(this).text();
        addSelectedEmployee(employeeId, employeeName);
        // Close the search dropdown
        $('#employeeSearch').val(''); // Clear the search input
        $('#employeeList').empty(); // Clear the search results
    });

    $(document).on('click', '.remove-icon', function (event) {
        event.stopPropagation(); // Stop the event from propagating up the DOM tree
        console.log('Remove icon clicked!');
        var employeeId = $(this).data('employee-id');
        removeSelectedEmployee(employeeId);
    });



    function addSelectedEmployee(employeeId, employeeName) {
        // Check if the employee is not already selected
        if (selectedEmployees.indexOf(employeeId) === -1) {
            // Add the employee to the selected list
            selectedEmployees.push(employeeId);
    
            // Check if the employeeName is not the "No employees found" message
            if (employeeName !== 'No employees found.') {
                // Append the selected employee to the list with a remove icon on the same line
                var $selectedEmployeesList = $('#selectedEmployeesList');
                var listItem = '<div style="display: flex; align-items: center; margin-bottom:5px;" class="selected-employee-item" data-employee-id="' + employeeId + '">' + 
                    '<input type="text" readonly value="' + employeeName + '" id="selectedEmployee_' + employeeId + '" name="selectedEmployees[]">' +
                    '<button style="margin-left: 10px;" type="button" class="close remove-icon" data-employee-id="' + employeeId + '"><span aria-hidden="true">&times;</span></button>' +
                '</div>';

                $selectedEmployeesList.append(listItem);
            }
    
            // Update any other necessary parts of your application
            updateSelectedEmployeesInput();
        }
    }



    function removeSelectedEmployee(employeeId) {

        selectedEmployees = selectedEmployees.filter(function (id) {
            return id !== employeeId;
        });

    // Remove the associated input field by using the employeeId
    $('#selectedEmployee_' + employeeId).remove();
    
    // Remove the entire selected-employee-item div
    $('.selected-employee-item[data-employee-id="' + employeeId + '"]').remove();
        updateSelectedEmployeesInput();
    }
    function updateSelectedEmployeesInput() {
        var $selectedEmployeesInput = $('#selectedEmployeeId');
        $selectedEmployeesInput.val(selectedEmployees.join(','));
    }

});



jQuery(document).ready(function ($) {
    var selectedEmployees = [];

    // Initialize selected employees based on existing data
    var existingEmployeeIds = $('#updateselectedEmployeeId').val();
    if (existingEmployeeIds) {
        selectedEmployees = existingEmployeeIds.split(',').map(function (id) {
            return parseInt(id);
        });

        // Populate the selected employees list based on existing data
        selectedEmployees.forEach(function (employeeId) {
            getEmployeeNameById(employeeId, function (employeeName) {
                addSelectedEmployeeFromExisting(employeeId, employeeName);
            });
        });
    }

   var searchTimer;

$('#employeeSearch').on('input', function () {
    var searchTerm = $(this).val().trim();

    // Clear the previous timer
    clearTimeout(searchTimer);

    // Set a new timer to delay the search
    searchTimer = setTimeout(function () {
        if (searchTerm !== '') {
            searchEmployees(searchTerm);
        } else {
            // Clear the search results if the search input is empty
            $('#employeeList').empty();
        }
    }, 500); // Adjust the delay time (in milliseconds) as needed
});

    $(document).on('click', '.list-group-item', function () {
		
        var employeeId = $(this).data('employee-id');
        var employeeName = $(this).text();
        addSelectedEmployee(employeeId, employeeName);
        // Close the search dropdown
        $('#employeeSearch').val(''); // Clear the search input
        $('#employeeList').empty(); // Clear the search results
    });

    $(document).on('click', '.remove-icon', function (event) {
        event.stopPropagation(); // Stop the event from propagating up the DOM tree
        var employeeId = $(this).data('employee-id');
        removeSelectedEmployee(employeeId);
    });

    function searchEmployees(searchTerm) {
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'search_employees',
                search_term: searchTerm,
            },
            success: function (response) {
                if (response && Array.isArray(response)) {
                    displaySearchResults(response);
                } else {
                    console.error('Error searching employees:', response);
                }
            },
            error: function (error) {
                console.error('AJAX error:', error);
            }
        });
    }

    function displaySearchResults(results) {
        var $employeeList = $('#employeeList');
        $employeeList.empty();
	
        if (results.length > 0) {
            results.forEach(function (employee) {
                $employeeList.append('<li id="search_employee" class="list-group-item" data-employee-id="' + employee.ID + '">' + employee.first_name + " " +employee.last_name + '</li>');
            });
        } else {
            $employeeList.append('<li class="list-group-item">No employees found.</li>');
        }
    }

 function addSelectedEmployee(employeeId, employeeName) {
        // Check if the employee is not already selected
        if (selectedEmployees.indexOf(employeeId) === -1) {
            // Add the employee to the selected list
            selectedEmployees.push(employeeId);
    
            // Check if the employeeName is not the "No employees found" message
            if (employeeName !== 'No employees found.') {
                // Append the selected employee to the list with a remove icon on the same line
                var $selectedEmployeesList = $('#updateselectedEmployeesList');
                var listItem = '<div style="display: flex; align-items: center; margin-bottom:5px;" class="selected-employee-item" data-employee-id="' + employeeId + '">' + 
                    '<input type="text" readonly value="' + employeeName + '" id="selectedEmployee_' + employeeId + '" name="selectedEmployees[]">' +
                    '<button style="margin-left: 10px;" type="button" class="close remove-icon" data-employee-id="' + employeeId + '"><span aria-hidden="true">&times;</span></button>' +
                '</div>';

                $selectedEmployeesList.append(listItem);
            }
    
            // Update any other necessary parts of your application
            updateSelectedEmployeesInput();
        }
    }

    function removeSelectedEmployee(employeeId) {

        selectedEmployees = selectedEmployees.filter(function (id) {
            return id !== employeeId;
        });

    // Remove the associated input field by using the employeeId
    $('#selectedEmployee_' + employeeId).remove();
    
    // Remove the entire selected-employee-item div
    $('.selected-employee-item[data-employee-id="' + employeeId + '"]').remove();
        updateSelectedEmployeesInput();
    }

    function addSelectedEmployeeFromExisting(employeeId, employeeName) {
        var $selectedEmployeesList = $('#updateselectedEmployeesList');
        var listItem = '<div style="display: flex; align-items: center; margin-bottom:5px;" class="selected-employee-item" data-employee-id="' + employeeId + '">' + 
                    '<input type="text" readonly value="' + employeeName + '" id="selectedEmployee_' + employeeId + '" name="selectedEmployees[]">' +
                    '<button style="margin-left: 10px;" type="button" class="close remove-icon" data-employee-id="' + employeeId + '"><span aria-hidden="true">&times;</span></button>' +
                '</div>';

        $selectedEmployeesList.append(listItem);

        updateSelectedEmployeesInput();
    }


   

    function getEmployeeNameById(employeeId, callback) {
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'get_employee_name_by_id',
                employee_id: employeeId,
            },
            success: function (response) {
                if (response.success) {
                    callback(response.data);
                } else {
                    console.error('Error getting employee name:', response.data);
                    callback('Employee ' + employeeId); // Fallback if there's an error
                }
            },
            error: function (error) {
                console.error('AJAX error:', error);
                callback('Employee ' + employeeId); // Fallback on AJAX error
            }
        });
    }

    

    function updateSelectedEmployeesInput() {
        var $selectedEmployeesInput = $('#updateselectedEmployeeId');
        $selectedEmployeesInput.val(selectedEmployees.join(','));
    }
});


// Function to fetch and update table data
function fetchAndUpdateTableData() {
    $.ajax({
        type: 'GET',
        url: ajax_object.ajax_url,
        data: { action: 'get_project_form_data' },
        success: function (response) {
            // Update the table body with the fetched data
            $('#projectFormsTableBody').html(response);
            showToast('Form submitted successfully!', 'bg-success');
        },
        error: function (error) {
            console.error('Error fetching table data:', error);
        }
    });
}







function submitForm(formId) {
    document.getElementById(formId).submit();
}




jQuery(document).ready(function($) {
    $('#custom-timesheet-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Serialize form data
        var formData = $(this).serialize();
  //  console.log('Form Data:', formData);
        // Submit form data using AJAX
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url, // Use the AJAX URL provided by WordPress
            data: formData + '&action=custom_timesheet_submit',
            success: function(response) {
                // Handle the response from the server
                if (response.success) {
                    // Display success message
                    alert(response.data.message);
                   // Redirect based on user role
                    window.location.href = response.data.redirect_url;
                } else {
                    // Display error message
                    alert(response.data.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors
                console.error(xhr.responseText);
            }
        });
    });
});


jQuery(document).ready(function($) {
    $('#update-timesheet-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Serialize form data
        var formData = $(this).serialize();
        //console.log('Form Data:', formData);

        // Submit form data using AJAX
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url, // Use the AJAX URL provided by WordPress
            data: formData + '&action=update_timesheet_submit', // Add the action parameter for WordPress AJAX
            dataType: 'json', // Expect JSON response from the server
            success: function(response) {
                // Handle the response from the server
                if (response.success) {
                    // Display success message
                    alert('Data updated successfully!');
                    // Redirect based on user role
                    window.location.href = response.data.redirect_url;
                } else {
                    // Display error message
                    alert(response.data.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors
                console.error(xhr.responseText);
            }
        }); // <-- Add this closing parenthesis
    });
});


//bookmark 
jQuery(document).ready(function($) {
    // Click event for bookmark button
    $('.bookmark-button').on('click', function() {
        var projectId = $(this).data('project-id');
        var projectCard = $('.card[data-project-id="' + projectId + '"]');

        // Toggle the visibility of the project card
        projectCard.slideToggle();
    });
});

// Function to toggle project details card based on bookmark button click
// Function to toggle project details card based on bookmark button click
function toggleProjectDetailsCard(button) {
    var projectId = button.getAttribute('data-project-id');
    
    // Send AJAX request to update the "action" value
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'update_project_action',
            project_id: projectId
        },
        success: function(response) {
            // Toggle the visibility of the card based on the response
            if (response === '1') {
                jQuery(button).closest('.card').show();
            } else {
                jQuery(button).closest('.card').hide();
            }
        }
    });
	$(element).find('i.fa-bookmark').toggleClass('clicked');
}

function toggleEmployeeCardDetails(button) {
    var projectId = button.getAttribute('data-project-id');

    // Check if the card with the specified project ID exists
    var card = jQuery('.employee-card[data-project-id="' + projectId + '"]');

    if (card.length) {
        // Send AJAX request to update the "employee_bookmark" value
        jQuery.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'update_employee_action',
                project_id: projectId
            },
            success: function(response) {
                // Check if the response is a valid bookmark string
                if (response !== '-1') {
                    // Update the visibility of the card based on the bookmarked status
                    if (response) {
            jQuery(card).slideDown();
        } else {
            jQuery(card).slideUp();
        }
                } else {
                    // Handle errors
                    console.error('Error updating the card visibility.');
                    alert('Error updating the card visibility.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                // Handle errors
                alert('Error updating the card visibility.');
            }
        });
    } else {
        // Display an alert if the card is not found
        alert('No entry found for this project. Unable to bookmark.');
    }
}