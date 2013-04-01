<?php

//Child Theme Language override
define('GENESIS_LANGUAGES_DIR', STYLESHEETPATH.'/languages');
define('GENESIS_LANGUAGES_URL', STYLESHEETPATH.'/languages');

require_once(TEMPLATEPATH.'/lib/init.php');

// Add support for custom background
if (function_exists('add_custom_background')) {
	add_custom_background();
}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Change the header **/
remove_action( 'genesis_header', 'genesis_do_header' );
add_action( 'genesis_header', 'mozilla_do_header' );

function mozilla_do_header() {
	echo '<div id="title-area">';
	echo '<div id="mozilla-header">';
	echo '<a class="mozilla-logo" href="http://firefox.hu/">visit <span>mozilla</span></a>';
	do_action( 'genesis_site_title' );
	do_action( 'genesis_site_description' );
	echo '<a class="mozilla" href="http://www.mozilla.org/">visit <span>mozilla</span></a></div>';
	echo '</div><!-- end #title-area -->';

	if ( is_active_sidebar( 'header-right' ) || has_action( 'genesis_header_right' ) ) {
		echo '<div class="widget-area">';
		do_action( 'genesis_header_right' );
		dynamic_sidebar( 'header-right' );
		echo '</div><!-- end .widget-area -->';
		}
	}

/** Customize the post info function */
add_filter( 'genesis_post_info', 'mozilla_post_info_filter' );
function mozilla_post_info_filter($post_info) {
global $post;
$categories = get_the_category( $post->ID );
$category = $categories[0]->slug;
$src = '/files/picture/logo/' . $category . '.png';
$category_image = '<img class="post-category-image" src="'. $src .'">';

if (!is_page()) {
    if (is_single()) {
//        $post_info = $category_image . '<p>[post_date] [post_author_posts_link] [post_tags] [post_edit]</p>';
        $post_info = $category_image . '<p>[post_date] [post_tags] [post_edit]</p>';
    } else {
//        $post_info = $category_image . '<p>[post_author_posts_link] [post_tags] [post_edit]</p>';
        $post_info = $category_image . '<p>[post_tags] [post_edit]</p>';
    }
    
    return $post_info;
}

}

// remove post meta
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );

// add post date before post title
remove_action( 'genesis_before_post_title', 'genesis_do_post_format_image' );
add_action( 'genesis_before_post_title', 'mozilla_before_post_title_filter' );
function mozilla_before_post_title_filter() {
    echo the_date('Y.m.d, l', '<span class="post-date">', '</span>');
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


add_action('genesis_before_content_sidebar_wrap', 'promote_post');
function promote_post() {
 if(is_home()) {
//	echo '[promoslider numberposts='3' post_type='post' category='promoted' time_delay="10"]';
 }
}





/** Add after post widgeted area */
add_action( 'genesis_before_content', 'child_after_post_area', 9 );
function child_after_post_area() {
    echo '<div class="right-widget">';
      dynamic_sidebar( 'right widget area' );
    echo '</div>';
}

genesis_register_sidebar( array(
	'id'		=> 'right-widget-area',
	'name'		=> __( 'Right Widget Area' ),
	'description'	=> __( 'Right widget area on main page' ),
) );


/** Add after post widgeted area */
add_action( 'genesis_after_content', 'child_after_content_area', 9 );
function child_after_content_area() {
    echo '<div class="bottom-widget">';
      dynamic_sidebar( 'bottom widget area' );
    echo '</div>';
}

genesis_register_sidebar( array(
	'id'		=> 'bottom-widget-area',
	'name'		=> __( 'Bottom Widget Area' ),
	'description'	=> __( 'Bottom widget area' ),
) );

?>