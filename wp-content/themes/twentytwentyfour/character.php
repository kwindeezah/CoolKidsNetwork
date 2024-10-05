<?php
/* Template Name: Character Data */
get_header();

// Check if user is logged in
if (!is_user_logged_in()) {
    wp_redirect(site_url('/login'));
    exit;
}

// Fetch character data here
$user = wp_get_current_user();
$character_data = get_user_meta($user->ID, 'character_data', true);
?>
<div class="container">
    <h2>Your Character Data</h2>
    <p>First Name: <?php echo esc_html($character_data['first_name']); ?></p>
    <p>Last Name: <?php echo esc_html($character_data['last_name']); ?></p>
    <p>Country: <?php echo esc_html($character_data['country']); ?></p>
    <p>Email: <?php echo esc_html($user->user_email); ?></p>
    <p>Role: <?php echo esc_html($character_data['role']); ?></p>
</div>
<?php get_footer(); ?>