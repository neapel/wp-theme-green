<?php
/**
 * @package Toolbox
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(has_post_thumbnail() ? 'with-thumbnail' : 'without-thumbnail'); ?>>
	<?php if(toolbox_show_title()) { ?>
	<header class="entry-header"<?php if(!is_singular() && has_post_thumbnail())
			echo ' style="background-image: url(' . wp_get_attachment_url(get_post_thumbnail_id()) . ')"'; ?>>
		<hgroup>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'jan1' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><span><?php the_title(); ?></span></a></h1>
		</hgroup>
		<div class="entry-meta"><?php toolbox_posted_on(); ?></div>
	</header>
	<?php } ?>
	<?php if ( is_search() ) { // Only display Excerpts for Search ?>
		<div class="entry-summary hyphenate"><?php the_excerpt(); ?></div>
	<?php } else if(/*!has_post_thumbnail() ||*/ is_singular()){ ?>
		<div class="entry-content hyphenate"><?php
			the_content( __( 'Continue reading', 'jan1' ) );
		?></div>
		<div class="pre-footer"><?php
			toolbox_link_pages();
		?></div>
	<?php } ?>
	<footer class="entry-meta">
		<?php if (toolbox_show_title()) { ?>
			<div class="taxonomy">
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'jan1' ) );
				if ( $categories_list && toolbox_categorized_blog() ) {
			?>
			<p class="cat-links">
				<?php printf( '<span class="implicit-text">%1s</span> %2$s',  __( 'Posted in', 'jan1'), $categories_list ); ?>
			</p>
			<?php } ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'jan1' ) );
				if ( $tags_list ) {
			?>
			<p class="tag-links">
				<?php printf( '<span class="implicit-text">%s1</span> %2$s', __( 'Tagged as', 'jan1' ), $tags_list ); ?>
			</p>
			<?php } ?>
			</div>
		<?php } else { ?>
			<div class="entry-meta"><?php toolbox_posted_on(); ?></div>
		<?php } ?>
		<?php if ( !is_singular() && (comments_open() || ( '0' != get_comments_number() && ! comments_open() )) ) {
			$format = '<span class="number">%s</span><span class="implicit-text"> %s</span>';
			echo '<p class="comments-link">';
			comments_popup_link(
				sprintf($format, '0', __('Comments', 'jan1')),
				sprintf($format, '1', __('Comment', 'jan1')),
				sprintf($format, '%', __('Comments', 'jan1'))
			);
			echo '</p>';
		} ?>
	</footer>
</article>
