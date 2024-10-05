<?php
/*
Plugin Name: Flash Messages Display
Description: A plugin to display flash messages.
Version: 1.0
Author: Hadizat Abdulhakieem
*/

function display_flash_message() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['success_message'])) {
        echo '<div class="success-message">' . esc_html($_SESSION['success_message']) . '</div>';
        unset($_SESSION['success_message']);
    }

    if (!empty($_SESSION['error_message'])) {
        echo '<div class="error-message">' . esc_html($_SESSION['error_message']) . '</div>';
        unset($_SESSION['error_message']);
    }
}

?>