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

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'micro-dim');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'mysql');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY', '0K<iE>pr8^ S^$?<M3G~f8LG&z ^.h+LF9fZ;2!|Hj-yN@i]p*~lNA>yrvv;p8C['); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', ' rfT%_X[Ca.L^,xc^.1yM9iXDmO(A`aZB3i1bc3UMKE@-wyPrtZA+8}?5-!1l;uY'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', 'Cd)`6c`v!2V 5j}u2-zNZ?!4]gHxl Y5UH04JUd#>+e5dr!)iLyS-M7U)f5[c2!R'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', ',lg^KY}IN3W4PY`K&m,%iZ$Qj4?v=l&9;4F0.KoKi$GU!ygs>/iNwn{=;J<J>5W1'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', 'Msoew-(NB5YSo}XViEN>Q@Z]VN)OacR} m:`~CLa`vY/0u~Djc}qhsU={ xUK#}{'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', '0P8C%W^9y$pYRIWls g<{I1<Aqy#|_bD/t7kID/}T1/osR_^:Og%$hl(91o9DMqS'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', '[B%wrYEtsJ=6OY<7CadX,_DzwAm ]<{x*L!Ck&d^lDCLUL1C0p3k;l=iUQ-heNSm'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', 'J0k=83s:cKY.wlYT:olj]u2oeXPaW-i}TsdStWM8XysLV?)0 (i*HEcscC=|8mGL'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
define('WPLANG', 'es_ES');

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', true);


/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
