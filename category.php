<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */

get_header(); ?>
<section id="primary">
	<div id="content" role="main">
		<header class="page-header">
			<h1 class="page-title"><?php
				printf( __( 'Category Archives: %s', 'jan1' ), '<span>' . single_cat_title( '', false ) . '</span>' );
			?></h1>
			<?php
				$category_description = category_description();
				if ( ! empty( $category_description ) )
					echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
			?>
		</header>
		<?php toolbox_post_list() ?>
	</div>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
