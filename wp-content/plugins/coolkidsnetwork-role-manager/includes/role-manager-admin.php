<?php

// Adds the "Maintain Characters" page to the WordPress admin menu
function coolkidsnetwork_role_manager_menu() {
    add_menu_page(
        'Maintain Characters',
        'Maintain Characters',
        'administrator',
        'coolkidsnetwork_maintain_characters',
        'coolkidsnetwork_role_manager_admin_page',
        'dashicons-admin-users',
        6
    );
}
add_action('admin_menu', 'coolkidsnetwork_role_manager_menu');

// Admin page to display and change user roles
function coolkidsnetwork_role_manager_admin_page() {
    global $wpdb;

    // Handles success or error messages
    if (!empty($_SESSION['success_message'])) {
        echo '<div class="notice notice-success">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }

    // Queries characters from the custom table
    $characters = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}characters");

    echo '<h1>Maintain Characters</h1>';
    echo '<table class="widefat fixed">';
    echo '<thead><tr><th>Email</th><th>First Name</th><th>Last Name</th><th>Role</th><th>Action</th></tr></thead>';
    echo '<tbody>';

    foreach ($characters as $character) {
        echo '<tr>';
        echo '<td>' . esc_html($character->email) . '</td>';
        echo '<td>' . esc_html($character->first_name) . '</td>';
        echo '<td>' . esc_html($character->last_name) . '</td>';
        echo '<td>' . esc_html($character->role) . '</td>';
        echo '<td>
                <form method="post" action="' . admin_url('admin-post.php') . '">
                    <input type="hidden" name="action" value="change_role">
                    <input type="hidden" name="email" value="' . esc_attr($character->email) . '">
                    <select name="new_role">
                        <option value="Cool Kid"' . selected($character->role, 'Cool Kid', false) . '>Cool Kid</option>
                        <option value="Cooler Kid"' . selected($character->role, 'Cooler Kid', false) . '>Cooler Kid</option>
                        <option value="Coolest Kid"' . selected($character->role, 'Coolest Kid', false) . '>Coolest Kid</option>
                    </select>
                    <input type="submit" class="button" value="Change Role">
                </form>
              </td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}