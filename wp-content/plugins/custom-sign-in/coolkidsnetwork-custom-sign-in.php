<?php
/*
Plugin Name: CoolKidsNetwork Custom Sign In
Description: Adds a custom sign in form via a shortcode.
Version: 1.0
Author: Hadizat Abdulhakieem
*/

function custom_signin_form() {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    display_flash_message();
    ob_start();
    ?>

    <!-- Sign In form -->
    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="login_user">
        <label for="character-email">Email:</label>
        <input type="email" name="character-email" required />

        <button type="submit">Sign In</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_signin_form', 'custom_signin_form'); // Create a shortcode to display the form
