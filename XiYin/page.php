<?php get_header(); ?>

<div id="main-area">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				
				<?php
					if ( comments_open() && 'on' == et_get_option( 'harmony_show_pagescomments', 'false' ) ) 
						comments_template( '', true );
				?>
				
			<?php endwhile; ?>
		
			</div> <!-- end #left-area -->
			
			<?php get_sidebar(); ?>
		</div> <!-- end #content-area -->
	</div> <!-- end .container -->
</div> <!-- end #main-area -->
	
<?php get_footer(); ?>