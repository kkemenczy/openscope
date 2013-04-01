<?php

//Child Theme Language override
define('GENESIS_LANGUAGES_DIR', STYLESHEETPATH.'/languages');
define('GENESIS_LANGUAGES_URL', STYLESHEETPATH.'/languages');

require_once(TEMPLATEPATH.'/lib/init.php');

// Add support for custom background
if (function_exists('add_custom_background')) {
	add_custom_background();
}

// Modify credits section
add_filter('genesis_footer_creds_text', 'custom_footer_creds_text');
function custom_footer_creds_text($creds) {
    $creds = '<a href="/kapcsolat/">Kapcsolat</a> &ndash; <a href="/adatvedelmi-iranyelvek/">Adatvédelmi irányelvek</a> &ndash; <a href="/impresszum/">Impresszum</a> &ndash; <a href="/felhasznált-bovitmenyek/">Felhasznált bővítmények</a><br />A LibreOffice név, ikon és logo kivételével a tartalom és a hírek felhasználási feltételei: <a href="http://creativecommons.org/licenses/by/2.5/hu/">Creative Commons Nevezd meg!</a>.';
    return $creds;
} 

// Modify get-to-top footer
add_filter('genesis_footer_backtotop_text', 'custom_footer_backtotop_text');
function custom_footer_backtotop_text($backtothetop) {
    $backtothetop = '<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"><img alt="Creative Commons License" style="border-width:0; vertical-align: middle" src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png" width="88" height="31" /></a>';
    return $backtothetop;
} 

// Modify the author box title
 add_filter('genesis_author_box_title', 'child_author_box_title');
 function child_author_box_title() {
    return '<strong>A cíkk szerzőjéről</strong>';
}

// Custom sticky id for sticky posts
add_action('genesis_before_post_title', 'featured_text');
function featured_text(){
if (is_sticky()) {
   echo '<div id="sticky-before-header">Kiemelt hír</div>';}
}

// Custom post navigation on single pages
add_action('genesis_before_comments', 'custom_post_nav');
function custom_post_nav(){
echo '<div class="post-nav">';
echo '<div class="next-post-nav">';
echo '<span class="next">';
echo 'Következő';
echo '</span>';
echo next_post_link('%link', '%title');
echo '</div>';
echo '<div class="prev-post-nav">';
echo '<span class="prev">';
echo 'Előző';
echo '</span>';
echo previous_post_link('%link', '%title');
echo '</div>';
echo '</div>';
}

// Custom before post content hook
add_action('genesis_before_post_content', 'community_links');
function community_links(){

if (is_single()) {
   echo '<div>&nbsp;</div><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="libreoffice">Csirip</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script><script type="text/javascript" src="http://connect.facebook.net/hu_HU/all.js#xfbml=1"></script><fb:like show_faces="true" width="450"></fb:like>';}
}

// Custom post meta
add_filter('genesis_post_meta', 'custom_post_meta');
function custom_post_meta(){

   echo '<div class="post-meta">';
   echo the_tags('Címkék:', ', ', '');
   if(function_exists('the_views')) { echo '&nbsp; &ndash; &nbsp;'; echo the_views(); };
   echo '</div>';}

// image shortcode for writers
add_shortcode('logo', 'logo_shortcode');
function logo_shortcode($atts) {
	
	$defaults = array(
		'pic' => 'libreoffice.jpg',
		'class' => 'logopicture',
		'path' => '/wp-content/themes/libreoffice/images/libreoffice/logo/',
		'alt' => 'LibreOffice',
	);
	$atts = shortcode_atts( $defaults, $atts );
	
	$output = sprintf( '<img src="%3$s%1$s" class="%2$s" alt="%4$s" title="%4$s logo" /> ', $atts['pic'], $atts['class'], $atts['path'], $atts['alt']);
	
	return apply_filters('logo_shortcode', $output, $atts);
}

// download shortcode for writers
add_shortcode('download', 'download_shortcode');
function download_shortcode($atts) {
	
	$defaults = array(
		'spanclass' => 'download',
		'picfile' => 'download_20.png',
		'picclass' => 'downloadpic',
		'path' => '/wp-content/themes/libreoffice/images/libreoffice/',
		'alt' => 'letöltés',
		'href' => 'http://www.documentfoundation.org/download',
		'linkclass' => 'linkclass',
		'text' => '',
		'divclass' => 'download-div-class',
	);
	$atts = shortcode_atts( $defaults, $atts );
	
	$output = sprintf( '<div class="%9$s"><span class="%1$s"><img class="%3$s" src="%4$s%2$s" alt="%5$s" title="%5$s" /></span><span class="%7$s"><a href="%6$s" rel="external">%8$s</a></span></div>', $atts['spanclass'], $atts['picfile'], $atts['picclass'], $atts['path'], $atts['alt'], $atts['href'], $atts['linkclass'], $atts['text'], $atts['divclass']);
	
	return apply_filters('download_shortcode', $output, $atts);
}


//Custom login logo
function fb_custom_login_logo() {
$style = '<style type="text/css"> h1 a { background: transparent url(/wp-content/themes/libreoffice/images/logo.png) no-repeat center top !important; } </style>';
echo $style;
 }
add_action( 'login_head', 'fb_custom_login_logo' );

// Custom login header title
function fb_login_headertitle() {
$name = get_option('blogname');
echo $name;
}
add_filter( 'login_headertitle', 'fb_login_headertitle' );

function fb_login_headerurl() {
echo 'http://new.libreoffice.hu';
}
add_filter( 'login_headerurl', 'fb_login_headerurl' );



//Exclude English category from the homepage
add_filter('pre_get_posts', 'exclude_category_from_home');
function exclude_category_from_home($query) {
if ( $query->is_home ) {
$query->set('cat', '-149');
}
return $query;
}  

//Allow upload different kind of filetypes
add_filter( 'upload_mimes', 'custom_upload_mimes' );

function custom_upload_mimes( $existing_mimes=array() ) {
    $existing_mimes['sla'] = 'application/sla';
    return $existing_mimes;
}

?>