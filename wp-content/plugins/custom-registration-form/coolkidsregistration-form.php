<?php
/*
Plugin Name: CoolKidsNetwork Custom Registration
Description: Adds a custom registration form via a shortcode.
Version: 1.0
Author: Hadizat Abdulhakieem
*/

function custom_registration_form() {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    display_flash_message();
    ob_start();
    ?>
    <!-- Registration Form -->
    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="register_user">
        <label for="character-email">Email:</label>
        <input type="email" name="character-email" required />
        <button type="submit">Confirm</button>
    </form>
    <?php
    return ob_get_clean();
}

// Create shortcode for registration form
add_shortcode('custom_registration_form', 'custom_registration_form');
