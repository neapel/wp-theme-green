<?php
/**
 * @package Toolbox
 */
$is_post = 'post' == get_post_type();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'toolbox' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php if ($is_post) { ?>
			<div class="entry-meta"><?php toolbox_posted_on(); ?></div>
		<?php } ?>
	</header>
	<?php if ( is_search() ) { // Only display Excerpts for Search ?>
		<div class="entry-summary hyphenate"><?php the_excerpt(); ?></div>
	<?php } else { ?>
		<div class="entry-content hyphenate"><?php
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'toolbox' ) );
wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'toolbox' ), 'after' => '</div>' ) );
		?></div>
	<?php } ?>
	<footer class="entry-meta">
		<?php if ($is_post) { ?>
			<div class="taxonomy">
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'toolbox' ) );
				if ( $categories_list && toolbox_categorized_blog() ) {
			?>
			<p class="cat-links">
				<?php printf( __( '<span class="implicit-text">Posted in</span> %1$s', 'toolbox' ), $categories_list ); ?>
			</p>
			<?php } ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'toolbox' ) );
				if ( $tags_list ) {
			?>
			<p class="tag-links">
				<?php printf( __( '<span class="implicit-text">Tagged</span> %1$s', 'toolbox' ), $tags_list ); ?>
			</p>
			<?php } ?>
			</div>
		<?php } ?>
		<?php // edit_post_link( __( 'Edit', 'toolbox' ), '<p class="edit-link">', '</p>' ); ?>
		<?php if ( !is_singular() && (comments_open() || ( '0' != get_comments_number() && ! comments_open() )) ) { ?>
			<p class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'toolbox' ), __( '<span>1</span> Comment', 'toolbox' ), __( '<span>%</span> Comments', 'toolbox' ) ); ?></p>
		<?php } ?>
	</footer>
</article>
