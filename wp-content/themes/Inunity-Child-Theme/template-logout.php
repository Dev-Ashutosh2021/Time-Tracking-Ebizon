<?php
/**
 * Template Name: Custom Logout Template
 */

// Log out the current user
wp_logout();

// Redirect to the Ultimate Member login page after logout
$login_page_url = get_permalink( 19 ); // Replace 19 with your Ultimate Member login page ID
wp_redirect( $login_page_url );
exit;
