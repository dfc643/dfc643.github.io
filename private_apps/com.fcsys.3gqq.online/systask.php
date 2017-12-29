<?php
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
include('config.php');
include('tools.php');
$fp=fopen($file,"a+");
$data = fgets($fp);
fclose($fp);
$array = explode( ';' , $data );
date_default_timezone_set("PRC");
$time = date("Y-m-j H:i:s ");
for ( $i = 0 ; $i < (count($array) - 1) ; $i++ ) {
	$a=explode( ',' , $array[$i] );
	$qid=$a[3];
	$qq=$a[1];
	$sid=$a[2];
	$a = openu('http://pt3.3g.qq.com/s?aid=nLogin3gqqbysid&auto=1&loginType=1&3gqqsid=' . $sid);
}
$fp=fopen($runfile,"a+");
date_default_timezone_set("PRC");
$time = date("Y-m-j H:i:s ");
ftruncate($fp,0);
fwrite($fp,$time);
fclose($fp);
?>