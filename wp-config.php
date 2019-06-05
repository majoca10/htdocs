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
define( 'DB_NAME', 'wpts' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '-CYW$q]M;D$qldOt-b ISa_QDx;W{|kD,67$N%2q(=s,{s<Cx9n},Bos3B.n0l(&' );
define( 'SECURE_AUTH_KEY',  '*K=<P99[1,v&RV&sW$WP<Gf|;WX$*pXTWq6R;k>!;-!>*P3YwySY^Hxq0SSrmux)' );
define( 'LOGGED_IN_KEY',    '^F3%E7-=K=}63,qai[S&~1(En#lS @LSUo%F|yB>A;>J/nuK=yuQAYL3us&+!(w=' );
define( 'NONCE_KEY',        'ntt?puCKp/tp12ki6;kR#Gm0|SR?1)H1N611WW$:n5O?]%[#W!AyAm94I-dc9TL.' );
define( 'AUTH_SALT',        '1%SwAy*^[c$d.AsnGnOC_!@h(%gG1ppx[MD4oYJnq&xTQo#cq%=pG]UU`1(t8u*Z' );
define( 'SECURE_AUTH_SALT', '@AotPJ2Ui/t_N,TL~g)fTk/cg<s$qmLR *$TJM4(Lop>I``.z-C~]wOny8#tI[)r' );
define( 'LOGGED_IN_SALT',   'H:WmB!}[40&jcX?0cD%&KwLF:L=N_}S>q].OJ3FOYm|Vbzo0Pq@6FEU2`44H>Bjh' );
define( 'NONCE_SALT',       'iaRUVby_u/UY9&c/[Ut*1t^~(X DH|&V0 c,9N|HQ^=.aFD#oU$lZRk;O7N9IvI|' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
