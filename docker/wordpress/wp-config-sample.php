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
define( 'DB_NAME', getenv('DB_NAME') );

/** MySQL database username */
define( 'DB_USER', getenv('DB_USER') );

/** MySQL database password */
define( 'DB_PASSWORD', getenv('DB_PASSWORD') );

/** MySQL hostname */
define( 'DB_HOST', getenv('DB_HOST') );

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
define( 'AUTH_KEY',          '@0E8n7{m$hO#@k{=_PPL<]6(CO)<i]zZgt.-(vcgJ 5U$J6~(99!PJ6 iFzMr0N+' );
define( 'SECURE_AUTH_KEY',   'g%MQGv0Oa[loZ`![nWs2jitQ{Iq~CL&:eYtHT7Vz%q=>)^g0wB.vS@39?`A5WAjl' );
define( 'LOGGED_IN_KEY',     'k:-O{sw|nnhE7-HmTo8__O8mc:l(_/LOj.3)WxOBU_*DVLE$bV39u/HU;3*BnPh;' );
define( 'NONCE_KEY',         '=4p|uJ~$_cut{8XT&Y/TS*e~gYsTpbh=|qY&A,E$GVAr^Q24aG~F-V=L_08 GvO9' );
define( 'AUTH_SALT',         '_+#[]!tif/<BJ<`dp*I>;qfz:duRm{`0m:+fXrdD~jDA<1P?-0:=Gjj^jWiOKf/A' );
define( 'SECURE_AUTH_SALT',  'b]diDi<4G2:i!AVX-msnf{t,u.2m8zro.g<.[iJR`G?IjTkD{B1nHedOO$Ed!UIv' );
define( 'LOGGED_IN_SALT',    'LDN,yk<aiK-bON7TM*JwHGigS[%3i9lldTCPVW+4S5$YrFcHh(uB;Q#E|t}[D,G%' );
define( 'NONCE_SALT',        '@RJL=}B>M z!vozna1zz%A2p8b:&bQ#c>]b#?QkO<Hwv]&nND5-uE=TQ1Ip^zJ?]' );
define( 'WP_CACHE_KEY_SALT', '6jX|=LbR7eV9M,.2;$o^EZ. u@u[!aF-95g!%Y|&4dCZ[a`+G#dc$ELYRz&ep}~A' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/* That's all, stop editing! Happy blogging. */
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

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SAVEQUERIES', true );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
