<?php
/**
 * WARNING: This file is part of the core Genesis framework. DO NOT edit
 * this file under any circumstances. Please do all modifications
 * in the form of a child theme.
 *
 * This file handles posts, but only exists for the sake of
 * child theme forward compatibility.
 */
/* genesis(); */
 
	get_header();

	genesis_before_content_sidebar_wrap();
	?>
	<div id="content-sidebar-wrap">
		<?php genesis_before_content(); ?>
		<div id="content" class="hfeed">
			<?php
				genesis_before_loop(); ?>


			<?php	genesis_loop();
				genesis_after_loop();
			?>
		</div><!-- end #content -->
		<?php genesis_after_content(); ?>
	</div><!-- end #content-sidebar-wrap -->
	<?php
	genesis_after_content_sidebar_wrap();

	get_footer();
?>