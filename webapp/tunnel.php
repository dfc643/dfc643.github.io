<?php
// Global Settings
$timeout = 5;
$protocol = 'https';
$apiServ = 'sowhatstory.com';
$apiPath = '/vpngate.php?country='.$_GET['c'];
mb_internal_encoding("UTF-8");
error_reporting(0);

// Http request process module
function httpReq($url, $mode = 0, $timeout) {
	switch($mode) {
		case 0:
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_ENCODING , "gzip");
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36');
			$r = curl_exec($ch);
			curl_close($ch);
			return $r;
		
		case 1:
			$mode_timeout = stream_context_create(array('http' => array('timeout' => $timeout)));
			$r = file_get_contents($url, 0, $mode_timeout);
			return $r;
			
		case 2:
			$handle = fopen ($url, "rb"); 
			$r = ""; 
			do { 
				$data = fread($handle, 1024); 
				if (strlen($data) == 0) { 
					break; 
				} 
				$r .= $data; 
			} while(true); 
			fclose ($handle); 
			return $r; 
	}
}

// Time Process Module
class TIME {     
    public static function tranSecToMHDY($second) {  
        return self::_tranSecToMHDY($second);  
    }  
      
    private static function _tranSecToMHDY($second, $return = '') {  
        if(! is_numeric($second) || $second < 0) return false;  
        if($second > 30240000) return '50+ 年 '; 
        if(0 != $second) {  
            if($second < 60) {  
                $return .= $second.' 秒 ';
                $second = 0;  
            } else if($second >= 60 && $second < 60 * 60) {//分钟  
                $return .= floor($second / 60).' 分钟 ';
                $second %= 60;    
            } else if($second >= 60 * 60 && $second < 24 * 60 * 60) {//小时  
                $return .= floor($second / (60 * 60)).' 小时 '; $second %= (60 * 60);   
            } else if ($second >= 24 * 60 * 60 && $second < 7 * 24 * 60 * 60) {//天  
                $return .= floor($second / (24 * 60 * 60)).' 天 '; $second %= (24 * 60 * 60);  
            } else if ($second >= 7 * 24 * 60 * 60 && $second < 365 * 24 * 60 * 60) {//年  
                $return .= floor($second / (7 * 24 * 60 * 60)).' 年 '; $second %= (7 * 24 * 60 * 60);  
            }  
            return self::_tranSecToMHDY($second, $return);  
        }  
        else {  
            return $return;  
        }  
    }  
}

// Time Execution Function
function timetostr($msec) {
    $time = TIME::tranSecToMHDY($msec/1000);
    $time_obj = explode(" ",$time);
    return explode(".",$time_obj[0])[0]." ".$time_obj[1];
}

// Donload function for OpenVpn 
if(isset($_POST['d'])) {
    $decode = base64_decode($_POST['raw']);
    if($_POST['ml'] != '') {
        if(substr_count($decode,"proto udp") > 1) {
            die('<html><body><script>alert("该服务器采用了 UDP 通信方式，不支持免流！");</script></body></html>');
        }
    }
	switch($_POST['ml']) {
        case 'cnct':
            $decode = str_replace("proto tcp","proto tcp-client",$decode);
            $decode .= 'http-proxy 10.0.0.200 80
http-proxy-option EXT1 "POST http://ltetp.tv189.com" 
http-proxy-option EXT1 "GET http://ltetp.tv189.com" 
http-proxy-option EXT1 "X-Online-Host: ltetp.tv189.com" 
http-proxy-option EXT1 "POST http://ltetp.tv189.com" 
http-proxy-option EXT1 "X-Online-Host: ltetp.tv189.com" 
http-proxy-option EXT1 "POST http://ltetp.tv189.com" 
http-proxy-option EXT1 "Host: ltetp.tv189.com" 
http-proxy-option EXT1 "GET http://ltetp.tv189.com" 
http-proxy-option EXT1 "Host: ltetp.tv189.com"';
            break;
            
        case 'cncu':
            $decode = str_replace("proto tcp","proto tcp-client",$decode);
            $decode .= 'http-proxy 10.0.0.172 80
http-proxy-option EXT1 "POST http://m.client.10010.com" 
http-proxy-option EXT1 "GET http://m.client.10010.com" 
http-proxy-option EXT1 "X-Online-Host: m.client.10010.com" 
http-proxy-option EXT1 "POST http://m.client.10010.com" 
http-proxy-option EXT1 "X-Online-Host: m.client.10010.com" 
http-proxy-option EXT1 "POST http://m.client.10010.com" 
http-proxy-option EXT1 "Host: m.client.10010.com" 
http-proxy-option EXT1 "GET http://m.client.10010.com" 
http-proxy-option EXT1 "Host: m.client.10010.com"';
            break;
            
        case 'cmcc':
            $decode = str_replace("proto tcp","proto tcp-client",$decode);
            $decode .= 'http-proxy 10.0.0.172 80
http-proxy-option EXT1 "GET http://migumovie.lovev.com"
http-proxy-option EXT1 "POST http://migumovie.lovev.com"
http-proxy-option EXT1 "X-Online-Host: migumovie.lovev.com"
http-proxy-option EXT1 "Host: migumovie.lovev.com"';
            break;
            
        case 'hncmcc':
            $decode = str_replace("proto tcp","proto tcp-client",$decode);
            $decode .= 'http-proxy 10.0.0.172 80
http-proxy-option EXT1 "POST http://wap.hn.10086.cn"
http-proxy-option EXT1 "GET http://wap.hn.10086.cn"
http-proxy-option EXT1 "X-Online-Host: wap.hn.10086.cn"
http-proxy-option EXT1 "POST http://wap.hn.10086.cn"
http-proxy-option EXT1 "X-Online-Host: wap.hn.10086.cn"
http-proxy-option EXT1 "POST http://wap.hn.10086.cn"
http-proxy-option EXT1 "Host: wap.hn.10086.cn"
http-proxy-option EXT1 "GET http://wap.hn.10086.cn"
http-proxy-option EXT1 "Host: wap.hn.10086.cn"';
            break;
	}
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$_POST['f']);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	die($decode);
}

// Do process for remote resource.
if($_GET['c'] == "") $apiPath .= "CN";
$list_json = httpReq($protocol.'://'.$apiServ.$apiPath, 2, $timeout);
$list_obj = json_decode($list_json);
$list_count = count($list_obj);

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>国内隧道服务器</title>
	<link href="https://cdn.bootcss.com/twitter-bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<style>
		body {background:#f5f5f5;}
		.header {min-width:1000px; text-align:center; background:#fff; height:120px; display:table; width:100%; box-shadow:0 0 12px #CACACA; margin-bottom:30px;}
		.footer {margin:30px auto;}
		h1 {font-family:"宋体" !important; margin-top:27px; text-shadow:1px 1px 1px #DADADA;}
		h5 {font-weight:normal; color:#C7C7C7;}
		img {width:50px; max-height:50px;}
		img[src=''] {display:none;}
		table {min-width:1000px; max-width:1200px !important; margin:0 auto; background:#fff; box-shadow:0 0 15px #DEDEDE;}
		thead {font-weight:bold;}
		td {height: 50px; vertical-align:middle !important; text-align:center;}
		td.mainType {background:#fff; font-size:32px; word-wrap:break-word; word-break:break-all; width:1px; padding:0 50px !important; line-height:300% !important; font-family:"宋体"; color:#757575; text-shadow:0 0 0px #000;}
	</style>
</head>
<body>
	<div class="header">
		<h1>国内公共隧道服务器列表</h1>
        <form name="cc" method="get">
            选择其他地区：
            <select name="c" onChange="javascript:document.cc.submit();">
                <option value="" select>请选择</option>
                <option value="CN" >中国</option>
                <option value="HK">香港</option>
                <option value="TW">台湾</option>
                <option value="JP">日本</option>
                <option value="KR">韩国</option>
                <option value="US">美国</option>
                <option value="GB">英国</option>
            <select>
        </form>
	</div>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<td class="f">国旗</td>
			<td class="c">国家</td>
			<td class="ip">IP地址</td>
			<td class="p">延迟</td>
			<td class="s">速度</td>
			<td class="t">在线时长</td>
			<td class="u">在线用户</td>
			<td class="ts">总流量</td>
			<!--<td class="o">服主</td>-->
			<td class="sc">分数</td>
			<td class="d">下载</td>
			<td class="ml">免流</td>
		</thead>
		<tbody>
		<?php
            for($i=0; $i<$list_count; $i++) {
                $cObj = $list_obj[$i];
                echo "
                <form name='".$cObj->hostname."' method='post' target='_blank'>
                    <input type='hidden' name='d' value='1'/>
                    <input type='hidden' name='raw' value='".$cObj->openvpn_configdata."'/>
                    <input type='hidden' name='f' value='".$cObj->countryshort."_".$cObj->ip."_".number_format(($cObj->speed/1024/1024),0)."Mbps.ovpn"."'/>
                    <tr>
                        <td class=\"f\"><img src=\"http://lipis.github.io/flag-icon-css/flags/4x3/".strtolower($cObj->countryshort).".svg\" /></td>
                        <td class=\"c\">".$cObj->countrylong."</td>
                        <td class=\"ip\">".$cObj->ip."</td>
                        <td class=\"p\">".$cObj->ping." 毫秒</td>
                        <td class=\"s\">".number_format(($cObj->speed/1024/1024),2)." Mbps</td>
                        <td class=\"t\">".timetostr($cObj->uptime)."</td>
                        <td class=\"u\">".$cObj->numvpnsessions."</td>
                        <td class=\"ts\">".number_format(($cObj->totaltraffic/1024/1024),0)." MB</td>
                        <!--<td class=\"o\">".$cObj->operator."</td>-->
                        <td class=\"sc\">".number_format($cObj->score,0)."</td>
                        <td class=\"d\"><a href=\"javascript:document.".$cObj->hostname.".submit();\">下载 .ovpn</a></td>
                        <td class=\"ml\">
                            <select name='ml' onChange='javascript:document.".$cObj->hostname.".submit();'>
                                <option value='' select>不使用</option>
                                <option disabled>————</option>
                                <option value='cnct'>全国电信</option>
                                <option value='cncu'>全国联通</option>
                                <option value='cmcc'>全国移动</option>
                                <option disabled>————</option>
                                <option value='hncmcc'>湖南移动</option>
                            </select>
                        </td>
                    </tr>
                </form>
                ";
            }
		?>
		</tbody>
	</table>
	<center class="footer">
		Copyright &copy; 2016 China Public Tunnel Server List (CPTSL)
	</center>
</body>
</html>
