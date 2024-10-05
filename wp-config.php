<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'coolkidsnetwork' );

/** Database username */
define( 'DB_USER', 'hadizat' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Bt?>m5o&|j}iu9xAPiFR()Ws+HUHz!B}t;<ISNft_;8OxnpwYWu%^/WoiT`V4DU<' );
define( 'SECURE_AUTH_KEY',  'LHhBz3`YZiA+$4!X>^2qb2]_.7>]cU0+!bmdzep~k@e>39&S+%:yaG5)$chbQI)[' );
define( 'LOGGED_IN_KEY',    'ehqUe2fkzyZ%:bo~Joaq3%@Pa_;9R4N^-zmmqGD!KlM_?:{x)Rw40R-s~fs$0Mk|' );
define( 'NONCE_KEY',        't2wr1qg#$1?1nDD2)R.GB-Je/+nQ&}~Augrg??t^dnO_ZcP]So9k,Qg8C5.x*Bf&' );
define( 'AUTH_SALT',        'AdHdza9n?k=G4Vtmx#<P+RHjggr^mW`?aYO5mb~lZFZ Jm&$x:0[d-o2wq=*Vb8a' );
define( 'SECURE_AUTH_SALT', 'O$VHkA0&YVniirjz9F~gWFZPXZe8D<x62t,_[g-zuGO@tm]r5-T:!/q-9<Q_UAU(' );
define( 'LOGGED_IN_SALT',   'b>|lutEHI<{%d,&*lHc*boc$C aju,{tGoM:}4h_w*.uAyL:>ZzF2%hh}[Y)eItT' );
define( 'NONCE_SALT',       'ume|Q7ly}JT(FXU8RG(N*<mDmkmZ`lcwGv$tZf(:<vFt~^ns1~z|t.!_-7-B>3O8' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
