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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv( 'DB_NAME' ) );

/** MySQL database username */
define( 'DB_USER', getenv( 'DB_USER' ) );

/** MySQL database password */
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );

/** MySQL hostname */
define( 'DB_HOST', getenv( 'DB_HOST' ) );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', getenv( 'AUTH_KEY' ) ?: hash( 'sha256', md5( php_uname( 'n' ).'1' ) ) );
define( 'SECURE_AUTH_KEY', getenv( 'SECURE_AUTH_KEY' ) ?: hash( 'sha256', md5( php_uname( 'n' ).'2' ) ) );
define( 'LOGGED_IN_KEY', getenv( 'LOGGED_IN_KEY' ) ?: hash( 'sha256', md5( php_uname( 'n' ).'3' ) ) );
define( 'NONCE_KEY', getenv( 'NONCE_KEY' ) ?: hash( 'sha256', md5( php_uname( 'n' ).'4' ) ) );
define( 'AUTH_SALT', getenv( 'AUTH_SALT' ) ?: hash( 'sha256', md5( php_uname( 'n' ).'5' ) ) );
define( 'SECURE_AUTH_SALT', getenv( 'SECURE_AUTH_SALT' ) ?: hash( 'sha256', md5( php_uname( 'n' ).'6' ) ) );
define( 'LOGGED_IN_SALT', getenv( 'LOGGED_IN_SALT' ) ?: hash( 'sha256', md5( php_uname( 'n' ).'7' ) ) );
define( 'NONCE_SALT', getenv( 'NONCE_SALT' ) ?: hash( 'sha256', md5( php_uname( 'n' ).'8' ) ) );
define( 'WP_CACHE_KEY_SALT', getenv( 'WP_CACHE_KEY_SALT' ) ?: hash( 'sha256', md5( php_uname( 'n' ).'9' ) ) );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/* That's all, stop editing! Happy blogging. */
define( 'WP_ENV', getenv( 'WP_ENV' ) );

define( 'WP_DEBUG', ! ! getenv( 'WP_DEBUG' ) );
define( 'WP_DEBUG_DISPLAY', false );
// set to 'true' means the default debug.log file would be wp-content/debug.log
define( 'WP_DEBUG_LOG', getenv( 'WP_DEBUG_LOG' ) );
define( 'SAVEQUERIES', ! ! getenv( 'SAVEQUERIES' ) );

// ## Below snippets are for installing plugins, themes from the Admin Dashboard
// define( 'FS_METHOD', 'direct' );
// define( 'FS_CHMOD_DIR', (0755 & ~ umask()) );
// define( 'FS_CHMOD_FILE', (0664 & ~ umask()) );

// For https
// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
	$_SERVER['HTTPS'] = 'on';
}

if ( isset( $_SERVER['HTTP_HOST'] ) ) {
	$http_protocol = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
	define( 'WP_HOME', $http_protocol . '://' . $_SERVER['HTTP_HOST'] );
	define( 'WP_SITEURL', $http_protocol . '://' . $_SERVER['HTTP_HOST'] );
}

define( 'WP_APP_FORCE_CREATE_WP_APP_FOLDER', ! ! getenv( 'WP_APP_FORCE_CREATE_WP_APP_FOLDER' ) );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
