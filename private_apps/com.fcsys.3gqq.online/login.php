<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
<center>
<?php
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
include('config.php');
include('tools.php');
//-------------------------
?>
<br/>
<form method="get">
	<input type="text" class="form-control" name="yourqq" placeholder="QQ号码" style="width:200px;display: inline;"/>
	<input type="submit" class="btn btn-primary" value="查询" style="margin-top:-3px;"/>
</form><br/>
<?php
if(!isset($_GET['yourqq'])) {die();}
//-------------------------
$fp=fopen($file,"a+");
$data = fgets($fp);
fclose($fp);
$array = explode( ';' , $data );
for ( $i = 0 ; $i < (count($array) - 1) ; $i++ ) {
	$a=explode( ',' , $array[$i] );
	$qid=$a[3];
	$qq=$a[1];
	$sid=$a[2];
	$a = openu('http://pt3.3g.qq.com/s?aid=nLogin3gqqbysid&auto=1&loginType=1&3gqqsid=' . $sid);
	$yourqq=$_GET['yourqq'];
	if(!strcmp($qq,$yourqq)){
		if (ereg('nqqchat',$a)) {
			echo '<code>'.$qq . ' 登陆成功</code>';
		} else {
			echo '<code>'.$qq . ' 登陆失败</code>';
		}
	}
}
$fp=fopen($runfile,"a+");
date_default_timezone_set("PRC");
$time = date("Y-m-j H:i:s ");
ftruncate($fp,0);
fwrite($fp,$time);
fclose($fp);
?>
</center>