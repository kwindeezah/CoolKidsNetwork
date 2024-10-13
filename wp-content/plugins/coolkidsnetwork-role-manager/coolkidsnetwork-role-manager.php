<?php
/**
 * Plugin Name: CoolKidsNetwork Role Manager
 * Description: Allows a maintainer to change a user’s role through a 3rd party integration.
 * Version: 1.0
 * Author: Hadizat Abdulhakieem
 */

// Includes the necessary files
require_once plugin_dir_path(__FILE__) . 'includes/role-manager-api.php';
require_once plugin_dir_path(__FILE__) . 'includes/role-manager-admin.php';

// Activates the plugin to create the characters table
register_activation_hook(__FILE__, 'coolkidsnetwork_create_characters_table');

function coolkidsnetwork_create_characters_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'characters';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(100) NOT NULL,
        first_name varchar(100) NOT NULL,
        last_name varchar(100) NOT NULL,
        role varchar(50) NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

?>