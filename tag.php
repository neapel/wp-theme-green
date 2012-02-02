<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */

get_header(); ?>
<section id="primary">
	<div id="content" role="main">
		<header class="page-header">
			<h1 class="page-title"><?php
				printf( __( 'Tag Archives: %s', 'jan1' ), '<span>' . single_tag_title( '', false ) . '</span>' );
			?></h1>
			<?php
				$tag_description = tag_description();
				if ( ! empty( $tag_description ) )
					echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
			?>
		</header>
		<?php toolbox_post_list() ?>
	</div>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
