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
define( 'DB_NAME', 'csd' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'V{k^s fLIbbZyq2xzGtO+$`*8a1ayD7gb] hb@j3pl0eg): {+3^vV3!oera/:@7' );
define( 'SECURE_AUTH_KEY',  'h]SUl&tt,J0%LK|/<>;m-8*njT3e[jt+lO?_+q*PgJUtx$64OjIYFB,[~8[5?NpA' );
define( 'LOGGED_IN_KEY',    'B@5Ae{RJ.fN1H=V!<b?YCaNs.f}+Qx./TR#1SSgtD}_O~ii]fk%6w3TZ+4`SB(Ba' );
define( 'NONCE_KEY',        '<{: -76`O@[f[d@NJNEGf1M{t@Q?[er.[3LNt3Z=3pUf4xfS#iaPnj&)k`9A`a/?' );
define( 'AUTH_SALT',        'K0o$YMrC!wp~A]?8Vt![xVuF:0&XfBnew44OhOi<=k/SIu>LYe=Lnwbyx!j%LYp)' );
define( 'SECURE_AUTH_SALT', 'a 2&q2S$@`OJ~73C3bQ(z?1h$,]8wUJ:5fDU:>z6>?5[?!O/+QK!<wdWP.|i-3^C' );
define( 'LOGGED_IN_SALT',   'T-&Q;[:6Sx/8:a&:BS72RX.(q,DNtx8j;?_ybN!42h}cZ0frqDu7}D](cH_RW15e' );
define( 'NONCE_SALT',       'J]Ol1O@+z6HV3owV[5$w<`aD<_FZ~pE0$bIIsoB3>Q]O)jCWi{SR!GP5o4/zV1oo' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_software';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
