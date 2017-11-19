<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_LOG', true );
// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'MyAppDroidv2');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'wpuser');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'katya');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '%(38*FI]8a^ay8*v1Z>o]v,))s$^+ -h&.gqetwI;>o|V<;1h21:x6(dR&h`kj)p');
define('SECURE_AUTH_KEY', 'E^k&WhI.$;b[J,XfYG%KXBA(mz+#At>yb9O#^B.<8FMp$(b+!+0Tw*n(`4M-*LZJ');
define('LOGGED_IN_KEY', 'N5M$t~MIu!B%R<Xb=^|+77^2iz)hXrip[Rhz|&XX,`rz/=.IPC(3MA/Rju31VdV{');
define('NONCE_KEY', '2S!e~F0(@Jpfzr~UQ)T=hUNk|iGxA;=p-XUPam#4KY7rpe%c)jCk2do&BGDasq8H');
define('AUTH_SALT', '^]{][0{0t1}~R&W)WHiRZ0x%d&Opr&4fVBiC1+Tv:-`:.HJ+a4wTR*iYFhYXTv#q');
define('SECURE_AUTH_SALT', '*{H/zQ@=+di<?+T}Hxdhe]oj(k?~$vexll0q2sl_X%%NoY_s(pR`|FC+DhJ|kRe[');
define('LOGGED_IN_SALT', 'K:#[KEEjF<^/4#wAYOe%)f#_[=}=29?w}[]C)SXKZ!{c0n}[YkvcbSEpjMw72LB(');
define('NONCE_SALT', ')i$kU<6%VnNDl%i.Q~!>6e-C`gX81o}k@H>gqPqmhRi}dHZ&.FYpmO6,M&sM<FzP');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('FS_METHOD','direct');
