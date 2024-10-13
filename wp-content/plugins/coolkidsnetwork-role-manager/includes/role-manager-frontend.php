<?php
// Adds the 'Maintain Characters' button to the homepage
function coolkidsnetwork_display_maintain_characters_button() {
    if (current_user_can('administrator')) {
        echo '<a href="' . esc_url(admin_url('admin.php?page=coolkidsnetwork-characters')) . '" class="button">Maintain Characters</a>';
    } else {
        echo '<a href="' . esc_url(home_url()) . '" class="button">Maintain Characters</a>';
    }
}
add_shortcode('maintain_characters_button', 'coolkidsnetwork_display_maintain_characters_button');