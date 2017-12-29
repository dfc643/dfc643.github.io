<!DOCTYPE html>
<!OWN FC-SYSTEM>
<html lang="en">
<head profile="http://gmpg.org/xfn/11">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf(( 'Page %s' ), max( $paged, $page ) );
	?></title>
	<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!--[if IE]>
    	<script src="<?php bloginfo('template_directory'); ?>/html5.js"></script>
	<![endif]-->
	<?php 
		if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		wp_head();
	?>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/javascript/CJL.0.1.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/javascript/cmenu.js"></script>
</head>

<body>
<header id="header_FC">
    <div class="m_sub_fc" id="ro_BLANK_OF_LOGO"><div id="id_logo" class="ro_item" style="background-color:#2496ee;width:200px;"></div></div>
    <div class="m_sub_fc" id="ro_BLANK_OF_LOGO"><div id="id_logo" class="ro_item" style="background-color:#2496ee;width:200px;"></div></div>
    <div class="m_sub_fc" id="ro_TOP">

        <!-- LOGO -->
        <div id="id_logo_img" class="ro_item" style="background-color:#2496ee;height:50px;">
            <center><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a></center>
        </div>
        
        <!-- MENU -->
        <div id="ro_BLANK_OF_MENU" class="ro_item" style="width:23px;"></div>
        <div id="ro_toolbar" class="ro_item" style="background-color:#FFFFFF;height:50px;line-height:50px;">
            <table id="idMenu" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td id="m_bbs"><a href="../phpwind">北极社</a></td>
                    <td id="m_tv"><a href="../../style.fc/html.html.612/live.html">北极光</a></td>
                    <td id="m_hikaru"><a href="../Sliverlight/xmas/default.htm">蓝泽光</a></td>
                    <td id="m_data"><a href="../../data/">藏物馆</a></td>
                    <td id="m_fcsys"><a href="../../">返回小屋</a></td>
                </tr>
            </table>
            <script>
                $$A.forEach($$("idMenu").getElementsByTagName("td"), function(x, i){
                    var a = x.getElementsByTagName("a")[0], href = a.href, txt = a.innerHTML;
                    x.onclick = function(){ location.href = href; }
                    x.innerHTML = txt;            
                    var ct1 = new ColorTrans(x, { to: "white" }),
                        ct2 = new ColorTrans(x, { to: "#2496ee", style: "backgroundColor" });
                    x.onmouseover = function(){ ct1.transIn(); ct2.transIn(); }
                    x.onmouseout = function(){ ct1.transOut(); ct2.transOut(); }
                })
            </script>
        </div>
    </div>
	<!--<div id="header_box">
		<hgroup>
			<h1><a href="<?php //echo esc_url( home_url( '/' ) ); ?>"><?php //bloginfo('name'); ?></a></h1>
			<h2><?php //bloginfo('description'); ?></h2>
		</hgroup>
		<div id="toolbar">
			<div id="rss"><a href="<?php //bloginfo('rss2_url'); ?>" title="RSS Feed">RSS</a></div>
			<form id="searchform" method="get" action="<?php //echo esc_url( home_url( '/' ) ); ?>">
				<input type="text" value="<?php //the_search_query(); ?>" name="s" id="s" size="30" placeholder="Search" autocomplete="off" required />
				<button type="submit">Search</button>
			</form>
		</div>
	</div>-->
</header>
<nav id="menu"><?php wp_nav_menu( array('theme_location'=>'header-menu', 'container'=>'false', 'menu_class'=>'nav')); ?></nav>
<div id="content">