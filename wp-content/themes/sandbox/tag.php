<?php get_header() ?>
  <div id="middle" class="doc">
    <div id="left-menu" class="aside"><?php get_sidebar(); ?></div><!-- #left-menu .aside -->
    <div id="content" class="section">
<div id="headline"><?php single_tag_title(__('Currently browsing ', 'sandbox')); ?>.</div>

		<?php while (have_posts()) : the_post(); ?>
			<h1 class="h1 headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="			<?php printf(__('Permalink to %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>"><?php the_title(); ?></a></h1>
			<div class="entry-date"><?php unset($previousday); printf( __( '%1$s &#8211; %2$s', 'sandbox' ), the_date( '', '', '', false ), get_the_time() ) ?></div>
			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">

				<div class="entry-content">
			<?php the_content( __( 'Read More <span class="meta-nav">&raquo;</span>', 'sandbox' ) ) ?>
			<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'sandbox' ) . '&after=</div>') ?>
		</div>
		<div class="h4 meta">
			<span class="author vcard"><?php printf( __( 'By %s', 'sandbox' ), '<a class="url fn n" href="' . get_author_link( false, $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( __( 'View all posts by %s', 'sandbox' ), $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></span>
			<span class="meta-sep">|</span>
			<?php the_tags( __( '<span class="tag-links">Tagged ', 'sandbox' ), ", ", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?><?php edit_post_link( __( 'Edit', 'sandbox' ), "\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Comments (0)', 'sandbox' ), __( 'Comments (1)', 'sandbox' ), __( 'Comments (%)', 'sandbox' ) ) ?></span>
		</div><!-- .h4 meta -->
			</div><!-- .post -->

<?php endwhile; ?>

<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_footer() ?>