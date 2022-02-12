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
define( 'DB_NAME', 'hixio' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'k82[xf{Y$}#neb~6j.)orw0 R7zc?HKSe1#=PtG;AZW8bQQ+Wjx5d< |/TETX=}X' );
define( 'SECURE_AUTH_KEY',  '#lX(J6>XwRU.+WONGGl9Di]YXh/:V)/@`ln/svLNl)Lu0Tia6FB{2@L,S+8ful9=' );
define( 'LOGGED_IN_KEY',    'w>Wh) ,j<ZL+|&l<Y@|BTZou;4P_w*Ydk)9R#M6Q=$SgC1LX}/GIbV>*S.ksRbf!' );
define( 'NONCE_KEY',        'Mj[_RT`]Slp#_pZ.%1o#x<&%5!=DT`q%b-lP-ix U22>}FkOAtDjM>+G1932[#4h' );
define( 'AUTH_SALT',        'w}U 4>Ic!&1;0i09jMaNsxlSo>:~S.X:qGnp&gL*:nEq$s sIbn? D44>/Uyx~/r' );
define( 'SECURE_AUTH_SALT', 'WK{!.hp&^?-r}OxX,r>T}=Ys82|^ad_xP/p0i7qmOWj:~v`0i!0+5z)JFf|JQ4:X' );
define( 'LOGGED_IN_SALT',   'WkLDQ5[<AZsvx V5[zv3Gx<gFI|Cy5nlv^#CtHj8p8F/v=P6<NTi=#MbY/#OTo4&' );
define( 'NONCE_SALT',       'IW~kcx3Rd8/1@ZF`&Grjri6aK@(U?jUPAo93K@#M$//Xe6elZiXO:=l+J!5Pq*=x' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
