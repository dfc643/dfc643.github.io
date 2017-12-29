<?php
header("Content-Type: text/html; charset=utf-8");
include('config.php');
include('tools.php');
$fp=fopen($file,"a+");
$rand=fgets($fp);
if ($_POST['com'] != "1") {
$a = '<form action="' . $_SERVER[PHP_SELF] . '" method="POST"> <input type="hidden" name="com" value="1" >腾讯帐号:<input type="hidden" name="qq"><br>ＳｉＤ码:<input type="hidden" name="sid"><br>ＦＣＬＮ:<input type="hidden" name="pwd" value="FC-SYSTEM"><br>';
$b = '验证字符:<input name="rand" type="hidden"><img src="rand.php"><br>';
if ($abcd == "1") {
echo $a . $b . $c;
} else {
echo $a . $c;
}
} else {
if(!preg_match("/^[0-9]\d{5,11}$/",$_POST["qq"])) {
echo '不正确的腾讯帐号，请检查';
exit();
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
if ($abcd == "1") {
if ($_POST['rand'] != $_SESSION['rand']) {
echo '验证字符错误，请重新填写';
exit();
}
}
$a = explode(',',$rand);
for( $i = 0 ; $i <= count($a) ; $i++) {
if ($a[$i] == $_POST['sid']) {
echo '此ＳｉＤ已存在，若此ＳｉＤ已过期，请联系管理员删除原记录';
exit();
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
echo '已成功修改该腾讯帐号的ＳｉＤ';
exit();
}
}
date_default_timezone_set("PRC");
$time = date("Y-m-j H:i:s ");
$data = $_POST['pwd'] . ',' . $_POST['qq'] . ',' . $_POST['sid'] . ',' . $time . ';';
fwrite($fp,$data);
fclose($fp);
echo '已增加记录';
} else {
echo '请检查录入的信息';
}
}
?>