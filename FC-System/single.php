<?php get_header(); ?>
<div id="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<div <?php post_class() ?>>
			<?php if (has_post_format('video')) : ?>
				<span class="icon icon_video" title="视频"></span>
			<?php elseif (has_post_format('audio')) : ?>
				<span class="icon icon_audio" title="音频"></span>
			<?php elseif (has_post_format('gallery')) : ?>
				<span class="icon icon_gallery" title="图片"></span>
			<?php elseif (has_post_format('aside')) : ?>
				<span class="icon icon_aside" title="日志"></span>
			<?php else : ?>
				<span class="icon icon_aside" title="日志"></span>
			<?php endif; ?>
			<header id="post_header">
				<h1><?php the_title(); ?></h1>
				<time class="time" datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
			</header>
			<article id="post_content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</article>
			<?php if(has_tag()) : ?>
				<footer id="post_footer">
					<span class="icon icon_tag" title="标签"></span>
					<?php the_tags((' '), ', '); ?>
				</footer>
			<?php endif; ?>
			<div class="adbanner">
                <!-- There for the advertisement banner size:728*90 IMG [ONLY ONE]-->
			</div>
		</div>
	<?php endwhile; ?>
	<?php comments_template(); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>