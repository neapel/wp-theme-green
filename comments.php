<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to toolbox_comment() which is
 * located in the functions.php file.
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */
?>
	<div id="comments">
	<?php if ( post_password_required() ) { ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'jan1' ); ?></p>
	</div>
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		}
	?>
	<?php if ( have_comments() ) { ?>
		<h2 id="comments-title"><?php
			printf( _n( 'One comment', '%1$s comments', get_comments_number(), 'jan1' ), number_format_i18n( get_comments_number() )  );
		?></h2>
		<ol class="commentlist"><?php
			/* Loop through and list the comments. Tell wp_list_comments()
			 * to use toolbox_comment() to format the comments.
			 * If you want to overload this in a child theme then you can
			 * define toolbox_comment() and that will be used instead.
			 * See toolbox_comment() in toolbox/functions.php for more.
			 */
			wp_list_comments( array( 'callback' => 'toolbox_comment' ) );
		?></ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'jan1' ); ?></h1>
			<div class="menu">
				<ul>
					<li class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'jan1' ) ); ?></li>
					<li class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'jan1' ) ); ?></li>
				</ul>
			</div>
		</nav>
		<?php } ?>
	<?php } ?>
	<?php
		// If comments are closed and there are no comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'jan1' ); ?></p>
	<?php } ?>
	<?php comment_form(); ?>
</div>
