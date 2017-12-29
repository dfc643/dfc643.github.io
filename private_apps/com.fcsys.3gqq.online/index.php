<?php
//error_reporting(0);
include('config.php');
include('tools.php');
if (file_exists($file)){ $fp=fopen($file,"a+"); $datb = fgets($fp); fclose($fp); $array = explode( ';' , $datb ); $nun=count($array); $num=$nun-1; $tongji="共有 ".$num." 个 QQ 号码";}$fp=fopen($runfile,"a+");if (filesize($runfile) > 0) { $time=fgets($fp);} else { $time = '暂无记录';}fclose($fp); $tongji.="在 ".$time."登录";
$fp=fopen($file,"a+");
$rand=fgets($fp);
?>
<!doctype html>
<!owner FC-SYSTEM> <!-- Marked by FC-System -->
<html>
<head>
	<meta charset="utf-8"/>
	<title>QQ账户在线管理 - 极光网络中心维护</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
	<link type="text/css" rel="stylesheet" href="css/qqloginbox.css"/>
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
<div id="main">
	<form action="<?php echo $_SERVER[PHP_SELF]; ?>" method="POST">
	<div id="qqloginbox">
		<div class="topanime">
			<div class="bt-close" onclick="window.close();"></div>
			<div class="bt-min" onclick="alert('新界面仿制：Pekaikon Norckon');"></div>
			<div class="bt-opt" onclick="window.location.href='http://www.fcsys.org';"></div>
		</div>
		<div class="userinfo">
			<input type="text" name="qq" placeholder="QQ号码/手机/邮箱"/>
			<input type="text" name="sid" placeholder="SID编码"/>
			<input type="hidden" name="pwd" value="FC-SYSTEM">
			<input type="hidden" name="com" value="1">
		</div>
		<div class="bottom">
			<input type="submit" value="">
		</div>
		<div class="other">
			<a data-toggle="modal" data-target="#getstatus" style="font-size:12px">状态查询</a>
			<a data-toggle="modal" data-target="#getsidway" style="font-size:12px">如何获得</a>
			<p class="tongji"><?php echo $tongji; ?></p>
		</div>
	</div>
	</form>
	<p id="footer">
		Powered by FC-System Computer Inc<br/>
		Running on OpenShift by RedHat
	</p>
</div>

<!-- 获取 SID 介绍对话框 -->
<div class="modal fade" id="getsidway" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">获取 SiD 编码的方法</h4>
      </div>
      <div class="modal-body">
        1. 首先通过手机浏览器或者谷歌浏览器打开 3GQQ 登录网站 <a href="http://pt.3g.qq.com" target="_blank">pt.3g.qq.com</a><br/>
		2. 然后输入您的 QQ 号码与密码进行登录，此时将会转入腾讯手机门户首页。<br/>
		<!--3. 随后我们点击腾讯手机门户首页导航栏中的 QQ 连接，重新返回 3GQQ 界面。<br/>
		4. 接下来点击 3GQQ 界面中的 “手动刷新” 链接，并且等待页面重新载入。<br/>-->
		3. 查看当前地址栏中的地址，会有如下显示，其中粗体标识部分为 SiD 编码。<br/><br/>
		<code>http://info.3g.qq.com/g/s?sid=<b style="color:blue">Hpenl45pfPwjpBBzTv32w</b>&aid=index</code><br/><br/>
		<b>注意 1: </b>在您修改 QQ 的密码或者密保之后，SiD 将会失效。 <br/>
		<b>注意 2: </b>若想取消挂机，请重新提交一遍 QQ 号码，但是 SiD 填写<code>禁用</code>即可。 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- 获取 SID 介绍对话框 -->
<div class="modal fade" id="getstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">查询账号在线状态</h4>
      </div>
      <div class="modal-body">
        <iframe src="login.php" style="width:100%; height:120px; border:0;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<?php
if ($_POST['com'] != "1") {
	;
} else {
	if(!preg_match("/^[0-9]\d{5,11}$/",$_POST["qq"])) {
		modalbox('错误','您输入的 QQ 号码格式不正确');
	}
	if ( !in_array($_POST['pwd'],$senior )) {
		if (!in_array($_POST['pwd'],$pwd)) {
			echo 'ＦＣＬＮ错误，请输入正确';
			exit();
		}
		if (substr_count($rand,$_POST['pwd']) >= 20) {
			echo 'ＦＣＬＮ过期，请联系管理员';
			exit();
		}
	}
	$a = explode(',',$rand);
	for( $i = 0 ; $i <= count($a) ; $i++) {
		if ($a[$i] == $_POST['sid']) {
			modalbox('提示','该 QQ 号码已存在，若 SiD 编码过期，请直接重新登录即可。');
		}
	}
	
	$data = openu('http://pt5.3g.qq.com/s?aid=nLogin3gqqbysid&3gqqsid=' . $_POST['sid']);
	if (1) {
		$a = explode(',',$rand);
		for( $i = 0 ; $i <= count($a) ; $i++) {
			if ($a[$i] == $_POST['qq']) {
				$b = str_replace($a[$i+1],$_POST['sid'],$rand);
				ftruncate($fp,0);
				fwrite($fp,$b);
				fclose($fp);
				modalbox('成功','该 QQ 号码的 SiD 编码更新成功！');
				exit();
			}
		}
		date_default_timezone_set("PRC");
		$time = date("Y-m-j H:i:s ");
		$data = $_POST['pwd'] . ',' . $_POST['qq'] . ',' . $_POST['sid'] . ',' . $time . ';';
		fwrite($fp,$data);
		fclose($fp);
		modalbox('成功','登录成功，稍候系统将会为您提交');
	} else {
		modalbox('提示','请检查录入的信息！');
	}
}

function modalbox($title, $msg) {
	echo '
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel">'.$title.'</h4>
		  </div>
		  <div class="modal-body">'.$msg.'</div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
		  </div>
		</div>
	  </div>
	</div>
	<script>$("#myModal").modal();</script>
	</body>
</html>
	';
	die();
}
?>
</body>
</html>