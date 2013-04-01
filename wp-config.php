<?php
/** 
 * A WordPress fő konfigurációs állománya
 *
 * Ebben a fájlban a következő beállításokat lehet megtenni: MySQL beállítások
 * tábla előtagok, titkos kulcsok, a wordpress nyelve, és ABSPATH.
 * További információ a fájl lehetséges opcióiról angolul itt található:
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php} 
 *  A MySQL beállításokat a szolgáltatódtól kell kérned.
 *
 * Ebből a fájlból készül el a telepítési folyamat közben a wp-config.php
 * állomány. Nem kötelező webes telepítés használata, elegendő átnevezni 
 * "wp-config.php" névre, és kitölteni az értékeket.
 *
 * @package WordPress
 */

// ** MySQL beállítások - Ezeket a szolgálatótól lehet beszerezni ** //
/** Adatbázisod neve */
define('DB_NAME', 'openscope-org');

/** MySQL felhasználóneved */
define('DB_USER', 'openscope-org');


/** MySQL jelszó. */
define('DB_PASSWORD', 'xxx');

/** MySQL  kiszolgáló neve */
define('DB_HOST', 'localhost');

/** Az adatbázis karakter kódolása */
define('DB_CHARSET', 'utf8');

/** Az adatbázis egybevetése */
define('DB_COLLATE', '');

/**#@+
 * Bejelentkezést tikosító kulcsok
 *
 * Változtasd meg a lenti konstansok értékét egy-egy tetszóleges mondatra
 * Generálhatsz is ilyen kulcsokat a {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org titkos kulcs szolgáltatásával}
 * Ezeknek a kulcsoknak a módosításával bármikor kiléptethető az összes bejelentkezett felhasználó az oldalról. 
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '(OR4$-44oz^JWLPB-*+~t3_0jBN=(}*oZ?41`D0`?u@tOxH)Z=j{X>5f5$$B$jMb');
define('SECURE_AUTH_KEY', ',#h!f@7p$[5IgqT&h9jKZd=U+ZxY#b7J>-.Zva+|S$yy-yA>!]TC+(c=BUNR7Q8?');
define('LOGGED_IN_KEY', ',j[T:-:UvGa`]:D`^2o`u-Xl}.UiDc.|%-t-O1[,Gy;,f1${yC4GzR{lrEr@$5]5');
define('NONCE_KEY', 'iMeN!$?@k=g{{aN`]a-@8I*)kN)5_*l0bX`txn.:3M%_9!I0T3p_%K0*}sT;@jVO');
define('AUTH_SALT',        'gk1M&>s-s!ZZNTI+DP4IJ@ba`3e$K&0-@IqaZ-se4TJN;obNo1fL::< ViG%4gR1');
define('SECURE_AUTH_SALT', 'WCLv)N$+lu>{-vT6`+}U8&>y,U<;o(GAGt=:k=fp/YLyLfo(;ozC@c;E5#I-sXPj');
define('LOGGED_IN_SALT',   'U7nV^vhb(RP>e97ru)k+zZ-)kQad!$}=L)w!l=-euDo0i<<Sm5>eTU4U9U: -ZgK');
define('NONCE_SALT',       'y*&w1nOjlv+*&s>%PzZ,A)Mp*]B3,T6|ae]i:aT^BU.fA]-mLnPe^$51^Z{zIy^E');

/**#@-*/

/**
 * WordPress Adatbázis tábla előtag.
 *
 * Több blogot is telepíthetünk egy adatbázisba, ha valamennyinek egyedi
 * előtagot adunk. Csak számokat, betűket és alulvonásokat adhatunk meg.
 */
$table_prefix  = 'os_';

/**
 * WordPress nyelve. Ahhoz, hogy magyarul működjön az oldal, ennek az értéknek
 * 'hu_HU'-nak kell lennie. Üresen hagyva az oldal angolul fog megjelenni.
 *
 * A beállított nyelv .mo fájljának telepítve kell lennie a wp-content/languages
 * könyvtárba. Ahogyan ez a magyar telepítőben alapértelmezetten benne is van.
 *  
 * Például: be kell másolni a hu_HU.mo fájlt a wp-content/languages könyvtárba, 
 * és be kell állítani a WPLANG konstanst 'hu_HU'-ra, 
 * hogy a magyar nyelvi támogatást bekapcsolásra kerüljön.
 */

define ('WPLANG', 'hu_HU');

/**
 * Fejlesztőknek: WordPress hibakereső mód.
 *
 * Engedélyezzük ezt a megjegyzések megjelenítéséhez a fejlesztés során. 
 * Erősen ajánlott, hogy a bővítmény és sablon fejlesztők használják a WP_DEBUG
 * konstansot.
 */
define('WP_DEBUG', false);
define('WP_ALLOW_MULTISITE', true);

define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'openscope.org' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

define( 'SUNRISE', 'on' );
/* Ennyi volt, kellemes blogolást! */

/** A WordPress könyvtár abszolút elérési útja. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Betöltjük a WordPress változókat és szükséges fájlokat. */
require_once(ABSPATH . 'wp-settings.php');
