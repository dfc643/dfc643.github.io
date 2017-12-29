<?php
//if(!defined('IN_KKFRAME')) exit();
?>
<!DOCTYPE html>
<html>
<head>
<title>用户中心 - 贴吧签到助手</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="renderer" content="webkit">
<link rel="stylesheet" href="./style/main.css?version=<?php echo VERSION; ?>" type="text/css" />
<link rel="stylesheet" href="./style/custom.css" type="text/css" />
</head>
<body>
<div class="wrapper" id="page_login">
<div class="center-box">
<div class="side-bar">
<span class="icon"></span>
<ul>
<li id="menu_login" class="current">登陆</li>
<li id="menu_register">注册</li>
</ul>
</div>
<div class="main" id="content-login">
<h1>登录 (极光039服务器)</h1>
<form method="post" action="member.php?action=login">
<div class="login-info">
<p>用户名：</p>
<p><input type="text" name="username" required tabindex="1" /></p>
<p>密码 (<a href="javascript:;" onClick="switch_tabs('find_password');" tabindex="0">找回密码</a>)：</p>
<p><input type="password" name="password" required tabindex="2" /></p>
<p>(此账号仅用于登陆代签系统，不同于百度通行证)</p>
<?php HOOK::run('login_form'); ?>
</div>
<p><input type="submit" value="登录" tabindex="3" /></p>
</form>
</div>
<div class="main hidden" id="content-register">
<h1>注册</h1>
<form method="post" action="member.php?action=register">
<div class="login-info">
<p>用户名：</p>
<p><input type="text" name="<?php echo $form_username; ?>" required tabindex="1" /></p>
<p>密码：</p>
<p><input type="password" name="<?php echo $form_password; ?>" required tabindex="2" /></p>
<p>邮箱：</p>
<p><input type="text" name="<?php echo $form_email; ?>" required tabindex="3" /></p>
<?php
if($invite_code) echo '<p>邀请码：</p><p><input type="text" name="invite_code" required /></p>';
?>
<p>(此账号仅用于登陆代签系统，不同于百度通行证)</p>
<?php HOOK::run('register_form'); ?>
</div>
<p><input type="submit" value="注册" tabindex="4" /></p>
</form>
</div>
<div class="main hidden" id="content-find_password">
<h1>找回密码</h1>
<form method="post" action="member.php?action=find_password">
<div class="login-info">
<p>用户名：</p>
<p><input type="text" name="username" required tabindex="1" /></p>
<p>邮箱：</p>
<p><input type="text" name="email" required tabindex="2" /></p>
</div>
<p><input type="submit" value="登录" tabindex="3" /></p>
</form>
</div>
</div>
<p class="copyright">当前程序运行于<a href="http://www.fcsys.org" target="_blank">极光计算机系统</a>的「039号」服务器之上</p>
<script src="http://lib.fcsys.org/jquery/jquery-1.10.2.min.js"></script>
<script src="system/js/member.js?version=<?php echo VERSION; ?>"></script>
<?php HOOK::run('member_footer'); ?>
</div>
<iframe src="index.php?action=cache_frame" style="display: none"></iframe>
</body>
</html>
