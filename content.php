<?php
/**
 * @package Toolbox
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(has_post_thumbnail() ? 'with-thumbnail' : 'without-thumnail'); ?>>
	<?php if(toolbox_show_title()) { ?>
	<header class="entry-header">
		<hgroup>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'toolbox' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><span><?php the_title(); ?></span><?php if(has_post_thumbnail()) the_post_thumbnail('full'); ?></a></h1>
		</hgroup>
		<div class="entry-meta"><?php toolbox_posted_on(); ?></div>
	</header>
	<?php } ?>
	<?php if ( is_search() ) { // Only display Excerpts for Search ?>
		<div class="entry-summary hyphenate"><?php the_excerpt(); ?></div>
	<?php } else if(!has_post_thumbnail() || is_singular()){ ?>
		<div class="entry-content hyphenate"><?php
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'toolbox' ) );
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
		<?php } else { ?>
			<div class="entry-meta"><?php toolbox_posted_on(); ?></div>
		<?php } ?>
		<?php if ( !is_singular() && (comments_open() || ( '0' != get_comments_number() && ! comments_open() )) ) { ?>
			<p class="comments-link"><?php comments_popup_link( __( '<span class="number">0</span><span class="implicit-text"> Comments</span>', 'toolbox' ), __( '<span class="number">1</span><span class="implicit-text"> Comment</span>', 'toolbox' ), __( '<span class="number">%</span><span class="implicit-text"> Comments</span>', 'toolbox' ) ); ?></p>
		<?php } ?>
	</footer>
</article>
