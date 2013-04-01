<?php
/**
 * Template Name: Scope
 */

?>
	<div <?php post_class(); ?>>
                    
		<?php genesis_before_post_title() ; ?>
		<?php genesis_post_title(); ?>
		<?php genesis_after_post_title(); ?>

		<?php genesis_before_post_content(); ?>
		<div class="entry-content">
			<?php genesis_do_post_content(); ?>
		</div><!-- end .entry-content -->
		<?php genesis_after_post_content(); ?>

	</div><!-- end .postclass -->
	<?php genesis_after_post(); ?>

	</div><!-- end .postclass -->

