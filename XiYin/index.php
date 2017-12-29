<?php get_header(); ?>

<div id="main-area">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
		<?php 
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;
				if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi();
				else get_template_part( 'includes/navigation', 'index' );
			else:
				get_template_part( 'includes/no-results','index' );
			endif;
		?>
			</div> <!-- end #left-area -->
			
			<?php get_sidebar(); ?>
		</div> <!-- end #content-area -->
	</div> <!-- end .container -->
</div> <!-- end #main-area -->
	
<?php get_footer(); ?>