<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'timetracking' );

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
define( 'AUTH_KEY',         'a8q)PSVApCYHWI~~;~VmV%iX&DmQX=&w<lUr]Op34!,4<2<K#B)^jGOiQpQBhF^z' );
define( 'SECURE_AUTH_KEY',  'BBi}FUv0{39Lsp2Ev:rWX$hCU<Ky1|SoZT?tx$Tk&.F&xhS@N(:%BU(t]|s/-W*!' );
define( 'LOGGED_IN_KEY',    'RV}e{= cc&58!$jiWOX6jlW{}%3i]{ #fiMX%.Ls,/$q36v}[AQK27R=5WeG51.e' );
define( 'NONCE_KEY',        'iL%W~9]610KOYR@s4@y|HYjG^M$^-*XC6twnz&H!>z*249o0d V}#J_xy5@QWIyA' );
define( 'AUTH_SALT',        '-8]<z~;j_FZ=<13 m5P(K)#!Jt;&`)i/ZeiD]!`uH`iXB/(r3p8:R6d[jnah|CVJ' );
define( 'SECURE_AUTH_SALT', '&]<_tD<t?h/U}dtj)9m79dd*]iw3oY=Yyi+1<y-RQ>sl]UxDK=+b=D?ph$x_b{n?' );
define( 'LOGGED_IN_SALT',   'eRZyad1}@Uhf:,-F,U5hW  YG$&`*3Qsr|*=~A3|s#lHdX [FN%eZ* Qr{tDZ,*j' );
define( 'NONCE_SALT',       'Tm~HJ@Lv0n@8OjJ2V.otEu$d1=RfNvwnD T~KWZiVHzRsR?lxn1-Ykzhciut!UP{' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
define('FS_METHOD', 'direct');


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
