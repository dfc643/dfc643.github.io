l<?php
//if(!defined('IN_KKFRAME')) exit();
?>
<!DOCTYPE html>
<html>
<head>
<title>贴吧签到助手</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<!--<meta name="author" content="kookxiang" />
<meta name="copyright" content="KK's Laboratory" />-->
<link rel="shortcut icon" href="favicon.ico" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="renderer" content="webkit">
<link rel="stylesheet" href="./style/main.css?version=<?php echo VERSION; ?>" type="text/css" />
<link rel="stylesheet" href="./style/custom.css" type="text/css" />
</head>
<body>
<div class="wrapper" id="page_index">
<div id="append_parent"><div class="loading-icon"><img src="style/loading.gif" /> 载入中...</div></div>
<div class="main-box clearfix">
<h1>极光039</h1>
<div class="avatar"><?php echo $username; echo $_COOKIE["avatar_{$uid}"] ? '<img id="avatar_img" src="'.$_COOKIE["avatar_{$uid}"].'">' : '<img id="avatar_img" class="hidden" src="style/member.png">'; ?></div>
<ul class="menu hidden" id="member-menu">
<li id="menu_password"><a href="javascript:;">修改密码</a></li>
<?php
foreach ($users as $_uid => $username){
	echo '<li class="menu_switch_user"><span class="del" href="member.php?action=unbind_user&uid='.$_uid.'&formhash='.$formhash.'">x</span><a href="member.php?action=switch&uid='.$_uid.'&formhash='.$formhash.'">切换至: '.$username.'</a></li>';
}
?>
<li id="menu_adduser"><a href="#user-new">关联其他帐号</a></li>
<li id="menu_logout"><a href="member.php?action=logout&hash=<?php echo $formhash; ?>">退出登录</a></li>
</ul>
<div class="menubtn"><p>-</p><p>-</p><p>-</p></div>
<div class="main-wrapper">
<div class="sidebar">
<ul id="menu" class="menu">
<li id="menu_guide"><a href="#guide">配置向导</a></li>
<li id="menu_sign_log"><a href="#sign_log">签到记录</a></li>
<li id="menu_liked_tieba"><a href="#liked_tieba">我喜欢的贴吧</a></li>
<li id="menu_baidu_bind"><a href="#baidu_bind">百度账号绑定</a></li>
<li id="menu_setting"><a href="#setting">设置</a></li>
<?php HOOK::page_menu(); ?>
<?php if(is_admin($uid)) echo '<li id="menu_admincp"><a href="admin.php">管理面板</a></li><li id="menu_updater"><a href="http://update.kookxiang.com/gateway.php?id=tieba_sign&version='.VERSION.'" target="_blank" onclick="return show_updater_win(this.href)">检查更新</a></li>'; ?>
</ul>
</div>
<div class="main-content">
<div id="content-guide" class="hidden">
</div>
<div id="content-liked_tieba" class="hidden">
<h2>我喜欢的贴吧</h2>
<p>如果此处显示的贴吧有缺失，请<a href="index.php?action=refresh_liked_tieba" onClick="return msg_redirect_action(this.href+'&formhash='+formhash)">点此刷新喜欢的贴吧</a>.</p>
<table>
<thead><tr><td style="width: 40px">#</td><td>贴吧</td><td style="width: 65px">忽略签到</td></tr></thead>
<tbody></tbody>
</table>
</div>
<div id="content-sign_log" class="hidden">
<h2>签到记录</h2>
<span id="page-flip" class="float-right"></span>
<p id="sign-stat"></p>
<table>
<thead><tr><td style="width: 40px">#</td><td>贴吧</td><td class="mobile_min">状态</td><td class="mobile_min">经验</td></tr></thead>
<tbody></tbody>
</table>
</div>
<div id="content-setting" class="hidden">
<h2>设置</h2>
<form method="post" action="index.php?action=update_setting" id="setting_form" onSubmit="return post_win(this.action, this.id)">
<input type="hidden" name="formhash" value="<?php echo $formhash; ?>">
<p>签到方式：</p>
<p><label><input type="radio" name="sign_method" id="sign_method_3" value="3" checked readonly /> 3.0 (模拟客户端签到，+8经验)</label></p>
<p>附加签到：</p>
<p><label><input type="checkbox" disabled name="zhidao_sign" id="zhidao_sign" value="1" /> 自动签到百度知道 (测试版)</label></p>
<p><label><input type="checkbox" disabled name="wenku_sign" id="wenku_sign" value="1" /> 自动签到百度文库 (测试版)</label></p>
<!--<p><s>报告设置</s>(极光服务器不支持)：</p>
<p><label><input type="checkbox" disabled name="error_mail" id="error_mail" value="0" /> 当天有无法签到的贴吧时给我发送邮件</label></p>
<p><label><input type="checkbox" disabled name="send_mail" id="send_mail" value="0" /> 每日发送一封签到报告邮件</label></p>-->
<p><input type="submit" value="保存设置" /></p>
</form>
<?php HOOK::run('user_setting'); ?>
<br>
<p>签到测试：</p>
<p>随机选取一个贴吧，进行一次签到测试，检查你的设置有没有问题</p>
<p><a href="index.php?action=test_sign&formhash=<?php echo $formhash; ?>" class="btn" onClick="return msg_redirect_action(this.href)">测试签到</a></p>
</div>
<div id="content-baidu_bind" class="hidden">
<h2>百度账号绑定</h2>
<div class="tab tab-binded hidden">
<p>您的百度账号绑定正常。</p>
<br>
<div class="baidu_account"></div>
<br>
<p><a href="index.php?action=clear_cookie&formhash=<?php echo $formhash; ?>" id="unbind_btn" class="btn">解除绑定</a> &nbsp; (解除绑定后自动签到将停止)</p>
</div>
<div class="tab tab-bind">
<p>您还没有绑定百度账号！</p>
<br>
<p>只有绑定百度账号之后程序才能自动进行签到。</p>
<!--<p>您可以使用百度通行证登陆，或是手动填写 Cookie 进行绑定。</p>
<br>
<p><a href="https://api.ikk.me/baidu_login.php?callback=<?php echo rawurlencode($siteurl)."&formhash={$formhash}&ver=".VERSION; ?>" class="btn" target="_blank">点击此处登陆百度通行证</a> &nbsp; <a href="javascript:;" class="btn" id="show_cookie_setting">手动绑定</a></p>
</div>
<div class="tab-cookie hidden">
<br>
<h2>手动绑定百度账号</h2>-->
<p>请填写百度贴吧 Cookie:</p>
<form method="post" action="index.php?action=update_cookie">
<p>
<input type="text" name="cookie" style="width: 60%" placeholder="请在此粘贴百度贴吧的 cookie" />
<input type="submit" value="更新" />
</p>
</form>
<br>
<p>Cookie 获取工具:</p>
<p>请先下载下方 Cookies 获取工具。打开工具后将“自动去除BAIDUID部分”设置为“否”后，在工具左侧输入您的百度账号与密码，然后滑动鼠标滚轮点击“登录”，最后将工具中的 Cookies 复制到上方输入框中点击“更新”按钮即可。</p>
<p><a href="./Tieba_Cookies_Obtainer.exe" class="btn" target="_blank">下载百度贴吧 Cookie 获取工具</a></p>
<!--<p><a href="javascript:(function(){if(document.cookie.indexOf('BDUSS')<0){alert('找不到BDUSS Cookie\n请先登陆 http://wapp.baidu.com/');location.href='http://wappass.baidu.com/passport/?login&u=http%3A%2F%2Fwapp.baidu.com%2F&ssid=&from=&uid=wapp_1375936328496_692&pu=&auth=&originid=2&mo_device=1&bd_page_type=1&tn=bdIndex&regtype=1&tpl=tb';}else{prompt('您的 Cookie 信息如下:', document.cookie);}})();" onClick="alert('请拖动到收藏夹');return false;" class="btn">获取手机百度贴吧 Cookie</a></p>-->
</div>
</div>
<?php HOOK::page_contents(); ?>
</div>
</div>
</div>
<p class="copyright">当前程序运行于<a href="http://www.fcsys.org" target="_blank">极光计算机系统</a>的「039号」服务器之上</p>
</div>
<script src="http://lib.fcsys.org/jquery/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
var mobile = <?php echo IN_MOBILE ? '1' : '0'; ?>;
var formhash = '<?php echo $formhash; ?>';
</script>
<script src="system/js/main.js?version=<?php echo VERSION; ?>"></script>
<script src="system/js/fwin.js?version=<?php echo VERSION; ?>"></script>
<script type="text/javascript">
$('#content-guide').html('');
var guide_html, siteurl;
siteurl = 'https://apps.fcsys.org/com.fcsys.tieba.sign/';
if(siteurl.indexOf('#') >= 0) siteurl = siteurl.substring(0, siteurl.indexOf('#'));
guide_html = '';
guide_html += '<h2>贴吧签到助手 配置向导</h2>';
guide_html += '<div id="guide_pages">';
guide_html += '<div id="guide_page_1">';
guide_html += '<p><small>服务器信息：FCSERVER039 @ 极光计算机公司 [CENTOS] - <a href="http://www.fcsys.org" target="_blank">www.fcsys.org</a></small></p><br>';
guide_html += '<p><i>极光计算机系统公司只提供服务器资源，仅仅在极光第039号服务器上运行本程序，对于程序的任何问题，极光计算机系统公司概不负责。</i></p>';
guide_html += '<p>配置签到助手之后，程序将会在这一天中帮您代签，由于采用了分批签到，所以您早上起来看贴吧的时候可能只有部分签到了，您不用着急为什么还有未签到的贴吧，程序还会继续帮您签到，在当日内您的所有贴吧均会签到完毕。签到过程不需要人工干预，不过北极光建议您有空没空还是检查下签到列表，避免意外情况没有签到。最后请按照向导一步步继续，我们会严格保护您的账号安全。</p><br>';
guide_html += '<p>准备好了吗？点击下面的“下一步”按钮开始配置吧</p>';
guide_html += '<p class="btns"><button onclick="load_guide_page(2);">下一步 &raquo;</button></p>';
guide_html += '</div>';
guide_html += '<div id="guide_page_2" class="hidden">';
guide_html += '<p>首先，你需要绑定你的百度账号。</p><br>';
guide_html += '<p>我们需要使用你的账号信息登陆贴吧。为了确保账号安全，我们只储存你的百度 Cookie，不会保存你的账号密码信息。你可以通过简单的修改密码来让这些 Cookie 失效。</p><br>';
guide_html += '<p>请填写百度贴吧 Cookie:</p>';
guide_html += '<form method="post" action="index.php?action=update_cookie">';
guide_html += '<p>';
guide_html += '<input type="text" name="cookie" style="width: 60%" placeholder="请在此粘贴百度贴吧的 cookie" />';
guide_html += '<input type="submit" value="更新" />';
guide_html += '</p>';
guide_html += '</form>';
guide_html += '<br>';
guide_html += '<p>Cookie 获取工具:</p>';
guide_html += '<p>请先下载下方 Cookies 获取工具。打开工具后将“自动去除BAIDUID部分”设置为“否”后，在工具左侧输入您的百度账号与密码，然后滑动鼠标滚轮点击“登录”，最后将工具中的 Cookies 复制到上方输入框中点击“更新”按钮即可。</p>';
guide_html += '<p><a href="./Tieba_Cookies_Obtainer.exe" class="btn" target="_blank">下载百度贴吧 Cookie 获取工具</a></p>';
//guide_html += '<p>将本链接拖到收藏栏，在新页面点击收藏栏中的链接（推荐使用 Chrome 隐身窗口模式），按提示登陆wapp.baidu.com，登陆成功后，在该页面再次点击收藏栏中的链接即可复制cookies信息。</p>';
//guide_html += '<p><a href="javascript:(function(){if(document.cookie.indexOf(\'BDUSS\')<0){alert(\'找不到BDUSS Cookie\n请先登陆 http://wapp.baidu.com/\');location.href=\'http://wappass.baidu.com/passport/?login&u=http%3A%2F%2Fwapp.baidu.com%2F&ssid=&from=&uid=wapp_1375936328496_692&pu=&auth=&originid=2&mo_device=1&bd_page_type=1&tn=bdIndex&regtype=1&tpl=tb\';}else{prompt(\'您的 Cookie 信息如下:\', document.cookie);}})();" onClick="alert(\'请拖动到收藏夹\');return false;" class="btn">获取手机百度贴吧 Cookie</a></p>';
guide_html += '</div>';
guide_html += '<div id="guide_page_3" class="hidden">';
guide_html += '<p>一切准备就绪~</p><br>';
guide_html += '<p>我们已经成功接收到你百度账号信息，自动签到已经准备就绪。</p>';
guide_html += '<p>您可以点击 <a href="#setting">高级设置</a> 更改邮件设定，或更改其他附加设定。</p><br>';
guide_html += '<p>感谢您的使用！</p><br>';
guide_html += '<p>服务器：FCSERVER039 (由 <a href="http://www.fcsys.org" target="_blank">FC-System Computer Inc</a> 提供)</p>';
//guide_html += '<p>程序作者：kookxiang (<a href="http://www.ikk.me" target="_blank">http://www.ikk.me</a>)</p>';
//guide_html += '<p>赞助开发：<a href="https://me.alipay.com/kookxiang" target="_blank">https://me.alipay.com/kookxiang</a></p>';
guide_html += '</div>';
guide_html += '</div>';

function load_guide_page(pageid){
	$('#guide_pages>div').addClass('hidden');
	$('#guide_page_'+pageid).removeClass('hidden');
}

$('#content-guide').html(guide_html);
$('div#bind_by_cookie').html($('.tab-cookie').html());
$('div#bind_by_cookie h2').remove();
$('input#bind_by_account').click(function(){
	$('#guide_page_2>div').addClass('hidden');
	$('div#bind_by_account').removeClass('hidden');
});
$('input#bind_by_cookie').click(function(){
	$('#guide_page_2>div').addClass('hidden');
	$('div#bind_by_cookie').removeClass('hidden');
});
</script>
<?php HOOK::run('page_footer_js'); ?>
<iframe src="index.php?action=cache_frame" style="display: none"></iframe>
</body>
</html>
