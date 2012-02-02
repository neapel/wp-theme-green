<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */

get_header(); ?>
<section id="primary">
	<div id="content" role="main">
		<header class="page-header">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'jan1' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		</header>
		<?php if ( have_posts() ) {
			while(have_posts()) {
				the_post();
				get_template_part( 'content', 'search' );
			}
			toolbox_content_nav( 'nav-below' );
		} else ?>
		<article id="post-0" class="post no-results not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Nothing Found', 'jan1' ); ?></h1>
			</header>
			<div class="entry-content">
				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'jan1' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</article>
		<?php } ?>
	</div>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
