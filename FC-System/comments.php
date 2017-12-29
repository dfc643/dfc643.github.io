<div id="comments">	
	<span class="icon icon_comment" title="评论"></span>
	<?php if (have_comments()) : ?>
		<h3><?php comments_number(__('No Comments', '1 Comment', '% Comments' ));?></h3>
		<ol class="comment_list">
			<?php wp_list_comments( array ('avatar_size'=>36));?>
		</ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    		<nav class="navigation">
				<span class="icon icon_page" title="分页"></span>
				<?php previous_comments_link(('<' )); ?><?php next_comments_link(( '>' )); ?>
			</nav>
		<?php endif; ?>
	<?php endif; ?>
	<?php if (post_password_required()) : ?>
		<p>请输入密码查看评论。</p>
	<?php endif; ?>
	<?php if (!comments_open()) : ?>
		<p>评论已关闭。</p>
	<?php endif; ?>
	<?php comment_form(); ?>
</div>