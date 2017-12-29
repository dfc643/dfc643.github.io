<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Writr
 */

if ( ! function_exists( 'writr_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function writr_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'writr' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', __( '<span class="genericon genericon-leftarrow"></span> %title', 'writr' ) ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', __( '%title <span class="genericon genericon-rightarrow"></span>', 'writr' ) ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="genericon genericon-leftarrow"></span> Older posts', 'writr' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts  <span class="genericon genericon-rightarrow"></span>', 'writr' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // writr_content_nav

if ( ! function_exists( 'writr_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function writr_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'writr' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'writr' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>
				</div><!-- .comment-author -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><em><?php _e( 'Your comment is awaiting moderation.', 'writr' ); ?></em></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<div class="comment-metadata">
				<ul class="clear">
					<li class="comment-time">
						<div class="genericon genericon-month"></div>
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'writr' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
					</li>
					<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<li class="reply"><div class="genericon genericon-reply"></div> ',
							'after'     => '</li>',
						) ) );
					?>
					<?php edit_comment_link( __( 'Edit', 'writr' ), '<li class="edit-link"><div class="genericon genericon-edit"></div> ', '</li>' ); ?>
				</ul>
			</div><!-- .comment-metadata -->
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for writr_comment()

if ( ! function_exists( 'writr_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 */
function writr_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'writr_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url = wp_get_attachment_url();

	if ( $post->post_parent ) {
		/**
		 * Grab the IDs of all the image attachments in a gallery so we can get the
		 * URL of the next adjacent image in a gallery, or the first image (if
		 * we're looking at the last image in a gallery), or, in a gallery of one,
		 * just the link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => 999,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $idx => $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = $attachment_ids[ ( $idx + 1 ) % count( $attachment_ids ) ];
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id )
				$next_attachment_url = get_attachment_link( $next_id );

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 */
function writr_categorized_blog() {
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
		// This blog has more than 1 category so writr_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so writr_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in writr_categorized_blog
 */
function writr_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'writr_category_transient_flusher' );
add_action( 'save_post', 'writr_category_transient_flusher' );


if ( ! function_exists( 'writr_meta' ) ) :
/**
 * Prints HTML with meta information for the date, author, categories, tags and comments
 */
function writr_meta() {
?>

	<li class="date-meta">
		<div class="genericon genericon-month"></div>
		<span class="screen-reader-text"><?php _e( 'Date', 'writr' ); ?></span>
		<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" title="<?php the_time(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
	</li>

	<?php

	// If more than 1 author display author name
	if ( is_multi_author() ) :
	?>

		<li class="author-meta">
			<div class="genericon genericon-user"></div>
			<span class="screen-reader-text"><?php _e( 'Author', 'writr' ); ?></span>
			<span class="author vcard"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'writr' ), get_the_author() ) ) ?>" rel="author"><?php the_author(); ?></a></span>
		</li>

	<?php
	endif;

	// If has tags
	/* translators: used between list items, there is a space after the comma */
	$tag_list = get_the_tag_list( '', ', ' );

	if ( '' != $tag_list && ! is_wp_error( $tag_list ) ) :
	?>

		<li class="tags-meta">
			<div class="genericon genericon-tag"></div>
			<span class="screen-reader-text"><?php _e( 'Tags', 'writr' ); ?></span>
			<?php echo $tag_list; ?>
		</li>

	<?php
	endif;

	// If comments are open
	if ( comments_open() ) :
	?>

		<li class="comment-meta">
			<div class="genericon genericon-comment"></div>
			<span class="screen-reader-text"><?php _e( 'Comments', 'writr' ); ?></span>
			<?php comments_popup_link( __('Leave a comment', 'writr'), __('1 Comment', 'writr'), __('% Comments', 'writr') ); ?>
		</li>

	<?php
	endif;

	edit_post_link( __( 'Edit', 'writr' ), '<li class="edit-link"><div class="genericon genericon-edit"></div>', '</li>' );

}
endif;

if ( ! function_exists( 'writr_eventbrite_event_meta' ) ) :
/**
 * Output Eventbrite event information such as date, time, venue, and organizer
 */
function writr_eventbrite_event_meta() {
	// Start with the event time.
	$time = sprintf( '<li class="event-time"><span class="screen-reader-text">%s</span>%s</li>',
		esc_html__( 'Event date and time', 'writr' ),
		eventbrite_event_time()
	);

	// Add a venue name if available.
	$venue = '';
	if ( ! empty( eventbrite_event_venue()->name ) ) {
		$venue = sprintf( '<li class="event-venue"><span class="screen-reader-text">%s</span><a class="event-venue-link url fn n" href="%s">%s</a></li>',
			esc_html__( 'Venue', 'writr' ),
			esc_url( eventbrite_venue_get_archive_link() ),
			esc_html( eventbrite_event_venue()->name )
		);
	}

	// Add the organizer's name if available. Author-related functions are filtered to use the event's organizer.
	$organizer = '';
	if ( ! empty( eventbrite_event_organizer()->name ) ) {
		$organizer = sprintf( '<li class="event-organizer"><span class="screen-reader-text">%s</span><a class="event-organizer-link url fn n" href="%s">%s</a></li>',
			esc_html__( 'Organizer', 'writr' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}

	// Add a contextual link to event details.
	if ( eventbrite_is_single() ) {
		// Link to event info on eventbrite.com.
		$url = add_query_arg( array( 'ref' => 'wporglink' ), eventbrite_event_eb_url() );
	} else {
		// Link to the event single view.
		$url = get_the_permalink();
	}

	$details = sprintf( '<li class="event-details"><a class="event-details-link" href="%s">%s</a></li>',
		esc_url( $url ),
		esc_html__( 'Details', 'writr' )
	);

	// Add an event Edit link.
	$edit = '';
	if ( current_user_can( 'edit_posts' ) ) {
		$url = add_query_arg( array(
			'eid' => get_the_ID(),
			'ref' => 'wporgedit',
		), 'https://eventbrite.com/edit' );

		$edit = sprintf( '<li class="event-edit"><a href="%s">%s</a></li>',
			esc_url( $url ),
			esc_html__( 'Edit', 'writr' )
		);
	}

	// Assemble our HTML. Yugly.
	$html = sprintf( '<ul class="clear">%1$s%2$s%3$s%4$s%5$s</ul>',
		$time,
		$venue,
		$organizer,
		$details,
		$edit
	);

	echo apply_filters( 'eventbrite_event_meta', $html, $time, $venue, $organizer, $details, $edit );
}
endif;
