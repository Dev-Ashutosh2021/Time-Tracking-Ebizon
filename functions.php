<?php /*

  This file is part of a child theme called Inunity - Child Theme.
  Functions in this file will be loaded before the parent theme's functions.
  For more information, please read
  https://developer.wordpress.org/themes/advanced-topics/child-themes/

*/

// this code loads the parent's stylesheet (leave it in place unless you know what you're doing)

function your_theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, 
      get_template_directory_uri() . '/style.css'); 

    wp_enqueue_style( 'child-style', 
      get_stylesheet_directory_uri() . '/style.css', 
      array($parent_style), 
      wp_get_theme()->get('Version') 
    );
}

add_action('wp_enqueue_scripts', 'your_theme_enqueue_styles');

/*  Add your own functions below this line.
    ======================================== */ 

// Add fields to the "Add New User" form
function custom_user_fields($user) {
    ?>
    <h3><?php _e('Additional Information', 'textdomain'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="employee_code"><?php _e('Employee Code', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="employee_code" id="employee_code" value="<?php echo esc_attr(get_the_author_meta('employee_code', $user->ID)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="date_of_birth"><?php _e('Date of Birth', 'textdomain'); ?></label></th>
            <td>
                <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo esc_attr(get_the_author_meta('date_of_birth', $user->ID)); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="date_of_joining"><?php _e('Date of Joining', 'textdomain'); ?></label></th>
            <td>
                <input type="date" name="date_of_joining" id="date_of_joining" value="<?php echo esc_attr(get_the_author_meta('date_of_joining', $user->ID)); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="experience"><?php _e('Experience', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="experience" id="experience" value="<?php echo esc_attr(get_the_author_meta('experience', $user->ID)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="department"><?php _e('Department', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="department" id="department" value="<?php echo esc_attr(get_the_author_meta('department', $user->ID)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="position"><?php _e('Position', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="position" id="position" value="<?php echo esc_attr(get_the_author_meta('position', $user->ID)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="address"><?php _e('Address', 'textdomain'); ?></label></th>
            <td>
                <textarea name="address" id="address" class="regular-text"><?php echo esc_textarea(get_the_author_meta('address', $user->ID)); ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="phone_number"><?php _e('Phone Number', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="phone_number" id="phone_number" value="<?php echo esc_attr(get_the_author_meta('phone_number', $user->ID)); ?>" class="regular-text" />
            </td>
        </tr>
      
    </table>
    <?php
}
 



// Save custom fields when creating a new user
function save_custom_user_fields($user_id) {
    if (current_user_can('edit_user', $user_id)) {
        update_user_meta($user_id, 'employee_code', sanitize_text_field($_POST['employee_code']));
        update_user_meta($user_id, 'date_of_birth', sanitize_text_field($_POST['date_of_birth']));
        update_user_meta($user_id, 'date_of_joining', sanitize_text_field($_POST['date_of_joining']));
        update_user_meta($user_id, 'experience', sanitize_text_field($_POST['experience']));
        update_user_meta($user_id, 'department', sanitize_text_field($_POST['department']));
        update_user_meta($user_id, 'position', sanitize_text_field($_POST['position']));
        update_user_meta($user_id, 'address', sanitize_textarea_field($_POST['address']));
        update_user_meta($user_id, 'phone_number', sanitize_text_field($_POST['phone_number']));
    }
}
 
add_action('user_new_form', 'custom_user_fields');
add_action('user_register', 'save_custom_user_fields');




function custom_login_redirect($redirect_to, $request, $user) {
    // Check if the user is an administrator
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            // Redirect administrators to the dashboard
            return admin_url();
        } elseif (in_array('employee', $user->roles)) {
            // Redirect editors to a specific page
            return home_url('/');
        } elseif (in_array('project_manager', $user->roles)) {
            // Redirect subscribers to a different page
            return home_url('/');
        }
    }

    // For other roles or unauthenticated users, use the default redirect URL
    return $redirect_to;
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);




// Register Custom Post Type
function register_employee_post_type() {
    $labels = array(
        'name'                  => _x( 'Location', 'Post Type General Name', 'textdomain' ),
        'singular_name'         => _x( 'Location', 'Post Type Singular Name', 'textdomain' ),
        // Add other labels as needed
    );

    $args = array(
        'label'                 => __( 'Employee', 'textdomain' ),
        'labels'                => $labels,
        'public'                => true,
        'hierarchical'          => false,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        // Add other arguments as needed
    );

    register_post_type( 'employee', $args );
}
add_action( 'init', 'register_employee_post_type' );





// Register Custom Taxonomy
function register_location_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Locations', 'Taxonomy General Name', 'textdomain' ),
        'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'textdomain' ),
        // Add other labels as needed
    );

    $args = array(
        'labels'                     => $labels,
        'public'                     => true,
        'hierarchical'               => true,
        // Add other arguments as needed
    );

    register_taxonomy( 'location', array( 'employee' ), $args );
}
add_action( 'init', 'register_location_taxonomy' );




//location dropdown
function display_location_dropdown() {
    $terms = get_terms( array(
        'taxonomy' => 'location',
        'hide_empty' => false,
    ) );

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        echo '<select name="location_dropdown" id="location_dropdown">';
        echo '<option value="">Select Location</option>';
        
        foreach ( $terms as $term ) {
            echo '<option value="' . esc_attr( $term->term_id ) . '">' . esc_html( $term->name ) . '</option>';
        }

        echo '</select>';
    } else {
        echo '<p>No locations found</p>';
    }
}
// Add a shortcode for easy use in post/page content
add_shortcode( 'location_dropdown', 'display_location_dropdown' );

// Step 1: Create a Shortcode
function location_add_shortcode() {
    ob_start(); // Start output buffering

    // Output the form HTML
    ?>
<form method="post" style="max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <label for="new_location" style="display: block; margin-bottom: 10px; font-size: 16px; font-weight: bold;">New Location:</label>
    <input type="text" name="new_location" required placeholder="Add Location" style="width: 100%; padding: 10px; box-sizing: border-box; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 3px;">
    <input type="submit" value="Add Location" style="width: 100%; padding: 10px; cursor: pointer; background-color: #4CAF50; color: #fff; border: none; border-radius: 3px; font-size: 16px; font-weight: bold;">
</form>

    <?php

    return ob_get_clean(); // End and clean the buffer
}

// Step 2: Handle Form Submission
function handle_location_form_submission() {
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

function location_delete_shortcode() {
    ob_start(); // Start output buffering

    // Output the form HTML
    ?>
   <form method="post" style="max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <label for="delete_location" style="display: block; margin-bottom: 10px; font-size: 16px; font-weight: bold;">Select Location to Delete:</label>
    <select name="delete_location" style="width: 100%; padding: 10px; box-sizing: border-box; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 3px;">
        <option value="" disabled selected>Select Location</option> <!-- Default or placeholder option -->
        <?php
        $locations = get_terms('location', array('hide_empty' => false));
        foreach ($locations as $location) {
            echo '<option value="' . esc_attr($location->term_id) . '">' . esc_html($location->name) . '</option>';
        }
        ?>
    </select>
    <input type="submit" value="Delete Location" style="width: 100%; padding: 10px; cursor: pointer; background-color: #e74c3c; color: #fff; border: none; border-radius: 3px; font-size: 16px; font-weight: bold;">
</form>

    <?php

    return ob_get_clean(); // End and clean the buffer
}

// Step 3: Handle Form Submission for Deleting Locations
function handle_location_delete_form_submission() {
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
function display_locations_table_shortcode() {
    // Get all locations
    $locations = get_terms('location', array('hide_empty' => false));
    
    // Output the table HTML for displaying locations
    ob_start();
    ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <thead>
        <tr>
            <th style="border: 1px solid #ccc; padding: 10px; text-align: left;">Location Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($locations as $location) : ?>
            <tr>
                <td style="border: 1px solid #ccc; padding: 10px;"><?php echo esc_html($location->name); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    <?php
    return ob_get_clean(); // End and clean the buffer
}
// Add a shortcode for displaying locations in a table
add_shortcode( 'display_locations_table', 'display_locations_table_shortcode' );






// Register Project Taxonomy
function register_Project_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Project', 'Taxonomy General Name', 'textdomain' ),
        'singular_name'              => _x( 'Project', 'Taxonomy Singular Name', 'textdomain' ),
        // Add other labels as needed
    );

    $args = array(
        'labels'                     => $labels,
        'public'                     => true,
        'hierarchical'               => true,
        // Add other arguments as needed
    );

    register_taxonomy( 'Project', array( 'employee' ), $args );
}
add_action( 'init', 'register_Project_taxonomy' );

// Display Project Dropdown
function display_Project_dropdown() {
    $terms = get_terms( array(
        'taxonomy' => 'Project',
        'hide_empty' => false,
    ) );

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        echo '<select name="Project_dropdown" id="Project_dropdown">';
        echo '<option value="">Select Project</option>';
        
        foreach ( $terms as $term ) {
            echo '<option value="' . esc_attr( $term->term_id ) . '">' . esc_html( $term->name ) . '</option>';
        }

        echo '</select>';
    } else {
        echo '<p>No Project found</p>';
    }
}

// Add Shortcode for Project Dropdown
add_shortcode( 'Project_dropdown', 'display_Project_dropdown' );

// Add New Project Form Shortcode
function project_add_shortcode() {
    ob_start(); ?>

  <form id="project-add-form" method="post" style="max-width: 400px; margin: 20px auto; padding: 20px; background-color: #f5f5f5; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <label for="new_project" style="display: block; margin-bottom: 10px; font-weight: bold;">New Project:</label>
    <input type="text" name="new_project" required style="width: 100%; padding: 8px; margin-bottom: 15px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
    <input type="submit" value="Add Project" style="background-color: #4caf50; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">
</form>


    <?php
    return ob_get_clean();
}

// Handle Project Form Submission
function handle_project_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_project'])) {
        $new_project = sanitize_text_field($_POST['new_project']);

        // Check if the project already exists
        $existing_project = term_exists($new_project, 'Project');

        if ($existing_project === 0 || $existing_project === null) {
            // Project doesn't exist, insert the new project
            $term = wp_insert_term($new_project, 'Project');

            if (!is_wp_error($term)) {
                echo '<p class="success-message">Project added successfully!</p>';
                
                // Clear the term cache to immediately reflect the changes
                update_term_cache($term->term_id, 'Project');
            } else {
                echo '<p class="error-message">Error adding project. Please try again.</p>';
                // Output error details
                error_log('Error adding project: ' . print_r($term, true));
            }
        } else {
            echo '<p class="error-message">Project already exists!</p>';
        }
    }
}

// Add Shortcode for New Project Form
add_shortcode('project_add_form', 'project_add_shortcode');

// Add Action for Handling Project Form Submission
add_action('init', 'handle_project_form_submission');






function register_Task_type_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Task Type', 'Taxonomy General Name', 'textdomain' ),
        'singular_name'              => _x( 'Task Type', 'Taxonomy Singular Name', 'textdomain' ),
        // Add other labels as needed
    );

    $args = array(
        'labels'                     => $labels,
        'public'                     => true,
        'hierarchical'               => true,
        // Add other arguments as needed
    );

    register_taxonomy( 'task_type', array( 'employee' ), $args );
}
add_action( 'init', 'register_Task_type_taxonomy' );
function task_type_add_shortcode() {
    ob_start(); ?>

 <form id="task-type-add-form" method="post" style="max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
    <label for="new_task_type" style="display: block; margin-bottom: 10px; font-weight: bold; color: #333;">New Task Type:</label>
    <input type="text" name="new_task_type" required style="width: 100%; padding: 10px; box-sizing: border-box; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 3px;">
    <input type="submit" value="Add Task Type" style="background-color: #4caf50; color: white; padding: 12px 20px; border: none; border-radius: 3px; cursor: pointer; font-size: 16px;">
</form>


    <?php
    return ob_get_clean();
}
add_shortcode('task_type_add_form', 'task_type_add_shortcode');
function handle_task_type_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_task_type'])) {
        $new_task_type = sanitize_text_field($_POST['new_task_type']);

        // Check if the task type already exists
        $existing_task_type = term_exists($new_task_type, 'task_type');

        if ($existing_task_type === 0 || $existing_task_type === null) {
            // Task type doesn't exist, insert the new task type
            $term = wp_insert_term($new_task_type, 'task_type');

            if (!is_wp_error($term)) {
                echo '<p class="success-message">Task Type added successfully!</p>';
                
                // Clear the term cache to immediately reflect the changes
                update_term_cache($term->term_id, 'task_type');
            } else {
                echo '<p class="error-message">Error adding Task Type. Please try again.</p>';
            }
        } else {
            echo '<p class="error-message">Task Type already exists!</p>';
        }
    }
}

add_action('init', 'handle_task_type_form_submission');

function display_task_type_dropdown() {
    $terms = get_terms( array(
        'taxonomy' => 'task_type',
        'hide_empty' => false,
    ) );

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        echo '<select name="task_type_dropdown" id="task_type_dropdown">';
        echo '<option value="">Select Task Type</option>';
        
        foreach ( $terms as $term ) {
            echo '<option value="' . esc_attr( $term->term_id ) . '">' . esc_html( $term->name ) . '</option>';
        }

        echo '</select>';
    } else {
        echo '<p>No Task Type found</p>';
    }
}

// Add a shortcode for easy use in post/page content
add_shortcode( 'task_type_dropdown', 'display_task_type_dropdown' );




// function display_wpforms_data_in_table( $atts ) {
//     // Extract shortcode attributes
//     $atts = shortcode_atts( array(
//         'form_id' => '322', // Default form ID
//     ), $atts, 'wpforms_data_table' );

//     // Get form entries
//     $entries = wpforms()->entry->get( 
//         array(
//             'form_id' => absint( $atts['form_id'] ),
//             'orderby' => 'date_created',
//             'order'   => 'DESC',
//         )
//     );

//     // Output table HTML
//     $output = '<table>';
//     $output .= '<tr><th>Project</th><th>Task Type</th><th>Location</th><th>Description</th><th>Date</th><th>Working Hours (From)</th><th>Working Hours (To)</th></tr>';
//     foreach ( $entries as $entry ) {
//         $output .= '<tr>';
//         $output .= '<td>' . wpforms()->entry->get_meta( $entry->id, 1 ) . '</td>'; // Project
//         $output .= '<td>' . wpforms()->entry->get_meta( $entry->id, 2 ) . '</td>'; // Task Type
//         $output .= '<td>' . wpforms()->entry->get_meta( $entry->id, 4 ) . '</td>'; // Location
//         $output .= '<td>' . wpforms()->entry->get_meta( $entry->id, 5 ) . '</td>'; // Description
//         $output .= '<td>' . wpforms()->entry->get_meta( $entry->id, 15 ) . '</td>'; // Date
//         $output .= '<td>' . wpforms()->entry->get_meta( $entry->id, 16 ) . '</td>'; // Working Hours (From)
//         $output .= '<td>' . wpforms()->entry->get_meta( $entry->id, 17 ) . '</td>'; // Working Hours (To)
//         $output .= '</tr>';
//     }
//     $output .= '</table>';

//     return $output;
// }
// add_shortcode( 'wpforms_data_table', 'display_wpforms_data_in_table' );


function display_wpforms_data_in_table( $atts ) {
    global $wpdb;

    // Extract shortcode attributes
    $atts = shortcode_atts( array(
        'form_id' => '322', // Default form ID
    ), $atts, 'wpforms_data_table' );

    // Retrieve form entries from the database
    $entries_table = $wpdb->prefix . 'wpforms_entry_fields';
    $sql = $wpdb->prepare( "SELECT * FROM $entries_table WHERE form_id = %d", $atts['form_id'] );
    $entries = $wpdb->get_results( $sql );

    // Output table HTML
    $output = '<table>';
    $output .= '<tr><th>Project</th><th>Task Type</th><th>Location</th><th>Description</th><th>Date</th><th>Working Hours (From)</th><th>Working Hours (To)</th></tr>';
    foreach ( $entries as $entry ) {
        $entry_data = json_decode( $entry->fields, true );
        $output .= '<tr>';
        $output .= '<td>' . $entry_data[1]['value'] . '</td>'; // Project
        $output .= '<td>' . $entry_data[2]['value'] . '</td>'; // Task Type
        $output .= '<td>' . $entry_data[4]['value'] . '</td>'; // Location
        $output .= '<td>' . $entry_data[5]['value'] . '</td>'; // Description
        $output .= '<td>' . $entry_data[15]['value'] . '</td>'; // Date
        $output .= '<td>' . $entry_data[16]['value'] . '</td>'; // Working Hours (From)
        $output .= '<td>' . $entry_data[17]['value'] . '</td>'; // Working Hours (To)
        $output .= '</tr>';
    }
    $output .= '</table>';

    return $output;
}
add_shortcode( 'wpforms_data_table', 'display_wpforms_data_in_table' );




 
?>