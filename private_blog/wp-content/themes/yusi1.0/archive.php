<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<header class="archive-header"> 
			<h1>Post of <?php 
				if(is_day()) echo the_time('Y-m-j');
				elseif(is_month()) echo the_time('Y yr m mo');
				elseif(is_year()) echo the_time('Y year'); 
			?></h1>
		</header>
		<?php include( 'modules/excerpt.php' ); ?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>