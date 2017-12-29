<?php
/**
 * The template for displaying events on archive pages
 *
 */
?>
<li id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>

<?php
$et_event_date = get_post_meta( get_the_ID(), '_et_event_date', true ); 
$et_event_location = get_post_meta( get_the_ID(), '_et_event_location', true );
if ( '' != $et_event_date ) : ?>
	<div class="show-date">
		<span class="post-meta"><?php echo date( _x( 'M', 'Event date format', 'Harmony' ), $et_event_date ); ?><span><?php echo date( _x( 'd', 'Event day format', 'Harmony' ), $et_event_date ); ?></span></span>
	</div>
<?php endif; ?>
	<div class="event-title-area">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		
	<?php if ( '' != $et_event_location ) : ?>
		<p><?php echo esc_html( $et_event_location ); ?></p>
	<?php endif; ?>
	</div> <!-- .event-title-area -->
	
	<a href="<?php the_permalink(); ?>" class="more"><?php esc_html_e( 'Event Info', 'Harmony' ); ?></a>
</li> <!-- end .post-->