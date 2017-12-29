<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<div <?php post_class() ?>>
		<span class="icon icon_aside" title="日志"></span>
		<header id="post_header">
			<h1><?php the_title(); ?></h1>
		</header>
		<article id="post_content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</article>
	</div>
<?php endwhile; ?>
<?php get_footer(); ?>