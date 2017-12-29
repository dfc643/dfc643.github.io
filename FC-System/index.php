<?php get_header(); ?>
<div id="main">
	<?php if (is_search()) : ?>
		<div class="mini_nav">搜索： <strong><?php the_search_query(); ?></strong></div>
	<?php elseif (is_tag()) : ?>
		<div class="mini_nav">标签： <strong><?php single_tag_title(); ?></strong></div>
	<?php elseif (is_day()) : ?>
		<div class="mini_nav">日期： <strong><?php the_time('Y-m-d'); ?></strong></div>
	<?php elseif ( is_month() ) : ?>
		<div class="mini_nav">月份： <strong><?php the_time('Y-m'); ?></strong></div>
	<?php elseif ( is_year() ) : ?>
		<div class="mini_nav">年份： <strong><?php the_time('Y'); ?></strong></div>
	<?php endif; ?>
	<article id="post_list">
		<?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>
		<section <?php post_class(); ?>>
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
			<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<hr size="1" color="#2496ee" />
			<time class="time" datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
			<div style="font-size:9px;float:right;margin-top:-40px;height:13px;width:23px;"><?php edit_post_link(); ?></div>
			<?php if (!is_sticky() ) : ?>
				<?php if (has_post_thumbnail()) { ?>
					<div class="thumbnail"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a></div>
				<?php } ?>
				<?php the_content(('阅读详细 &raquo;')); ?>
			<?php endif; ?>
		</section>
		<?php endwhile; endif; ?>
	</article>
	<nav class="navigation">
		<span class="icon icon_page" title="分页"></span>
		<?php previous_posts_link(('<')) ?><?php next_posts_link(('>')) ?>
	</nav>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>