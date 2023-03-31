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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'NbAxWS$(Cgo&v!s_[P;>Jz~b|ocI@^<$&;rbFb-iJT`4ny5ai/?[7^d!,Mha>G0`' );
define( 'SECURE_AUTH_KEY',  'mZ]sG:K:4//2PRv$_^AJjy/~CFqt*@)mKh%a20[W>o.t_Y67x[)G7vAsx0R<&,n/' );
define( 'LOGGED_IN_KEY',    'KfQ{CJGHC RcDk`$hF]<YkQSOv)Y{eVI5RI)ax;o+_X0T[8qyL$g$Zi+CRn_z e>' );
define( 'NONCE_KEY',        '+lmf0bkFe*Cvs*79P{hv-IM.Mpe8a[6]SO-BFiZD;?$&]d@P#B3rk,BDpl@MjS-Y' );
define( 'AUTH_SALT',        'I9 63Qn,tpDK L 5f~25;SM~&g=Y8))b9-dBH27,~>=Dg/Y+)>St{?}8D<B!RuWQ' );
define( 'SECURE_AUTH_SALT', '0&`f,a7%_pkD+4`8^#`1s.ozbW[Iy#6,;k_D4Nn C Fs|Cw)M&,(JBAu=2w`n_Q~' );
define( 'LOGGED_IN_SALT',   '`*g91O71OO2-Kt(#!ue+Y]GnCj@;8:bH5QwKmmUH^zcg[)rqDz{c7(nHt3EOV[-P' );
define( 'NONCE_SALT',       'm!2-7^5*<!#M)RJ%lrSF0*0v./Zwd]Ldl~5c4YKlU/T~ HGiD< @bO60nDA^L9(u' );

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
