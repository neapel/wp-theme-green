<?php
/**
 * Toolbox functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'toolbox_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override toolbox_setup() in a child theme, add your own toolbox_setup to your child theme's
 * functions.php file.
 */
function toolbox_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on toolbox, use a find and replace
	 * to change 'jan1' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'jan1', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'jan1' ),
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', // no title
		'gallery', // gallery shortcode, image attachments
		'link', // first link external/content only url
		'image', // single image/url
		'quote', // blockquote, title:author
		'status', // no title, tweet-like
		'video', // single video/attachment
		'audio', // single audio/attachment
		'chat', // transcript
	) );
	add_theme_support('post-thumbnails', array('post'));
}
endif; // toolbox_setup

/**
 * Tell WordPress to run toolbox_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'toolbox_setup' );

/**
 * Set a default theme color array for WP.com.
 */
$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '444444',
);

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function toolbox_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'toolbox_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function toolbox_widgets_init() {
	register_sidebar(array(
		'name' => __('Footer', 'jan1'),
		'id' => 'footer',
		'description' => __('Shown at the bottom of every page, for copyright, licenses, etc.', 'jan1'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>'
	));
}
add_action( 'init', 'toolbox_widgets_init' );

/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Toolbox 1.2
 */
function toolbox_content_nav( $nav_id ) {
	global $wp_query;
	$has_prev = $has_next = false;
	if(is_single()){
		$has_prev = !!get_previous_post();
		$has_next = !!get_next_post();
	} else if($wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) {
		$has_prev = !!get_next_posts_link();
		$has_next = !!get_previous_posts_link();
	}
	if($has_next || $has_prev) {
	?>
	<nav class="pagination <?php echo ($has_next && $has_prev) ? 'both-directions' : ($has_next ? 'only-next' : 'only-previous') ?>" id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'jan1' ); ?></h1>
		<div class="menu"><ul><?php
		if ( is_single() ) {
			previous_post_link( '<li class="nav-previous">%link</li>', '<span>%title</span>' );
			next_post_link( '<li class="nav-next">%link</li>', '<span>%title</span>' );
		} else {
			if($has_prev) {
				echo '<li class="nav-previous">';
				next_posts_link( sprintf('<span>%s</span>', __( 'Older posts', 'jan1' )) );
				echo '</li>';
			}
			if($has_next) {
				echo '<li class="nav-next">';
				previous_posts_link( sprintf('<span>%s</span>', __( 'Newer posts', 'jan1' ) ) );
				echo '</li>';
			}
		}
	?></ul><span class="helper" /></div>
	</nav>
<?php
	}
}



/**
 * The formatted output of a list of pages.
 *
 * Displays page links for paginated posts (i.e. includes the <!--nextpage-->.
 * Quicktag one or more times). This tag must be within The Loop.
 *
 * Replaces wp_link_pages
 */
function toolbox_link_pages() {
	global $page, $numpages, $multipage;
	if( $multipage ) {
		echo '<nav class="post-pagination">';
		echo '<h1 class="assistive-text">Multi-page post navigation</h1>';
		echo '<div class="menu">';
		echo '<p class="pages-text">'. __('Pages:') . '</p>';
		echo '<ul>';
		for( $i = 1 ; $i <= $numpages ; $i += 1 ) {
			if( $i == $page )
				echo '<li class="current-page"><span>' . $i . '</span></li>';
			else
				echo '<li class="other-page">' . _wp_link_page($i) . $i . '</a></li>';
		}
		echo '</ul></div></nav>';
	}
}


/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own toolbox_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Toolbox 0.4
 */
function toolbox_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) {
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><span class="description"><?php _e( 'Trackback:', 'jan1' ); ?> </span><?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'jan1' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-content hyphenate"><?php comment_text(); ?></div>
			<footer>
				<div class="comment-author vcard">
					<?php // echo get_avatar( $comment, 40 ); ?>
					<?php printf( '<span class="implicit-text">%s</span> <cite class="fn">%s</span>', __( 'by', 'jan1' ), get_comment_author_link() ); ?>
				</div>
				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>"><?php
						printf( __( '%s ago', 'jan1' ), human_time_diff(get_comment_time('U')) );
					?></time></a>
					<?php if ( $comment->comment_approved == '0' ) { ?>
					<span class="moderation"><?php _e( 'Your comment is awaiting moderation.', 'jan1' ); ?></span>
					<?php } ?>
				</div>
				<div class="reply"><?php
					comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
					edit_comment_link( __( 'Edit', 'jan1' ), ' ' );
				?></div>
			</footer>
		</article>
	<?php
			break;
	}
}


function toolbox_show_title() {
	if(get_the_title() == '') return false;
	switch(get_post_format()) {
		case 'aside':
		case 'link':
		case 'image':
		case 'quote':
		case 'status':
			return false;
		default:
			return true;
	}
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own toolbox_posted_on to override in a child theme
 *
 * @since Toolbox 1.2
 */
function toolbox_posted_on() {
	$y = get_the_time('Y');
	$m = get_the_time('m');
	$d = get_the_time('d');
?>
	<p class="date">
		<span class="implicit-text"><?php echo __('Posted on', 'jan1') ?></span>
		<time class="entry-date" datetime="<?php echo get_the_time('c')?>" pubdate>
			<span class="day-month">
				<a href="<?php echo get_day_link($y,$m,$d) ?>" title="<?php echo __('Show all posts of this day', 'jan1') ?>" class="day"><?php the_time('j.') ?></a>
				<a href="<?php echo get_month_link($y,$m) ?>" title="<?php echo __('Show all posts of this month', 'jan1') ?>" class="month"><?php the_time('M') ?></a>
			</span>
			<a href="<?php echo get_year_link($y) ?>" title="<?php echo __('Show all posts of this year', 'jan1') ?>" class="year"><?php the_time('Y') ?></a>
		</time>
	</p>
	<p class="byline">
		<span class="implicit-text"><?php echo __('by', 'jan1') ?></span>
		<span class="author vcard"><a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" title="<?php echo sprintf( __( 'View all posts by %s', 'jan1' ), get_the_author() ) ?>" rel="author"><?php echo get_the_author() ?></a></span>
	</p>
	<?php if(!toolbox_show_title()) { // no title displayed ?>
	<p class="permalink">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'jan1' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">Permalink</a>
	</p>
	<?php }
	edit_post_link( __( 'Edit', 'jan1' ), '<p class="edit-link">', '</p>' );
}
/*
function toolbox_posted_on() {?>
	<p class="date"><span>Posted on </span>
<?php
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'jan1' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'jan1' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}*/

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Toolbox 1.2
 */
function toolbox_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'toolbox_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 *
 * @since Toolbox 1.2
 */
function toolbox_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so toolbox_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so toolbox_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in toolbox_categorized_blog
 *
 * @since Toolbox 1.2
 */
function toolbox_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'toolbox_category_transient_flusher' );
add_action( 'save_post', 'toolbox_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function toolbox_enhanced_image_navigation( $url ) {
	global $post, $wp_rewrite;
	if(!$post) return null;
	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'toolbox_enhanced_image_navigation' );




function toolbox_post_list() {
	rewind_posts();
?>
			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php toolbox_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'jan1' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'jan1' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
<?php
}





/**
 * Outputs a complete commenting form for use within a template.
 * Most strings and form fields may be controlled through the $args array passed
 * into the function, while you may also choose to use the comment_form_default_fields
 * filter to modify the array of default fields if you'd just like to add a new
 * one or remove a single field. All fields are also individually passed through
 * a filter of the form comment_form_field_$name where $name is the key used
 * in the array of fields.
 *
 * @since 3.0.0
 * @param array $args Options for strings, fields etc in the form
 * @param mixed $post_id Post ID to generate the form for, uses the current post if null
 * @return void
 */
function toolbox_comment_form( $args = array(), $post_id = null ) {
	global $id;
	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;
	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = ! empty( $user->ID ) ? $user->display_name : '';
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true' required='required'" : '' );
	$class_req = ($req ? ' required' : '');
	$fields = array(
		'author' => '<p class="comment-form-author' . $class_req . '">' .
			'<label for="author">' . __( 'Name' ) . ' </label>' .
			'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email' => '<p class="comment-form-email' . $class_req . '">' .
			'<label for="email">' . __( 'Email' ) . ' </label>' .
			'<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url' => '<p class="comment-form-url">' .
			'<label for="url">' . __( 'Website' ) . ' </label>' .
			'<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);
	$defaults = array(
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . ' </label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required="required"></textarea></p>',
		'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . '</p>',
		'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'title_reply' => __( 'Leave a Reply' ),
		'title_reply_to' => __( 'Leave a Reply to %s' ),
		'cancel_reply_link' => __( 'Cancel reply' ),
		'label_submit' => __( 'Post Comment' ),
	);
	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );
	if ( comments_open() ) {
		do_action( 'comment_form_before' );
		echo '<div id="respond">';
		echo '<h3 id="reply-title">';
		comment_form_title( $args['title_reply'], $args['title_reply_to'] );
		echo ' <small>';
		cancel_comment_reply_link( $args['cancel_reply_link'] );
		echo '</small></h3>';
		if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) {
			echo $args['must_log_in'];
			do_action( 'comment_form_must_log_in_after' );
		} else {
			echo '<form action="' . site_url( '/wp-comments-post.php' ) . '" method="post" id="' . esc_attr( $args['id_form'] ) . '">';
			do_action( 'comment_form_top' );
			if ( is_user_logged_in() ) {
				echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
				do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
			} else {
				echo $args['comment_notes_before'];
				do_action( 'comment_form_before_fields' );
				foreach ( (array) $args['fields'] as $name => $field ) {
					echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
				}
				do_action( 'comment_form_after_fields' );
			}
			echo apply_filters( 'comment_form_field_comment', $args['comment_field'] );
			echo $args['comment_notes_after'];
			echo '<p class="form-submit">';
			echo '<button name="submit" value="submit" id="' .esc_attr( $args['id_submit'] ) .'">' . esc_attr( $args['label_submit'] ) . '</button>';
			comment_id_fields( $post_id );
			echo '</p>';
			do_action( 'comment_form', $post_id );
			echo '</form>';
		}
		echo '</div>';
		do_action( 'comment_form_after' );
	} else {
		do_action( 'comment_form_comments_closed' );
	}
}


/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and a Toolbox.
 */
