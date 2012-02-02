<?php
/**
 * Template Name: Full-width, no sidebar
 * Description: A full-width template with no sidebar
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */

get_header(); ?>
<section id="primary" class="full-width">
	<div id="content" role="main"><?php
		while( have_posts() ) {
			the_post();
			get_template_part('content', 'page');
			comments_template('', true);
		}
	?></div>
</section>
<?php get_footer(); ?>
