<!doctype html>
<!own FC-System> <!-- Marked by FC-System -->
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $site_name; ?></title>
	<link href="style.css" type="text/css" rel="stylesheet" />
</head>
<body>
	<?php if(!is_object($content)) {?>
	<div class="tw_login">
		<div class="inner">
			<div class="content">
				<a href="./redirect.php"><img width="145px" height="145px" src="./images/Twitter_Icon_b.png"/></a>
				<br/>
				<br/>
				Please click on <b>Twitter icon</b> to ( sign in <?php echo $site_name; ?> ) with your twitter account.
			</div>
		</div>
	</div>
	<?php } else {?>
	<div class="tw_info">
		<div class="inner">
			<div class="content">
				<a href="<?php echo 'https://twitter.com/'.$content->screen_name; ?>" target="_blank"><img width="145px" height="145px" src="<?php echo str_replace('_normal', '', $content->profile_image_url_https); ?>" style="border-radius: 20px"/></a>
				<h4><?php echo $content->name.'　(@'.$content->screen_name.')'; ?></h4>
				<hr/>
					<ul class="tw_profile">
						<li class="tweets"> <?php echo $content->statuses_count; ?>
						<li class="favorite"> <?php echo $content->favourites_count; ?>
						<li class="following"> <?php echo $content->friends_count; ?>
						<li class="follower"> <?php echo $content->followers_count; ?>
					</ul>
				<hr/>
				<br/>
				Your account has been logged in <?php echo $site_name;?>, System will retweet something about <b><?php echo $search_keyword; ?></b> for your account per each hour.
				<br/>
				<br/>
				If you are having issues try <a href='./clearsessions.php'>clearing your session</a>.
			</div>
		</div>
	</div>
	<?php } ?>
</body>
</html>