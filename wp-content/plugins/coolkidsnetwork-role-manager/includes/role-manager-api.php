<?php

// Handles changing the role of the user from the admin interface
function coolkidsnetwork_change_role() {
    global $wpdb;

    // Verifies the user has the right capabilities
    if (!current_user_can('administrator')) {
        $_SESSION['error_message'] = 'You do not have access to perform this action.';
        wp_redirect(home_url());
        exit;
    }

    // Gets the email and new role from the form
    if (isset($_POST['email']) && isset($_POST['new_role'])) {
        $email = sanitize_email($_POST['email']);
        $new_role = sanitize_text_field($_POST['new_role']);

        // Ensures the role is valid
        $valid_roles = ['Cool Kid', 'Cooler Kid', 'Coolest Kid'];
        if (!in_array($new_role, $valid_roles)) {
            $_SESSION['error_message'] = 'Invalid role selection.';
            wp_redirect(admin_url('admin.php?page=coolkidsnetwork_maintain_characters'));
            exit;
        }

        // Updates the character's role in the custom table
        $updated = $wpdb->update(
            "{$wpdb->prefix}characters",
            ['role' => $new_role],
            ['email' => $email]
        );

        if ($updated !== false) {
            $_SESSION['success_message'] = 'User role updated successfully.';
        } else {
            $_SESSION['error_message'] = 'Failed to update user role.';
        }

        // Redirects back to the admin page
        wp_redirect(admin_url('admin.php?page=coolkidsnetwork_maintain_characters'));
        exit;
    }
}
add_action('admin_post_change_role', 'coolkidsnetwork_change_role');