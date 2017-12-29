<?php get_header(); ?>

	<section id="primary" class="site-content">
			<div class="main">
		
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

	</div><!-- main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>