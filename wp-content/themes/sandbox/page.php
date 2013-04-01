<?php get_header() ?>
	<div id="middle" class="doc">
	<div id="left-menu" class="aside"><?php get_sidebar(); ?></div><!-- #left-menu .aside -->
    	<div id="content" class="section">
			<?php the_post() ?>
			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h1 class="h1 headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permalink to %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>"><?php the_title(); ?></a></h1>
				<div class="entry-content">
					<?php the_content() ?>
					<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'sandbox' ) . '&after=</div>') ?>
					<?php edit_post_link( __( 'Edit', 'sandbox' ), '<span class="edit-link">', '</span>' ) ?>

				</div><!-- .entry-content -->
			</div><!-- .post -->
			<?php if ( get_post_custom_values('comments') ) comments_template() // Add a key+value of "comments" to enable comments on this page ?>
		</div><!-- #content  .section-->
	</div><!-- #mindke.doc -->
<?php get_footer() ?>
