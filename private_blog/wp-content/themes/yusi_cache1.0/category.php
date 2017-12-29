<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<header class="archive-header"> 
			<h1><i class="fa fa-folder-open"></i>  &nbsp;Category：<?php single_cat_title() ?>  <a title="Subscribe <?php single_cat_title() ?>" target="_blank" href="<?php echo get_category_link( get_cat_ID( single_cat_title('',false) ) ); ?>/feed"><i class="rss fa fa-rss"></i></a></h1>
			<?php if ( category_description() ) echo '<div class="archive-header-info">'.category_description().'</div>'; ?>
		</header>
		<?php include( 'modules/excerpt.php' ); ?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>