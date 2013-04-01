<?php
/**
 * This file adds the Portfolio template to our Child Theme.
 *
 * @author Greg Rickaby
 * @package Child
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

// Add custom body class to the head
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
   $classes[] = 'landing';
   return $classes;
}

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' ); // Force Full-Width Layout
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' ); // Removes breadcrumbs
remove_action( 'genesis_post_title','genesis_do_post_title' ); // Removes post title
remove_action( 'genesis_post_content', 'genesis_do_post_content' ); // Removes content
add_action( 'genesis_post_content', 'child_do_content' ); // Adds your custom page code/content

// Do Custom Content
function child_do_content() { ?>

<h1>Termékek</h1>
<p>A Mozilla számos termékkel és projekttel támogatja a <a href="http://www.mozilla.org/about/manifesto.hu.html" target="_new">Mozilla Manifesto</a> által kitűzött célokat. További <span class="lighttext"><a href="http://www.mozilla.org/products/" target="_new">termékek és projektek »</a></span></p>

<ul>
	<li>
		<a href="//affiliates.mozilla.org/link/banner/22100" target="_new"><img src="http://firefox.hu/files/2013/03/badge-firefox-252x134.jpg" alt="badge-firefox" width="252" height="134" class="alignnone size-medium wp-image-4260" />
		<h3>Firefox</h3>
		<p>Ingyenes, non-profit böngésző.</p></a>
	</li>
	<li>
		<a href="http://www.mozilla.org/firefox/partners/" target="_new"><img src="http://firefox.hu/files/2013/03/badge-firefoxos-252x134.jpg" alt="badge-firefoxos" width="252" height="134" class="alignnone size-medium wp-image-4261" />
		<h3>Firefox OS</h3>
		<p>Nyílt operációs rendszer mobil eszközökhöz.</p></a>
	</li>
	<li>
		<a href="http://www.mozilla.org/thunderbird/" target="_new"><img src="http://firefox.hu/files/2013/03/badge-thunderbird-252x134.jpg" alt="badge-thunderbird" width="252" height="134" class="alignnone size-medium wp-image-4262" />
		<h3>Thunderbird</h3>
		<p>Biztonságos, gyors levelezőprogram.</p></a>
	</li>
</ul>

<h1>Közösség</h1>
<p>Számtalan módon segíthetsz, csatlakozzon a Mozilla közösségéhez. Nem kell programozónak lenned, <strong>elég ha szereted az internetet</strong>.</p>

<ul>
	<li>
		<a href="https://support.mozilla.org/hu/get-involved" target="_new"><img src="http://firefox.hu/files/2013/04/mozilla-hu-sumo.jpg" alt="badge-firefox" width="252" height="134" class="alignnone size-medium wp-image-4260" />
		<h3>SUMO</h3>
		<p>Vegyél részt a tudásbázis fordításában.</p></a>
	</li>
	<li>
		<a href="https://webmaker.org" target="_new"><img src="http://firefox.hu/files/2013/03/badge-webmaker.jpg" alt="badge-firefoxos" width="252" height="134" class="alignnone size-medium wp-image-4261" />
		<h3>Webmaker</h3>
		<p>Vegyél részt a jövő nemzedékének oktatásában.</p></a>
	</li>

</ul>

<h1>Kapcsolat</h1>
<p>Ha elakadtál, vedd fel velünk a <a href="/kapcsolat/" target="_new">kapcsolatot</a>.</p>	

<?php }
genesis();