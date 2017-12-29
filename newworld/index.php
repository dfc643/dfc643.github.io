<?php get_header(); ?>

<!-- Contents -->			
			<div id="contents">
				<div id="main">
				
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<div class="post">
						<h2 class="title">
							<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						<div class="blog_info">
							<ul>
								<li class="cal"><?php the_time('Y年m月d日') ?></li>
								<li class="cat"><?php the_category(', ') ?></li>
								<li class="tag"><?php the_tags('', ', '); ?></li>
							</ul>
							<br class="clear" />
						</div>
						
						<?php if(has_post_thumbnail()) { echo the_post_thumbnail(); } ?>
						
						<?php the_content('余下全文'); ?>
					</div><!-- /.post -->
					
				<?php endwhile; ?>
				    
				    <div class="nav-below">
						<span class="nav-previous"><?php previous_posts_link('上一页') ?></span>
						<span class="nav-next"><?php next_posts_link('下一页') ?></span>
					</div><!-- /.nav-below -->
				 
				<?php else : ?>
				 
				    <h2 class="title">未找到相关文章</h2>
				    <p>搜索已经完成，但是并未找到相关的文章，请尝试修改搜索关键字然后再重新搜索。</p><br />
				    <?php get_search_form(); ?>
				 
				<?php endif; ?>
					
				</div><!-- /#main -->
				
<?php get_sidebar(); ?>
<?php get_footer(); ?>