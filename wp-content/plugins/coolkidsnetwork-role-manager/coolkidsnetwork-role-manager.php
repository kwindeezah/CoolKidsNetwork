<?php
/**
 * Plugin Name: CoolKidsNetwork Role Manager
 * Description: Allows a maintainer to change a user’s role through a 3rd party integration.
 * Version: 1.0
 * Author: Hadizat Abdulhakieem
 */

// Includes the admin interface and endpoint logic
require_once plugin_dir_path(__FILE__) . 'includes/role-manager-admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/role-manager-api.php';

// Registers the Maintain Characters Button shortcode
function maintain_characters_button_shortcode() {
    // Checks if the current user is an administrator
    if (current_user_can('administrator')) {
        // Show the button to administrators
        return '<a href="' . admin_url('admin.php?page=coolkidsnetwork_maintain_characters') . '" class="button">Maintain Characters</a>';
    } else {
        // Non-admins see the flash message and get redirected
        if (!empty($_SESSION['error_message'])) {
            return '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
        }
        return '';
    }
}
add_shortcode('maintain_characters_button', 'maintain_characters_button_shortcode');

// Start the session to handle flash messages
function coolkidsnetwork_start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'coolkidsnetwork_start_session');

?>