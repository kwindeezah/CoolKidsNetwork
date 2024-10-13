<?php
/*
Plugin Name: CoolKidsNetwork Character Detail
Description: Displays characters details via a shortcode.
Version: 1.0
Author: Hadizat Abdulhakieem
*/

function coolkidsnetwork_dashboard() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    display_flash_message();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Character Details</title>
    </head>
    <body>
    <div class="character-dashboard">
        <h2>Your Character Details</h2>
        <?php
        // Checks if user is logged in
        if (!is_character_logged_in()) {
            $_SESSION['error_message'] = 'You need to log in to view your character details.';
            wp_redirect(home_url('/sign-in'));  // Redirects to login page
            exit;
        }
        
        // Gets current user's email from session or directly after login
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

        // Fetches character data from the 'characters' table
        global $wpdb;
        $table_name = $wpdb->prefix . 'characters';
        $character_data = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT first_name, last_name, country, email, role FROM $table_name WHERE email = %s",
                $email
                )
            );
            
            if ($character_data) {
            // Displays character details
            ?>
            <p>First Name: <?php echo esc_html($character_data->first_name); ?></p>
            <p>Last Name: <?php echo esc_html($character_data->last_name); ?></p>
            <p>Country: <?php echo esc_html($character_data->country); ?></p>
            <p>Email: <?php echo esc_html($character_data->email); ?></p>
            <p>Role: <?php echo esc_html($character_data->role); ?></p>
            <?php

            // Checks if the user is a Cooler Kid or Coolest Kid
            if ($character_data->role === 'Cooler Kid' || $character_data->role === 'Coolest Kid') {
                echo '<form method="post" action="' . esc_url($_SERVER['REQUEST_URI']) . '">
                        <input type="hidden" name="view_other_characters" value="1">
                        <button type="submit">See Other Characters</button>
                      </form>';
            }

            // Handles the request to view other characters
            if (isset($_POST['view_other_characters'])) {
                display_other_characters($character_data->role);
            }

        } else {
            $_SESSION['error_message'] = 'No character data found for this email.';
            wp_redirect(home_url('/dashboard'));  // Redirects to dashboard
            exit;
        }
        ?>
    </div>
    </body>
    </html>
    <?php
}

// Function to display other characters based on user role
function display_other_characters($user_role) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'characters';

    // Fetches all characters based on user role
    if ($user_role === 'Cooler Kid') {
        $characters = $wpdb->get_results("SELECT first_name, last_name, country FROM $table_name");
        echo '<h2>All Characters (Cooler Kid Access)</h2>';
        echo '<table><tr><th>First Name</th><th>Last Name</th><th>Country</th></tr>';
        foreach ($characters as $character) {
            echo '<tr>';
            echo '<td>' . esc_html($character->first_name) . '</td>';
            echo '<td>' . esc_html($character->last_name) . '</td>';
            echo '<td>' . esc_html($character->country) . '</td>';
            echo '</tr>';
        }
        echo '</table>';

    } elseif ($user_role === 'Coolest Kid') {
        $characters = $wpdb->get_results("SELECT first_name, last_name, email, role, country FROM $table_name");
        echo '<h2>All Characters (Coolest Kid Access)</h2>';
        echo '<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Role</th><th>Country</th></tr>';
        foreach ($characters as $character) {
            echo '<tr>';
            echo '<td>' . esc_html($character->first_name) . '</td>';
            echo '<td>' . esc_html($character->last_name) . '</td>';
            echo '<td>' . esc_html($character->email) . '</td>';
            echo '<td>' . esc_html($character->role) . '</td>';
            echo '<td>' . esc_html($character->country) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>You do not have permission to view other characters.</p>';
    }
}

// Custom function to check if the user is logged in via the characters table
function is_character_logged_in() {
    if (isset($_SESSION['email'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'characters';
        $email = $_SESSION['email'];
        $character = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE email = %s", $email)
        );
        return $character !== null; // Return true if character exists
    }
    return false; // No email in session means not logged in
}

// Registers the shortcode
add_shortcode('coolkidsnetwork_user_dashboard', 'coolkidsnetwork_dashboard');