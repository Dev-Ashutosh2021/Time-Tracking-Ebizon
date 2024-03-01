<?php
/*
Plugin Name: Timesheet Archive Scheduler
Description: Plugin to schedule the timesheet archiving event.
Version: 1.0
Author: Ashutosh Uniyal
*/

// Add custom cron schedule for every 1 minute
function custom_cron_schedule($schedules) {
    // Add custom cron schedule for every 1 minute
    $schedules['every_1_minute'] = array(
        'interval' => 60, // 60 seconds = 1 minute
        'display'  => __('Every 1 Minute')
    );
    return $schedules;
}
add_filter('cron_schedules', 'custom_cron_schedule');

// Schedule the event for every 1 minute
function schedule_1_minute_event() {
    if (!wp_next_scheduled('my_custom_1_minute_event')) {
        wp_schedule_event(time(), 'every_1_minute', 'my_custom_1_minute_event');
    }
}
// Run the scheduling function only when the plugin is activated
register_activation_hook(__FILE__, 'schedule_1_minute_event');

// Define the function to be triggered by the scheduled event
function my_custom_1_minute_event() {
    global $wpdb;

    // Archive timesheets older than 10 days
    $sql_move = "
    INSERT INTO {$wpdb->prefix}archive_timesheets (id, project_id, employee_id, location, date, hours_worked, task, description, status, comment)
    SELECT id, project_id, employee_id, location, date, hours_worked, task, description, status, comment
    FROM {$wpdb->prefix}timesheets
    WHERE date < DATE_SUB(CURDATE(), INTERVAL 5 DAY);
    ";
    
    // Execute the move query and handle errors
    if ($wpdb->query($sql_move) === false) {
        error_log("Error moving timesheets to archive: " . $wpdb->last_error);
        return;
    }

    // After moving, delete the records from the original table
    $sql_delete = "
    DELETE FROM {$wpdb->prefix}timesheets
    WHERE date < DATE_SUB(CURDATE(), INTERVAL 5 DAY);
    ";

    // Execute the delete query and handle errors
    if ($wpdb->query($sql_delete) === false) {
        error_log("Error deleting timesheets: " . $wpdb->last_error);
        return;
    }
}

// Hook the event handler function
add_action('my_custom_1_minute_event', 'my_custom_1_minute_event');

// Deactivate the cron event when the plugin is deactivated
function deactivate_custom_cron_every_minute() {
    wp_clear_scheduled_hook('my_custom_1_minute_event');
}
// Run the deactivation function only when the plugin is deactivated
register_deactivation_hook(__FILE__, 'deactivate_custom_cron_every_minute');
