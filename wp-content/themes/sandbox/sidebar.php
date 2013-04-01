
<?php $my_query = new WP_Query('cat=23'); ?>

<div id="facebook" class="sidebox" style="height: 250px;">
<?php facebook_fan_box('35dcb95fadda6d84e4dd3d5b9514ea44', '372155461478', '0', '20', '250', '', '0', '450', '0', 'hu_HU'); ?>
</div><!-- #facebook.sidebox -->

<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
   <div id="news" class="sidebox">
   <h3><?php the_title(); ?></h3>
   <?php the_content() ?>
</div><!-- #news.sidebox -->
<?php endwhile; ?>

<div id="download" class="sidebox">
<h3><?php _e( 'Download', 'sandbox' ) ?></h3>
<div style="padding: 10px 0 10px 15px;">
<img src="/files/picture/firefox-16x16.png" alt="icon">&nbsp;<a href="http://www.mozilla-europe.org/hu/firefox/">Firefox</a><br />
<img src="/files/picture/thunderbird-16x16.png" alt="icon">&nbsp;<a href="http://www.mozilla-europe.org/hu/products/thunderbird/">Thunderbird</a><br />
<img src="/files/picture/seamonkey-16x16.png" alt="icon">&nbsp;<a href="/seamonkey/">SeaMonkey</a><br />
<img src="/files/picture/calendar-16x16.png" alt="icon">&nbsp;<a href="https://addons.mozilla.org/hu/thunderbird/addon/2313">Lightning</a><br />
<img src="/files/picture/pgp-16x16.png" alt="icon">&nbsp;<a href="/enigmail/">Enigmail</a><br />
<img src="/files/picture/bluegriffon-16x16.png" alt="icon">&nbsp;<a href="/bluegriffon/">BlueGriffon</a><br />
<img src="/files/picture/hunspell-16x16.png" alt="icon">&nbsp;<a href="https://addons.mozilla.org/hu/firefox/addon/3386">Magyar helyesírás-ellenőrző szótár</a>
</div>
</div><!-- #download.sidebox -->


<div id="tagcloud" class="sidebox">
	<p><?php wp_tag_cloud(''); ?></p>
</div><!-- #tagcloud -->

<div id="rssbox" class="sidebox">
<h3><?php _e( 'Twitter', 'sandbox' ) ?></h3>
<p><?php include_once(ABSPATH.WPINC.'/rss.php'); wp_rss('http://twitter.com/statuses/user_timeline/41556764.rss', 5); ?></p>
<h3><?php _e( 'Mozilla Europe RSS', 'sandbox' ) ?></h3>
<p><?php include_once(ABSPATH.WPINC.'/rss.php'); wp_rss('http://mozilla-europe.org/hu/news.rdf', 5); ?></p>
<h3><?php _e( 'HUP Mozilla RSS', 'sandbox' ) ?></h3>
<p><?php include_once(ABSPATH.WPINC.'/rss.php'); wp_rss('http://hup.hu/taxonomy/term/22/0/feed', 5); ?></p>
</div><!-- #rssbox -->

<div id="rssbox" class="sidebox">
	<h3><?php _e( 'Archives', 'sandbox' ) ?></h3>
	<p style="font-size:90%"><?php arl_kottke_archives('.','m') ?></p>
</div><!-- #archives .sidebox -->