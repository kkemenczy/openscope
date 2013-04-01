<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); // support for comment threading ?>
<?php wp_head() // For plugins ?>
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
</head>

<body>
<div id="wrapper">
	<div id="header">
		<div id="header-left">
		  <a href="<?php bloginfo('home') ?>/" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" rel="home" /></a>
		  <h1><?php bloginfo('description') ?></h1>
		</div><!-- header-left -->
		<div id="header-right">
			<div id="header-login">
				<ul class="nav"> <?php wp_register() ?> &nbsp; <li><?php wp_loginout() ?></li></ul>
				<form method="get" action="<?php bloginfo('home') ?>">
					<div id="header-search">
						<input id="s" name="s" type="text" class="text" value="<?php the_search_query() ?>" size="10" tabindex="1" />
						<input class="submit" type="submit" class="button" value="<?php _e( 'Find', 'sandbox' ) ?>" tabindex="2" />
					</div>
				</form>
			</div><!-- #header-login -->
		</div><!-- #header-right -->
	</div><!--  #header -->
	<div id="header-bottom">
		<div id="header-bottom-navigation" class="navigation">
			<ul>
				<li id="" class="plain"><a title="Ugrás a kezdőlapra" href="http://hu.openoffice.org/"><span>Kezdőlap</span></a></li>
				<li id="" class="th"><a title="" href="#"><span>Hírek</span></a></li>
				<li id="" class="plain"><a title="Az OpenOffice.org letöltése" href="http://hu.openoffice.org/about-downloads.html"><span>Letöltés</span></a></li>
                <li id="" class="plain"><a title="Kiterjesztések" href="http://www.openoffice.hu/kiterjesztesek"><span>Kiterjesztések</span></a></li>
				<li id="" class="plain"><a title="OpenOffice.org Közösségi Fórum" href="http://user.services.openoffice.org/hu/forum/index.php"><span>Fórum</span></a></li>
				<li id="" class="plain"><a title="OpenOffice.org felhasználói levelezőlista" href="http://www.openoffice.hu/cgi-bin/mailman/listinfo/forum"><span>Levlista</span></a></li>
				<li id="" class="plain"><a title="Az OpenOffice.org-gal kapcsolatos hibák bejelentése" href="http://hu.openoffice.org/about-issues.html"><span>Hibabejelentés</span></a></li>
				<li id="" class="plain"><a title="Dokumentáció" href="http://hu.openoffice.org/about-documentation.html"><span>Dokumentáció</span></a></li>
				<li id="" class="plain"><a title="Az OpenOffice.org bemutatása" href="http://hu.openoffice.org/about-product.html"><span>Bemutatás</span></a></li>
				<li id="" class="plain"><a title="OpenOffice.org Wiki" href="http://wiki.services.openoffice.org/wiki/Category:Magyar"><span>Wiki</span></a></li>
			</ul>
		</div><!-- #header-bottom-navigation -->
	</div><!-- #header-bottom -->