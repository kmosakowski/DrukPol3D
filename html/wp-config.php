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
/** The name of the database for WordPress dsadas*/

// $dbname = getenv('DB_ENV_NAME');
$dbname = 'cms_wordpress_db_dev01';
if (empty($dbname)){
	$dbname = wordpress5000;
}

// $dbuser = getenv('DB_ENV_USER');
$dbuser = 's16392@cms-wordpress-server02';
if (empty($dbuser)){
	$dbuser = 'yaprigal@yaprigalmysql';
}

$dbpassword = 'CmsIsCool69';
if (empty($dbpassword)){
	$dbpassword = 'Microsoft0512$';
}

$dbhost = 'cms-wordpress-server02.mysql.database.azure.com:3306';
if (empty($dbhost)){
	$dbhost = 'yaprigalmysql.mysql.database.azure.com:3306';
}

define('DB_NAME', $dbname);

/** MySQL database username */
define('DB_USER', $dbuser);

/** MySQL database password */
define('DB_PASSWORD', $dbpassword);

/** MySQL hostname */
define('DB_HOST', $dbhost);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'yS_pl1IzKIB[Hy#YxI-jL|FaC~ZM)5p:[=74+6-8m3T-?<KH:H@2??lK`d*`@8hw');
define('SECURE_AUTH_KEY',  '$y-y8yB|)S}.kBI1n(EF/9^~g|1(I~h`@Paq}{@E@,*/u14!&I*yZi~O#xAE|+V/');
define('LOGGED_IN_KEY',    '+&-I=V?@=l>ZtkhX4~s)9cD2[RLVn,W[S.EaB9}0XI]a?pB^:|Q6H0O9^|?QRe->');
define('NONCE_KEY',        '[Y:j~~P/Muh)J S8xDr-*_WiszROFsozC@Yw-o~O92ooQI)v}5RgpljcS^Uo%H-P');
define('AUTH_SALT',        '+$US7=T;cM$H.Uz1jT;?R(UWb7-*0w;i>M{B^B=qnx.<L(`M2R6|5:6CKX)&Y8Vz');
define('SECURE_AUTH_SALT', '?r 8tRe3}f3a~#tHj=M8=&~6T1sYK+cN(0<:F0U-x2bnqGOo(g;5<(kXPi?<4J@5');
define('LOGGED_IN_SALT',   'Xfkj7c:F@NC?]mg@EZGVEi7PwQ++63::]KSIz<^*nn>1jF_/-mFBD|8PN-#kaV8P');
define('NONCE_SALT',       'Z2Q>Atxp$EE*|$gr#>&m7u2+jH@E9j,sp*Be/cSh[uf[Zo#6FP&&~5T%Y>2Ag_#&');

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

// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/** allow strange 3D model file formats */
define('ALLOW_UNFILTERED_UPLOADS', true);