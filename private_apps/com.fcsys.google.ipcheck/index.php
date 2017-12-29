<?php
$username = 'google';
$password = 'app'.date("md");

if ($_SERVER['PHP_AUTH_USER'] != $username || $_SERVER['PHP_AUTH_PW'] != $password) {
	header('WWW-Authenticate: Basic realm="___Username: google        Password: app+date         (e.g. app0131)"');
	header('HTTP/1.0 401 Unauthorized');
	echo '<H1>ACCESS NO WAY!</H1><hr>FC-System Computer Inc - www.fcsys.org';
	exit;
}

$ip_tmpok_modtime = shell_exec("stat -c %Y /tmp/gae_ip_tmpok.txt");
$ip_tmpgood_modtime = shell_exec("stat -c %Y /var/www/apps/com.fcsys.google.ipcheck/ip.txt");

$ip_tmpok = file_get_contents("/tmp/gae_ip_tmpok.txt");
$ip_tmpgood = file_get_contents("/var/www/apps/com.fcsys.google.ipcheck/ip.txt");
$ip_tmpok_arr = explode("\n", $ip_tmpok);
$ip_tmpgood_arr = explode("|", $ip_tmpgood);
$ip_tmpok_cnt = count($ip_tmpok_arr) - 1;
$ip_tmpgood_cnt = count($ip_tmpgood_arr) - 1;
$ip_tmpno_cnt = count(explode("\n", file_get_contents("/tmp/gae_ip_tmpno.txt")));

function GRunning() {
	global $ip_tmpok_modtime, $ip_tmpgood_modtime;
	if($ip_tmpok_modtime - $ip_tmpgood_modtime < 60) {
		echo "style=\"display:none;\"";
	}
}

function GPage() {
	global $ip_tmpok_cnt;
	if($ip_tmpok_cnt / 500 > 0) {
		$page  = "<div class=\"page\">";
		for($i=1; $i<=ceil($ip_tmpok_cnt / 500); $i++)
			$page .= "		<a href=\"?p=$i\">$i</a>";
		$page .= "</div>";
		echo $page;
	}
}

function GTable() {
	global $ip_tmpok_arr, $ip_tmpok_cnt;
	
	if($ip_tmpok_cnt == 0) {
		$table = "<tr>";
		$table .= "<td>*</td>";
		$table .= "<td>0.0.0.0</td>";
		$table .= "<td>N/A</td>";
		$table .= "<td>System rebooted, Now provide download service only.</td>";
		$table .= "</tr>";
		echo $table;
		return ;
	}
	
	if(isset($_GET['p'])) {
		$page = $_GET['p'];
	} else {
		$page = 1;
	}
	
	for($i=($page-1)*500; $i<$page*500; $i++) {
		$tmp_arr = explode(" ", $ip_tmpok_arr[$i]);
		$table = "<tr>";
		$table .= "<td>".($i+1)."</td>";
		$table .= "<td>".$tmp_arr[0]."</td>";
		$table .= "<td>".$tmp_arr[1]."ms</td>";
		$table .= "<td>".$tmp_arr[2]."</td>";
		$table .= "</tr>";
		echo $table;
		if($i == $ip_tmpok_cnt-1) break;
	}
	
}
  
if(isset($_GET['d'])) {
	$ipuser  = "[iplist]\r\n";
	$ipuser .= "google_cn = ".$ip_tmpgood."\r\n";
	$ipuser .= "google_hk = ".$ip_tmpgood."\r\n";
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=proxy.user.ini');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	echo $ipuser;
	die();
}

include('index.inc');
?>
