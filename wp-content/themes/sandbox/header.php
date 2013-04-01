<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
<?php wp_head() // For plugins ?>
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
        <link rel="icon" href="/picture/mozilla-16.png" type="image/png" />
</head>
<body>
  <div id="header-bar" class="header">
    <div class="doc">
      <div class="logo">
        <img src="<?php bloginfo('template_directory'); ?>/images/logo/dino.png" class="dino" alt="" />
        <img src="<?php bloginfo('template_directory'); ?>/images/logo/mozilla.png" class="mozilla" alt="mozilla" />
        <span>community website</span>
      </div><!-- .logo -->
      <ul class="nav">
        <li>
			<form id="searchform" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
					<input id="hb-searchinput" name="s" type="text" class="text" value="<?php the_search_query() ?>" tabindex="1" />
					<input type="submit" id="hb-searchbutton" value="<?php _e( '&#9658;', 'sandbox' ) ?>" tabindex="2" />
			</form>
        </li>
        <li><?php wp_register() ?></li>
        <li><?php wp_loginout() ?></li>
      </ul>
    </div><!-- .doc -->
  </div><!-- #header-bar .header -->
  <div id="header" class="header">
    <div class="doc">
      <a href="<?php bloginfo('home') ?>/" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" rel="home">
        <img src="<?php bloginfo('template_directory'); ?>/images/logo/mctlogo.png" id="logo" alt="" />
        <span id="title"><?php bloginfo('name') ?></span>
      </a>
      <span id="sub-title"><?php bloginfo('description') ?></span>
<span id="header-rss">
	<a class="rss" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" rel="alternate" type="application/rss+xml"><?php _e( 'Blog entries', 'sandbox' ) ?></a>
        <a class="rss" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" rel="alternate" type="application/rss+xml"><?php _e( 'Comments', 'sandbox' ) ?></a>
        <a class="twitter" href="http://twitter.com/MozillaHU" title="Kövesse a Mozilla híreit twitteren">Twitter</a>
</span>
    </div><!-- .doc -->
  </div><!-- #header .header -->