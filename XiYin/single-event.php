<?php get_header(); ?>

<div id="main-area">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
						
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix entry entry-content' ); ?>>
				
					<h1 class="title"><?php the_title(); ?></h1>
					<p class="meta-info">
					<?php
						printf( _x( 'Posted by %1$s in %2$s | %3$s', 'Meta information on single event page', 'Harmony' ),
							et_get_the_author_posts_link(),
							get_the_term_list( get_the_ID(), 'event_category', '', ', ' ),
							et_get_comments_popup_link( __( '0 comments', 'Harmony' ), __( '1 comment', 'Harmony' ), '% ' . __( 'comments', 'Harmony' ) )
						); ?>
					</p>
					
				<?php
					$date_format = apply_filters( 'et_event_settings_date_format', 'D, M d, Y' );
					$default_time_format = get_option( 'time_format' );
					
					$et_event_startdate = get_post_meta( get_the_ID(), '_et_event_date', true );
					$et_event_enddate = get_post_meta( get_the_ID(), '_et_event_enddate', true );
					$et_event_location = get_post_meta( get_the_ID(), '_et_event_location', true );
					$et_event_venue = get_post_meta( get_the_ID(), '_et_event_venue', true );
					$et_event_price = get_post_meta( get_the_ID(), '_et_event_price', true );
					$et_purchase_link = get_post_meta( get_the_ID(), '_et_purchase_link', true );
					
					$event_startday = date( $date_format, $et_event_startdate );
					$event_endday = date( $date_format, $et_event_enddate );
					$event_starttime = date( $default_time_format, $et_event_startdate );
					$event_endtime = date( $default_time_format, $et_event_enddate );
					
					$time = '';
				?>

					<ul id="event-properties">
					<?php if ( $et_event_price ) : ?>
						<li><strong><?php esc_html_e( 'Price', 'Harmony' ); ?>: </strong><?php echo esc_html( $et_event_price ); ?></li>
					<?php endif; ?>
					<?php if ( $et_event_startdate ) : ?>
						<li>
							<strong><?php esc_html_e( 'Date', 'Harmony' ); ?>: </strong>
						<?php 
							if ( $event_startday == $event_endday )
								echo esc_html( date( $date_format, $et_event_startdate ) );
							else
								echo esc_html( date( $date_format, $et_event_startdate ) . ' - ' . date( $date_format, $et_event_enddate ) );
								
							$time = $event_starttime == $event_endtime ? $event_starttime : $event_starttime . ' - ' . $event_endtime;
						?>
						</li>
					<?php endif; ?>
					<?php if ( '' != $time ) : ?>
						<li><strong><?php esc_html_e( 'Time', 'Harmony' ); ?>: </strong><?php echo esc_html( $time ); ?></li>
					<?php endif; ?>
					<?php if ( $et_event_venue ) : ?>
						<li><strong><?php esc_html_e( 'Venue', 'Harmony' ); ?>: </strong><?php echo esc_html( $et_event_venue ); ?></li>
					<?php endif; ?>
					<?php if ( $et_event_location ) : ?>
						<li><strong><?php esc_html_e( 'Location', 'Harmony' ); ?>: </strong><?php echo esc_html( $et_event_location ); ?></li>
					<?php endif; ?>
					<?php if ( $et_purchase_link ) : ?>
						<li class="clearfix"><a href="<?php echo esc_url( $et_purchase_link ); ?>" class="more"><?php esc_html_e( 'Purchase Tickets', 'Harmony' ); ?></a></li>
					<?php endif; ?>
					</ul> <!-- #event-properties -->
					
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
			
			<?php get_sidebar(); ?>
		</div> <!-- end #content-area -->
	</div> <!-- end .container -->
</div> <!-- end #main-area -->
	
<?php get_footer(); ?>