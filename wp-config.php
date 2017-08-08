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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'L->AIRYq:2Hm%6[3Q|l3KzA=rBl4S&0Sxh.dv]6m}cj|;UO+67T2OE{@^`G0+E&1');
define('SECURE_AUTH_KEY',  'dB_U|1$<x}9;WcKB@U76YZYm-t.S]fW`DYuk<SZ@u!VUhRB#e^+=6*ZwC9<R{;x&');
define('LOGGED_IN_KEY',    'Jr[^eaM{Uh/jrpELu1#A7rzv6x7h,hLMs8b?-be-@;;YXc:eu<2qH>k{a?#EqOnW');
define('NONCE_KEY',        'sC&`~q;4Nb][roEOomCOd5F]W+s+Eoo2q2:JZXJL&SlEeKi~la|Z*[d{Znz90DU$');
define('AUTH_SALT',        'Q3RGV}P+U_EZ@)[BL,nz:(-BC#K/SMSK0/PX1!a,-O`z%$FBVKpcH_+`EQ5mwZpP');
define('SECURE_AUTH_SALT', ':2PP1aSUX=(<4&i_hu93maENpQeEb3Kc=g6Gp|n/VOc_PDR)S4gf*]E1e+[`vd|T');
define('LOGGED_IN_SALT',   'pk:maWK|z>>Y..PUI{.(/jF2CsetdP,4gbk~qwYfIjKlHrs~_B.(ll9|<O?h?~5^');
define('NONCE_SALT',       'DX-|)Og@:O0AnWT~Q~/;R#kQ1G1Q;RC:#B(Ur-EHFl!ctkzpP$RIc>6We(mzKB?h');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
