<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php bloginfo( 'name' ); ?></title>
	<?php elegant_description(); ?>
	<?php elegant_keywords(); ?>
	<?php elegant_canonical(); ?>

	<?php do_action('et_head_meta'); ?>
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php $template_directory_uri = get_template_directory_uri(); ?>
	<!--[if lt IE 9]>
		<script src="<?php echo esc_url( $template_directory_uri . '/js/html5.js"' ); ?>" type="text/javascript"></script>
	<![endif]-->

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>
	
	<?php wp_head(); ?>
	<link rel='stylesheet' id='harmony-fonts-css'  href='http://fonts.useso.com/css?family=Open+Sans:300italic,700italic,800italic,400,300,700,800&#038;subset=latin,latin-ext' type='text/css' media='all' />
</head>
<body <?php body_class(); ?>>
	
	<?php do_action('et_header_top'); ?>
	
	<header id="main-header" class="main_bg">
		<div class="container">
			<?php $logo = ( $user_logo = et_get_option( 'harmony_logo' ) ) && '' != $user_logo ? $user_logo : $template_directory_uri . '/images/logo.png'; ?>
			<a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo"/></a>
			
			<hgroup>
				<h1><?php //bloginfo( 'name' ); ?></h1>
				<h2><?php bloginfo( 'description' ); ?></h2>
			</hgroup>
		</div> <!-- end .container -->
	</header> <!-- end #main-header -->	
	<div id="main-nav">
		<div class="container clearfix">
			<nav id="top-menu">
			<?php
				$menuClass = 'nav';
				$primaryNav = '';
				
				if ( 'on' == et_get_option( 'harmony_disable_toptier' ) ) $menuClass .= ' et_disable_top_tier';

				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
				
				if ( '' == $primaryNav ) { ?>
					<ul class="<?php echo esc_attr( $menuClass ); ?>">
						<?php if ( 'on' == et_get_option( 'harmony_home_link' ) ) { ?>
							<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'Harmony' ); ?></a></li>
						<?php } ?>

						<?php show_page_menu( $menuClass, false, false ); ?>
						<?php show_categories_menu( $menuClass, false ); ?>
					</ul>
			<?php }
				else echo $primaryNav;
			?>
			</nav>
			
			<div id="social-icons">
			<?php
				$et_rss_url = '' != et_get_option( 'harmony_rss_url' ) ? et_get_option( 'harmony_rss_url' ) : get_bloginfo( 'comments_rss2_url' );
				if ( 'on' == et_get_option( 'harmony_show_twitter_icon', 'on' ) ) $social_icons['twitter'] = array( 'image' => $template_directory_uri . '/images/twitter.png', 'url' => et_get_option( 'harmony_twitter_url' ), 'alt' => __( 'Twitter', 'Harmony' ) );
				if ( 'on' == et_get_option( 'harmony_show_rss_icon', 'on' ) ) $social_icons['rss'] = array( 'image' => $template_directory_uri . '/images/rss.png', 'url' => $et_rss_url, 'alt' => __( 'Rss', 'Harmony' ) );
				if ( 'on' == et_get_option( 'harmony_show_facebook_icon','on' ) ) $social_icons['facebook'] = array( 'image' => $template_directory_uri . '/images/facebook.png', 'url' => et_get_option( 'harmony_facebook_url' ), 'alt' => __( 'Facebook', 'Harmony' ) );
				if ( 'on' == et_get_option( 'harmony_show_soundcloud_icon', 'on' ) ) $social_icons['soundcloud'] = array( 'image' => $template_directory_uri . '/images/soundcloud.png', 'url' => et_get_option( 'harmony_soundcloud_url' ), 'alt' => __( 'SoundCloud', 'Harmony' ) );
				
				if ( ! empty( $social_icons ) ) {
					$social_icons = apply_filters( 'et_social_icons', $social_icons );
					foreach ( $social_icons as $icon ) {
						if ( $icon['url'] ) 
							printf( '<a href="%s" target="_blank"><img src="%s" alt="%s" /></a>', esc_url( $icon['url'] ), esc_url( $icon['image'] ), esc_attr( $icon['alt'] ) );
					}
				}
			?>
			</div> <!-- end .#social-icons -->
		</div> <!-- end .container -->
	</div> <!-- end #main-nav -->
	
	<?php if ( ! is_home() ) get_template_part( 'includes/breadcrumbs' ); ?>