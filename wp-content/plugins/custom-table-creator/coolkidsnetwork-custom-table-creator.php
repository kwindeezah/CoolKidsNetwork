<?php
/*
Plugin Name: CoolKidsNetwork Custom Table Creator
Description: A plugin to create custom tables in the coolkidsnetwork database.
Version: 1.0
Author: Hadizat Abdulhakieem
*/

register_activation_hook( __FILE__, 'coolkidsnetwork_custom_install' );

if (!session_id()) {
    session_start();
}

function coolkidsnetwork_custom_install () {
    global $wpdb;
 
    $charset_collate = $wpdb->get_charset_collate();

    $table_name = $wpdb->prefix . 'characters';

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(100) NOT NULL,
        first_name varchar(100) NOT NULL,
        last_name varchar(100) NOT NULL,
        country varchar(100) NOT NULL,
        role varchar(50) DEFAULT 'Cool Kid',
        PRIMARY KEY (id),
        UNIQUE KEY email (email),
    ) $charset_collate";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
 }

// Logic handling user registration
function coolkidsnetwork_insert_custom_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'characters';
    
    if (isset($_POST['character-email'])) {

        $email = sanitize_email($_POST['character-email']); // Sanitizes email input

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Checks if the email exists in the 'characters' table
        $email_exists = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE email = %s", $email
        ));

        if ($email_exists > 0) {
            $_SESSION['error_message'] = 'This email is already registered.';
            wp_redirect(home_url('/sign-up')); // Redirects to sign up page
            exit;
        }

        // API request to generate random user data
        $response = wp_remote_get('https://randomuser.me/api/');
        if (is_wp_error($response)) {
            wp_die('Error retrieving user data');
        }
        $data = json_decode(wp_remote_retrieve_body($response), true);

        $first_name = sanitize_text_field($data['results'][0]['name']['first']);
        $last_name = sanitize_text_field($data['results'][0]['name']['last']);
        $country = sanitize_text_field($data['results'][0]['location']['country']);
        $role = 'Cool Kid';

        $result = $wpdb->insert(
            $table_name,
            [
                'email'      => $email,
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'country'    => $country,
                'role'       => $role
            ]
        );

        if ($result === false) {
            $_SESSION['error_message'] = 'Registration failed. Please try again.';
            wp_redirect(home_url('/sign-up')); // Redirects to sign up page
            exit;
        }

        // Sets success message
        $_SESSION['success_message'] = 'Registration successful! Please sign in.';
        wp_redirect(home_url('/sign-in')); // Redirects to sign in page
        exit;
    }
}
add_action('admin_post_nopriv_register_user', 'coolkidsnetwork_insert_custom_data');
add_action('admin_post_register_user', 'coolkidsnetwork_insert_custom_data');


// Logic handling user login
function coolkidsnetwork_user_login() {
    if (isset($_POST['character-email'])) {
        global $wpdb;

        // Sanitizes the email input
        $email = sanitize_email($_POST['character-email']);

        $table_name = $wpdb->prefix . 'characters';

        // Queries the character table to check if the email exists
        $user = $wpdb->get_row( $wpdb->prepare(
            "SELECT * FROM $table_name WHERE email = %s", $email
        ));

        // Checks if the email exists in the table
        if ($user) {
            
            if (!session_id()) {
                session_start();
            }

            // Stores user data in the session
            $_SESSION['user_id'] = $user->id;
            $_SESSION['email'] = $user->email;
            $_SESSION['first_name'] = $user->first_name;
            $_SESSION['last_name'] = $user->last_name;
            $_SESSION['country'] = $user->country;
            $_SESSION['role'] = $user->role;

            // Redirects to the dashboard
            wp_redirect(home_url('/dashboard'));
            exit;
        } else {
            $_SESSION['error_message'] = 'No account found with this email.';
            wp_redirect(home_url('/sign-in'));
            exit;
        }
    }
}
add_action('admin_post_nopriv_login_user', 'coolkidsnetwork_user_login');
add_action('admin_post_login_user', 'coolkidsnetwork_user_login');

?>