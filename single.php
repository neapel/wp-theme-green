<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */
get_header();
?>
		<section id="primary">
			<div id="content" role="main"><?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content', 'single' );
					toolbox_content_nav( 'nav-below' );
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				}
			?></div>
		</section>
<?php
get_sidebar();
get_footer();
?>
