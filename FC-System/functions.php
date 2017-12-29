<?php
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => 'Sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		));
	}
	register_nav_menus(
		array(
			'header-menu' => 'header-menu'
		)
	);
	add_theme_support( 'post-formats', array( 'aside', 'gallery','video','audio' ) );
	if ( ! isset( $content_width ) ) $content_width = 800;
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
		set_post_thumbnail_size( 200, 150, true );
	}
?>