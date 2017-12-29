<?php get_header(); ?>
	<section id="primary" class="site-content">
		<div class="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header block">
				<p class="ui ribbon label red"><?php printf( __( '包含关键字 %s 的文章', 'amativeness' ), '<span>' . get_search_query() . '</span>' ); ?></p>
			</header>

			<?php amativeness_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'search-page', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php amativeness_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-0" class="post block no-results not-found">
				<header class="entry-header">
					<p class="ui ribbon label red"><?php _e( '没有发现诶', 'amativeness' ); ?></p>
				</header>

				<div class="entry-content">
					<p><?php _e( '抱歉，没有符合您搜索条件的结果。请换其它关键词再试。', 'amativeness' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>
		</div>
	</section><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>