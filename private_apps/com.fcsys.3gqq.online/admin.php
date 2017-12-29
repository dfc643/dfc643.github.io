<meta charset="utf-8"/>
<?php
error_reporting(0);
include("config.php");
if ($_COOKIE["password"] != md5($password)) {
if ($_POST["com"] != '1' ) {
echo '<form action="' . $_SERVER[PHP_SELF] . '" method="POST"> <input type="hidden" name="com" value="1" >密码:<input type="password" name="pwd"><br><input type="submit" value="登录"></form>';
} else {
if ($_POST["pwd"] == "$password") {
echo "已登录，请刷新";
setcookie("password",md5($_POST["pwd"]));
} else {
echo "密码错误";
}
}
} else {
echo '<div style="float:left;width:60%;">';
$fp=fopen($file,"a+");
$data = fgets($fp);
fclose($fp);
if ($_POST["com"] != "2") {
echo '<form action="' . $_SERVER[PHP_SELF] . '" method="POST"> <input type="hidden" name="com" value="2" > <textarea name="text" rows="20" cols="70">' . $data . '</textarea> <br> <input type="submit" value="修改"><br>';
} else {
echo "修改成功";
$data=$_POST['text'];
$fp=fopen($file,"a+");
ftruncate($fp,0);
fwrite($fp,$data);
fclose($fp);
}
echo '</div>';
echo '<div style="float:left;width:40%;">';
$page = $_GET["page"];
$pagesize=10;
if (file_exists($file))
{
$fp=fopen($file,"a+");
$datb = fgets($fp);
fclose($fp);
$array = explode( ';' , $datb );
$nun=count($array);
$num=$nun-1;
fclose($fp);
if ($num>0)
{
$total=ceil($num/$pagesize);
if($page<1)
{
$page=1;
}
$number=($page-1)*$pagesize;
for($i=0;$i<=$pagesize-1;$i++)
{
$row=explode(",",$array[$number]);
list($pwd,$qq,$sid,$data)=$row;
echo 'QQ:' . $qq . ' | 状态:<img src="http://wpa.qq.com/pa?p=1:' . $qq . ':45&r=' . time() . '"> | <a href="http://pt3.3g.qq.com/s?aid=nLogin3gqqbysid&auto=1&loginType=1&3gqqsid=' . $sid . '" target="_blank">输入验证码</a><br>';
if ($number==$num-1)
{
break;
}
$number=$number+1;
}
fc_buttom:
}
if ($page<>1)
{
$back=$page-1;
echo"<a href=" . $_SERVER[PHP_SELF] . "?page=1>第一页</a>";
echo"<a href=" . $_SERVER[PHP_SELF] . "?page=$back>上一页</a>";
}
if ($page<>$total)
{
$next=$page+1;
echo"<a href=" . $_SERVER[PHP_SELF] . "?page=$next>下一页</a>";
echo"<a href=" . $_SERVER[PHP_SELF] . "?page=$total>最后一页</a>";
}
echo"<br>页数：$page / $total";
echo"<br>共有 $num 个腾讯帐号";
}
else {
echo"<center>数据文件丢失，请联系管理员！</center>";
}
$fp=fopen("runtime.txt","a+");
if (filesize("runtime.txt") > 0) {
$time=fgets($fp);
} else {
$time = '暂无记录';
}
fclose($fp);
echo "<br>系统上次登陆时间：<br>" . $time . "<br>";
echo '</div>';
}
?>