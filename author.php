<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */

get_header(); ?>
<section id="primary">
	<div id="content" role="main">
		<?php the_post() ?>
		<header class="page-header">
			<h1 class="page-title author"><?php printf( __( 'All posts by %s', 'jan1' ), '<span>' . get_the_author() . '</span>' ); ?></h1>
		</header>
		<?php toolbox_post_list(); ?>
	</div>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
