<?php
/**
 * The template for displaying posts on archive pages
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix entry entry-content' ); ?>>
	<?php
		$thumb = '';
		$width = apply_filters( 'et_index_image_width', 260 );
		$height = apply_filters( 'et_index_image_height', 260 );
		$titletext = get_the_title();
		$thumbnail = get_thumbnail( $width, $height, '', $titletext, $titletext, false, 'Indeximage' );
		$thumb = $thumbnail["thumb"];
		$is_single = is_singular();
		$postinfo = ! $is_single ? et_get_option( 'harmony_postinfo1' ) : et_get_option( 'harmony_postinfo2' );
		$show_thumb = ! $is_single ? et_get_option( 'harmony_thumbnails_index', 'on' ) : et_get_option( 'harmony_thumbnails', 'on' );
		if ( is_page() ) $show_thumb = et_get_option( 'harmony_page_thumbnails', 'false' );
	?>
	
	<?php if ( ! $is_single ) { ?>
		<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php } else { ?>
		<h1 class="title"><?php the_title(); ?></h1>
	<?php } ?>
		
	<?php 
		if ( $postinfo && ! is_page() && ( ! is_post_type_archive( 'gallery' ) && ! is_tax( 'gallery_category' ) ) ) {
			echo '<p class="meta-info">';
			et_postinfo_meta( $postinfo, et_get_option( 'harmony_date_format', 'M j, Y' ), esc_html__( '0 comments', 'Harmony' ), esc_html__( '1 comment', 'Harmony' ), '% ' . esc_html__( 'comments', 'Harmony' ) );
			echo '</p>';
		}
		
		if ( is_post_type_archive( 'gallery' ) || is_tax( 'gallery_category' ) ) {
			$et_gallery_date = get_post_meta( get_the_ID(), '_et_gallery_date', true );
			
			if ( '' != $et_gallery_date ) {
				echo '<p class="meta-info">' . sprintf( __( 'Gallery Date: %1$s', 'Harmony' ), esc_html( date( et_get_option( 'harmony_date_format', 'M j, Y' ), $et_gallery_date ) ) ) . '</p>';
			}
		}
	?>
			
	<?php if ( '' != $thumb && 'false' != $show_thumb ) { ?>
		<div class="post-thumbnail">
		<?php if ( ! $is_single ) : ?>
			<a href="<?php the_permalink(); ?>">
		<?php endif; ?>
				<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, '' ); ?>
		<?php if ( ! $is_single ) : ?>
			</a>
		<?php endif; ?>
		</div> 	<!-- end .post-thumbnail -->
	<?php } ?>

<?php
	if ( $is_single ) :
		the_content();
		wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Harmony' ), 'after' => '</div>' ) );
	else :
		if ( 'on' == et_get_option( 'harmony_blog_style' ) ) the_content('');
		else echo '<p>' . truncate_post( 400, false ) . '</p>'; ?>
		
		<a href="<?php the_permalink(); ?>" class="more"><?php esc_html_e( 'Read More', 'Harmony' ); ?></a>
<?php
	endif;
?>
	</article> <!-- end .post-->