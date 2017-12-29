<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?php wp_title('-', true, 'right'); /*echo get_option('blogname');*/ if (is_home ()) echo get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?></title>
<?php
$sr_1 = 0; $sr_2 = 0; $commenton = 0; 
if( dopt('d_sideroll_b') ){ 
    $sr_1 = dopt('d_sideroll_1');
    $sr_2 = dopt('d_sideroll_2');
}
if( is_singular() ){ 
    if( comments_open() ) $commenton = 1;
}
?>
<script>
window._deel = {name: '<?php bloginfo('name') ?>',url: '<?php echo get_bloginfo("template_url") ?>', ajaxpager: '<?php echo dopt('d_ajaxpager_b') ?>', commenton: <?php echo $commenton ?>, roll: [<?php echo $sr_1 ?>,<?php echo $sr_2 ?>]}
</script>
<?php 
wp_head(); 
if( dopt('d_headcode_b') ) echo dopt('d_headcode'); ?>
<!--[if lt IE 9]><script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script><![endif]-->
<!-- GOOGLE FONT -->
<link href='//fonts.lug.ustc.edu.cn/css?family=Josefin+Sans|Cinzel+Decorative' rel='stylesheet' type='text/css'>
</head>
<body <?php body_class(); ?>>

<header id="header" class="header">
<div id="nav-header" class="navbar">
    
    <ul class="nav">
        <li class="title">Norckon</li>
        <?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>
<li style="float:right;">
                <div class="toggle-search"><i class="fa fa-search"></i></div>
<div class="search-expand" style="display: none;"><div class="search-expand-inner"><form method="get" class="searchform themeform" onsubmit="location.href='<?php echo home_url('/?s='); ?>' + encodeURIComponent(this.s.value).replace(/%20/g, '+'); return false;" action="/"><div> <input type="ext" class="search" name="s" onblur="if(this.value=='')this.value='search...';" onfocus="if(this.value=='search...')this.value='';" value="search..."></div></form></div></div>
</li>
    </ul>
</div>
</div>

<div class="container-inner" <?php if( true || $_SERVER['REQUEST_URI'] == "/") {echo 'style="display:none"';} ?>>
 <div class="yusi-logo">
<a href="/">
<h1>
<span class="yusi-mono"><?php bloginfo('name'); ?></span>
<span class="yusi-bloger"><?php bloginfo('description'); ?></span>
</h1>
</a>
</div>
</div>
</header>


<?php if( false && $_SERVER['REQUEST_URI'] == "/") { //已禁用 ?>
<div class="hot-article">
<?php 
$result = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='views' ORDER BY CAST(`meta_value` AS DECIMAL) DESC LIMIT 0 , 5"); 
$i=0;
    foreach ($result as $postmeta) {
        query_posts('p='.$postmeta->post_id);
        while (have_posts()): the_post();
            if (preg_match("/[\x7f-\x80]/", $new_str=deel_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 310, ' ...'))) {$new_str = deel_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 90, ' ...');}
            /*$category = get_the_category();
            $catLink = get_category_link($category[0]->term_id);
            $catName = $category[0]->cat_name;*/
            $the_title[$i] = google_translate(the_title('','',false));
            $the_permalink[$i] = get_permalink();
            $the_note[$i] = google_translate($new_str);
            $the_thumb[$i] = get_thumbnail_src();
        endwhile;
    wp_reset_query();
    $i++;
    }
?>
    <div class="bg-blur">
        <?php for($i=0;$i<5;$i++) { ?>
            <div class="bg-blur-item" id="bg-blur-<?php echo $i; ?>" style="background:url(<?php echo $the_thumb[$i]; ?>)"></div>
        <?php } ?>
    </div>
    <div class="content-container">
        <div class="content-area">
            <?php for($i=0;$i<5;$i++) { ?>
                <div class="content-area-item" id="content-area-<?php echo $i; ?>">
                    <a class="img" href="<?php echo $the_permalink[$i]; ?>" title="<?php echo $the_title[$i]; ?>" target="_blank">
                        <img src="<?php echo $the_thumb[$i]; ?>" alt="<?php echo $the_title[$i]; ?>"/>
                    </a>
                    <div class="desc">
                        <div class="desc-title"><a href="<?php echo $the_permalink[$i]; ?>" title="<?php echo $the_title[$i]; ?>" target="_blank"><?php echo $the_title[$i]; ?></a></div>
                        <div class="desc-note"><?php echo $the_note[$i]; ?></div>
                        <!--<div class="desc-cat"><a href="<?php //echo $catLink; ?>" target="_blank"><?php //echo $catName; ?></a></div>-->
                        <div class="desc-more"><a href="<?php echo $the_permalink[$i]; ?>" target="_blank">More &gt;</a></div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="content-thumb">
            <?php for($i=0;$i<5;$i++) { ?>
                <a class="content-thumb-item" id="content-thumb-<?php echo $i; ?>" href="<?php echo $the_permalink[$i]; ?>" title="<?php echo $the_title[$i]; ?>" target="_blank" onmouseover="hmouseover(<?php echo $i; ?>)" onmouseout="t2=setTimeout('timedCount()',5000);">
                    <img src="<?php echo $the_thumb[$i]; ?>"/>
                    <div class="thumb-title"><?php echo $the_title[$i]; ?></div>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var c=0;
    var t;
    var t2;
    
    document.getElementById('bg-blur-0').className = 'bg-blur-item active';
    document.getElementById('content-area-0').className = 'content-area-item active';
    document.getElementById('content-thumb-0').className = 'content-thumb-item active';
    
    function hotSwitch(citem) {
        for (var i=0;i<5;i++) {
            document.getElementById('bg-blur-'+i).className = 'bg-blur-item';
            document.getElementById('content-area-'+i).className = 'content-area-item';
            document.getElementById('content-thumb-'+i).className = 'content-thumb-item';
        }
        document.getElementById('bg-blur-'+citem).className = 'bg-blur-item active';
        document.getElementById('content-area-'+citem).className = 'content-area-item active';
        document.getElementById('content-thumb-'+citem).className = 'content-thumb-item active';
    }
    
    function timedCount()
    {
        if(c==5) c=0;
        hotSwitch(c);
        c=c+1;
        t=setTimeout("timedCount()",15000);
    }
    
    function hmouseover(citem) {
        hotSwitch(citem);
        clearTimeout(t);
        clearTimeout(t2);
    }
    
    timedCount();
</script>
<?php } ?>


<section class="container"><div class="speedbar">
		<?php 
		if( dopt('d_sign_b') ){ 
			global $current_user; 
			get_currentuserinfo();
			$uid = $current_user->ID;
			$u_name = get_user_meta($uid,'nickname',true);
		?>
			<div class="pull-right">
				<?php if(is_user_logged_in()){echo '<i class="fa fa-user"></i> '.$u_name.' &nbsp; '; echo ' &nbsp; &nbsp; <i class="fa fa-power-off"></i> ';}else{echo '<i class="fa fa-user"></i> ';}; wp_loginout(); ?>
			</div>
		<?php } ?>
		<div class="toptip"><strong class="text-success"><i class="fa fa-volume-up"></i> </strong> <?php echo dopt('d_tui'); ?></div>
	</div>
	<?php if( dopt('d_adsite_01_b') ) echo '<div class="banner banner-site">'.dopt('d_adsite_01').'</div>'; ?>