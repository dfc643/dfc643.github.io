<?php
global $epanelMainTabs, $themename, $shortname, $default_colorscheme, $options;

$default_colorscheme = "Default";

$epanelMainTabs = array('general','navigation','layout','ad','seo','integration','support');

$cats_array = get_categories('hide_empty=0');
$pages_array = get_pages('hide_empty=0');
$pages_number = count($pages_array);

$site_pages = array();
$site_cats = array();
$pages_ids = array();
$cats_ids = array();

foreach ($pages_array as $pagg) {
	$site_pages[$pagg->ID] = htmlspecialchars($pagg->post_title);
	$pages_ids[] = $pagg->ID;
}

foreach ($cats_array as $categs) {
	$site_cats[$categs->cat_ID] = $categs->cat_name;
	$cats_ids[] = $categs->cat_ID;
}

$options = array (

	array( "name" => "wrap-general",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "general-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("通用",$themename)),

			array( "name" => "general-2",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("首页",$themename)),

		array( "type" => "subnavtab-end",),

		array( "name" => "general-1",
			   "type" => "subcontent-start",),
			      
			/*array( "name" => esc_html__("Logo",$themename),
				   "id" => $shortname."_logo",
				   "type" => "upload",
				   "std" => "",
				   "desc" => esc_html__("If you would like to use your own custom logo image click the Upload Image button.",$themename)
			),*/

			array( "name" => esc_html__("标题前小图标",$themename),
				   "id" => $shortname."_favicon",
				   "type" => "upload",
				   "std" => "",
				   "desc" => esc_html__("在网页的标题栏的最前面添加一个属于本站点的小图标",$themename)
			),
			
			array( "name" => esc_html__("站点标题背景图案",$themename),
				   "id" => $shortname."_header_bg_image",
				   "type" => "upload",
				   "std" => "",
				   "desc" => esc_html__("该图案位于网页的最顶端，其前景为网页的标志与标题，您可以修改其背景图案。",$themename)
			),
			
			array( "name" => esc_html__("音乐播放器背景图案",$themename),
				   "id" => $shortname."_songs_bg_image",
				   "type" => "upload",
				   "std" => "",
				   "desc" => esc_html__("修改音乐播放器背景的图案，请点击上传按钮上传图片。",$themename)
			),
			
			array( "name" => esc_html__("商品展示背景图案",$themename),
				   "id" => $shortname."_media_bg_image",
				   "type" => "upload",
				   "std" => "",
				   "desc" => esc_html__("修改商品展示背景的图案，请点击上传按钮上传图片。",$themename)
			),

			array( "name" => esc_html__("以博文风格发表",$themename),
                   "id" => $shortname."_blog_style",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => esc_html__("默认情况下，该主题自动截断索引/主页你的职位，以创造职位预览。如果您愿意展示自己的帖子全部索引页像一个传统的博客，那么你可以激活此功能。",$themename)
			),

			array( "name" => esc_html__("抓取文章中首张图片",$themename),
				   "id" => $shortname."_grab_image",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__("默认情况下使用的自定义字段创建缩略图。但是，如果你宁愿使用已经在您的文章为您的缩略图（和旁路使用自定义字段）的图像，你可以激活此选项。一旦activcated缩略图会自动使用第一个图像在您的文章中产生。图像必须被托管在您自己的服务器上。",$themename)
			),

			array( "type" => "clearfix",),
			
			array( "name" => esc_html__( "显示 Twitter 图标", $themename ),
                   "id" => $shortname."_show_twitter_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__( "无说明", $themename )
			),
			
			array( "name" => esc_html__( "显示 RSS 订阅图标", $themename ),
                   "id" => $shortname."_show_rss_icon",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => esc_html__( "无说明", $themename )
			),

			array( "type" => "clearfix",),
			
			array( "name" => esc_html__( "显示 Facebook 图标", $themename ),
                   "id" => $shortname."_show_facebook_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__( "无说明", $themename )
			),
				   
			array( "name" => esc_html__( "显示 SoundCloud 图标", $themename ),
                   "id" => $shortname."_show_soundcloud_icon",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => esc_html__( "无说明", $themename )
			),
			
			array( "type" => "clearfix",),
			
			array( "name" => esc_html__( "Twitter 个人页面链接", $themename ),
                   "id" => $shortname."_twitter_url",
                   "std" => "",
                   "type" => "text",
				   "desc" => esc_html__( "无说明", $themename )
			),
			
			array( "name" => esc_html__( "RSS 订阅地址链接", $themename ),
                   "id" => $shortname."_rss_url",
                   "std" => "",
                   "type" => "text",
				   "desc" => esc_html__( "无说明", $themename )
			),
				   
			array( "name" => esc_html__( "Facebook 个人页面链接", $themename ),
                   "id" => $shortname."_facebook_url",
                   "std" => "",
                   "type" => "text",
				   "desc" => esc_html__( "无说明", $themename )
			),
				   
			array( "name" => esc_html__( "SoundCloud 个人页面链接", $themename ),
                   "id" => $shortname."_soundcloud_url",
                   "std" => "",
                   "type" => "text",
				   "desc" => esc_html__( "无说明 ", $themename )
			),
			
			/*array( "name" => esc_html__("Display shop pages as full width",$themename),
                   "id" => $shortname."_shop_pages_fullwidth",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can enable the option to display shop index pages as full width.",$themename)
			),
			
			array( "name" => esc_html__("Display product page as full width",$themename),
                   "id" => $shortname."_product_pages_fullwidth",
                   "type" => "checkbox2",
                   "std" => "false",
                   "desc" => esc_html__("Here you can enable the option to display product page as full width.",$themename)
			),*/

			array( "type" => "clearfix",),
							   				   
			array( "name" => esc_html__("在分类页面中每页显示文章数",$themename),
                   "id" => $shortname."_catnum_posts",
                   "std" => "6",
                   "type" => "text",
				   "desc" => esc_html__("在分类页面中每页显示文章数，超出内容将被分割到下一页。",$themename)
			),

			array( "name" => esc_html__("在按月份（存档）页面中每页显示文章数",$themename),
                   "id" => $shortname."_archivenum_posts",
                   "std" => "5",
                   "type" => "text",
				   "desc" => esc_html__("在按月份（存档）页面中每页显示文章数，超出内容将被分割到下一页。",$themename)
			),

			array( "name" => esc_html__("在搜索页面中每页显示文章数",$themename),
                   "id" => $shortname."_searchnum_posts",
                   "std" => "5",
                   "type" => "text",
				   "desc" => esc_html__("在搜索页面中每页显示文章数，超出内容将被分割到下一页。",$themename)
			),

			array( "name" => esc_html__("在标签浏览页面中每页显示文章数",$themename),
                   "id" => $shortname."_tagnum_posts",
                   "std" => "5",
                   "type" => "text",
				   "desc" => esc_html__("在标签浏览页面中每页显示文章数，超出内容将被分割到下一页。",$themename)
			),

			array( "name" => esc_html__("日期格式（建议Y-m-d）",$themename),
				   "id" => $shortname."_date_format",
				   "std" => "M j, Y",
                   "type" => "text",
				   "desc" => __("对于不同的国家地区都有不同的日期和时间的标准，请根据 WordPress <a href='http://codex.wordpress.org/Formatting_Date_and_Time' target='_blank'>日期与时间格式</a> 来设置相对应的日期时间格式。",$themename)
			),
				   				   
			array( "type" => "clearfix",),
			
			array( "name" => esc_html__("当文章有摘要时则显示摘要",$themename),
				   "id" => $shortname."_use_excerpt",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("如果文章中已经定义了摘要部分，则默认显示文章的摘要内容，而非文章内容。",$themename)
			),
			
			array( "name" => esc_html__("页面响应式设计",$themename),
				   "id" => $shortname."_responsive_shortcodes",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => esc_html__("启用本项目后，页面将会根据屏幕大小自动调整。",$themename)
			),

			array( "type" => "clearfix",),

		array( "name" => "general-1",
			   "type" => "subcontent-end",),

		array( "name" => "general-2",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("显示最近新闻（博文）模块",$themename),
                   "id" => $shortname."_display_news_section",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Recent News Section on the homepage.",$themename)
			),
			
			/*array( "name" => esc_html__("Display Upcoming Shows Section",$themename),
                   "id" => $shortname."_display_shows_section",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Upcoming Shows Section on the homepage.",$themename)
			),*/
			
			//array( "type" => "clearfix",),
			
			array( "name" => esc_html__("显示音乐播放器模块",$themename),
                   "id" => $shortname."_display_audio_section",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Featured Songs Section on the homepage.",$themename)
			),
			
			/*array( "name" => esc_html__("Display Featured Products Section",$themename),
                   "id" => $shortname."_display_shop_section",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Featured Products on the homepage.",$themename)
			),*/
			
			array( "type" => "clearfix",),
			
			array( "name" => esc_html__("显示商品展示模块",$themename),
                   "id" => $shortname."_display_gallery_section",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Media Gallery Section on the homepage.",$themename)
			),
	   				   
			array( "type" => "clearfix",),
			
			array( "name" => esc_html__("「更多新闻」按钮链接 ( 位于最近新闻[博文]模块 )",$themename),
                   "id" => $shortname."_more_news_link",
                   "std" => '',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define the 'read more' link url in the Recent News section on homepage",$themename)
			),
			
			array( "name" => esc_html__("在首页中最近新闻（博文）显示数量。请使用偶数",$themename),
                   "id" => $shortname."_homepage_posts",
                   "std" => "3",
                   "type" => "text",
				   "desc" => esc_html__("Here you can designate how many recent articles are displayed on the homepage. This option works independently from the Settings > Reading options in wp-admin.",$themename)
			),
			
			/*array( "name" => esc_html__("Number of Upcoming Shows",$themename),
                   "id" => $shortname."_home_events_number",
                   "std" => '3',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define the number of Upcoming Shows on homepage",$themename)
			),*/
			
			array( "name" => esc_html__("在音乐播放器中音乐列表显示数量",$themename),
                   "id" => $shortname."_audio_postsnum",
                   "std" => '4',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define the number of Featured Songs on homepage",$themename)
			),
			
			/*array( "name" => esc_html__("Number of Featured Products",$themename),
                   "id" => $shortname."_homepage_products_per_page",
                   "std" => '8',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define the number of Featured Products on homepage",$themename)
			),*/
			
			array( "name" => esc_html__("在商品展示中商品显示数量",$themename),
                   "id" => $shortname."_home_gallery_number",
                   "std" => '8',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define the number of Media Gallery items on homepage",$themename)
			),
			
			array( "name" => esc_html__("为最近新闻（博文）自定义一个标题",$themename),
                   "id" => $shortname."_recent_news_title",
                   "std" => '',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define Recent News section title on homepage",$themename)
			),
			
			/*array( "name" => esc_html__("Upcoming Shows Section custom title",$themename),
                   "id" => $shortname."_upcoming_shows_title",
                   "std" => '',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define Upcoming Shows Section custom title on homepage",$themename)
			),*/
			
			array( "name" => esc_html__("为音乐播放器自定义一个标题",$themename),
                   "id" => $shortname."_featured_songs_title",
                   "std" => '',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define Featured Songs Section custom title on homepage",$themename)
			),
			
			/*array( "name" => esc_html__("Featured Products Section custom title",$themename),
                   "id" => $shortname."_shop_section_title",
                   "std" => '',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define Featured Products Section custom title on homepage",$themename)
			),*/
			
			array( "name" => esc_html__("为商品展示自定义一个标题",$themename),
                   "id" => $shortname."_media_gallery_section_title",
                   "std" => '',
                   "type" => "text",
				   "desc" => esc_html__("Here you can define Media Gallery Section custom title on homepage",$themename)
			),
				   
			array( "name" => esc_html__("从下列的分类中提取最近新闻（博文）",$themename),
				   "id" => $shortname."_exlcats_recent",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => esc_html__("By default the homepage displays a list of all of your most recent posts. However, if you would like to exlcude certain category from the list you can do so here. ",$themename),
				   "usefor" => "categories",
				   "options" => $cats_ids),

		array( "name" => "general-2",
			   "type" => "subcontent-end",),

	array(  "name" => "wrap-general",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-navigation",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "navigation-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("页面",$themename)
			),

			array( "name" => "navigation-2",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("分类",$themename)
			),

			array( "name" => "navigation-3",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("通用",$themename)
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "navigation-1",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("若无菜单时在导航栏显示下列页面",$themename),
				   "id" => $shortname."_menupages",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => esc_html__("Here you can choose to remove certain pages from the navigation menu. All pages marked with an X will not appear in your navigation bar. ",$themename),
				   "usefor" => "pages",
				   "options" => $pages_ids),

			array( "name" => esc_html__("显示下拉菜单",$themename),
            "id" => $shortname."_enable_dropdowns",
            "type" => "checkbox",
            "std" => "on",
			"desc" => esc_html__("If you would like to remove the dropdown menus from the pages navigation bar disable this feature.",$themename)
			),

			array( "name" => esc_html__("显示首页链接",$themename),
            "id" => $shortname."_home_link",
            "type" => "checkbox2",
            "std" => "on",
			"desc" => esc_html__("By default the theme creates a Home link that, when clicked, leads back to your blog's homepage. If, however, you are using a static homepage and have already created a page called Home to use, this will result in a duplicate link. In this case you should disable this feature to remove the link.",$themename)
			),

			array( "type" => "clearfix",),

			array( "name" => esc_html__("页面排序",$themename),
                   "id" => $shortname."_sort_pages",
                   "type" => "select",
                   "std" => "post_title",
				   "desc" => esc_html__("Here you can choose to sort your pages links.",$themename),
                   "options" => array("post_title", "menu_order","post_date","post_modified","ID","post_author","post_name")),

			array( "name" => esc_html__("页面升降序",$themename),
                   "id" => $shortname."_order_page",
                   "type" => "select",
                   "std" => "asc",
				   "desc" => esc_html__("Here you can choose to reverse the order that your pages links are displayed. You can choose between ascending and descending.",$themename),
                   "options" => array("asc", "desc")),

			array( "name" => esc_html__("下拉菜单显示层数",$themename),
            "id" => $shortname."_tiers_shown_pages",
            "type" => "text",
            "std" => "3",
			"desc" => esc_html__("This options allows you to control how many teirs your pages dropdown menu has. Increasing the number allows for additional menu items to be shown.",$themename)
			),

			array( "type" => "clearfix",),


		array( "name" => "navigation-1",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-2",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("若无菜单时在导航栏显示下列分类",$themename),
				   "id" => $shortname."_menucats",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => esc_html__("Here you can choose to remove certain categories from the navigation menu. All categories marked with an X will not appear in your navigation bar. ",$themename),
				   "usefor" => "categories",
				   "options" => $cats_ids),

			array( "name" => esc_html__("显示下拉菜单",$themename),
            "id" => $shortname."_enable_dropdowns_categories",
            "type" => "checkbox",
            "std" => "on",
			"desc" => esc_html__("If you would like to remove the dropdown menus from the categories navigation bar disable this feature.",$themename)
			),

			array( "name" => esc_html__("隐藏空分类",$themename),
            "id" => $shortname."_categories_empty",
            "type" => "checkbox",
            "std" => "on",
			"desc" => esc_html__("If you would like categories to be displayed in your navigationbar that don't have any posts in them then disable this option. By default empty categories are hidden",$themename)
			),

			array( "type" => "clearfix",),

			array( "name" => esc_html__("下拉菜单显示层数",$themename),
            "id" => $shortname."_tiers_shown_categories",
            "type" => "text",
            "std" => "3",
			"desc" => esc_html__("This options allows you to control how many teirs your pages dropdown menu has. Increasing the number allows for additional menu items to be shown.",$themename)
			),

			array( "type" => "clearfix",),

		    array( "name" => esc_html__("分类排序",$themename),
                   "id" => $shortname."_sort_cat",
                   "type" => "select",
                   "std" => "name",
				   "desc" => esc_html__("By default pages are sorted by name. However if you would rather have them sorted by ID you can adjust this setting.",$themename),
                   "options" => array("name", "ID", "slug", "count", "term_group")),

			array( "name" => esc_html__("分类升降序",$themename),
                   "id" => $shortname."_order_cat",
                   "type" => "select",
                   "std" => "asc",
				   "desc" => esc_html__("Here you can choose to reverse the order that your categories links are displayed. You can choose between ascending and descending.",$themename),
                   "options" => array("asc", "desc")),

		array( "name" => "navigation-2",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-3",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("若有下拉菜单则使顶层链接无效化",$themename),
            "id" => $shortname."_disable_toptier",
            "type" => "checkbox2",
            "std" => "false",
			"desc" => esc_html__("In some cases users will want to create parent categories or links as placeholders to hold a list of child links or categories. In this case it is not desirable to have the parent links lead anywhere, but instead merely serve an organizational function. Enabling this options will remove the links from all parent pages/categories so that they don't lead anywhere when clicked.",$themename)
			),

			array( "type" => "clearfix",),

		array( "name" => "navigation-3",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-navigation",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-layout",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "layout-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("单文章布局",$themename)
			),

			array( "name" => "layout-2",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("单页面布局",$themename)
			),

			array( "name" => "layout-3",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("通用设置",$themename)
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "layout-1",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("在文章信息区域显示什么内容",$themename),
				   "id" => $shortname."_postinfo2",
				   "type" => "different_checkboxes",
				   "std" => array("author","date"),
				   "desc" => esc_html__("Here you can choose which items appear in the postinfo section on single post pages. This is the area, usually below the post title, which displays basic information about your post. The highlighted itmes shown below will appear. ",$themename),
				   "options" => array("author","date","categories","comments")),

			array( "name" => esc_html__("在文章内替换缩略图",$themename),
                   "id" => $shortname."_thumbnails",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("By default thumbnails are placed at the beginning of your post on single post pages. If you would like to remove this initial thumbnail image to avoid repetition simply disable this option. ",$themename)
			),
				   
			array( "name" => esc_html__("在文章内显示评论框",$themename),
            "id" => $shortname."_show_postcomments",
            "type" => "checkbox2",
            "std" => "on",
			"desc" => esc_html__("You can disable this option if you want to remove the comments and comment form from single post pages. ",$themename)
			),

			array( "type" => "clearfix",),

		array( "name" => "layout-1",
			   "type" => "subcontent-end",),

		array( "name" => "layout-2",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("在页面内替换缩略图",$themename),
                   "id" => $shortname."_page_thumbnails",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => esc_html__("By default thumbnails are not placed on pages (they are only used on posts). However, if you want to use thumbnails on posts you can! Just enable this option. ",$themename)
			),

			array( "name" => esc_html__("在页面内显示评论框",$themename),
            "id" => $shortname."_show_pagescomments",
            "type" => "checkbox",
            "std" => "false",
			"desc" => esc_html__("By default comments are not placed on pages, however, if you would like to allow people to comment on your pages simply enable this option. ",$themename)
			),

			array( "type" => "clearfix",),

		array( "name" => "layout-2",
			   "type" => "subcontent-end",),

		array( "name" => "layout-3",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("文章信息模块",$themename),
				   "id" => $shortname."_postinfo1",
				   "type" => "different_checkboxes",
				   "std" => array("author","date"),
				   "desc" => esc_html__("Here you can choose which items appear in the postinfo section on pages. This is the area, usually below the post title, which displays basic information about your post. The highlighted itmes shown below will appear. ",$themename),
				   "options" => array("author","date","categories", "comments")),
				   
			array( "type" => "clearfix",),
				   
			array( "name" => esc_html__("在首页显示缩略图",$themename),
                   "id" => $shortname."_thumbnails_index",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Enable this option to show thumbnails on Index Pages.",$themename)
			),

			array( "type" => "clearfix",),

		array( "name" => "layout-3",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-layout",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//
	array( "name" => "wrap-seo",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "seo-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Homepage SEO",$themename)
			),

			array( "name" => "seo-2",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Single Post Page SEO",$themename)
			),

			array( "name" => "seo-3",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Index Page SEO",$themename)
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "seo-1",
			   "type" => "subcontent-start",),

			/*array( "name" => esc_html__(" Enable custom title ",$themename),
				   "id" => $shortname."_seo_home_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default the theme uses a combination of your blog name and your blog description, as defined when you created your blog, to create your homepage titles. However if you want to create a custom title then simply enable this option and fill in the custom title field below. ",$themename)
			),*/

			array( "name" => esc_html__(" 启用 meta 描述",$themename),
				   "id" => $shortname."_seo_home_description",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default the theme uses your blog description, as defined when you created your blog, to fill in the meta description field. If you would like to use a different description then enable this option and fill in the custom description field below. ",$themename)
			),

			array( "name" => esc_html__(" 启用 meta 关键字",$themename),
				   "id" => $shortname."_seo_home_keywords",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default the theme does not add keywords to your header. Most search engines don't use keywords to rank your site anymore, but some people define them anyway just in case. If you want to add meta keywords to your header then enable this option and fill in the custom keywords field below. ",$themename)
			),

			array( "name" => esc_html__(" 启用规范化 URL",$themename),
				   "id" => $shortname."_seo_home_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URLs all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",$themename)
			),

			array( "type" => "clearfix",),

			/*array( "name" => esc_html__("Homepage custom title (if enabled)",$themename),
				   "id" => $shortname."_seo_home_titletext",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("If you have enabled custom titles you can add your custom title here. Whatever you type here will be placed between the < title >< /title > tags in header.php",$themename)
			),*/

			array( "name" => esc_html__("主页 meta 描述信息 (若启用)",$themename),
				   "id" => $shortname."_seo_home_descriptiontext",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("If you have enabled meta descriptions you can add your custom description here.",$themename)
			),

			array( "name" => esc_html__("主页 meta 关键字 (若启用)",$themename),
				   "id" => $shortname."_seo_home_keywordstext",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("If you have enabled meta keywords you can add your custom keywords here. Keywords should be separated by comas. For example: wordpress,themes,templates,elegant",$themename)
			),

			/*array( "name" => esc_html__("If custom titles are disabled, choose autogeneration method",$themename),
				   "id" => $shortname."_seo_home_type",
				   "type" => "select",
				   "std" => "BlogName | Blog description",
				   "options" => array("BlogName | Blog description", "Blog description | BlogName", "BlogName only"),
				   "desc" => esc_html__("If you are not using cutsom post titles you can still have control over how your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.",$themename)
			),*/

			/*array( "name" => esc_html__("Define a character to separate BlogName and Post title",$themename),
				   "id" => $shortname."_seo_home_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => esc_html__("Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -",$themename)
			),*/

		array( "name" => "seo-1",
			   "type" => "subcontent-end",),

		array( "name" => "seo-2",
			   "type" => "subcontent-start",),

			/*array( "name" => esc_html__("Enable custom titles",$themename),
				   "id" => $shortname."_seo_single_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default the theme creates post titles based on the title of your post and your blog name. If you would like to make your meta title different than your actual post title you can define a custom title for each post using custom fields. This option must be enabled for custom titles to work, and you must choose a custom field name for your title below.",$themename)
			),*/

			array( "name" => esc_html__("启用自定义描述",$themename),
				   "id" => $shortname."_seo_single_description",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__("If you would like to add a meta description to your post you can do so using custom fields. This option must be enabled for descriptions to be displayed on post pages. You can add your meta description using custom fields based off the custom field name you define below.",$themename)
			),

			array( "type" => "clearfix",),

			array( "name" => esc_html__("启用自定义关键字",$themename),
				   "id" => $shortname."_seo_single_keywords",
				   	"type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("If you would like to add meta keywords to your post you can do so using custom fields. This option must be enabled for keywords to be displayed on post pages. You can add your meta keywords using custom fields based off the custom field name you define below.",$themename)
			),

			array( "name" => esc_html__("启用规范化 URL",$themename),
				   "id" => $shortname."_seo_single_canonical",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__("Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",$themename)
			),

			array( "type" => "clearfix",),

			/*array( "name" => esc_html__("Custom field Name to be used for title",$themename),
				   "id" => $shortname."_seo_single_field_title",
				   "type" => "text",
				   "std" => "seo_title",
				   "desc" => esc_html__("When you define your title using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom title you would like to use.",$themename)
			),*/

			array( "name" => esc_html__("用于描述的自定义名称",$themename),
				   "id" => $shortname."_seo_single_field_description",
				   "type" => "text",
				   "std" => "seo_description",
				   "desc" => esc_html__("When you define your meta description using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom description you would like to use.",$themename)
			),

			array( "name" => esc_html__("用于关键字的自定义名称",$themename),
				   "id" => $shortname."_seo_single_field_keywords",
				   "type" => "text",
				   "std" => "seo_keywords",
				   "desc" => esc_html__("When you define your keywords using custom fields you should use this value for the custom field Name. The Value of your custom field should be the meta keywords you would like to use, separated by comas.",$themename)
			),

			/*array( "name" => esc_html__("If custom titles are disabled, choose autogeneration method",$themename),
				   "id" => $shortname."_seo_single_type",
				   "type" => "select",
				   "std" => "Post title | BlogName",
				   "options" => array("Post title | BlogName", "BlogName | Post title", "Post title only"),
				   "desc" => esc_html__("If you are not using cutsom post titles you can still have control over hw your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.",$themename)
			),

			array( "name" => esc_html__("Define a character to separate BlogName and Post title",$themename),
				   "id" => $shortname."_seo_single_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => esc_html__("Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -",$themename)
			),*/

		array( "name" => "seo-2",
			   "type" => "subcontent-end",),

		array( "name" => "seo-3",
				   "type" => "subcontent-start",),

			array( "name" => esc_html__(" 启用规范化 URL",$themename),
				   "id" => $shortname."_seo_index_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",$themename)
			),

			array( "name" => esc_html__("启用 meta 描述",$themename),
				   "id" => $shortname."_seo_index_description",
				   	"type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__("Check this box if you want to display meta descriptions on category/archive pages. The description is based off the category description you choose when creating/edit your category in wp-admin.",$themename)
			),

			//array( "type" => "clearfix",),

			/*array( "name" => esc_html__("Choose title autogeneration method",$themename),
				   "id" => $shortname."_seo_index_type",
				   "type" => "select",
				   "std" => "Category name | BlogName",
				   "options" => array("Category name | BlogName", "BlogName | Category name", "Category name only"),
				   "desc" => esc_html__("Here you can choose how your titles on index pages are generated. You can change which order your blog name and index title are displayed, or you can remove the blog name from the title completely.",$themename)
			),

			array( "name" => esc_html__("Define a character to separate BlogName and Post title",$themename),
				   "id" => $shortname."_seo_index_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => esc_html__("Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",$themename)
			),*/

			array( "type" => "clearfix",),

		array( "name" => "seo-3",
				   "type" => "subcontent-end",),

	array(  "name" => "wrap-seo",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-integration",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "integration-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("代码整合",$themename)
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "integration-1",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("启用 head 区域代码",$themename),
                   "id" => $shortname."_integrate_header_enable",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Disabling this option will remove the header code below from your blog. This allows you to remove the code while saving it for later use.",$themename)
			),

			array( "name" => esc_html__("启用 body 区域代码",$themename),
                   "id" => $shortname."_integrate_body_enable",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => esc_html__("Disabling this option will remove the body code below from your blog. This allows you to remove the code while saving it for later use.",$themename)
			),

			array( "type" => "clearfix",),

			array( "name" => esc_html__("启用单页 top 代码",$themename),
                   "id" => $shortname."_integrate_singletop_enable",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Disabling this option will remove the single top code below from your blog. This allows you to remove the code while saving it for later use.",$themename)
			),

			array( "name" => esc_html__("启用单页 bottom 代码",$themename),
                   "id" => $shortname."_integrate_singlebottom_enable",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => esc_html__("Disabling this option will remove the single bottom code below from your blog. This allows you to remove the code while saving it for later use.",$themename)
			),

			array( "type" => "clearfix",),

			array( "name" => esc_html__("添加代码到 < head > 区域",$themename),
				   "id" => $shortname."_integration_head",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Any code you place here will appear in the head section of every page of your blog. This is useful when you need to add javascript or css to all pages.",$themename)
			),

			array( "name" => esc_html__("添加代码到 < body > 区域",$themename),
				   "id" => $shortname."_integration_body",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Any code you place here will appear in body section of all pages of your blog. This is usefull if you need to input a tracking pixel for a state counter such as Google Analytics.",$themename)
			),

			array( "name" => esc_html__("在文章的顶部添加如下代码",$themename),
				   "id" => $shortname."_integration_single_top",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Any code you place here will be placed at the top of all single posts. This is useful if you are looking to integrating things such as social bookmarking links.",$themename)
			),

			array( "name" => esc_html__("在文章底部评论框前添加如下代码",$themename),
				   "id" => $shortname."_integration_single_bottom",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Any code you place here will be placed at the top of all single posts. This is useful if you are looking to integrating things such as social bookmarking links.",$themename)
			),

		array( "name" => "integration-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-integration",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "support-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("参考文档",$themename)
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "support-1",
			   "type" => "subcontent-start",),

			array( "name" => "installation",
				   "type" => "support",),

		array( "name" => "support-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-advertisements",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "advertisements-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("广告",$themename)
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "advertisements-1",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("启用文章单页的 468x60 banner",$themename),
				   "id" => $shortname."_468_enable",
				   	"type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("Enabling this option will display a 468x60 banner ad on the bottom of your post pages below the single post content. If enabled you must fill in the banner image and destination url below.",$themename)
			),
			
			array( "type" => "clearfix",),

			array( "name" => esc_html__("给定 468x60 banner 广告的图像",$themename),
				   "id" => $shortname."_468_image",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",$themename)
			),

			array( "name" => esc_html__("给定 468x60 广告的目的 url",$themename),
				   "id" => $shortname."_468_url",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",$themename)
			),
				   
			array( "name" => esc_html__("给定 468x60 广告的 adsense 代码",$themename),
				   "id" => $shortname."_468_adsense",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Place your adsense code here.",$themename)
			),

		array( "name" => "advertisements-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

); 


function custom_colors_css(){
	global $shortname; ?>
	
	<style type="text/css">
		body { color: #<?php echo esc_html(et_get_option($shortname.'_color_mainfont')); ?>; }
		#content-area a { color: #<?php echo esc_html(et_get_option($shortname.'_color_mainlink')); ?>; }
		ul.nav li a { color: #<?php echo esc_html(et_get_option($shortname.'_color_pagelink')); ?> !important; }
		ul.nav > li.current_page_item > a, ul#top-menu > li:hover > a, ul.nav > li.current-cat > a { color: #<?php echo esc_html(et_get_option($shortname.'_color_pagelink_active')); ?>; }
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: #<?php echo esc_html(et_get_option($shortname.'_color_headings')); ?>; }
		
		#sidebar a { color:#<?php echo esc_html(et_get_option($shortname.'_color_sidebar_links')); ?>; }		
		.footer-widget { color:#<?php echo esc_html(et_get_option($shortname.'_footer_text')); ?> }
		#footer a, ul#bottom-menu li a { color:#<?php echo esc_html(et_get_option($shortname.'_color_footerlinks')); ?> }
	</style>

<?php } ?>