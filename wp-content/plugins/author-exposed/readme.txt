=== Author Exposed ===
Contributors: Igor Penjivrag
Tags: author, exposed, authorexposed, wp, info
Requires at least: 2.0
Tested up to: 3.0
Stable tag: 1.1

Simple and elegant way to display post author info (full name, website, description ...)

== Description ==


This plugin does the same thing as the the_author tag, displays the author name, only this time it's linked to hidden layer (div). By clicking on the author link the hidden layer(div) pop's up with author info gathered from the profile page, plus gravatar photo (if author email is assigned with one).

*   xhtml,css valid.
*   Tested in FF, Opera, IE6/7, Chrome and Safari.
*   Comes with separate css file for easier modification.

You can see the plugin in use by [clicking here](http://colorlightstudio.com/2010/06/01/wordpress-plugin-author-exposed-v-1-1/).


== Installation ==

Installation is simple and should not take you more than 2 minutes.

1. Upload 'author-exposed' folder to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. That's it! Although you might need to place (if you haven't already or if it's not included in your theme) `<?php the_author_posts_link(); ?>` where you want the author link to appear (must be inside the loop)


== Frequently Asked Questions ==

none


== Changelog ==

= 1.1 =
* Fixed wp auto installation.
* Changed dir name.
* Used hook to replace wp function - author posts link.
* Fixed z-index issue.


== Upgrade Notice ==

= 1.1 =
Upgrade to version 1.1 in order for plugin to work properly.