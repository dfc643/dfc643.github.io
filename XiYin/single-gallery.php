<?php get_header(); ?>

<div id="main-area">
	<div class="container">
		<div id="content-area" class="clearfix fullwidth">
			<div id="left-area">
						
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix entry entry-content' ); ?>>
				
					<h1 class="title"><?php the_title(); ?></h1>
					<p class="meta-info">
					<?php
						$gallery_date = get_post_meta( get_the_ID(), '_et_gallery_date', true );
						$et_gallery_date = '' != $gallery_date ? date( et_get_option( 'harmony_date_format', 'M j, Y' ), $gallery_date ) : et_get_option( 'harmony_date_format', 'M j, Y' );
						
						printf( _x( 'Posted by %1$s in %2$s on %3$s | %4$s', 'Meta information on single gallery page', 'Harmony' ),
							et_get_the_author_posts_link(),
							get_the_term_list( get_the_ID(), 'gallery_category', '', ', ' ),
							esc_html( $et_gallery_date ),
							et_get_comments_popup_link( __( '0 comments', 'Harmony' ), __( '1 comment', 'Harmony' ), '% ' . __( 'comments', 'Harmony' ) )
						); ?>
					</p>
					
		<?php
			$i = 0;
			$media = get_post_meta( get_the_ID(), '_et_used_images', true );
			$width = apply_filters( 'et_gallery_image_width', 170 );
			$height = apply_filters( 'et_gallery_image_height', 170 );
				
			if ( $media ) : ?>
						<div id="et-gallery-images" class="clearfix">
		<?php	foreach( (array) $media as $et_media ) :
					$i++;
					if ( is_numeric( $et_media ) ) {
						$et_fullimage_array = wp_get_attachment_image_src( $et_media, 'full' );
						if ( $et_fullimage_array ){
							$et_fullimage = $et_fullimage_array[0];
						?>
							<div class="gallery-photo<?php if ( $i % 4 == 0 ) echo ' last'; if ( ( $i - 1 ) % 4 == 0 ) echo ' et_first'; ?>">
								<div class="image">
									<a href="<?php echo esc_url( $et_fullimage ); ?>" class="fancybox" title="<?php echo esc_attr( get_the_title( $et_media ) ); ?>">
										<?php echo '<img src="' . esc_url( et_new_thumb_resize( et_multisite_thumbnail( $et_fullimage ), $width, $height, '', true ) ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" />'; ?>
									</a>
								</div> <!-- .image -->
							<?php if ( '' != $gallery_date ) { ?>
								<div class="image-date"><span><?php echo esc_attr( get_the_title( $et_media ) ); ?></span></div>
							<?php } ?>
							</div> <!-- .gallery-photo -->
				<?php	}
					}
				endforeach; ?>
						</div> <!-- #et-gallery-images -->
	<?php	endif;
		?>

				<?php
					the_content();
					wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Harmony' ), 'after' => '</div>' ) );
				?>
				
				</article> <!-- end .post-->
				
				<?php
					if ( comments_open() && 'on' == et_get_option( 'harmony_show_postcomments', 'on' ) ) 
						comments_template( '', true );
				?>
				
			<?php endwhile; ?>

			</div> <!-- end #left-area -->
		</div> <!-- end #content-area -->
	</div> <!-- end .container -->
</div> <!-- end #main-area -->
	
<?php get_footer(); ?>