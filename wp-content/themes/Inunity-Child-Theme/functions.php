<?php /*

This file is part of a child theme called Inunity - Child Theme.
Functions in this file will be loaded before the parent theme's functions.
For more information, please read
https://developer.wordpress.org/themes/advanced-topics/child-themes/

*/

// this code loads the parent's stylesheet (leave it in place unless you know what you're doing)

function your_theme_enqueue_styles()
{
    //Enqueue jQuery
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.7.0.js', array(), '3.7.0', true);

    $parent_style = 'parent-style';

    wp_enqueue_style(
        $parent_style,
        get_template_directory_uri() . '/style.css'
    );


    // Enqueue child theme style
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );


    // Fontawesome CSS
    wp_enqueue_style('fontawesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');

    // Enqueue DataTables CSS
    wp_enqueue_style('flatpicker-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');

    // Enqueue DataTables script
    wp_enqueue_script('flatpicker-js', 'https://cdn.jsdelivr.net/npm/flatpickr', array('jquery'), '1.13.7', true);

    // Enqueue DataTables CSS
    wp_enqueue_style('datatables-css', 'https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css');

    // Enqueue DataTables button CSS
    wp_enqueue_style('datatables-buttons-css', 'https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css');


    // Enqueue DataTables script
    wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js', array('jquery'), '1.13.7', true);

    // Enqueue DataTables script
    wp_enqueue_script('datatables-moment-js', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js', array('jquery'), '2.29.2', true);

    // Enqueue DataTables script
    wp_enqueue_script('datatables-datetime-js', 'https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js', array('jquery'), '1.5.1', true);

    // Enqueue DataTables Buttons script
    wp_enqueue_script('datatables-buttons-js', 'https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js', array('jquery', 'datatables-js'), '2.4.2', true);

    // Enqueue JSZip script
    wp_enqueue_script('jszip-js', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js', array(), '3.10.1', true);

    // Enqueue pdfmake script
    wp_enqueue_script('pdfmake-js', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', array(), '0.1.53', true);

    // Enqueue pdfmake vfs_fonts script
    wp_enqueue_script('vfs-fonts-js', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js', array(), '0.1.53', true);

    // Enqueue DataTables Buttons HTML5 script
    wp_enqueue_script('buttons-html5-js', 'https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js', array('jquery', 'datatables-js', 'datatables-buttons-js', 'jszip-js', 'pdfmake-js'), '2.4.2', true);

    // Enqueue DataTables Buttons Print script
    wp_enqueue_script('buttons-print-js', 'https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js', array('jquery', 'datatables-js', 'datatables-buttons-js'), '2.4.2', true);

    // Enqueue Bootstrap from CDN
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
        array(),
        '5.3.2'
    );

    // Optionally, you can also enqueue Bootstrap JavaScript
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.2',
        true
    );


    // Enqueue your custom script.js
    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/script.js',
        array('jquery'), // Add jQuery as a dependency if needed
        microtime(),
        true // Set to true to include the script in the footer
    );
}

add_action('wp_enqueue_scripts', 'your_theme_enqueue_styles');




/*  User Registration.
    ======================================== */


// Remove existing roles
remove_role('editor');
remove_role('author');
remove_role('contributor');
remove_role('subscriber');

// Add custom roles
add_role('project_manager', 'Project Manager', array());
add_role('employee', 'Employee', array());



// Create a shortcode for the form
function custom_form_shortcode()
{
    ob_start(); ?>

    <form id="custom-registration-form" method="post" action="">
        <div class="mb-3">
            <label for="user_username" class="form-label">Employee ID</label>
            <input type="text" class="form-control" id="user_username" name="user_username" required>
        </div>
        <div class="mb-3">
            <label for="user_email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="user_email" name="user_email" required>
        </div>
        <div class="mb-3">
            <label for="user_first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="user_first_name" name="user_first_name" required>
        </div>
        <div class="mb-3">
            <label for="user_last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="user_last_name" name="user_last_name" required>
        </div>
        <!-- <div class="mb-3">
            <label for="user_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="user_password" name="user_password" required>
        </div> -->
        <div class="mb-3">
            <label for="user_role" class="form-label">Role</label>
            <select class="form-control" id="user_role" name="user_role" required>
                <?php
                $allowed_roles = array('project_manager', 'employee');

                // Get all roles
                $roles = wp_roles()->get_names();

                // Filter and display only the allowed roles
                foreach ($roles as $role_value => $role_label) {
                    if (in_array($role_value, $allowed_roles)) {
                        echo '<option value="' . esc_attr($role_value) . '">' . esc_html($role_label) . '</option>';
                    }
                }
                ?>
            </select>
        </div><br>
        <button type="submit" class="btn btn-primary" name="custom_registration_submit">Submit</button>
    </form>

    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('custom_registration_form', 'custom_form_shortcode');





if (isset($_POST['custom_registration_submit'])) {
    // Get user input from the form
    $username = sanitize_user($_POST['user_username']);
    $email = sanitize_email($_POST['user_email']);
    $first_name = sanitize_text_field($_POST['user_first_name']);
    $last_name = sanitize_text_field($_POST['user_last_name']);
    $password = wp_generate_password();
    $role = $_POST['user_role'];

    // Check if the username and email are available
    if (!username_exists($username) && !email_exists($email)) {
        // Create a new user
        $user_id = wp_create_user($username, $password, $email);

        // Set user meta data (optional)
        update_user_meta($user_id, 'first_name', $first_name);
        update_user_meta($user_id, 'last_name', $last_name);

        // Assign the user to the selected role
        if ($user_id && in_array($role, array('project_manager', 'employee'))) {
            $user = new WP_User($user_id);
            $user->set_role($role);
        }

        // Send email to the user using wp_mail()
        $subject = 'Welcome to Time Tracking Tool - Your Account Information';
        $login_url = 'https://localhost/timetracking/login/';
        $message = '<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>New Account Email Template</title>
    <meta name="description" content="New Account Email Template." />
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }

        .body {
            margin: 0px;
            background-color: #f2f3f8;
        }

        .table1 {
            background-color: #f2f3f8;
            max-width: 670px;
            margin: 0 auto;
        }

        body {
            @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700);
            font-family: "Open Sans", sans-serif;
        }

        .tb2 {
            max-width: 670px;
            background: #fff;
            border-radius: 3px;
            text-align: center;
            -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
        }

        .h1 {
            color: #3ba1da;
            font-weight: 500;
            margin: 0;
            font-size: 30px;
            font-family: "Rubik", sans-serif;
        }

        .p1 {
            font-size: 15px;
            color: #455056;
            margin: 8px 0 0;
            line-height: 24px;
        }

        .p2 {
            color: #455056;
            font-size: 18px;
            line-height: 20px;
            margin: 0;
            font-weight: 500;
        }

        .p3 {
            font-size: 14px;
            color: rgba(69, 80, 86, 0.7411764705882353);
            line-height: 18px;
            margin: 0 0 0;
        }

        .s1 {
            display: inline-block;
            vertical-align: middle;
            margin: 29px 0 26px;
            border-bottom: 1px solid #cecece;
            width: 100px;
        }

        .st1 {
            display: block;
            font-size: 13px;
            margin: 0 0 4px;
            color: rgba(0, 0, 0, 0.64);
            font-weight: normal;
        }

        .st2 {
            display: block;
            font-size: 13px;
            margin: 24px 0 4px 0;
            font-weight: normal;
            color: rgba(0, 0, 0, 0.64);
        }

        .logo {
            background: #3ba1da;
            background: linear-gradient(90deg, #3ba1da 35%, #3ba1da 100%);
            text-decoration: none !important;
            display: inline-block;
            font-weight: 500;
            margin-top: 24px;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            padding: 10px 24px;
            display: inline-block;
            border-radius: 50px;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" class="body" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
        <tr>
            <td>
                <table width="100%" border="0" class="table1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="tb2">
                                <tr>
                                    <td style="height: 30px"> </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 35px">
                                        <h2 class="h1"><strong>Time Tracking Tool</strong></h2></strong>
                                        <p class="p1" style="margin-top: 20px;"><strong>Congratulations, ' . $first_name
            . ' ' . $last_name . '</strong><br> Your account has been created. Here
                                            are your login credentials.<br>Please change the password immediately after
                                            login.
                                        </p>
                                        <span class="s1"></span>
                                        <p class="p2">
                                            <strong class="st1">Username</strong><strong>' . $username . '</strong>
                                            <strong class="st2">Password</strong><strong>' . $password . '</strong>
                                        </p>

                                        <a href="https://localhost/timetracking/login/" class="logo"
                                            style="color:white;">
                                            Login to your Account
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 40px"> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <p class="p3">© <strong> 2024 Time Tracking Tool
                                </strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Time Tracking Tool <ashutoshuniyal223@gmail.com>',
        );

        // Send email using wp_mail()
        $mail_sent = wp_mail($email, $subject, $message, $headers);

        if ($mail_sent) {
            echo '<script>alert("User registration successful! Credentials email sent.");</script>';
        } else {
            echo '<script>alert("Error sending email. Please contact support.");</script>';
        }
    } else {
        // Use JavaScript to show an alert
        echo '<script>alert("Username or email already exists. Please choose a different one.");</script>';
    }
}










/*  Add your own functions below this line.
    ======================================== */






// Register Custom Post Type location
function register_employee_post_type()
{
    $labels = array(
        'name' => _x('Location', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Location', 'Post Type Singular Name', 'textdomain'),
        // Add other labels as needed
    );

    $args = array(
        'label' => __('Employee', 'textdomain'),
        'labels' => $labels,
        'public' => true,
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        // Add other arguments as needed
    );

    register_post_type('employee', $args);
}
add_action('init', 'register_employee_post_type');





// Register Custom Taxonomy
function register_location_taxonomy()
{
    $labels = array(
        'name' => _x('Locations', 'Taxonomy General Name', 'textdomain'),
        'singular_name' => _x('Location', 'Taxonomy Singular Name', 'textdomain'),
        // Add other labels as needed
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'hierarchical' => true,
        // Add other arguments as needed
    );

    register_taxonomy('location', array('employee'), $args);
}
add_action('init', 'register_location_taxonomy');




//location dropdown
function display_location_dropdown()
{
    $terms = get_terms(
        array(
            'taxonomy' => 'location',
            'hide_empty' => false,
        )
    );

    if (!empty($terms) && !is_wp_error($terms)) {
        echo '<select name="location_dropdown" id="location_dropdown">';
        echo '<option value="">Select Location</option>';

        foreach ($terms as $term) {
            echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
        }

        echo '</select>';
    } else {
        echo '<p>No locations found</p>';
    }
}
// Add a shortcode for easy use in post/page content
add_shortcode('location_dropdown', 'display_location_dropdown');

// Step 1: Create a Shortcode
function location_add_shortcode()
{
    ob_start(); // Start output buffering

    // Output the form HTML
    ?>
    <form method="post" onsubmit="return validateLocationForm();"
        style="max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <label for="new_location" style="display: block; margin-bottom: 10px; font-size: 16px; font-weight: bold;">New
            Location:</label>
        <input type="text" name="new_location" required placeholder="Add Location"
            style="width: 100%; padding: 10px; box-sizing: border-box; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 3px;">
        <input type="submit" value="Add Location"
            style="width: 100%; padding: 10px; cursor: pointer; background-color: #4CAF50; color: #fff; border: none; border-radius: 3px; font-size: 16px; font-weight: bold;">
    </form>



    <?php

    return ob_get_clean(); // End and clean the buffer
}

// Step 2: Handle Form Submission
function handle_location_form_submission()
{
    if (isset($_POST['new_location'])) {
        $new_location = sanitize_text_field($_POST['new_location']);

        // Validate and add the location (you can customize this based on your requirements)
        $term = wp_insert_term($new_location, 'location');

        if (!is_wp_error($term)) {
            echo '<p class="success-message">Location added successfully!</p>';
        } else {
            echo '<p class="error-message">Error adding location. Please try again.</p>';
        }
    }
}

// Step 3: Display Success or Error Messages
add_action('init', 'handle_location_form_submission');

// Step 4: Finalize the Shortcode
add_shortcode('location_add_form', 'location_add_shortcode');

function location_delete_shortcode()
{
    ob_start(); // Start output buffering

    // Output the form HTML
    ?>
    <form method="post"
        style="max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <label for="delete_location" style="display: block; margin-bottom: 10px; font-size: 16px; font-weight: bold;">Select
            Location to Delete:</label>
        <select name="delete_location" required
            style="width: 100%; padding: 10px; box-sizing: border-box; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 3px;">
            <option value="" disabled selected>Select Location</option> <!-- Default or placeholder option -->
            <?php
            $locations = get_terms('location', array('hide_empty' => false));
            foreach ($locations as $location) {
                echo '<option value="' . esc_attr($location->term_id) . '">' . esc_html($location->name) . '</option>';
            }
            ?>
        </select>
        <input type="submit" value="Delete Location"
            style="width: 100%; padding: 10px; cursor: pointer; background-color: #e74c3c; color: #fff; border: none; border-radius: 3px; font-size: 16px; font-weight: bold;">
    </form>



    <?php

    return ob_get_clean(); // End and clean the buffer
}

// Step 3: Handle Form Submission for Deleting Locations
function handle_location_delete_form_submission()
{
    if (isset($_POST['delete_location'])) {
        $location_id = intval($_POST['delete_location']);

        // Delete the location (you can customize this based on your requirements)
        $result = wp_delete_term($location_id, 'location');

        if (!is_wp_error($result)) {
            echo '<p class="success-message">Location deleted successfully!</p>';
        } else {
            echo '<p class="error-message">Error deleting location. Please try again.</p>';
        }
    }
}

// Step 4: Display Success or Error Messages for Deleting Locations
add_action('init', 'handle_location_delete_form_submission');

// Step 5: Finalize the Shortcodes
add_shortcode('location_delete_form', 'location_delete_shortcode');



// Create a Shortcode for Displaying Locations in a Table
function display_locations_table_shortcode()
{
    // Get all locations
    $locations = get_terms('location', array('hide_empty' => false));

    // Output the table HTML for displaying locations
    ob_start();
    ?>
    <table
        style="width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <thead>
            <tr>
                <th style="border: 1px solid #ccc; padding: 10px; text-align: center;">Location Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locations as $location): ?>
                <tr>
                    <td style="border: 1px solid #ccc; padding: 10px;">
                        <?php echo esc_html($location->name); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean(); // End and clean the buffer
}
// Add a shortcode for displaying locations in a table
add_shortcode('display_locations_table', 'display_locations_table_shortcode');





//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Register Custom Taxonomy for Task Types
function register_task_type_taxonomy()
{
    $labels = array(
        'name' => _x('Task Types', 'Taxonomy General Name', 'textdomain'),
        'singular_name' => _x('Task Type', 'Taxonomy Singular Name', 'textdomain'),
        // Add other labels as needed
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'hierarchical' => true,
        // Add other arguments as needed
    );

    register_taxonomy('task_type', array('employee'), $args);
}
add_action('init', 'register_task_type_taxonomy');

function display_tasktype_dropdown()
{
    $terms = get_terms(
        array(
            'taxonomy' => 'task_type',
            'hide_empty' => false,
        )
    );

    if (!empty($terms) && !is_wp_error($terms)) {
        echo '<select name="tasktype_dropdown" id="task_type_dropdown">';
        echo '<option value="">Select Task Type</option>';

        foreach ($terms as $term) {
            echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
        }

        echo '</select>';
    } else {
        echo '<p>No Task Type found</p>';
    }
}
// Add a shortcode for easy use in post/page content
add_shortcode('task_type_dropdown', 'display_tasktype_dropdown');

// Step 1: Create a Shortcode
function tasktype_add_shortcode()
{
    ob_start(); // Start output buffering

    // Output the form HTML
    ?>
    <form method="post"
        style="max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <label for="new_tasktype" style="display: block; margin-bottom: 10px; font-size: 16px; font-weight: bold;">New Task
            Type:</label>
        <input type="text" name="new_task_type" required placeholder="Add Task Type"
            style="width: 100%; padding: 10px; box-sizing: border-box; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 3px;">
        <input type="submit" value="Add Task"
            style="width: 100%; padding: 10px; cursor: pointer; background-color: #4CAF50; color: #fff; border: none; border-radius: 3px; font-size: 16px; font-weight: bold;">
    </form>

    <?php

    return ob_get_clean(); // End and clean the buffer
}

// Step 2: Handle Form Submission
function handle_tasktype_form_submission()
{
    if (isset($_POST['new_task_type'])) {
        $new_task_type = sanitize_text_field($_POST['new_task_type']);

        // Validate and add the task type (you can customize this based on your requirements)
        $term = wp_insert_term($new_task_type, 'task_type');

        if (!is_wp_error($term)) {
            echo '<p class="success-message">Task Type added successfully!</p>';
        } else {
            echo '<p class="error-message">Error adding task type. Please try again.</p>';
        }
    }
}

// Step 3: Display Success or Error Messages
add_action('init', 'handle_tasktype_form_submission');

// Step 4: Finalize the Shortcode
add_shortcode('task_type_add_form', 'tasktype_add_shortcode');

function tasktype_delete_shortcode()
{
    ob_start(); // Start output buffering

    // Output the form HTML
    ?>
    <form method="post"
        style="max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <label for="delete_tasktype" style="display: block; margin-bottom: 10px; font-size: 16px; font-weight: bold;">Select
            Task Type to Delete:</label>
        <select name="delete_task_type" required
            style="width: 100%; padding: 10px; box-sizing: border-box; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 3px;">
            <option value="" disabled selected>Select Task Type</option> <!-- Default or placeholder option -->
            <?php
            $task_types = get_terms('task_type', array('hide_empty' => false));
            foreach ($task_types as $task_type) {
                echo '<option value="' . esc_attr($task_type->term_id) . '">' . esc_html($task_type->name) . '</option>';
            }
            ?>
        </select>
        <input type="submit" value="Delete Task Type"
            style="width: 100%; padding: 10px; cursor: pointer; background-color: #e74c3c; color: #fff; border: none; border-radius: 3px; font-size: 16px; font-weight: bold;">
    </form>

    <?php

    return ob_get_clean(); // End and clean the buffer
}

// Step 3: Handle Form Submission for Deleting Task Types
function handle_tasktype_delete_form_submission()
{
    if (isset($_POST['delete_task_type'])) {
        $task_type_id = intval($_POST['delete_task_type']);

        // Delete the task type (you can customize this based on your requirements)
        $result = wp_delete_term($task_type_id, 'task_type');

        if (!is_wp_error($result)) {
            echo '<p class="success-message">Task Type deleted successfully!</p>';
        } else {
            echo '<p class="error-message">Error deleting task type. Please try again.</p>';
        }
    }
}

// Step 4: Display Success or Error Messages for Deleting Task Types
add_action('init', 'handle_tasktype_delete_form_submission');

// Step 5: Finalize the Shortcodes
add_shortcode('task_type_delete_form', 'tasktype_delete_shortcode');

// Create a Shortcode for Displaying Task Types in a Table
function display_task_types_table_shortcode()
{
    // Get all task types
    $task_types = get_terms('task_type', array('hide_empty' => false));

    // Output the table HTML for displaying task types
    ob_start();
    ?>
    <table
        style="width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <thead>
            <tr>
                <th style="border: 1px solid #ccc; padding: 10px; text-align: center;">Task Type Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($task_types as $task_type): ?>
                <tr>
                    <td style="border: 1px solid #ccc; padding: 10px;">
                        <?php echo esc_html($task_type->name); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean(); // End and clean the buffer
}
// Add a shortcode for displaying task types in a table
add_shortcode('display_task_types_table', 'display_task_types_table_shortcode');






// custom timesheet entry form
// Create a shortcode for the form
function custom_timesheetform_shortcode()
{
    ob_start();
    global $wpdb;

    // Get the logged-in user's ID
    $current_user_id = get_current_user_id();
    $current_user = wp_get_current_user();

    $is_project_manager = in_array('project_manager', $current_user->roles);

    if ($is_project_manager) {
        // Query to fetch projects from tables
        $projects_query = "
         SELECT project_id, project_name
        FROM wp_projects 
        WHERE project_manager_id ='$current_user_id' 
    ";
    } else {
        // Query to fetch projects from tables
        $projects_query = "
         SELECT project_id, project_name
        FROM wp_projects 
        WHERE employees_assigned LIKE '%$current_user_id%' 
    ";
    }

    // Execute the projects query
    $projects = $wpdb->get_results($projects_query);

    // Fetch locations from WordPress taxonomy
    $locations = get_terms(
        array(
            'taxonomy' => 'location', // Replace with your actual taxonomy name
            'hide_empty' => false,
        )
    );

    // Fetch task types from WordPress taxonomy
    $task_types = get_terms(
        array(
            'taxonomy' => 'task_type', // Replace with your actual taxonomy name
            'hide_empty' => false,
        )
    );

    // Display the form
    ?>
    <form id="custom-timesheet-form" method="post" action="">
        <div class="mb-3">
            <label for="project" class="form-label">Project Name</label>
            <select class="form-select" id="project" name="project" required>
                <option value="" disabled selected>Select Project</option>
                <?php
                // Loop through the fetched projects and create options for the dropdown
                foreach ($projects as $project) {
                    echo '<option value="' . esc_attr($project->project_id) . '">' . esc_html($project->project_name) . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="task" class="form-label">Task Type</label>
            <select class="form-select" id="task" name="task" required>
                <option value="" disabled selected>Select Task</option>
                <?php
                // Loop through the fetched task types and create options for the dropdown
                foreach ($task_types as $task_type) {
                    echo '<option value="' . esc_attr($task_type->term_id) . '">' . esc_html($task_type->name) . '</option>';
                }
                ?>
            </select>
        </div>
        <!--         <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <select class="form-select" id="location" name="location">
                <option selected>Select Location</option>
                <?php
                // Loop through the fetched locations and create options for the dropdown
//                 foreach ($locations as $location) {
//                     echo '<option value="' . esc_attr($location->term_id) . '">' . esc_html($location->name) . '</option>';
//                 }
                ?> 
            </select>
        </div> -->
        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="total-hours" class="form-label">Total Working Hours</label>
            <input type="text" class="form-control" id="total-hours" name="total-hours" pattern="[0-9]+(\.[0-9]{1,2})?"
                title="Enter a valid number with up to two decimal places" required>
        </div>
        <div class="mb-3">
            <label for="comments" class="form-label">Comments </label>
            <input type="text" class="form-control" id="comment" name="comment">
        </div>
        <div class="mb-3">
            <label for="updateStatus" class="form-label">Status</label>
            <select class="form-select" id="updateStatus" name="updateStatus">
                <option>Select Status</option>
                <option value="To-Do">To-Do</option>
                <option value="Work In Progress">Work In Progress</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="custom_timesheet_submit">Submit</button>
    </form>

    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('custom_timesheet_form', 'custom_timesheetform_shortcode');



add_action('wp_ajax_custom_timesheet_submit', 'custom_timesheet_submit');
//add_action('wp_ajax_nopriv_custom_timesheet_submit', 'custom_timesheet_submit'); // For non-logged-in users

function custom_timesheet_submit()
{
    global $wpdb;

    // Retrieve form data
    $project_id = $_POST['project'];
    $task = $_POST['task'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $total_hours = $_POST['total-hours'];
    $comments = $_POST['comment'];
    $status = isset($_POST['updateStatus']) ? $_POST['updateStatus'] : ''; // Check if the status is set, otherwise set it to an empty string

    // Check if the selected status is the default option
    if ($status === 'Select Status') {
        // Set status to an empty string
        $status = '';
    }

    // Validate the total hours format
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $total_hours)) {
        // Send invalid format error response
        wp_send_json_error(array('message' => 'Please enter a valid numeric value for Total Working Hours (up to two decimal places)'));
    }

    // Convert the submitted date to a DateTime object for comparison
    $submittedDate = new DateTime($date);
    // Get the current date as a DateTime object
    $currentDate = new DateTime();

    // Compare the submitted date with the current date
    if ($submittedDate > $currentDate) {
        // The submitted date is not a future date
        wp_send_json_error(array('message' => 'Please select the current date or a previous date for the timesheet.'));
    }


    // Query to calculate the total hours for the selected date
    $total_hours_query = $wpdb->prepare("
        SELECT SUM(hours_worked) as total_hours
        FROM wp_timesheets
        WHERE employee_id = %d AND date = %s
    ", get_current_user_id(), $date);

    // Execute the query
    $existing_total_hours = $wpdb->get_var($total_hours_query);

    // Calculate the new total hours (including the current submission)
    $new_total_hours = $existing_total_hours + $total_hours;

    // Check if the new total hours exceed the limit
    if ($new_total_hours > 24) {
        // Send limit exceeded error response
        wp_send_json_error(array('message' => 'Total working hours for ' . $date . ' exceeds the limit of 24 hours!'));
    }

    // Insert data into the timesheets table
    $result = $wpdb->insert(
        'wp_timesheets',
        array(
            'project_id' => $project_id,
            'employee_id' => get_current_user_id(),
            //                     'location' => $location,
            'date' => $date,
            'hours_worked' => $total_hours,
            'task' => $task,
            'description' => $description,
            'status' => $status,
            'comment' => $comments
        ),
        array(
            '%d',
            '%d',
            //                     '%s',
            '%s',
            '%f',
            '%s',
            '%s',
            '%s',
            '%s'

        )
    );
    if ($result !== false) {
        // Check the user's role for redirection
        $redirect_url = '';
        if (current_user_can('project_manager')) {
            // User is a project manager
            $redirect_url = 'https://localhost/timetracking/your-timesheet';
        } else {
            // User is not a project manager (presumably an employee)
            $redirect_url = 'https://localhost/timetracking/timesheet_entry';
        }

        // Send success response with the redirect URL
        wp_send_json_success(array('message' => 'Data submitted successfully!', 'redirect_url' => $redirect_url));
    } else {
        // Send database error response
        wp_send_json_error(array('message' => 'Error submitting data.'));
    }
}




// display timesheet employee

function display_timesheets_shortcode()
{
    global $wpdb;

    $current_user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $is_admin = in_array('administrator', $current_user->roles);
    $is_project_manager = in_array('project_manager', $current_user->roles);
    $timesheets_table = 'wp_timesheets';

    // Check if the URL contains 'timesheet_entry'
    if (strpos($_SERVER['REQUEST_URI'], 'employees-archived') !== false) {
        $timesheets_table = 'wp_archive_timesheets';
    }


    // Query to fetch timesheet data based on user role
    if ($is_admin) {
        $timesheets_query = "
            SELECT ".$timesheets_table.".*,
            CASE
                WHEN user_roles.meta_value LIKE '%project_manager%' THEN 'Project Manager'
                WHEN user_roles.meta_value LIKE '%employee%' THEN 'Employee'
                ELSE 'Unknown'
            END as user_role
            FROM ".$timesheets_table."
            LEFT JOIN wp_usermeta as user_roles ON ".$timesheets_table.".employee_id = user_roles.user_id
            WHERE user_roles.meta_key = 'wp_capabilities'
            ORDER BY ".$timesheets_table.".date DESC
        ";

    } elseif ($is_project_manager) {

        //$timesheets_query = "SELECT * FROM wp_timesheets WHERE employee_id = $current_user_id";
        // Construct the query to fetch timesheet data for the projects managed by the current user
        $projects_query = "
    SELECT project_id, employees_assigned
    FROM wp_projects
    WHERE project_manager_id = $current_user_id
    ";

        // Execute the query to get the projects managed by the current user
        $managed_projects = $wpdb->get_results($projects_query);

        // Initialize an empty array to store the project IDs and employee IDs
        $project_employee_map = array();

        // Loop through the managed projects to collect the project IDs and employee IDs
        foreach ($managed_projects as $project) {
            // Extract the employee IDs from the comma-separated list in the project's 'assigned_employee_ids' column
            $assigned_employee_ids = explode(',', $project->employees_assigned);

            // Add each project ID and its associated employee IDs to the map
            $project_employee_map[$project->project_id] = $assigned_employee_ids;
        }

        // Flatten the array of employee IDs to get a single list of unique employee IDs
        $employee_ids = array_unique(call_user_func_array('array_merge', $project_employee_map));

        // Construct the query to fetch timesheets for the collected employee IDs and project IDs
        $timesheets_query_project_manager = "
    SELECT *
    FROM ".$timesheets_table."
    WHERE employee_id IN (" . implode(',', array_map('intval', $employee_ids)) . ")
    AND project_id IN (" . implode(',', array_keys($project_employee_map)) . ")
    ";

        // Combine the existing query with the query for project manager's timesheets
        $timesheets_query = "
    SELECT * FROM (
        $timesheets_query_project_manager
    ) AS project_manager_timesheets
    ORDER BY date DESC";
    } else {
        $timesheets_query = "SELECT * FROM ".$timesheets_table." WHERE employee_id = $current_user_id ORDER BY date DESC";
    }

    // Execute the query
    $timesheets = $wpdb->get_results($timesheets_query);

    // Display the timesheet data in a table
    ob_start();
    ?>

    <div class="table-responsive">
        <table border="0" cellspacing="5" cellpadding="5">
            <tbody>
                <tr>
                    <td>From date:</td>
                    <td><input type="text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>To date:</td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>
                <tr>
                    <td>Filter by Date Range:</td>
                    <td><select id="date-filter" name="date-filter">
                            <option value="0">All</option>
                            <option value="7">Past 7 Days</option>
                            <option value="30">Past 30 Days</option>
                            <option value="60">Past 60 Days</option>
                            <option value="90">Past 90 Days</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <table id="timesheets-table" class="wp-timesheets-table ">
            <thead>
                <tr>

                    <?php if ($is_admin || $is_project_manager): ?>
                        <th class="no-wrapper">Employee Name</th>
                    <?php endif; ?>
                    <?php if ($is_admin): ?>
                        <th>User Role</th>
                    <?php endif; ?>
                    <th class="no-wrapper">Project</th>
                    <th class="no-wrapper">Task Type</th>
                    <!--                     <th class="no-wrapper">Location</th> -->
                    <th class="no-wrapper">Task Description</th>
                    <th class="no-wrapper">Date</th>
                    <th class="no-wrapper">Actual time(in hrs.)</th>
                    <th class="no-wrapper">Status</th>
                    <th class="no-wrapper">Comments</th>
                    <?php if (!$is_project_manager): ?>
                        <th class="no-wrapper">Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timesheets as $timesheet): ?>
                    <tr>
                        <?php if ($is_admin || $is_project_manager): ?>
                            <?php
                            $user = get_user_by('ID', $timesheet->employee_id);
                            $full_name = $user->first_name . ' ' . $user->last_name;
                            ?>
                            <td>
                                <?php echo esc_html($full_name); ?>
                            </td>
                        <?php endif; ?>
                        <?php if ($is_admin): ?>
                            <td>
                                <?php echo esc_html($timesheet->user_role); ?>
                            </td>
                        <?php endif; ?>
                        <td>
                            <?php echo esc_html(get_project_name($timesheet->project_id)); ?>
                        </td>
                        <td>
                            <?php echo get_term($timesheet->task, 'task_type')->name; ?>
                        </td>

                        <td>
                            <?php echo esc_html($timesheet->description); ?>
                        </td>
                        <td>
                            <?php echo esc_html(date('d/m/Y', strtotime($timesheet->date))); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->hours_worked); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->status); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->comment); ?>
                        </td>
                        <?php if (!$is_project_manager): ?>
                            <td class="buttons">
                                <form id="update-timesheet-<?php echo $timesheet->id; ?>" method="post"
                                    action="http://localhost/timetracking/update_timesheet">
                                    <input type="hidden" name="timesheet_id1" value="<?php echo $timesheet->id; ?>">
                                </form>
                                <a class="btn btn-primary text-white edit-timesheet-button"
                                    onclick="submitForm('update-timesheet-<?php echo $timesheet->id; ?>')"><i
                                        class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                <a class="btn btn-danger text-white delete-timesheet"
                                    data-timesheet-id="<?php echo $timesheet->id; ?>" data-timesheet-type="wp_timesheets"><i class="fa-solid fa-trash fa-lg"></i></a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('display_timesheets', 'display_timesheets_shortcode');



// AJAX handler for timesheet deletion
add_action('wp_ajax_delete_timesheet', 'custom_delete_timesheet_callback');

function custom_delete_timesheet_callback()
{
    check_ajax_referer('delete_timesheet_nonce', 'security');

    global $wpdb;

    // Get the timesheet ID from the AJAX request
    $timesheetId = intval($_POST['timesheet_id']);
    $timesheetType = isset($_POST['timesheet_type']) ? sanitize_text_field($_POST['timesheet_type']) : 'Invalid Type';

    // Delete the timesheet entry
    $result = $wpdb->delete($timesheetType, array('id' => $timesheetId));

    if ($result !== false) {
        echo 'Timesheet entry deleted successfully!';
    } else {
        echo 'Error deleting timesheet entry. Please try again.';
    }

    // Always exit to avoid further execution
    wp_die();
}



// Function to get project name from project ID
function get_project_name($project_id)
{
    global $wpdb;
    $project_name = $wpdb->get_var($wpdb->prepare("SELECT project_name FROM wp_projects WHERE project_id = %d", $project_id));
    return $project_name;
}



//update timesheet form for employee

function update_timesheet_form_shortcode1($atts)
{
    global $wpdb;


    $timesheet_table = 'wp_timesheets';
    if (isset($_POST['timesheet_type'])) {
        // Set the table name based on URL condition
        $timesheet_table = 'wp_archive_timesheets';
    }

    // Query to fetch tasks from the task_type taxonomy
    $tasks = get_terms(
        array(
            'taxonomy' => 'task_type',
            'hide_empty' => false,
        )
    );

    // Query to fetch locations from the location taxonomy
    $locations = get_terms(
        array(
            'taxonomy' => 'location',
            'hide_empty' => false,
        )
    );

    // Get the timesheet ID from the $_POST data
    $timesheet_id = isset($_POST['timesheet_id1']) ? intval($_POST['timesheet_id1']) : 0;

    // Query to fetch projects assigned to the current user
    $current_user_id = get_current_user_id();

    // Check user role
    $user_roles = wp_get_current_user()->roles;
    $is_admin_or_manager = in_array('administrator', $user_roles) || in_array('project_manager', $user_roles);

    // Query to fetch projects based on user role
    if ($is_admin_or_manager) {
        $emp_id_results = $wpdb->get_results("SELECT employee_id FROM $timesheet_table WHERE id= '$timesheet_id' ");
        $emp_id = $emp_id_results[0]->employee_id;

        // If the user is an admin or a manager, fetch  projects
        $projects = $wpdb->get_results("SELECT project_id, project_name FROM wp_projects  WHERE employees_assigned LIKE '%$emp_id%' or project_manager_id= '$emp_id'");
    } else {
        $projects = $wpdb->get_results($wpdb->prepare("
            SELECT project_id, project_name
            FROM wp_projects 
            WHERE employees_assigned LIKE '%$current_user_id%' 
        "));
    }

    // Check if a timesheet ID was provided
    if ($timesheet_id <= 0) {
        return 'Invalid timesheet ID'; // Return an error message if the ID is invalid
    }

    // Retrieve the timesheet data from the database based on the ID
    $timesheet = $wpdb->get_row($wpdb->prepare("SELECT * FROM $timesheet_table WHERE id = %d", $timesheet_id));

    // Check if the timesheet exists
    if (!$timesheet) {
        return 'Timesheet not found'; // Return an error message if the timesheet doesn't exist
    }

    // Generate the update form HTML
    ob_start();
    ?>
    <form id="update-timesheet-form" method="post">

        <input type="hidden" name="timesheet_id1" value="<?php echo $timesheet->id; ?>">
        <input type="hidden" name="employeeID" value="<?php echo $timesheet->employee_id; ?>">
        <input type="hidden" name="timesheet_type" value="<?php echo $timesheet_table; ?>">


        <div class="mb-3">
            <label for="project_id" class="form-label">Project:</label>
            <select id="project_id" name="project_id" class="form-select" required>

                <?php foreach ($projects as $project): ?>
                    <option value="<?php echo esc_attr($project->project_id); ?>" <?php selected($timesheet->project_id, $project->project_id); ?>>
                        <?php echo esc_html($project->project_name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="task_type" class="form-label">Task Type:</label>
            <select id="task_type" name="task_type" class="form-select" required>

                <?php foreach ($tasks as $task): ?>
                    <option value="<?php echo esc_attr($task->term_id); ?>" <?php selected($timesheet->task, $task->term_id); ?>>
                        <?php echo esc_html($task->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php   /* <div class="mb-3">
      <label for="location" class="form-label">Location:</label>
      <select id="location" name="location" class="form-select">
          <option value="">Select Location</option>
          <?php foreach ($locations as $location) : ?>
<option value="<?php echo esc_attr($location->term_id); ?>"
   <?php selected($timesheet->location, $location->term_id); ?>>
   <?php echo esc_html($location->name); ?>
</option>
<?php endforeach; ?>
</select>
</div>*/
        ?>
        <div class="mb-3">
            <label for="description" class="form-label">Task Description:</label>
            <input type="text" id="description" name="description" class="form-control"
                value="<?php echo esc_attr($timesheet->description); ?>" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" id="date" name="date" class="form-control" value="<?php echo esc_attr($timesheet->date); ?>"
                required>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Total Work Hours:</label>
            <input type="text" id="time" name="time" class="form-control"
                value="<?php echo esc_attr($timesheet->hours_worked); ?>" required>
        </div>
        <div class="mb-3">
            <label for="comments" class="form-label">Comments </label>
            <input type="text" class="form-control" id="comment" name="comment"
                value="<?php echo esc_attr($timesheet->comment); ?>">
        </div>
        <div class="mb-3">
            <label for="updateStatus" class="form-label">Status</label>
            <select class="form-select" id="updateStatus" name="updateStatus">
                <option>Select Status</option>
                <?php
                // Assuming $timesheet_status is the status fetched from the backend
                $timesheet_status = $timesheet->status;
                $status_options = array("To-Do", "Work In Progress", "Completed");
                foreach ($status_options as $option) {
                    $selected = ($timesheet_status === $option) ? 'selected' : '';
                    echo '<option value="' . esc_attr($option) . '" ' . $selected . '>' . esc_html($option) . '</option>';
                }
                ?>
            </select>
        </div>
        <!-- Add other form fields here -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary" name="update_timesheet_submit">Update Timesheet</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

add_shortcode('update_timesheet_form1', 'update_timesheet_form_shortcode1');


add_action('wp_ajax_update_timesheet_submit', 'update_timesheet_submit_callback');
//add_action('wp_ajax_nopriv_update_timesheet_submit', 'update_timesheet_submit_callback'); // For non-logged-in users

function update_timesheet_submit_callback()
{
    global $wpdb;


    // Sanitize and validate the submitted data
    $current_userss_id = intval($_POST['employeeID']);
    $timesheet_id = intval($_POST['timesheet_id1']);
    $timesheet_type = sanitize_text_field($_POST['timesheet_type']);
    $project_id = intval($_POST['project_id']);
    $task_type = sanitize_text_field($_POST['task_type']);
    // $location = sanitize_text_field($_POST['location']);
    $description = sanitize_text_field($_POST['description']);
    $date = sanitize_text_field($_POST['date']);
    $status = isset($_POST['updateStatus']) ? $_POST['updateStatus'] : ''; // Check if the status is set, otherwise set it to an empty string
    $comment = sanitize_text_field($_POST['comment']);
    $time = floatval($_POST['time']); // Assuming the time is submitted as a float



    // Check if the selected status is the default option
    if ($status === 'Select Status') {
        // Set status to an empty string
        $status = '';
    }

    // Convert the submitted date to a DateTime object for comparison
    $submittedDate = new DateTime($date);
    // Get the current date as a DateTime object
    $currentDate = new DateTime();

    // Compare the submitted date with the current date
    if ($submittedDate > $currentDate) {
        // The submitted date is not a future date
        wp_send_json_error(array('message' => 'Please select the current date or a previous date for the timesheet.'));
    }

    // Check total worked hours for the day
    $totalHoursQuery = $wpdb->prepare("
        SELECT SUM(hours_worked) AS total_hours
        FROM ".$timesheet_type."
        WHERE employee_id = %d
        AND date = %s
		 AND id != %d
    ", $current_userss_id, $date, $timesheet_id);

    $totalHoursResult = $wpdb->get_row($totalHoursQuery);

    // Calculate the total hours including the new entry
    $totalHours = floatval($totalHoursResult->total_hours) + $time;

    // Check if the total hours exceed 24
    if ($totalHours > 24) {
        // Total hours exceed the limit, send a validation error response
        wp_send_json_error(array('message' => 'Total worked hours for the day cannot exceed 24!'));
    } else {
        // Update the timesheet in the database
        $res = $wpdb->update(
            $timesheet_type,
            array(
                'project_id' => $project_id,
                // 'location' => $location,
                'date' => $date,
                'hours_worked' => $time,
                'task' => $task_type,
                'description' => $description,
                'status' => $status,
                'comment' => $comment
            ),
            array('id' => $timesheet_id),
            array(
                '%d',
                //    '%d',
                '%s',
                '%f',
                '%d',
                '%s',
                '%s',
                '%s'
            ),
            array('%d')
        );

        // Check for errors
        if ($res !== false) {
            // Check the user's role for redirection
            $redirect_url = '';
            if (current_user_can('project_manager') && $timesheet_type=='wp_timesheets') {
                // User is a project manager
                $redirect_url = 'http://localhost/timetracking/your-timesheet';
            } elseif($timesheet_type=='wp_timesheets'){
                // User is not a project manager (presumably an employee)
                $redirect_url = 'http://localhost/timetracking/timesheet_entry';
            }
            else{
                $redirect_url = 'http://localhost/timetracking/archive-timesheets/';
            }

            // Send success response with the redirect URL
            wp_send_json_success(array('message' => 'Data submitted successfully!', 'redirect_url' => $redirect_url));
        } else {
            // Handle the error (e.g., log it, display a message)
            error_log('Database error: ' . $wpdb->last_error);
            // Send an error response
            wp_send_json_error(array('message' => 'An error occurred while updating the data.'));
        }
    }


    // Always exit to prevent extra output
    wp_die();
}


// display timesheet of manager
function display_manager_timesheets_shortcode()
{
    global $wpdb;

    $current_user_id = get_current_user_id();
    $timesheets_query = "SELECT * FROM wp_timesheets WHERE employee_id = $current_user_id ORDER BY date DESC";


    // Execute the query
    $timesheets = $wpdb->get_results($timesheets_query);

    // Display the timesheet data in a table
    ob_start();
    ?>

    <div class="table-responsive">
        <table border="0" cellspacing="5" cellpadding="5">
            <tbody>
                <tr>
                    <td>From date:</td>
                    <td><input type="text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>To date:</td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>
                <tr>
                    <td>Filter by Date Range:</td>
                    <td><select id="date-filter" name="date-filter">
                            <option value="0">All</option>
                            <option value="7">Past 7 Days</option>
                            <option value="30">Past 30 Days</option>
                            <option value="60">Past 60 Days</option>
                            <option value="90">Past 90 Days</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <table id="timesheets-table" class="wp-timesheets-table">
            <thead>
                <tr>


                    <th class="no-wrapper">Project</th>
                    <th class="no-wrapper">Task Type</th>
                    <!--                     <th class="no-wrapper">Location</th> -->
                    <th class="no-wrapper">Task Description</th>
                    <th class="no-wrapper">Date</th>
                    <th class="no-wrapper">Actual time(in hrs.)</th>
                    <th class="no-wrapper">Status</th>
                    <th class="no-wrapper">Comments</th>
                    <th class="no-wrapper">Actions</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($timesheets as $timesheet): ?>
                    <tr>
                        <td>
                            <?php echo esc_html(get_project_name($timesheet->project_id)); ?>
                        </td>
                        <td>
                            <?php echo get_term($timesheet->task, 'task_type')->name; ?>
                        </td>

                        <td>
                            <?php echo esc_html($timesheet->description); ?>
                        </td>
                        <td>
                            <?php echo esc_html(date('d/m/Y', strtotime($timesheet->date))); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->hours_worked); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->status); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->comment); ?>
                        </td>

                        <td class="buttons">
                            <form id="update-timesheet-<?php echo $timesheet->id; ?>" method="post"
                                action="https://localhost/timetracking/update_timesheet">
                                <input type="hidden" name="timesheet_id1" value="<?php echo $timesheet->id; ?>">
                            </form>
                            <a class="btn btn-primary text-white edit-timesheet-button"
                                onclick="submitForm('update-timesheet-<?php echo $timesheet->id; ?>')"><i
                                    class="fa-solid fa-pen-to-square fa-xl"></i></a>
                            <a class="btn btn-danger text-white delete-timesheet"
                                data-timesheet-id="<?php echo $timesheet->id; ?>"><i class="fa-solid fa-trash fa-xl"></i></a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('display_manager_timesheets', 'display_manager_timesheets_shortcode');




function project_form_shortcode()
{
    ob_start();

    // Generate a unique project code
    $project_code = uniqid('PRJ');

    global $wpdb;

    // Query to get the last project ID from the wp_projects table
    $last_project_id = $wpdb->get_var("SELECT MAX(project_id) FROM {$wpdb->prefix}projects");

    // Increment the last project ID
    $new_project_id = $last_project_id + 1;

    // Generate a project ID with a prefix and the incremented number
    $project_id = 'PRJ' . str_pad($new_project_id, 4, '0', STR_PAD_LEFT);

    ?>

    <div class="container mt-5">
        <form id="projectForm">
            <div class="mb-3">
                <label for="projectCode" class="form-label">Project Code</label>
                <input type="text" class="form-control" id="projectCode" name="projectCode"
                    value="<?php echo esc_attr($project_id); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="projectType" class="form-label">Project Type</label>
                <select class="form-select" id="projectType" name="projectType" required>
                    <option value="" disabled selected>Select a project type</option>
                    <option value="Magento">Magento</option>
                    <option value="WordPress">WordPress</option>
                    <option value="Drupal">Drupal</option>
                    <option value="Shopify">Shopify</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="projectName" class="form-label">Project Name</label>
                <input type="text" class="form-control" id="projectName" name="projectName" required>
            </div>

            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required>
            </div>

            <div class="mb-3">
                <label for="completionDate" class="form-label">Completion Date</label>
                <input type="date" class="form-control" id="completionDate" name="completionDate" required>
            </div>

            <div class="mb-3">
                <label for="clientName" class="form-label">Client Name</label>
                <input type="text" class="form-control" id="clientName" name="clientName" required>
            </div>

            <div class="mb-3">
                <label for="contactDetails" class="form-label">Contact Details</label>
                <input type="text" class="form-control" id="contactDetails" name="contactDetails" required>
            </div>

            <div class="mb-3">
                <label for="timeZone" class="form-label">Time Zone</label>
                <input type="text" class="form-control" id="timeZone" name="timeZone" required>
            </div>

            <div class="mb-3">
                <label for="projectManager" class="form-label">Project Manager</label>
                <select class="form-select" id="projectManager" name="projectManager" required>
                    <!-- Add options for Project Manager dropdown -->
                    <option value="" disabled selected>Select a project manager</option>
                    <?php
                    $managers = get_users(array('role' => 'project_manager'));
                    foreach ($managers as $manager) {
                        $user_id = $manager->ID;
                        $first_name = get_user_meta($user_id, 'first_name', true);
                        $last_name = get_user_meta($user_id, 'last_name', true);
                        $full_name = $first_name . ' ' . $last_name;

                        echo '<option value="' . esc_attr($user_id) . '">' . esc_html($full_name) . '</option>';
                    }
                    ?>
                </select>

            </div>

            <div class="mb-3">
                <label for="employeeSearch" class="form-label">Search Employees</label>
                <input type="text" class="form-control" name="search_term" id="employeeSearch"
                    placeholder="Search Employee">
                <ul id="employeeList" class="list-group mt-2 position-absolute" style="z-index: 1000;"></ul>
            </div>
            <div class="mb-3">
                <label for="selectedEmployees" class="form-label">Selected Employees</label>
                <ul id="selectedEmployeesList" class="list-group">
                    <!-- Selected employees will be dynamically added here -->
                </ul>
            </div>
            <input type="hidden" id="selectedEmployeeId" name="selectedEmployeeId">

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="In Pipeline">In Pipeline</option>
                    <option value="Work In Progress">Work In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" id="comment" name="comment"></textarea>
            </div>

            <button type="button" class="btn btn-primary" id="submitFormButton">Submit</button>
        </form>
    </div>




    <?php
    return ob_get_clean();
}

add_shortcode('project_form', 'project_form_shortcode');




function enqueue_custom_scripts()
{
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/script.js', array('jquery'), '1.0', true);

    // Localize the script to pass the admin-ajax URL to the script.js file
    wp_localize_script(
        'custom-script',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce('delete_timesheet_nonce')
        )
    );
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function search_employees()
{
    $search_term = sanitize_text_field($_POST['search_term']);

    // Query to search users by first_name and last_name with role 'employee'
    $users_query = new WP_User_Query(
        array(
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'first_name',
                    'value' => $search_term,
                    'compare' => 'LIKE',
                ),
                array(
                    'key' => 'last_name',
                    'value' => $search_term,
                    'compare' => 'LIKE',
                ),
            ),
            'number' => 10, // Limit the number of results if needed
            'role' => 'employee', // Specify the role
        )
    );

    $users = $users_query->get_results();

    $result_array = array();
    if ($users) {
        foreach ($users as $user) {
            // Retrieve first_name and last_name from user meta
            $first_name = get_user_meta($user->ID, 'first_name', true);
            $last_name = get_user_meta($user->ID, 'last_name', true);

            // Add the user data to the result array
            $result_array[] = array(
                'ID' => $user->ID,
                'first_name' => $first_name,
                'last_name' => $last_name,
            );
        }
    }

    wp_send_json($result_array);
}


add_action('wp_ajax_search_employees', 'search_employees');
add_action('wp_ajax_nopriv_search_employees', 'search_employees');

// Save form data to the database
function save_project_form()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'projects';

    $project_name = sanitize_text_field($_POST['projectName']);
    $project_type = sanitize_text_field($_POST['projectType']);
    $start_date = sanitize_text_field($_POST['startDate']);
    $completion_date = sanitize_text_field($_POST['completionDate']);
    // Convert the date to a Unix timestamp and then format it
    $formatted_date = date('d/m/Y', strtotime($start_date));

    $client_name = sanitize_text_field($_POST['clientName']);
    $contact_details = sanitize_text_field($_POST['contactDetails']);
    $time_zone = sanitize_text_field($_POST['timeZone']);
    $project_manager = sanitize_text_field($_POST['projectManager']);
    $employees_assigned_ids = sanitize_text_field($_POST['selectedEmployeeId']);
    $status = sanitize_text_field($_POST['status']);
    $comment = sanitize_textarea_field($_POST['comment']);

    // Check if the project already exists
    $existing_project = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE project_name = %s", $project_name)
    );

    if ($existing_project) {
        // Project already exists
        wp_send_json_error('Project with the same name already exists.');
    } else {
        // Project doesn't exist, insert the new record
        $result = $wpdb->insert(
            $table_name,
            array(
                'project_name' => $project_name,
                'project_type' => $project_type,
                'start_date' => $start_date,
                'completion_date' => $completion_date,
                'client_name' => $client_name,
                'contact_details' => $contact_details,
                'time_zone' => $time_zone,
                'project_manager_id' => $project_manager,
                'employees_assigned' => $employees_assigned_ids,
                'status' => $status,
                'comment' => $comment,
            )
        );

        if ($result === false) {
            // Error occurred during insertion
            wp_send_json_error('Error inserting data into the database: ' . $wpdb->last_error);
        } else {
            // Get project manager details
            $manager_data = get_userdata($project_manager);
            $manager_name = $manager_data->first_name . ' ' . $manager_data->last_name;
            $manager_email = $manager_data->user_email;

            // Get employee names
            $employees_ids = explode(',', $employees_assigned_ids);
            $employees_names = array();
            foreach ($employees_ids as $employee_id) {
                $employee_data = get_userdata($employee_id);
                $employees_names[] = $employee_data->first_name . ' ' . $employee_data->last_name;
            }
            $employees_assigned = implode(', ', $employees_names);

            // Send email to project manager
            $manager_subject = 'Hello ' . $manager_name . ', New Project Created: ' . $project_name;
            $manager_message = '<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>New Account Email Template</title>
    <meta name="description" content="New Account Email Template." />
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }

        .body {
            margin: 0px;
            background-color: #f2f3f8;
        }

        .table1 {
            background-color: #f2f3f8;
            max-width: 670px;
            margin: 0 auto;
        }

        body {
            @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700);
            font-family: "Open Sans", sans-serif;
        }

        .tb2 {
            max-width: 670px;
            background: #fff;
            border-radius: 3px;
            text-align: center;
            -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
        }

        .h1 {
            color: #3ba1da;
            font-weight: 500;
            margin: 0;
            font-size: 30px;
            font-family: "Rubik", sans-serif;
        }

        .p1 {
            font-size: 15px;
            color: #455056;
            margin: 8px 0 0;
            line-height: 24px;
        }

        .p2 {
            color: #455056;
            font-size: 18px;
            line-height: 20px;
            margin: 0;
            font-weight: 500;
        }

        .p3 {
            font-size: 14px;
            color: rgba(69, 80, 86, 0.7411764705882353);
            line-height: 18px;
            margin: 0 0 0;
        }

        .s1 {
            display: inline-block;
            vertical-align: middle;
            margin: 29px 0 26px;
            border-bottom: 1px solid #cecece;
            width: 100px;
        }

        .st1 {
            display: block;
            font-size: 13px;
            margin: 0 0 4px;
            color: rgba(0, 0, 0, 0.64);
            font-weight: normal;
        }

        .st2 {
            display: block;
            font-size: 13px;
            margin: 24px 0 4px 0;
            font-weight: normal;
            color: rgba(0, 0, 0, 0.64);
        }

        .logo {
            background: #3ba1da;
            background: linear-gradient(90deg, #3ba1da 35%, #3ba1da 100%);
            text-decoration: none !important;
            display: inline-block;
            font-weight: 500;
            margin-top: 30px;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            padding: 10px 24px;
            display: inline-block;
            border-radius: 50px;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" class="body" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
        <tr>
            <td>
                <table width="100%" border="0" class="table1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="tb2">
                                <tr>
                                    <td style="height: 30px"> </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 35px">
                                        <h2 class="h1"><strong>Time Tracking Tool</strong></h2></strong>
                                        <p class="p1" style="margin-top: 20px;"><strong>Hello ' . $manager_name . ',</strong><br> A new project has been created. Here
                                            are the project details:
                                        </p>
                                        <span class="s1"></span>
                                        <p class="p2">
                                            <strong class="st1">Project Name</strong><strong>' . $project_name . '</strong>
                                            <strong class="st2">Start Date</strong><strong>' . $formatted_date . '</strong>
                                            <strong class="st2">Client Name</strong><strong>' . $client_name . '</strong>
                                            <strong class="st2">Employees Assigned</strong><strong>' . $employees_assigned . '</strong>
                                        </p>

                                        <a href="https://localhost/timetracking/your-projects/" class="logo"
                                            style="color:white;">
                                            View Project
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 40px"> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <p class="p3">© <strong> 2024 Time Tracking Tool
                                </strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>';

            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: Time Tracking Tool <ashutoshuniyal223@gmail.com>',
            );

            wp_mail($manager_email, $manager_subject, $manager_message, $headers);

            // Send email to employees
            foreach ($employees_ids as $employee_id) {
                $employee_data = get_userdata($employee_id);
                $employee_name = $employee_data->first_name . ' ' . $employee_data->last_name;
                $employee_email = $employee_data->user_email;

                $employee_subject = 'Hello ' . $employee_name . ', New Project Assignment: ' . $project_name;
                $employee_message = '<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>New Account Email Template</title>
    <meta name="description" content="New Account Email Template." />
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }

        .body {
            margin: 0px;
            background-color: #f2f3f8;
        }

        .table1 {
            background-color: #f2f3f8;
            max-width: 670px;
            margin: 0 auto;
        }

        body {
            @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700);
            font-family: "Open Sans", sans-serif;
        }

        .tb2 {
            max-width: 670px;
            background: #fff;
            border-radius: 3px;
            text-align: center;
            -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
        }

        .h1 {
            color: #3ba1da;
            font-weight: 500;
            margin: 0;
            font-size: 30px;
            font-family: "Rubik", sans-serif;
        }

        .p1 {
            font-size: 15px;
            color: #455056;
            margin: 8px 0 0;
            line-height: 24px;
        }

        .p2 {
            color: #455056;
            font-size: 18px;
            line-height: 20px;
            margin: 0;
            font-weight: 500;
        }

        .p3 {
            font-size: 14px;
            color: rgba(69, 80, 86, 0.7411764705882353);
            line-height: 18px;
            margin: 0 0 0;
        }

        .s1 {
            display: inline-block;
            vertical-align: middle;
            margin: 29px 0 26px;
            border-bottom: 1px solid #cecece;
            width: 100px;
        }

        .st1 {
            display: block;
            font-size: 13px;
            margin: 0 0 4px;
            color: rgba(0, 0, 0, 0.64);
            font-weight: normal;
        }

        .st2 {
            display: block;
            font-size: 13px;
            margin: 24px 0 4px 0;
            font-weight: normal;
            color: rgba(0, 0, 0, 0.64);
        }

        .logo {
            background: #3ba1da;
            background: linear-gradient(90deg, #3ba1da 35%, #3ba1da 100%);
            text-decoration: none !important;
            display: inline-block;
            font-weight: 500;
            margin-top: 30px;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            padding: 10px 24px;
            display: inline-block;
            border-radius: 50px;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" class="body" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
        <tr>
            <td>
                <table width="100%" border="0" class="table1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="tb2">
                                <tr>
                                    <td style="height: 30px"> </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 35px">
                                        <h2 class="h1"><strong>Time Tracking Tool</strong></h2></strong>
                                        <p class="p1" style="margin-top: 20px;"><strong>Hello
                                                ' . $employee_name . ',</strong><br> You have been assigned to a new project. Here
                                            are the project details:
                                        </p>
                                        <span class="s1"></span>
                                        <p class="p2">
                                            <strong class="st1">Project Name</strong><strong>' . $project_name . '</strong>
                                            <strong class="st2">Start Date</strong><strong>' . $formatted_date . '</strong>
                                            <strong class="st2">Client Name</strong><strong>' . $client_name . '</strong>
                                            <strong class="st2">Your Manager</strong><strong>' . $manager_name . '</strong>
                                        </p>

                                        <a href="https://localhost/timetracking/your-projects/" class="logo"
                                            style="color:white;">
                                            View Project
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 40px"> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <p class="p3">© <strong>2024 Time Tracking Tool
                                </strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>';

                wp_mail($employee_email, $employee_subject, $employee_message, $headers);
            }

            // Successfully inserted
            wp_send_json_success('Project added successfully!');
        }
        exit; // Important: Ensure that you call exit() after wp_redirect() to stop further execution
    }
}


add_action('wp_ajax_save_project_form', 'save_project_form');
add_action('wp_ajax_nopriv_save_project_form', 'save_project_form');






// Your Projects Section----------------------------------------------------------------------------------------------------------------------------------------------------
// Shortcode to display the custom projects table
function custom_project_table_shortcode()
{
    global $wpdb, $current_user;

    // Get the current user's roles
    $user_roles = $current_user->roles;

    // Check user role and modify the query accordingly
    if (in_array('administrator', $user_roles)) {
        // Administrator can see all projects
        $projects_query = "SELECT * FROM wp_projects ORDER BY start_date DESC";
    } elseif (in_array('project_manager', $user_roles)) {
        // Project manager can see projects assigned to them
        $current_manager_id = $current_user->ID;
        $projects_query = "SELECT * FROM wp_projects WHERE project_manager_id = $current_manager_id ORDER BY start_date DESC";
    } elseif (in_array('employee', $user_roles)) {
        // Employee can see projects assigned to them
        $current_employee_id = $current_user->ID;
        $projects_query = "SELECT * FROM wp_projects WHERE FIND_IN_SET($current_employee_id, employees_assigned) > 0 ORDER BY start_date DESC";
    } else {
        // Other roles (if any) can see an empty list or handle it as needed
        $projects_query = "";
    }

    // Fetch projects
    $projects = $wpdb->get_results($projects_query, ARRAY_A);

   
    // Table header
    $table_content = '
    <table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>From date:</td>
            <td><input type="text" id="min2" name="min"></td>
        </tr>
        <tr>
            <td>To date:</td>
            <td><input type="text" id="max2" name="max"></td>
        </tr>
    </tbody></table>
	<div class="table-responsive">
    <table id="projects_table" style="width:100%">
        <thead>
            <tr>
                <th class="no-wrapper">Project Name</th>
                <th class="no-wrapper">Code</th>
                <th class="no-wrapper">Start Date</th>
                <th class="no-wrapper">Completion Date</th>
                <th class="no-wrapper">Client Name</th>
                <th class="no-wrapper">Contact Details</th>';

    // Check if the user is not a project manager before displaying the "Project Manager" column
    if (!in_array('project_manager', $user_roles)) {
        $table_content .= '<th class="no-wrapper">Project Manager</th>';
    }

    $table_content .= '<th class="no-wrapper">Employees Assigned</th>
                <th >Time Consumed</th>
                <th class="no-wrapper">Status</th>
                <th class="no-wrapper">Comments</th>';

    // Check if the user is not an employee before displaying the action column
    if (!in_array('employee', $user_roles)) {
        $table_content .= '<th class="no-wrapper">Action</th>';
    }

    $table_content .= '</tr>
        </thead>
        <tbody>';

    foreach ($projects as $project) {
        // Retrieve user name based on project manager ID
        $project_manager_id = $project['project_manager_id'];
        $project_manager_data = get_userdata($project_manager_id);
        $project_manager_name = ($project_manager_data) ? $project_manager_data->first_name . ' ' . $project_manager_data->last_name : '';

        // Retrieve user names based on employees_assigned IDs
        $employees_assigned_ids = explode(',', $project['employees_assigned']);
        $employees_assigned_names = array();

        foreach ($employees_assigned_ids as $employee_id) {
            $user_info = get_userdata($employee_id);

            if ($user_info) {
                $employees_assigned_names[] = $user_info->first_name . ' ' . $user_info->last_name;
            }
        }

        // Query to calculate total hours worked for each project from both tables
        $total_hours_query = "
            SELECT
                COALESCE(SUM(hours_worked), 0) AS total_hours_worked
            FROM
                (SELECT hours_worked FROM wp_timesheets WHERE project_id = %d
                 UNION ALL
                 SELECT hours_worked FROM wp_archive_timesheets WHERE project_id = %d) AS combined_timesheets
        ";

        // Fetch total hours worked for the project from both tables
        $total_hours_worked = $wpdb->get_var($wpdb->prepare($total_hours_query, $project['project_id'], $project['project_id']));
        // Format total hours worked
        $total_hours_worked = number_format($total_hours_worked, 1);

        $table_content .= '
    <tr>
        <td>
			<form method="post" action="' . esc_url(home_url('/single/')) . '">
				<input type="hidden" name="project_id" value="' . esc_attr($project['project_id']) . '">
				<button type="submit" style="background:none; border:none; padding:0; margin:0; font-size:inherit; cursor:pointer; color:black;">
					' . esc_html($project['project_name']) . '
				</button>
			</form>
		</td>
        <td>PRJ' . str_pad($project['project_id'], 4, '0', STR_PAD_LEFT) . '</td>
        <td>' . (!empty($project['start_date']) && $project['start_date'] != '0000-00-00' ? esc_html(date('d/m/Y', strtotime($project['start_date']))) : '') . '</td>
        <td>' . (!empty($project['completion_date']) && $project['completion_date'] != '0000-00-00' ? esc_html(date('d/m/Y', strtotime($project['completion_date']))) : '') . '</td>
        <td>' . esc_html($project['client_name']) . '</td>
        <td>' . esc_html($project['contact_details']) . '</td>';

        // Check if the user is not a project manager before displaying the "Project Manager" column
        if (!in_array('project_manager', $user_roles)) {
            $table_content .= '<td>' . esc_html($project_manager_name) . '</td>';
        }

        $table_content .= '<td>' . implode(', ', $employees_assigned_names) . '</td>
        <td>' . esc_html($total_hours_worked) . '</td>
        <td>' . esc_html($project['status']) . '</td>
        <td>' . esc_html($project['comment']) . '</td>';

        // Check if the user is not an employee before displaying the action column
        if (!in_array('employee', $user_roles)) {
            $table_content .= '<td class="buttons">';

            // Edit button
            $form_id = 'edit_form_' . $project['project_id'];
            $update_url = esc_url(home_url('/update-project-form/'));
            $table_content .= '<form id="' . $form_id . '" action="' . $update_url . '" method="POST" style="display: none;">
                <input type="hidden" name="project_id" value="' . $project['project_id'] . '">
            </form>
            <a href="javascript:void(0);" onclick="submitForm(\'' . $form_id . '\')" class="btn btn-primary text-white"><i class="fa-solid fa-pen-to-square fa-lg"></i></a>';

            // Delete button (visible for administrators only)
            if (in_array('administrator', $user_roles)) {
                $table_content .= '<a href="javascript:void(0);" class="btn btn-danger text-white delete-project" data-project-id="' . $project['project_id'] . '" data-project-name="' . $project['project_name'] . '"><i class="fa-solid fa-trash fa-lg"></i></a>';
            }

            $table_content .= '</td>';
        }

        $table_content .= '</tr>';
    }

    // Table footer
    $table_content .= '</tbody></table></div>';

    return $table_content;
}


// Register the shortcode
add_shortcode('custom_projects_table', 'custom_project_table_shortcode');





// AJAX handler for project deletion
add_action('wp_ajax_delete_project', 'custom_delete_project_callback');
function custom_delete_project_callback()
{
    global $wpdb;

    // Get the project ID from the AJAX request
    $projectId = intval($_POST['project_id']);

    // Delete the project entry
    $result = $wpdb->delete('wp_projects', array('project_id' => $projectId));

    if ($result !== false) {
        echo 'Project deleted successfully!';
    } else {
        echo 'Error deleting project. Please try again.';
    }

    // Always exit to avoid further execution
    wp_die();
}





function update_project_form_shortcode($atts)
{
    ob_start();

    // Get the project ID from shortcode attributes
    $project_id = isset($_POST['project_id']) ? intval($_POST['project_id']) : 0;

    error_log('Received project ID: ' . $project_id);
    // Check if a valid project ID is provided
    if ($project_id > 0) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'projects';

        // Retrieve project details from the database based on project ID
        $project = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE project_id = %d", $project_id));

        // Generate a project ID with a prefix and the incremented number
        $gen_project_id = 'PRJ' . str_pad($project->project_id, 4, '0', STR_PAD_LEFT);

        if ($project) {
            // Get all users with the 'project_manager' role
            $project_managers = get_users(array('role' => 'project_manager'));

            ?>

            <div class="container mt-5">
                <form id="updateProjectForm" method="POST">
                    <!-- Add a hidden field for the project ID -->
                    <input type="hidden" name="projectID" value="<?php echo $project_id; ?>">

                    <div class="mb-3">
                        <label for="projectCode" class="form-label">Project Code</label>
                        <input type="text" class="form-control" id="projectCode" name="projectCode"
                            value="<?php echo esc_attr($gen_project_id); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="projectType" class="form-label">Project Type</label>
                        <select class="form-select" id="updateProjectType" name="updateProjectType" required>
                            <?php
                            // Array of project types
                            $project_types = array("Magento", "WordPress", "Drupal", "Shopify");

                            // Check if the project type is set
                            $selected_project_type = ''; // default value
                            if ($project->project_type !== NULL) { // Replace $project_type_from_database with the actual value from the database
                                $selected_project_type = $project->project_type;
                            }

                            // Output options
                            echo '<option value=""' . ($selected_project_type === 'NULL' ? ' selected disabled' : 'selected disabled') . '>Select a project type</option>';
                            foreach ($project_types as $project_type) {
                                $selected = ($selected_project_type === $project_type) ? 'selected' : '';
                                echo "<option value=\"$project_type\" $selected>$project_type</option>";
                            }
                            ?>
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="updateProjectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="updateProjectName" name="updateProjectName"
                            value="<?php echo esc_attr($project->project_name); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="updateStartDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="updateStartDate" name="updateStartDate"
                            value="<?php echo esc_attr($project->start_date); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="updateCompletionDate" class="form-label">Completion Date</label>
                        <input type="date" class="form-control" id="updateCompletionDate" name="updateCompletionDate"
                            value="<?php echo esc_attr($project->completion_date); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="updateClientName" class="form-label">Client Name</label>
                        <input type="text" class="form-control" id="updateClientName" name="updateClientName"
                            value="<?php echo esc_attr($project->client_name); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="updateContactDetails" class="form-label">Contact Details</label>
                        <input type="text" class="form-control" id="updateContactDetails" name="updateContactDetails"
                            value="<?php echo esc_attr($project->contact_details); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="updateTimeZone" class="form-label">Time Zone</label>
                        <input type="text" class="form-control" id="updateTimeZone" name="updateTimeZone"
                            value="<?php echo esc_attr($project->time_zone); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="updateProjectManager" class="form-label">Project Manager</label>

                        <?php
                        $current_user = wp_get_current_user();
                        $is_admin = current_user_can('administrator');
                        $is_project_manager = current_user_can('project_manager');

                        if ($is_admin) {
                            // Display dropdown for admin or project manager
                            ?>
                            <select class="form-select" id="updateProjectManager" name="updateProjectManager">
                                <!-- Add options for Project Manager dropdown -->
                                <option value="" disabled selected>Select a project manager</option>
                                <?php
                                foreach ($project_managers as $manager) {
                                    $user_id = $manager->ID;
                                    $first_name = get_user_meta($user_id, 'first_name', true);
                                    $last_name = get_user_meta($user_id, 'last_name', true);
                                    $full_name = $first_name . ' ' . $last_name;

                                    $selected = selected($project->project_manager_id, $user_id, false);
                                    echo '<option value="' . esc_attr($user_id) . '" ' . $selected . '>' . esc_html($full_name) . '</option>';
                                }
                                ?>
                            </select>

                            <!-- Hidden input to store the selected value (project manager ID) -->
                            <input type="hidden" name="updateProjectManager_hidden"
                                value="<?php echo esc_attr($project->project_manager_id); ?>">

                            <!-- Readonly input field for displaying project manager name -->
                            <input type="hidden" class="form-control" id="updateProjectManager_display"
                                value="<?php echo esc_html(get_userdata($project->project_manager_id)->display_name); ?>" readonly>
                            <?php
                        } else {
                            // Display hidden dropdown and show input field for project manager name
                            ?>
                            <select style="display: none;" class="form-select" id="updateProjectManager" name="updateProjectManager">
                                <!-- Add options for Project Manager dropdown (hidden) -->
                                <option value="<?php echo esc_attr($project->project_manager_id); ?>" selected>
                                    <?php echo esc_html(get_userdata($project->project_manager_id)->display_name); ?>
                                </option>
                            </select>

                            <!-- Visible input field for project manager name -->
                            <input type="text" class="form-control" id="updateProjectManager_display"
                                value="<?php echo esc_html(get_userdata($project->project_manager_id)->display_name); ?>" readonly>

                            <!-- Hidden input to store the selected value (project manager ID) -->
                            <input type="hidden" name="updateProjectManager_hidden"
                                value="<?php echo esc_attr($project->project_manager_id); ?>">
                            <?php
                        }
                        ?>
                    </div>







                    <div class="mb-3">
                        <label for="employeeSearch" class="form-label">Search Employees</label>
                        <input type="text" class="form-control" name="search_term" id="employeeSearch"
                            placeholder="Search Employee">
                        <ul id="employeeList" class="list-group mt-2 position-absolute" style="z-index: 1000;"></ul>
                    </div>
                    <div class="mb-3">
                        <label for="selectedEmployees" class="form-label">Selected Employees</label>
                        <ul id="updateselectedEmployeesList" class="list-group">
                            <!-- Selected employees will be dynamically added here -->
                        </ul>
                    </div>
                    <input type="hidden" id="updateselectedEmployeeId" name="updateselectedEmployeeId"
                        value="<?php echo esc_attr($project->employees_assigned); ?>">
                    <!-- <div class="mb-3">
    <label for="updateTimeConsumed" class="form-label">Time Consumed (in hours)</label>
    <input type="number" class="form-control" id="updateTimeConsumed" name="updateTimeConsumed">
</div> -->
                    <div class="mb-3">
                        <label for="updateStatus" class="form-label">Status</label>
                        <select class="form-select" id="updateStatus" name="updateStatus">
                            <option value="In Pipeline">In Pipeline</option>
                            <option value="Work In Progress">Work In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="updateComment" class="form-label">Comment</label>
                        <textarea class="form-control" id="updateComment"
                            name="updateComment"><?php echo esc_html($project->comment); ?></textarea>
                    </div>

                    <!-- Add more fields as needed -->

                    <button type="submit" class="btn btn-primary" name="update_project_submit">Update Project</button>
                </form>
            </div>

            <?php
        } else {
            echo 'Project not found.';
        }
    } else {
        echo 'Invalid project ID.';
    }

    return ob_get_clean();
}

add_shortcode('update_project_form', 'update_project_form_shortcode');

function get_employee_name_by_id($employee_id)
{
    $employee = get_userdata($employee_id);
    if ($employee) {
        return $employee->display_name;
    } else {
        return 'Employee ' . $employee_id;
    }
}

// Add an AJAX action to handle the request
add_action('wp_ajax_get_employee_name_by_id', 'get_employee_name_by_id_callback');

if (isset($_POST['update_project_submit'])) {
    global $wpdb;

    // Get user input from the form
    $project_id = intval($_POST['projectID']);
    $project_type = sanitize_text_field($_POST['updateProjectType']);
    $project_name = sanitize_text_field($_POST['updateProjectName']);
    $start_date = sanitize_text_field($_POST['updateStartDate']);
    // Convert the date to a Unix timestamp and then format it
    $formatted_date = date('d/m/Y', strtotime($start_date));
    $completion_date = sanitize_text_field($_POST['updateCompletionDate']);
    $client_name = sanitize_text_field($_POST['updateClientName']);
    $contact_details = sanitize_text_field($_POST['updateContactDetails']);
    $time_zone = sanitize_text_field($_POST['updateTimeZone']);
    $project_manager_id = intval($_POST['updateProjectManager']);
    $employees_assigned = sanitize_text_field($_POST['updateselectedEmployeeId']);
    $status = sanitize_text_field($_POST['updateStatus']);
    $comment = sanitize_textarea_field($_POST['updateComment']);

    // Validate and sanitize data as needed
    // Retrieve the current project manager and employees
    $old_project = $wpdb->get_row($wpdb->prepare("SELECT * FROM wp_projects WHERE project_id = %d", $project_id));
    $old_project_manager_id = $old_project->project_manager_id;
    $old_employees_assigned = explode(',', $old_project->employees_assigned);

    // Update project data in the database
    $table_name = $wpdb->prefix . 'projects';
    $wpdb->update(
        $table_name,
        array(
            'project_name' => $project_name,
            'project_type' => $project_type,
            'start_date' => $start_date,
            'completion_date' => $completion_date,
            'client_name' => $client_name,
            'contact_details' => $contact_details,
            'time_zone' => $time_zone,
            'project_manager_id' => $project_manager_id,
            'employees_assigned' => $employees_assigned,
            'status' => $status,
            'comment' => $comment,
        ),
        array('project_id' => $project_id)
    );

    // Send emails to selected employees who are newly added
    $selected_employee_ids = array_diff(
        array_unique(explode(',', $employees_assigned)),
        $old_employees_assigned
    );

    // Send email notifications to project manager if changed
    if ($project_manager_id != $old_project_manager_id) {
        $project_manager_email = get_userdata($project_manager_id)->user_email;
        $project_manager_name = get_names_from_id($project_manager_id);

        // Get employee names
        $employees_ids = explode(',', $employees_assigned);
        $employees_names = array();
        foreach ($employees_ids as $employee_id) {
            $employee_data = get_userdata($employee_id);
            $employees_names[] = $employee_data->first_name . ' ' . $employee_data->last_name;
        }
        $employees_assigned = implode(', ', $employees_names);

        // Email template
        $subject = 'Hello ' . $project_manager_name . ', New Project Created: ' . $project_name;
        $message = '<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>New Account Email Template</title>
    <meta name="description" content="New Account Email Template." />
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }

        .body {
            margin: 0px;
            background-color: #f2f3f8;
        }

        .table1 {
            background-color: #f2f3f8;
            max-width: 670px;
            margin: 0 auto;
        }

        body {
            @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700);
            font-family: "Open Sans", sans-serif;
        }

        .tb2 {
            max-width: 670px;
            background: #fff;
            border-radius: 3px;
            text-align: center;
            -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
        }

        .h1 {
            color: #3ba1da;
            font-weight: 500;
            margin: 0;
            font-size: 30px;
            font-family: "Rubik", sans-serif;
        }

        .p1 {
            font-size: 15px;
            color: #455056;
            margin: 8px 0 0;
            line-height: 24px;
        }

        .p2 {
            color: #455056;
            font-size: 18px;
            line-height: 20px;
            margin: 0;
            font-weight: 500;
        }

        .p3 {
            font-size: 14px;
            color: rgba(69, 80, 86, 0.7411764705882353);
            line-height: 18px;
            margin: 0 0 0;
        }

        .s1 {
            display: inline-block;
            vertical-align: middle;
            margin: 29px 0 26px;
            border-bottom: 1px solid #cecece;
            width: 100px;
        }

        .st1 {
            display: block;
            font-size: 13px;
            margin: 0 0 4px;
            color: rgba(0, 0, 0, 0.64);
            font-weight: normal;
        }

        .st2 {
            display: block;
            font-size: 13px;
            margin: 24px 0 4px 0;
            font-weight: normal;
            color: rgba(0, 0, 0, 0.64);
        }

        .logo {
            background: #3ba1da;
            background: linear-gradient(90deg, #3ba1da 35%, #3ba1da 100%);
            text-decoration: none !important;
            display: inline-block;
            font-weight: 500;
            margin-top: 30px;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            padding: 10px 24px;
            display: inline-block;
            border-radius: 50px;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" class="body" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
        <tr>
            <td>
                <table width="100%" border="0" class="table1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="tb2">
                                <tr>
                                    <td style="height: 30px"> </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 35px">
                                        <h2 class="h1"><strong>Time Tracking Tool</strong></h2></strong>
                                        <p class="p1" style="margin-top: 20px;"><strong>Hello
                                                ' . $project_manager_name . ',</strong><br> A new project has been created. Here
                                            are the project details:
                                        </p>
                                        <span class="s1"></span>
                                        <p class="p2">
                                            <strong class="st1">Project Name</strong><strong>' . $project_name . '</strong>
                                            <strong class="st2">Start Date</strong><strong>' . $formatted_date . '</strong>
                                            <strong class="st2">Client Name</strong><strong>' . $client_name . '</strong>
                                            <strong class="st2">Employees
                                                Assigned</strong><strong>' . $employees_assigned . '</strong>
                                        </p>

                                        <a href="http://localhost/timetracking/your-projects/" class="logo"
                                            style="color:white;">
                                            View Project
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 40px"> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <p class="p3">© <strong> 2024 Time Tracking Tool
                                </strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>';

        // Headers
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        // Send the email
        wp_mail($project_manager_email, $subject, $message, $headers);

        error_log('Email sent to project manager.');
    }


    // Debugging: Print values for debugging
    error_log('Project Manager ID: ' . $project_manager_id);
    error_log('Old Project Manager ID: ' . $old_project_manager_id);
    error_log('Selected Employee IDs: ' . print_r($selected_employee_ids, true));


    foreach ($selected_employee_ids as $employee_id) {
        $employee_data = get_userdata($employee_id);
        $employee_name = $employee_data->first_name . ' ' . $employee_data->last_name;
        $employee_email = $employee_data->user_email;
        $project_manager_name = get_names_from_id($project_manager_id);

        $employee_subject = 'Hello ' . $employee_name . ', New Project Assignment: ' . $project_name;
        $employee_message = '
<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>New Account Email Template</title>
    <meta name="description" content="New Account Email Template." />
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }

        .body {
            margin: 0px;
            background-color: #f2f3f8;
        }

        .table1 {
            background-color: #f2f3f8;
            max-width: 670px;
            margin: 0 auto;
        }

        body {
            @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700);
            font-family: "Open Sans", sans-serif;
        }

        .tb2 {
            max-width: 670px;
            background: #fff;
            border-radius: 3px;
            text-align: center;
            -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
            box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
        }

        .h1 {
            color: #3ba1da;
            font-weight: 500;
            margin: 0;
            font-size: 30px;
            font-family: "Rubik", sans-serif;
        }

        .p1 {
            font-size: 15px;
            color: #455056;
            margin: 8px 0 0;
            line-height: 24px;
        }

        .p2 {
            color: #455056;
            font-size: 18px;
            line-height: 20px;
            margin: 0;
            font-weight: 500;
        }

        .p3 {
            font-size: 14px;
            color: rgba(69, 80, 86, 0.7411764705882353);
            line-height: 18px;
            margin: 0 0 0;
        }

        .s1 {
            display: inline-block;
            vertical-align: middle;
            margin: 29px 0 26px;
            border-bottom: 1px solid #cecece;
            width: 100px;
        }

        .st1 {
            display: block;
            font-size: 13px;
            margin: 0 0 4px;
            color: rgba(0, 0, 0, 0.64);
            font-weight: normal;
        }

        .st2 {
            display: block;
            font-size: 13px;
            margin: 24px 0 4px 0;
            font-weight: normal;
            color: rgba(0, 0, 0, 0.64);
        }

        .logo {
            background: #3ba1da;
            background: linear-gradient(90deg, #3ba1da 35%, #3ba1da 100%);
            text-decoration: none !important;
            display: inline-block;
            font-weight: 500;
            margin-top: 30px;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            padding: 10px 24px;
            display: inline-block;
            border-radius: 50px;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" class="body" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
        <tr>
            <td>
                <table width="100%" border="0" class="table1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="tb2">
                                <tr>
                                    <td style="height: 30px"> </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 35px">
                                        <h2 class="h1"><strong>Time Tracking Tool</strong></h2></strong>
                                        <p class="p1" style="margin-top: 20px;"><strong>Hello
                                                ' . $employee_name . ',</strong><br> You have been assigned to a new
                                            project. Here
                                            are the project details:
                                        </p>
                                        <span class="s1"></span>
                                        <p class="p2">
                                            <strong class="st1">Project Name</strong><strong>' . $project_name . '</strong>
                                            <strong class="st2">Start Date</strong><strong>' . $formatted_date . '</strong>
                                            <strong class="st2">Client Name</strong><strong>' . $client_name . '</strong>
                                            <strong class="st2">Your Manager</strong><strong>' . $project_manager_name . '</strong>
                                        </p>

                                        <a href="https://localhost/timetracking/your-projects/" class="logo"
                                            style="color:white;">
                                            View Project
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 40px"> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 20px"> </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <p class="p3">© <strong>2024 Time Tracking Tool
                                </strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 80px"> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>';
        // Headers
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        wp_mail($employee_email, $employee_subject, $employee_message, $headers);
        error_log('Email sent to employee ' . $employee_id);
    }

    // Display a success message or handle errors as needed
    if ($wpdb->last_error) {
        echo '<script>alert("Error updating project. Please try again.");</script>';
        error_log('Error updating project: ' . $wpdb->last_error);
    } else {

        echo '<script>
            alert("Project updated successfully!");
            window.location.href = "https://localhost/timetracking/your-projects/";
          </script>';
        error_log('Project updated successfully!');

        exit; // Important: Ensure that you call exit() after wp_redirect() to stop further execution
    }
}


// Function to get first and last names from user ID
function get_names_from_id($user_id)
{
    $user = get_userdata($user_id);
    if ($user) {
        $first_name = $user->first_name;
        $last_name = $user->last_name;
        // Concatenate first name and last name
        $full_name = trim("{$first_name} {$last_name}");
        return $full_name;
    }
    return '';
}




function get_employee_name_by_id_callback()
{
    if (isset($_POST['employee_id'])) {
        $employee_id = intval($_POST['employee_id']);
        $employee_name = get_employee_name_by_id($employee_id);
        wp_send_json_success($employee_name);
    } else {
        wp_send_json_error('Invalid request');
    }
}




// function redirect_to_login_page()
// {
//     // Check if the user is not logged in and not on the login or forgot password page
//     if (!is_user_logged_in() && !is_page(array('login', 'password-reset'))) {
//         wp_redirect('/login/'); // Redirect to the login page
//         exit;
//     }
// }
// add_action('template_redirect', 'redirect_to_login_page');


$is_project_manager = current_user_can('project_manager');


/// Shortcode to display project details and logged hours
function project_details_and_logged_hours_shortcode()
{
    global $wpdb, $current_user;

    // Get current user ID
    $current_user_id = $current_user->ID;
    // 	echo $current_user_id;
    // Check if the current user has the "project_manager" capability
    $is_project_manager = current_user_can('project_manager');

    if (!$is_project_manager) {
        return 'You do not have permission to view this content.';
    }

    // Output variable
    $output = '';

    // Query to fetch projects where the current user is the project manager
    $projects_query = $wpdb->prepare(
        "SELECT project_id, project_name, project_manager_id, action
        FROM wp_projects 
        WHERE project_manager_id = %d",
        $current_user_id
    );
    $projects = $wpdb->get_results($projects_query);
    // 	print_r ($projects);
    if (empty($projects)) {
        return 'You are not assigned as a project manager for any projects.';
    }

    // Start the flex container
    $output .= '<div class="d-flex flex-wrap">';

    foreach ($projects as $project) {
        // Check if the project is bookmarked
        $bookmark_status = ($project->action == 1) ? 'block' : 'none';

        // Query to calculate total hours worked for the project
        $total_hours_project_query = $wpdb->prepare(
            "SELECT COALESCE(SUM(hours_worked), 0) AS total_hours
            FROM {$wpdb->prefix}timesheets
            WHERE project_id = %d",
            $project->project_id
        );
        $total_hours_project = $wpdb->get_var($total_hours_project_query);

        // Query to calculate total hours worked by the project manager for the project
        $total_hours_project_manager_query = $wpdb->prepare(
            "SELECT COALESCE(SUM(hours_worked), 0) AS total_hours
            FROM {$wpdb->prefix}timesheets
            WHERE project_id = %d
            AND employee_id = %d",
            $project->project_id,
            $current_user_id
        );
        $total_hours_project_manager = $wpdb->get_var($total_hours_project_manager_query);

        // Query to fetch logged hours for the specific project in the current month
        $logged_hours_query = $wpdb->prepare(
            "SELECT COALESCE(SUM(hours_worked), 0) AS logged_hours
            FROM {$wpdb->prefix}timesheets
            WHERE project_id = %d
            AND MONTH(date) = MONTH(CURRENT_DATE())
            AND YEAR(date) = YEAR(CURRENT_DATE())",
            $project->project_id
        );
        $logged_hours_month = $wpdb->get_var($logged_hours_query);

        // Query to fetch logged hours for the specific project in the current week
        $logged_hours_week_query = $wpdb->prepare(
            "SELECT COALESCE(SUM(hours_worked), 0) AS logged_hours
            FROM {$wpdb->prefix}timesheets
            WHERE project_id = %d
            AND YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)",
            $project->project_id
        );
        $logged_hours_week = $wpdb->get_var($logged_hours_week_query);

        // Display project details and working hours using Flexbox and Bootstrap card
        $output .= '<div class="card m-2 border shadow" style="width: 300px; display: ' . $bookmark_status . ';" data-project-id="' . $project->project_id . '">';
        $output .= '<div class="card-header  d-flex justify-content-between text-white" style="background:#4d4d4d;">';
        $output .= '<h5 class="card-title d-flex justify-content-between mb-1 mt-1 text-white">' . esc_html($project->project_name) . '</h5>';
        $output .= '<small><a href="javascript:void(0);" class="btn bookmark-button" data-project-id="' . esc_attr($project->project_id) . '" onclick="toggleProjectDetailsCard(this)"><i class="fa-solid fa-bookmark text-white fa-xl"></i></a></small>';
        $output .= '</div>';
        $output .= '<div class="card-body">';
        $output .= '<p class="card-text mb-1 h6">Total Hrs: ' . esc_html($total_hours_project) . ' </p>';
        $output .= '<p class="card-text mb-1 h6">Manager Hrs: ' . esc_html($total_hours_project_manager) . ' </p>';
        $output .= '<p class="card-text mb-1 h6">This Month Hrs: ' . esc_html($logged_hours_month) . '</p>';
        $output .= '<p class="card-text mb-1 h6">This Week Hrs: ' . esc_html($logged_hours_week) . '</p>';
        // $output .= '<small><a href="javascript:void(0);" class="btn bookmark-button" data-project-id="' . esc_attr($project->project_id) . '" onclick="toggleProjectDetailsCard(this)"><i class="fa-solid fa-bookmark fa-xl"></i></a></small>';
        $output .= '</div>';
        $output .= '</div>';

    }
    // End the flex container
    $output .= '</div>';

    return $output;
}

// Register the shortcode
add_shortcode('project_details_and_logged_hours_shortcode', 'project_details_and_logged_hours_shortcode');
// AJAX handler to update the "action" value
function update_project_action_callback()
{
    global $wpdb;

    $project_id = $_POST['project_id'];

    // Check if the project is currently bookmarked
    $current_action = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT action FROM {$wpdb->prefix}projects WHERE project_id = %d",
            $project_id
        )
    );

    // Toggle the "action" value
    $new_action = ($current_action == 1) ? 0 : 1;

    // Update the "action" value in the database
    $wpdb->update(
        $wpdb->prefix . 'projects',
        array('action' => $new_action),
        array('project_id' => $project_id)
    );

    // Return the updated "action" value
    echo $new_action;

    // Always exit to avoid extra output
    wp_die();
}
add_action('wp_ajax_update_project_action', 'update_project_action_callback');
add_action('wp_ajax_nopriv_update_project_action', 'update_project_action_callback');

// Shortcode to display the custom projects table
function custom_project_manager_table_shortcode()
{
    global $wpdb, $current_user;

    // Get the current user's roles
    $user_roles = $current_user->roles;

    // Check user role and modify the query accordingly
    if (in_array('administrator', $user_roles)) {
        // Administrator can see all projects
        $projects_query = "SELECT * FROM {$wpdb->prefix}projects";
    } elseif (in_array('project_manager', $user_roles)) {
        // Project manager can see projects assigned to them
        $current_manager_id = $current_user->ID;
        $projects_query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}projects WHERE project_manager_id = %d", $current_manager_id);
    } elseif (in_array('employee', $user_roles)) {
        // Employee can see projects assigned to them
        $current_employee_id = $current_user->ID;
        $projects_query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}projects WHERE FIND_IN_SET(%d, employees_assigned) > 0", $current_employee_id);
    } else {
        // Other roles (if any) can see an empty list or handle it as needed
        $projects_query = "";
    }

    // Fetch projects
    $projects = $wpdb->get_results($projects_query, ARRAY_A);

    // Table header
    $table_content = '
    <table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>From date:</td>
            <td><input type="text" id="min2" name="min"></td>
        </tr>
        <tr>
            <td>To date:</td>
            <td><input type="text" id="max2" name="max"></td>
        </tr>
    </tbody></table>
	<div class="table-responsive">
    <table id="projects_table" style="width:100%">
        <thead>
            <tr>
                <th class="no-wrapper">Project Name</th>
                <th class="no-wrapper">Start Date</th>
                <th class="no-wrapper">Completion Date</th>
                <th class="no-wrapper">Client Name</th>
                <th class="no-wrapper">Employees Assigned</th>
                <th class="no-wrapper">Status</th>
              
                <th class="no-wrapper">Action</th>';  // Added "Action" column header

    $table_content .= '</tr>
        </thead>
        <tbody>';

    // Loop through the projects and generate table rows
    foreach ($projects as $project) {
        // Retrieve user name based on project manager ID
        $project_manager_id = $project['project_manager_id'];
        $project_manager_name = get_user_by('id', $project_manager_id)->display_name;

        // Retrieve user names based on employees_assigned IDs
        $employees_assigned_ids = explode(',', $project['employees_assigned']);
        $employees_assigned_names = array();
        foreach ($employees_assigned_ids as $employee_id) {
            $user_info = get_user_by('id', $employee_id);
            if ($user_info) {
                $employees_assigned_names[] = $user_info->first_name . ' ' . $user_info->last_name;
            }
        }

        $form_id = 'edit_form_' . $project['project_id'];

        $table_content .= "
                <tr>
                    <td class=\"project-name\" data-project-id=\"" . esc_attr($project['project_id']) . "\">
                        <form method=\"post\" action=\"" . esc_url(home_url('/single/')) . "\">
                            <input type=\"hidden\" name=\"project_id\" value=\"" . esc_attr($project['project_id']) . "\">
                            <button type=\"submit\" style=\"background:none; border:none; padding:0; margin:0; font-size:inherit; cursor:pointer; color:black;\">
                                " . esc_html($project['project_name']) . "
                            </button>
                        </form>
                    </td>

                    <td>" . (!empty($project['start_date']) && $project['start_date'] != '0000-00-00' ? esc_html(date('d/m/Y', strtotime($project['start_date']))) : '') . "</td>
                    <td>" . (!empty($project['completion_date']) && $project['completion_date'] != '0000-00-00' ? esc_html(date('d/m/Y', strtotime($project['completion_date']))) : '') . "</td>
                    <td>" . esc_html($project['client_name']) . "</td>
                    <td>" . implode(', ', $employees_assigned_names) . "</td>
                    <td>" . esc_html($project['status']) . "</td>
                    <td class=\"buttons\">
                        <a href=\"javascript:void(0);\" class=\"btn  bookmark-button\" data-project-id=\"" . esc_attr($project['project_id']) . "\" onclick=\"toggleProjectDetailsCard(this)\"><i class=\"fa-solid fa-bookmark fa-xl\"></i></a>
                    </td>
                </tr>";

    }

    $table_content .= '</tbody></table></div>';

    $table_content .= '<script>
        var ajaxurl = "' . esc_url(admin_url('admin-ajax.php')) . '";
     </script>';

    $table_content .= '<div id="employee-details-container"></div>';

    return $table_content;
}

// Register the shortcode
add_shortcode('custom_project_manager_table', 'custom_project_manager_table_shortcode');


// Shortcode naming consistency
add_shortcode('employee_dashboard', 'project_details_and_logged_hours_employee');
add_shortcode('custom_employee_table', 'custom_employee_table_shortcode');

function project_details_and_logged_hours_employee()
{
    global $wpdb, $current_user;

    $current_user_id = $current_user->ID;
    $output = '';
    // 	echo  $current_user_id;
    $projects_query = $wpdb->prepare(
        "SELECT project_id, project_name, employee_bookmark
    FROM {$wpdb->prefix}projects
    WHERE project_id IN (
        SELECT DISTINCT project_id FROM {$wpdb->prefix}timesheets
        WHERE employee_id = %d
    )",
        $current_user_id
    );


    $projects = $wpdb->get_results($projects_query);
    // 	print_r ($projects);
    $output .= '<div class="d-flex flex-wrap">';

    foreach ($projects as $project) {
        // Fetch the employee_bookmark column value
        $bookmark_status_query = $wpdb->prepare(
            "SELECT employee_bookmark
        FROM {$wpdb->prefix}projects
        WHERE project_id = %d",
            $project->project_id
        );
        $bookmark_status = $wpdb->get_var($bookmark_status_query);

        // Check if the current user ID is in the list of bookmarks
        $bookmark_array = explode(',', $bookmark_status);
        $user_index = array_search($current_user_id, $bookmark_array);

        // Adjust the bookmark status based on user presence in the list
        $bookmark_status = ($user_index !== false) ? 'block' : 'none';

        $total_hours_project_query = $wpdb->prepare(
            "SELECT COALESCE(SUM(hours_worked), 0) AS total_hours
            FROM {$wpdb->prefix}timesheets
            WHERE project_id = %d
            AND employee_id = %d",
            $project->project_id,
            $current_user_id
        );
        $total_hours_project = $wpdb->get_var($total_hours_project_query);

        $logged_hours_query = $wpdb->prepare(
            "SELECT COALESCE(SUM(hours_worked), 0) AS logged_hours
            FROM {$wpdb->prefix}timesheets
            WHERE project_id = %d
            AND employee_id = %d
            AND MONTH(date) = MONTH(CURRENT_DATE())
            AND YEAR(date) = YEAR(CURRENT_DATE())",
            $project->project_id,
            $current_user_id
        );
        $logged_hours_month = $wpdb->get_var($logged_hours_query);

        $logged_hours_week_query = $wpdb->prepare(
            "SELECT COALESCE(SUM(hours_worked), 0) AS logged_hours
            FROM {$wpdb->prefix}timesheets
            WHERE project_id = %d
            AND employee_id = %d
            AND YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)",
            $project->project_id,
            $current_user_id
        );
        $logged_hours_week = $wpdb->get_var($logged_hours_week_query);

        $output .= '<div class="employee-card m-2 border rounded shadow" style="width: 300px; line-height:2rem; display: ' . $bookmark_status . ';" data-project-id="' . $project->project_id . '">';
        $output .= '<div class="card-header text-white" style="background:#4d4d4d;">';
        $output .= '<h5 class="card-title d-flex justify-content-between align-items-center text-white" id="employee_title">';
        $output .= esc_html($project->project_name);
        $output .= '<small><a href="javascript:void(0);" class="btn bookmark-button ml-2" data-project-id="' . esc_attr($project->project_id) . '" onclick="toggleEmployeeCardDetails(this)"><i class="fa-solid fa-bookmark  text-white fa-xl"></i></a></small>';
        $output .= '</h5>';
        $output .= '</div>';
        $output .= '<div class="card-body">';
        $output .= '<p class="card-text mb-1 p-2 h6"> Total Hrs: ' . esc_html($total_hours_project) . ' </p>';
        $output .= '<p class="card-text mb-1 p-2 h6"> This Month Hrs: ' . esc_html($logged_hours_month) . '</p>';
        $output .= '<p class="card-text mb-1  p-2 h6"> This Week Hrs: ' . esc_html($logged_hours_week) . '</p>';
        $output .= '</div>';
        $output .= '</div>';

    }

    $output .= '</div>';

    return $output;
}

// AJAX handler to update the "action" value for an employee
// AJAX handler to update the "action" value for an employee
function update_employee_action_callback()
{
    global $wpdb, $current_user;

    $project_id = $_POST['project_id'];
    $current_user_id = $current_user->ID;

    try {
        // Check if the project is currently bookmarked
        $current_bookmarks = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT employee_bookmark FROM {$wpdb->prefix}projects WHERE project_id = %d",
                $project_id
            )
        );

        // Convert the comma-separated list to an array
        $bookmark_array = explode(',', $current_bookmarks);

        // Check if the current user ID is already in the array
        $user_index = array_search($current_user_id, $bookmark_array);

        if ($user_index === false) {
            // User not found, add the current user ID to the array
            $bookmark_array[] = $current_user_id;
        } else {
            // User found, remove the current user ID from the array
            unset($bookmark_array[$user_index]);
        }

        // Convert the array back to a comma-separated list
        $new_bookmarks = implode(',', array_filter($bookmark_array));

        // Update the "employee_bookmark" value in the database
        $wpdb->update(
            $wpdb->prefix . 'projects',
            array('employee_bookmark' => $new_bookmarks),
            array('project_id' => $project_id)
        );

        // Return the updated "employee_bookmark" value
        echo $new_bookmarks;
    } catch (Exception $e) {
        // Return a special value (-1) to indicate an error
        echo '-1';
    }
    // Always exit to avoid extra output
    wp_die();
}
add_action('wp_ajax_update_employee_action', 'update_employee_action_callback');
add_action('wp_ajax_nopriv_update_employee_action', 'update_employee_action_callback');






function custom_employee_table_shortcode()
{
    global $wpdb, $current_user;

    $current_user_id = $current_user->ID;

    $projects_query = $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}projects WHERE FIND_IN_SET(%d, employees_assigned) > 0",
        $current_user_id
    );
    $projects = $wpdb->get_results($projects_query, ARRAY_A);

    $table_content = '
    <table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>From date:</td>
            <td><input type="text" id="min2" name="min"></td>
        </tr>
        <tr>
            <td>To date:</td>
            <td><input type="text" id="max2" name="max"></td>
        </tr>
    </tbody></table>
	<div class="table-responsive">
    <table id="projects_table" style="width:100%">
        <thead>
            <tr>
                <th class="no-wrapper">Project Name</th>
                <th class="no-wrapper">Start Date</th>
                <th class="no-wrapper">Completion Date</th>
                <th class="no-wrapper">Project Manager</th>
                <th class="no-wrapper">Employees Assigned</th>
                <th class="no-wrapper">Status</th>
                <th class="no-wrapper">Action</th>';
    $table_content .= '</tr>
        </thead>
        <tbody>';

    foreach ($projects as $project) {
        $project_manager_id = $project['project_manager_id'];
        $project_manager_user = get_user_by('id', $project_manager_id);

        // Retrieve first name and last name from user meta and combine them
        $project_manager_name = $project_manager_user?->first_name . ' ' . $project_manager_user?->last_name;

        // Display the full name (or a default value if the manager user is not found)
// echo esc_html($project_manager_name ?? 'Manager Not Found');


        $employees_assigned_ids = explode(',', $project['employees_assigned']);
        $employees_assigned_names = array();
        foreach ($employees_assigned_ids as $employee_id) {
            $user_info = get_user_by('id', $employee_id);
            if ($user_info) {
                $employees_assigned_names[] = $user_info->first_name . ' ' . $user_info->last_name;
            }
        }

        $form_id = 'edit_form_' . $project['project_id'];

        $table_content .= "
    <tr>
        <td class=\"project-name\" data-project-id=\"" . esc_attr($project['project_id']) . "\">
                        <form method=\"post\" action=\"" . esc_url(home_url('/single/')) . "\">
                            <input type=\"hidden\" name=\"project_id\" value=\"" . esc_attr($project['project_id']) . "\">
                            <button type=\"submit\" style=\"background:none; border:none; padding:0; margin:0; font-size:inherit; cursor:pointer; color:black;\">
                                " . esc_html($project['project_name']) . "
                            </button>
                        </form>
        </td>
          <td>" . (!empty($project['start_date']) && $project['start_date'] != '0000-00-00' ? esc_html(date('d/m/Y', strtotime($project['start_date']))) : '') . "</td>
        <td>" . (!empty($project['completion_date']) && $project['completion_date'] != '0000-00-00' ? esc_html(date('d/m/Y', strtotime($project['completion_date']))) : '') . "</td>
        <td>" . esc_html($project_manager_name) . "</td>
        <td>" . implode(', ', $employees_assigned_names) . "</td>
        <td>" . esc_html($project['status']) . "</td>
        <td class=\"buttons\">
            <a href=\"javascript:void(0);\" class=\"btn bookmark-button\" data-project-id=\"" . esc_attr($project['project_id']) . "\" onclick=\"toggleEmployeeCardDetails(this)\"><i class=\"fa-solid fa-bookmark fa-xl\"></i></a>
        </td></tr>";
    }

    $table_content .= '</tbody></table></div>';

    $table_content .= '<script>
        var ajaxurl = "' . esc_url(admin_url('admin-ajax.php')) . '";
     </script>';

    $table_content .= '<div id="employee-details-container"></div>';

    return $table_content;
}









// Redirect users based on their role after login
function custom_role_redirect($user_login, $user)
{
    // Is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        // Check for admins
        if (in_array('administrator', $user->roles)) {
            // Redirect admins to the admin dashboard
            wp_redirect(home_url('/timesheet_entry'));
            exit();
        } elseif (in_array('project_manager', $user->roles)) {
            // Redirect project managers to a specific page
            wp_redirect(home_url('/manager-dashboard'));
            exit();
        } elseif (in_array('employee', $user->roles)) {
            // Redirect employees to another page
            wp_redirect(home_url('/employee-dashboard'));
            exit();
        }
    }
}

add_action('wp_login', 'custom_role_redirect', 10, 2);


// Function to modify page title based on user role
function custom_modify_page_title($title, $id = null)
{
    // Check if the user is logged in
    if (is_user_logged_in()) {
        $user = wp_get_current_user();

        // Modify page title based on user role and page slug
        if (in_array('employee', $user->roles)) {
            // If the user is an employee, modify the page title
            $employee_dashboard_page = get_page_by_path('timesheet_entry');
            if ($employee_dashboard_page && $id === $employee_dashboard_page->ID) {
                $title = 'Your Timesheet';
            }
        }
    }

    return $title;
}
add_filter('the_title', 'custom_modify_page_title', 10, 2);



// Function to modify page title based on user role
function custom_modify_page_title_project($title, $id = null)
{
    // Check if the user is logged in
    if (is_user_logged_in()) {
        $user = wp_get_current_user();

        // Modify page title based on user role and page slug
        if (in_array('administrator', $user->roles)) {
            // If the user is an employee, modify the page title
            $employee_dashboard_page = get_page_by_path('your-projects');
            if ($employee_dashboard_page && $id === $employee_dashboard_page->ID) {
                $title = 'All Projects';
            }
        }
    }

    return $title;
}
add_filter('the_title', 'custom_modify_page_title_project', 10, 2);




/*  Site name/logo
/* ------------------------------------ */
if (!function_exists('inunity_site_title')) {

    function inunity_site_title()
    {

        $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

        // Text or image?
        if (has_custom_logo()) {
            $logo = '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
            ;
        } else {
            $logo = esc_html(get_bloginfo('name'));
        }

        $link = $logo;

        if (is_front_page() || is_home()) {
            $sitename = '<h1 class="site-title">' . $link . '</h1>' . "\n";
        } else {
            $sitename = '<p class="site-title">' . $link . '</p>' . "\n";
        }

        return $sitename;
    }

}







// Project based timesheet entries-------------------------------------------------------------------------------------------------------------------------------------------

function get_project_id_shortcode()
{
    // Check if the form has been submitted and the project ID is available
    if (isset($_POST['project_id'])) {
        global $wpdb;

        $project_id = intval($_POST['project_id']); // Sanitize the project ID as an integer

        // Query the wp_projects table to get the project name based on the project ID
        $project_name = $wpdb->get_var(
            $wpdb->prepare("SELECT project_name FROM {$wpdb->prefix}projects WHERE project_id = %d", $project_id)
        );

        // If project name is not found, use a default message
        if (!$project_name) {
            $project_name = 'Unknown Project';
        }

        // Return the project ID and project name
        return "<h3>" . $project_name . " - Timesheets</h3>";
    } else {
        return 'Project ID not found'; // Return a message if the project ID is not available
    }
}
add_shortcode('get_project_id', 'get_project_id_shortcode');





function display_single_project_timesheets_shortcode()
{
    global $wpdb;

    $current_user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $is_admin = in_array('administrator', $current_user->roles);
    $is_project_manager = in_array('project_manager', $current_user->roles);

    // Initialize project ID variable
    $selected_project_id = '';

    // Check if the form has been submitted with a project ID
    if (isset($_POST['project_id'])) {
        $selected_project_id = intval($_POST['project_id']);
    }

    // Query to fetch timesheet data based on user role
    if ($is_admin) {
        // For admin, display all timesheets related to the selected project
        $timesheets_query = "
            SELECT wp_timesheets.*,
            CASE
                WHEN user_roles.meta_value LIKE '%project_manager%' THEN 'Project Manager'
                WHEN user_roles.meta_value LIKE '%employee%' THEN 'Employee'
                ELSE 'Unknown'
            END as user_role
            FROM wp_timesheets
            LEFT JOIN wp_usermeta as user_roles ON wp_timesheets.employee_id = user_roles.user_id
            WHERE user_roles.meta_key = 'wp_capabilities'
            AND wp_timesheets.project_id = $selected_project_id
            ORDER BY wp_timesheets.date DESC
        ";
    } elseif ($is_project_manager) {
        // For project managers, display their own timesheets for the selected project
        $timesheets_query = "
            SELECT wp_timesheets.*,
            CASE
                WHEN user_roles.meta_value LIKE '%project_manager%' THEN 'Project Manager'
                WHEN user_roles.meta_value LIKE '%employee%' THEN 'Employee'
                ELSE 'Unknown'
            END as user_role
            FROM wp_timesheets
            LEFT JOIN wp_usermeta as user_roles ON wp_timesheets.employee_id = user_roles.user_id
            WHERE user_roles.meta_key = 'wp_capabilities'
            AND wp_timesheets.project_id = $selected_project_id
            AND wp_timesheets.employee_id = $current_user_id
            ORDER BY wp_timesheets.date DESC
        ";
    } else {
        // For regular employees, display their own timesheets for the selected project
        $timesheets_query = "
            SELECT *
            FROM wp_timesheets
            WHERE project_id = $selected_project_id
            AND employee_id = $current_user_id
            ORDER BY date DESC
        ";
    }

    // Execute the query
    $timesheets = $wpdb->get_results($timesheets_query);

    // Display the timesheet data in a table
    ob_start();
    ?>
    <div class="table-responsive">
        <table border="0" cellspacing="5" cellpadding="5">
            <tbody>
                <tr>
                    <td>From date:</td>
                    <td><input type="text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>To date:</td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>
                <tr>
                    <td>Filter by Date Range:</td>
                    <td>
                        <select id="date-filter" name="date-filter">
                            <option value="0">All</option>
                            <option value="7">Past 7 Days</option>
                            <option value="30">Past 30 Days</option>
                            <option value="60">Past 60 Days</option>
                            <option value="90">Past 90 Days</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <table id="timesheets-table" class="wp-timesheets-table">
            <!-- Table header -->
            <thead>
                <tr>
                    <?php if ($is_admin): ?>
                        <th class="no-wrapper">Employee Name</th>
                    <?php endif; ?>
                    <?php if ($is_admin): ?>
                        <th>User Role</th>
                    <?php endif; ?>
                    <th class="no-wrapper">Project</th>
                    <th class="no-wrapper">Task Type</th>
                    <th class="no-wrapper">Task Description</th>
                    <th class="no-wrapper">Date</th>
                    <th class="no-wrapper">Actual time (in hrs.)</th>
                    <th class="no-wrapper">Status</th>
                    <th class="no-wrapper">Comments</th>
                    <th class="no-wrapper">Actions</th>
                </tr>
            </thead>
            <!-- Table body -->
            <tbody>
                <?php foreach ($timesheets as $timesheet): ?>
                    <tr>
                        <?php if ($is_admin): ?>
                            <?php
                            // Get user information
                            $user = get_user_by('ID', $timesheet->employee_id);
                            $full_name = $user->first_name . ' ' . $user->last_name;
                            ?>
                            <td>
                                <?php echo esc_html($full_name); ?>
                            </td>
                        <?php endif; ?>
                        <?php if ($is_admin): ?>
                            <td>
                                <?php echo esc_html($timesheet->user_role); ?>
                            </td>
                        <?php endif; ?>
                        <td>
                            <?php echo esc_html(get_project_name($timesheet->project_id)); ?>
                        </td>
                        <td>
                            <?php echo esc_html(get_term($timesheet->task, 'task_type')->name); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->description); ?>
                        </td>
                        <td>
                            <?php echo esc_html(date('d/m/Y', strtotime($timesheet->date))); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->hours_worked); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->status); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->comment); ?>
                        </td>
                        <td class="buttons">
                            <form id="update-timesheet-<?php echo $timesheet->id; ?>" method="post"
                                action="<?php echo esc_url(home_url('/update_timesheet')); ?>">
                                <input type="hidden" name="timesheet_id1" value="<?php echo $timesheet->id; ?>">
                            </form>
                            <a class="btn btn-primary text-white edit-timesheet-button"
                                onclick="submitForm('update-timesheet-<?php echo $timesheet->id; ?>')">
                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </a>
                            <a class="btn btn-danger text-white delete-timesheet"
                                data-timesheet-id="<?php echo $timesheet->id; ?>">
                                <i class="fa-solid fa-trash fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('display_single_project_timesheets', 'display_single_project_timesheets_shortcode');






// display archive timesheets

function display_archive_timesheets_shortcode()
{
        // Define role mappings
    $role_mappings = array(
        'administrator' => 'Administrator',
        'project_manager' => 'Project Manager',
        'employee' => 'Employee',
        // Add more role mappings if needed
    );

    global $wpdb;

    $current_user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $is_admin = in_array('administrator', $current_user->roles);
    $is_project_manager = in_array('project_manager', $current_user->roles);


    // Query to fetch timesheet data based on user role
    if ($is_admin) {

        $timesheets_query = "SELECT * FROM wp_archive_timesheets ORDER BY date DESC";

    } elseif ($is_project_manager) {

        $timesheets_query = "SELECT * FROM wp_archive_timesheets WHERE employee_id = $current_user_id ORDER BY date DESC";

    } else {

        $timesheets_query = "SELECT * FROM wp_archive_timesheets WHERE employee_id = $current_user_id ORDER BY date DESC";
    }

    // Execute the query
    $timesheets = $wpdb->get_results($timesheets_query);

    // Display the timesheet data in a table
    ob_start();
    ?>

    <div class="table-responsive">
        <table border="0" cellspacing="5" cellpadding="5">
            <tbody>
                <tr>
                    <td>From date:</td>
                    <td><input type="text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>To date:</td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>
                <tr>
                    <td>Filter by Date Range:</td>
                    <td><select id="date-filter" name="date-filter">
                            <option value="0">All</option>
                            <option value="7">Past 7 Days</option>
                            <option value="30">Past 30 Days</option>
                            <option value="60">Past 60 Days</option>
                            <option value="90">Past 90 Days</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <table id="timesheets-table" class="wp-timesheets-table ">
            <thead>
                <tr>

                    <?php if ($is_admin): ?>
                        <th class="no-wrapper">Employee Name</th>
                    <?php endif; ?>
                    <?php if ($is_admin): ?>
                        <th>User Role</th>
                    <?php endif; ?>
                    <th class="no-wrapper">Project</th>
                    <th class="no-wrapper">Task Type</th>
                    <!--                     <th class="no-wrapper">Location</th> -->
                    <th class="no-wrapper">Task Description</th>
                    <th class="no-wrapper">Date</th>
                    <th class="no-wrapper">Actual time(in hrs.)</th>
                    <th class="no-wrapper">Status</th>
                    <th class="no-wrapper">Comments</th>
                        <th class="no-wrapper">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timesheets as $timesheet): ?>
                    <tr>
                        <?php if ($is_admin): ?>
                            <?php
                            $user = get_user_by('ID', $timesheet->employee_id);
                            $full_name = $user->first_name . ' ' . $user->last_name;
                            ?>
                            <td>
                                <?php echo esc_html($full_name); ?>
                            </td>
                        <?php endif; ?>
                        <?php if ($is_admin): ?>
                            <td>
                                            <?php
                                $user_roles = $user ? $user->roles : array();
                                $formatted_roles = array();
                                foreach ($user_roles as $role) {
                                    // Map role slug to formatted text
                                    if (isset($role_mappings[$role])) {
                                        $formatted_roles[] = $role_mappings[$role];
                                    }
                                }
                                echo !empty($formatted_roles) ? esc_html(implode(', ', $formatted_roles)) : 'N/A';
                                ?>
                            </td>
                        <?php endif; ?>
                        <td>
                            <?php echo esc_html(get_project_name($timesheet->project_id)); ?>
                        </td>
                        <td>
                            <?php echo get_term($timesheet->task, 'task_type')->name; ?>
                        </td>

                        <td>
                            <?php echo esc_html($timesheet->description); ?>
                        </td>
                        <td>
                            <?php echo esc_html(date('d/m/Y', strtotime($timesheet->date))); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->hours_worked); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->status); ?>
                        </td>
                        <td>
                            <?php echo esc_html($timesheet->comment); ?>
                        </td>
                            <td class="buttons">
                                <form id="update-timesheet-<?php echo $timesheet->id; ?>" method="post"
                                    action="http://localhost/timetracking/update_timesheet">
                                    <input type="hidden" name="timesheet_id1" value="<?php echo $timesheet->id; ?>">
                                    <input type="hidden" name="timesheet_type" value="archive">
                                </form>
                                <a class="btn btn-primary text-white edit-timesheet-button"
                                    onclick="submitForm('update-timesheet-<?php echo $timesheet->id; ?>')"><i
                                        class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                <a class="btn btn-danger text-white delete-timesheet"
                                    data-timesheet-id="<?php echo $timesheet->id; ?>" data-timesheet-type="wp_archive_timesheets"><i class="fa-solid fa-trash fa-lg"></i></a>
                            </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('display_archive_timesheets', 'display_archive_timesheets_shortcode');
?>