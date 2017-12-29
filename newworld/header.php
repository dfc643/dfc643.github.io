<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<!-- External files -->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>">

<!-- Favicon, Thumbnail image -->
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.png">
	
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page">
		<div id="wrapper">

<!-- Header -->		
			<div id="header">
				<?php if(is_home()): // ホームが表示されている場合、ブログタイトルを H1 で表示 ?>
					<h1><a href="<?php bloginfo('url'); ?>" class="blog_title"><?php bloginfo('name'); ?></a></h1>
				<?php else: // ホーム以外のページが表示されている場合は H1 を削除。各記事やページのタイトルに H1 を使用 ?>
					<a href="<?php bloginfo('url'); ?>" class="blog_title"><?php bloginfo('name'); ?></a>
				<?php endif; ?>
				
				<p><?php bloginfo('description'); ?></p>
				<?php wp_nav_menu( array('menu_id' => 'nav' )); ?>
			</div><!-- /#header -->