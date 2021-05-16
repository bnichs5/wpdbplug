<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', '' );

/** MySQL database username */
define( 'DB_USER', '' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', '' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'f304f0390ecc2d38cf1853c1597fde60c2e6b171e854e2df6a7822831aa73c33' );
define( 'SECURE_AUTH_KEY',  'b60042ff3f35a832d9d4786a6514abd3f02e91fe638bd6dc9bc35f4fb08daaef' );
define( 'LOGGED_IN_KEY',    'a944ebbaebd3ba65025b5ca570a15dc1c09b4f979a78c9042fd9c5ede878efa4' );
define( 'NONCE_KEY',        'd8785748c385ed12c63970e80d34b9901b52b628b2568200654561febfaca889' );
define( 'AUTH_SALT',        '24ae867bd704d17aa444dc4320737d14e2833e3162ef903b5faa8db3d9adda75' );
define( 'SECURE_AUTH_SALT', 'b60042ff3f35a832d9d4786a6514abd3f02e91fe638bd6dc9bc35f4fb08daaef' );
define( 'LOGGED_IN_SALT',   '7944fc61eed7321cb95460b45a262e3c696a1807cdb5bec7b26a477f2e600d39' );
define( 'NONCE_SALT',       'a92d7ea615495776fd969501c341ebac248365dc95f36771e7f7f01eaa98926d' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

/** Sets up WordPress memory limit to 256MB. */
define( 'WP_MEMORY_LIMIT', '256M' );
