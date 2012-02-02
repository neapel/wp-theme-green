<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */

get_header(); ?>
<section id="primary">
	<div id="content" role="main">
		<header class="page-header">
			<h1 class="page-title"><?php
				$y = get_the_time('Y');
				$m = get_the_time('m');
				$d = get_the_time('d');
				if ( is_day() ) { ?>
					<? _e('Daily Archives:') ?>
					<span>
						<?php the_time('j.') ?>
						<a href="<?php echo get_month_link($y,$m) ?>" title="<?php echo __('Show all posts of this month', 'toolbox') ?>"><?php the_time('F') ?></a>
						<a href="<?php echo get_year_link($y) ?>" title="<?php echo __('Show all posts of this year', 'toolbox') ?>"><?php the_time('Y') ?></a>
				<?php } else if ( is_month() ) { ?>
					<? _e('Monthly Archives:') ?>
					<span>
						<?php the_time('F') ?>
						<a href="<?php echo get_year_link($y) ?>" title="<?php echo __('Show all posts of this year', 'toolbox') ?>"><?php the_time('Y') ?></a>
					</span>
				<?php } else if ( is_year() ) {
					printf( __( 'Yearly Archives: %s', 'toolbox' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
				} else {
					_e( 'Archives', 'toolbox' );
				}
			?></h1>
		</header>
		<?php toolbox_post_list() ?>
	</div>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
