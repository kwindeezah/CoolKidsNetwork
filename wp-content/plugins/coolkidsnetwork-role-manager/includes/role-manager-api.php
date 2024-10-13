<?php

// Hook to register the API endpoint
add_action('rest_api_init', function () {
    register_rest_route('coolkidsnetwork/v1', '/change-role', array(
        'methods' => 'POST',
        'callback' => 'coolkidsnetwork_change_user_role',
        'permission_callback' => 'coolkidsnetwork_check_permissions',
    ));
});

// Function to check permissions
function coolkidsnetwork_check_permissions() {
    return current_user_can('administrator'); // Only allows admins to access this endpoint
}

// Callback function to handle role change requests
function coolkidsnetwork_change_user_role(WP_REST_Request $request) {
    // Gets the parameters from the request
    $email = sanitize_email($request->get_param('email'));
    $first_name = sanitize_text_field($request->get_param('first_name'));
    $last_name = sanitize_text_field($request->get_param('last_name'));
    $new_role = sanitize_text_field($request->get_param('role'));

    // Validates email format
    if (!is_email($email)) {
        return new WP_Error('invalid_email', 'Invalid email address.', array('status' => 400));
    }

    // Validates role
    $valid_roles = array('Cool Kid', 'Cooler Kid', 'Coolest Kid');
    if (!in_array($new_role, $valid_roles)) {
        return new WP_Error('invalid_role', 'Invalid role specified.', array('status' => 400));
    }

    // Finds the user in the characters table
    global $wpdb;
    $table_name = $wpdb->prefix . 'characters';
    $character = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s AND first_name = %s AND last_name = %s", $email, $first_name, $last_name));

    // Checks if character exists
    if (!$character) {
        return new WP_Error('user_not_found', 'User not found with the provided details.', array('status' => 404));
    }

    // Updates the user's role
    $updated = $wpdb->update($table_name, array('role' => $new_role), array('email' => $email));

    // Checks if the update was successful
    if ($updated === false) {
        return new WP_Error('update_failed', 'Failed to update user role.', array('status' => 500));
    }

    return new WP_REST_Response('User role updated successfully.', 200);
}