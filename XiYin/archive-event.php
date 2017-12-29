<?php get_header(); ?>

<div id="main-area">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
	<?php 
		if ( have_posts() ) : ?>
				<h1 class="events-title"><?php esc_html_e( 'Upcoming Shows', 'Harmony' ); ?></h1>
				<ul id="events-list">
	<?php
			while ( have_posts() ) : the_post();
					get_template_part( 'content', 'event' );
			endwhile;
	?>
				</ul> <!-- #events-list -->'
	<?php		if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi();
				else get_template_part( 'includes/navigation', 'archive_event' );
			else:
				get_template_part( 'includes/no-results','archive_event' );
		endif;
	?>
			</div> <!-- end #left-area -->
			
			<?php get_sidebar(); ?>
		</div> <!-- end #content-area -->
	</div> <!-- end .container -->
</div> <!-- end #main-area -->
	
<?php get_footer(); ?>