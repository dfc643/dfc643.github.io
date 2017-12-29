<?php 
	if ( 'on' == et_get_option( 'harmony_blog_style', 'false' ) ) :
		get_template_part( 'index' );
		return;
	endif;
?>
<?php get_header(); ?>

<?php 
	$display_news_section 		= et_get_option( 'harmony_display_news_section', 'on' );
	$display_shows_section 		= et_get_option( 'harmony_display_shows_section', 'on' );
	$display_audio_section 		= et_get_option( 'harmony_display_audio_section', 'on' );
	$display_shop_section 		= et_get_option( 'harmony_display_shop_section', 'on' );
	$display_gallery_section 	= et_get_option( 'harmony_display_gallery_section', 'on' );
?>

<?php if ( 'on' == $display_news_section || 'on' == $display_shows_section ) : ?>

<div id="news-section">
	<div class="container clearfix">
	
	<?php if ( 'on' == $display_news_section ) { ?>
	
		<div id="news">
			<h2><?php echo esc_html( et_get_option( 'harmony_recent_news_title', __( 'Recent News', 'Harmony' ) ) ); ?></h2>
			<ul id="news-posts">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php 
				$thumb = '';
				$width = apply_filters( 'et_home_blog_image_width', 60 );
				$height = apply_filters( 'et_home_blog_image_height', 60 );
				$titletext = get_the_title();
				$thumbnail = get_thumbnail( $width, $height, '', $titletext, $titletext, false, 'Blogimage' );
				$thumb = $thumbnail["thumb"];
			?>
				<li class="clearfix">
				<?php if ( '' != $thumb ) { ?>
					<div class="news-image">
						<a href="<?php the_permalink(); ?>">
							<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, '' ); ?>
						</a>
					</div>
				<?php } ?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php 
					printf ( __( '<p class="meta-info">Posted by <a href="%1$s">%2$s</a> on %3$s</p>', 'Harmony' ),
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author(),
						esc_html( get_the_time( et_get_option( 'harmony_date_format', 'M j, Y' ) ) )
					);
				?>
				</li>
			<?php endwhile; endif; ?>
			</ul>
		
		<?php if ( ( $more_news_link = et_get_option( 'harmony_more_news_link' ) ) && '' != $more_news_link ) { ?>
			<a href="<?php echo esc_url( $more_news_link ); ?>" class="more"><?php esc_html_e( 'More News', 'Harmony' ); ?></a>
		<?php } ?>
		</div> <!-- end #news -->
		
	<?php } ?>
	
	<?php if ( 'on' == $display_shows_section ) { ?>
	
<?php
	$event_meta_query = array(
		array(
			'key' => '_et_event_date',
			'value' => time(),
			'compare' => '>'
		)
	);
	$args = array(
		'meta_query'		=> apply_filters( 'et_home_event_meta_query_args', $event_meta_query ),
		'post_type'			=> 'event',
		'meta_key'			=> '_et_event_date',
		'orderby'			=> 'meta_value_num',
		'order' 			=> 'ASC',
		'posts_per_page' 	=> et_get_option( 'harmony_home_events_number', 3 )
	);
	$et_events_query = new WP_Query( apply_filters( 'et_home_events_query_args', $args ) );
	if ( $et_events_query->have_posts() ) :
?>
		<div id="shows">
			<h2><?php echo esc_html( et_get_option( 'harmony_upcoming_shows_title', __( 'Upcoming Shows', 'Harmony' ) ) ); ?></h2>
			<ul id="shows-posts">
		<?php
			while ( $et_events_query->have_posts() ) : $et_events_query->the_post();
				$et_event_date = get_post_meta( get_the_ID(), '_et_event_date', true ); 
				$et_event_location = get_post_meta( get_the_ID(), '_et_event_location', true );
		?>
				<li class="clearfix">
				<?php if ( '' != $et_event_date ) { ?>
					<div class="show-date">
						<span class="post-meta"><?php echo date( _x( 'M', 'Event date format', 'Harmony' ), $et_event_date ); ?><span><?php echo date( _x( 'd', 'Event day format', 'Harmony' ), $et_event_date ); ?></span></span>
					</div>
				<?php } ?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php if ( '' != $et_event_location ) { ?>
					<p><?php echo esc_html( $et_event_location ); ?></p>
				<?php } ?>
				</li>
			<?php endwhile; ?>
			</ul>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="more"><?php esc_html_e( 'More Shows', 'Harmony' ); ?></a>
		</div> <!-- end #shows -->
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
	
	<?php } ?>
	
	</div> <!-- end .container -->
</div> <!-- end #news-section -->

<?php endif; // 'on' == $display_news_section || 'on' == $display_shows_section ?>

<?php if ( 'on' == $display_audio_section ) : ?>

<?php
	$audio_posts_query = new WP_Query( apply_filters( 'et_audio_posts_args', array(
				'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => 'post-format-audio'
					)
				),
				'showposts' => (int) et_get_option( 'harmony_audio_postsnum', 4 )
			) 
		)
	); 
?>
<?php if ( $audio_posts_query->have_posts() ) : ?>
<div id="songs" class="main_bg">
	<div class="container clearfix">
		<div id="main_audio_player">
		<?php
			wp_enqueue_script( 'jplayer.playlist' );
			wp_enqueue_script( 'jplayer' );
		?>
			<div id="et_main_audio_player" class="jp-jplayer"></div>

			<div id="et_main_audio_container" class="jp-audio">
				<div class="audio_slider">
			<?php
				$audio_playlist_js = '';
				$audio_info_panel = array();
				$i = 0;
				while ( $audio_posts_query->have_posts() ) : $audio_posts_query->the_post();
					$thumb = '';
					
					$width = apply_filters( 'et_audio_image_width', 420 );
					$height = apply_filters( 'et_audio_image_height', 340 );
					$audio_info_panel[$i]['small_width'] = apply_filters( 'et_audio_image_small_width', 60 );
					$audio_info_panel[$i]['small_height'] = apply_filters( 'et_audio_image_small_height', 60 );
					
					$titletext = get_the_title();
					$audio_info_panel[$i]['titletext'] = get_the_title();
					
					$thumbnail = get_thumbnail( $width, $height, '', $titletext, $titletext, false, 'Audioimage' );
					$audio_info_panel[$i]['thumbnail'] = get_thumbnail( $audio_info_panel[$i]['small_width'], $audio_info_panel[$i]['small_height'], '', $titletext, $titletext, false, 'Audiosmallimage' );
					
					$thumb = $thumbnail["thumb"];
					$audio_mp3 = get_post_meta( get_the_ID(), '_et_audio_mp3', true );
					$audio_ogg = get_post_meta( get_the_ID(), '_et_audio_ogg', true );
					$album_title = get_post_meta( get_the_ID(), '_et_audio_album_title', true );
					$audio_info_panel[$i]['album_title'] = $album_title;
					
					$audio_playlist_js .= 	( '' != $audio_playlist_js ? ',' : "\n" ) 
											. '{' . "\n"
											. 'title : "' . esc_js( $titletext ) . '",' . "\n"
											. ( '' != $audio_mp3 ? 'mp3 : "' . esc_js( $audio_mp3 ) . '", ' . "\n" : '' )
											. ( '' != $audio_ogg ? 'oga : "' . esc_js( $audio_ogg ) . '"' . "\n" : '' )
											. '}';
			?>
					<div class="audio_image">
						<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, '' ); ?>
						<div class="audio_meta">
							<span class="title"><?php echo esc_html( $titletext ); ?></span>
						<?php if ( '' != $album_title ) : ?>
							<span class="album_title"><?php echo esc_html( $album_title ); ?></span>
						<?php endif; ?>
						</div> <!-- .audio_meta -->
					</div> <!-- .audio_image -->
			<?php
					$i++;
				endwhile; 
			?>
				</div> <!-- .audio_slider -->
			
				<div class="jp-type-playlist">
					<div class="jp-gui jp-interface clearfix">
						<ul class="jp-controls">
							<li><a href="javascript:;" class="jp-play" tabindex="1"><?php esc_html_e( 'play', 'Harmony' ); ?></a></li>
							<li><a href="javascript:;" class="jp-pause" tabindex="1"><?php esc_html_e( 'pause', 'Harmony' ); ?></a></li>
						</ul>
						
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
					</div> <!-- .jp-gui -->
					
					<div class="jp-playlist">
						<ul>
							<li></li>
						</ul>
					</div> <!-- .jp-playlist -->
					
					<div class="jp-no-solution">
						<span><?php esc_html_e( 'Update Required', 'Harmony' ); ?></span>
						<?php esc_html_e( 'To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.', 'Harmony' ); ?>	
					</div> <!-- .jp-no-solution -->
				</div> <!-- .jp-type-playlist -->
				
				<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready( function($){
					et_main_playlist = new jPlayerPlaylist({
						jPlayer: "#et_main_audio_player",
						cssSelectorAncestor: "#et_main_audio_container"
					}, [ <?php echo $audio_playlist_js; ?>
					], {
						swfPath: "<?php echo esc_js( get_template_directory_uri() . '/js' ); ?>",
						supplied: "oga, mp3",
						wmode: "window"
					});
				} );
				//]]>
				</script>
			</div> <!-- .jp-audio -->
		</div> <!-- #main_audio_player -->
		
		<div id="main_audio_playlist">
			<h2><?php echo esc_html( et_get_option( 'harmony_featured_songs_title', __( 'Featured Songs', 'Harmony' ) ) ); ?></h2>
			<ul>
			<?php for ( $i = 0; $i < count( $audio_info_panel ); $i++ ) { ?>
				<li class="clearfix<?php if ( 0 == $i ) echo ' active_song'; ?>">
				<?php if ( '' != $audio_info_panel[$i]['thumbnail']['thumb'] ) { ?>
					<div class="audio_post_image">
						<?php print_thumbnail( $audio_info_panel[$i]['thumbnail']['thumb'], $audio_info_panel[$i]['thumbnail']['use_timthumb'], $audio_info_panel[$i]['titletext'], $audio_info_panel[$i]['small_width'], $audio_info_panel[$i]['small_height'], '' ); ?>
					</div> <!-- .audio_post_image -->
				<?php } ?>
					<h3><?php echo esc_html( $audio_info_panel[$i]['titletext'] ); ?></h3>
				<?php if ( '' != $audio_info_panel[$i]['album_title'] ) : ?>
					<span class="album_title"><?php echo esc_html( $audio_info_panel[$i]['album_title'] ); ?></span>
				<?php endif; ?>
				</li>
			<?php } ?>
			</ul>
		</div> <!-- #main_audio_playlist -->
	</div> <!-- end .container -->
</div> <!-- end #songs -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php endif; // 'on' == $display_audio_section ?>

<?php //if ( class_exists( 'woocommerce' ) && 'on' == $display_shop_section ) : ?>

<div id="home-products">
	<div class="container">
		<h2><?php echo esc_html( et_get_option( 'harmony_shop_section_title', __( 'Awesome Swag', 'Harmony' ) ) ); ?></h2>
		<div id="products" class="clearfix">
		<?php
			//$products_per_page = (int) et_get_option( 'harmony_homepage_products_per_page', 8 );
			//echo do_shortcode( sprintf( '[featured_products per_page="%s" columns="4"]', esc_attr( $products_per_page ) ) ); 
		?>
		<p style="font-size: 16px;">汐音社是一个基于兴趣的合作型网络同好社团，成员分布在世界各地。社团力主通过成员的共同努力，将大家感兴趣的idea具现化。社团的核心能力集中在音乐方面。</p>
		<p style="font-size: 16px;">汐音社起源于国内ACG领域著名的歌姬“西国の海妖”所创办的XIGUO BBS。因受到日本Sound Horizon幻想乐团的影响，逐渐步入原创音乐领域，起初为创作属于自己的幻想物语组曲，后进入原创古风音乐领域。</p>
		</div> <!-- end #products -->	
	</div> <!-- end .container -->
</div> <!-- end #home-products -->

<?php //endif; // class_exists( 'woocommerce' ) && 'on' == $display_shop_section ?>

<?php if ( 'on' == $display_gallery_section ) : ?>

<?php
	$args = array( 
		'post_type'			=> 'gallery',
		'meta_key'			=> '_et_gallery_date',
		'orderby'			=> 'meta_value_num',
		'order' 			=> 'Desc',
		'posts_per_page' 	=> et_get_option( 'harmony_home_gallery_number', 8 )
	);
	$et_gallery_query = new WP_Query( apply_filters( 'et_home_gallery_query_args', $args ) ); 
?>
<?php if ( $et_gallery_query->have_posts() ) : ?>
<div id="media-gallery" class="main_bg">
	<div class="container">
		<h2><?php echo esc_html( et_get_option( 'harmony_media_gallery_section_title', __( 'Media Gallery', 'Harmony' ) ) ); ?></h2>
		<div id="gallery-photos" class="clearfix">
	<?php 
		$i = 0;
		while ( $et_gallery_query->have_posts() ) : $et_gallery_query->the_post();
			$thumb = '';
			$width = apply_filters( 'et_gallery_image_width', 170 );
			$height = apply_filters( 'et_gallery_image_height', 170 );
			$classtext = '';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Gallery' );
			$thumb = $thumbnail["thumb"];
			$gallery_date = get_post_meta( get_the_ID(), '_et_gallery_date', true );
			$i++;
		?>
			<div class="gallery-photo<?php if ( $i % 4 == 0 ) echo ' last'; ?>">
				<div class="image">
					<a href="<?php the_permalink(); ?>" target="_blank">
				<?php 
					if ( '' != $thumb ) {
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext );
					} else {
						$media = get_post_meta( get_the_ID(), '_et_used_images', true );
						if ( $media ){
							foreach( (array) $media as $et_media ){
								if ( is_numeric( $et_media ) ) {
									$et_fullimage_array = wp_get_attachment_image_src( $et_media, 'full' );
									if ( $et_fullimage_array ){
										$et_fullimage = $et_fullimage_array[0];
										echo '<img src="' . esc_url( et_new_thumb_resize( et_multisite_thumbnail($et_fullimage ), $width, $height, '', true ) ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" />';
									}
									break;
								} else {
									continue;
								}
							}
						}
					}
				?>
					</a>
				</div> <!-- .image -->
			<?php if ( '' != $gallery_date ) { ?>
				<div class="image-date"><span><?php echo $titletext; ?></span></div>
			<?php } ?>
			</div> <!-- .gallery-photo -->
		<?php endwhile; ?>
		</div> <!-- end #gallery-photos -->
		<!--<a href="<?php echo esc_url( get_post_type_archive_link( 'gallery' ) ); ?>" class="view-more"><?php esc_html_e( 'View More', 'Harmony' ); ?></a>	-->
	</div> <!-- end .container -->	
</div> <!-- end #media-gallery -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php endif; // 'on' == $display_gallery_section ?>

<?php get_footer(); ?>