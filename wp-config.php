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
define( 'DB_NAME', 'e-commerce' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         ';`?qK>yu/%}w}OI``Ttg!~kRhPGwa@j)LLH6bVX,_ctj56Zd*dW^NFI~DY$-RP$l' );
define( 'SECURE_AUTH_KEY',  '{.o}Ek*a/K FW7iaa!l1#+p(1z.~D8|l96IG?jPS4Hj{gMWOdWL6ENqmW9dNJ:rY' );
define( 'LOGGED_IN_KEY',    '/i{B6$}!MHCpZcHQ?ju)rH4HH!Swfq2niK~$(DpMC?`)_^SEK,[cCrq@79X,gTym' );
define( 'NONCE_KEY',        'V?!><|Kp0#9nBV1|C)W@l*7]7yY1uTQO|vU1!9J~$w}bhprTbwpT]2(dNwj05kWS' );
define( 'AUTH_SALT',        'E:.T=)^uq>4$B;?GcBkk>*+=qfcm>IvXrY;{@9i-y1U#<UGqSv:6])`h%)DpU.!m' );
define( 'SECURE_AUTH_SALT', 'Re`w`s|Z1$QV]rtmz!Li%kd1W-. ;:dONq08,*BilLFd6FvtVT<n0,%f1&AJg6aK' );
define( 'LOGGED_IN_SALT',   'G-QW]i*45D-_g+#+D|Xw1Y7n{]2}(e+i,0y*EglPL6w}I6IP,}5.lRog.7QBc#9z' );
define( 'NONCE_SALT',       'H93MDK6G^MdQ!N+.SWTD?:D9~oZX%t:+H?(=+~V%;S+aBSZaScA^=]c?cFtY|n&G' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
