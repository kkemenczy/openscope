<?php get_header();?>
<?php genesis_before_content_sidebar_wrap(); ?>
<div id="content-sidebar-wrap">

	<?php genesis_before_content(); ?>
	<div id="content">
	
	<?php genesis_before_loop(); ?>
		
		<?php genesis_before_post(); ?>
		<div class="post hentry">

			<h1 class="entry-title"><?php _e('Not Found, Error 404', 'genesis'); ?></h1>
			<div class="entry-content">
				<p><?php printf(__('The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it with the information below.', 'genesis'), get_bloginfo('url')); ?></p>
			</div>

			<div class="archive-page">

				<h2><?php _e("Authors:", 'genesis'); ?></h2>
				<ul>
					<?php wp_list_authors('exclude_admin=0&optioncount=1&show_fullname=true'); ?>   
				</ul>


<!--
				<?php if ( $pagelist = wp_list_pages('echo=0&title_li=') ) : ?> 
				<h4><?php _e('Pages:', 'genesis'); ?></h4> 
				<ul> 
					<?php echo $pagelist; ?> 
				</ul> 
				<?php endif; ?>

				<h4><?php _e("Categories:", 'genesis'); ?></h4>
				<ul>
					<?php wp_list_categories('sort_column=name&title_li='); ?>
				</ul>
-->
			</div><!-- end .archive-page-->

			<div class="archive-page">
<!--
				<h4><?php _e("Monthly:", 'genesis'); ?></h4>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
-->
				<h2><?php _e("Recent Posts:", 'genesis'); ?></h2>
				<ul>
					<?php wp_get_archives('type=postbypost&limit=10'); ?> 
				</ul>	

			</div><!-- end .archive-page-->
								
		</div><!-- end .postclass -->
		<?php genesis_after_post(); ?>

	<?php genesis_after_loop(); ?>
	
	</div><!-- end #content -->
	<?php genesis_after_content(); ?>

</div><!-- end #content-sidebar-wrap -->
<?php genesis_after_content_sidebar_wrap(); ?>

<?php get_footer(); ?>