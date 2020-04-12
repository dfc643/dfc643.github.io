<?php
// Global Settings
$timeout = 5;
$protocol = 'http';
$apiServ = 'api.ibestv.com';
$apiPath = '/api/channel/list';
mb_internal_encoding("UTF-8");
error_reporting(0);

// Global Variables
$totalType = 0;

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

// Return value True or False?
function trueFalse ($string) {
	if($string == NULL)
		return '不稳定';
	else
		return $string;
}

// Get stream provider information
function streamProvider ($url) {
	if (strpos($url, 'letv') > -1) return '<span class="s-letv">乐视</span>';
	else if (strpos($url, 'video123456') > -1) return '<span class="s-letv">乐视</span>';
	else if (strpos($url, 'lecloud') > -1) return '<span class="s-letv">乐视</span>';
	else if (strpos($url, 'wasu') > -1) return '<span class="s-wasu">华数</span>';
	else if (strpos($url, '52itv') > -1) return '<span class="s-52itv">52iTV</span>';
	else if (strpos($url, 'cntv') > -1) return '<span class="s-cntv">CNTV</span>';
	else if (strpos($url, 'cmvideo') > -1) return '<span class="s-cmvideo">和视界</span>';
	else if (strpos($url, 'dztv') > -1) return '<span class="s-dztv">大略网</span>';
	else if (strpos($url, 'cztv') > -1) return '<span class="s-cztv">新蓝网</span>';
	else if (strpos($url, '8686c') > -1) return '<span class="s-8686c">炉石网</span>';
	else if (strpos($url, 'hoolo') > -1) return '<span class="s-hoolo">葫芦网</span>';
	else if (strpos($url, 'sxtv') > -1) return '<span class="s-sxtv">绍兴TV</span>';
	else if (strpos($url, 'dhtv') > -1) return '<span class="s-dhtv">东海网</span>';
	else if (strpos($url, 'imgo') > -1) return '<span class="s-imgo">芒果网</span>';
	else if (strpos($url, 'yicai') > -1) return '<span class="s-yicai">一财网</span>';
	else if (strpos($url, 'gstv') > -1) return '<span class="s-gstv">甘肃卫视</span>';
	else if (strpos($url, 'nmtv') > -1) return '<span class="s-nmtv">内蒙卫视</span>';
	else if (strpos($url, 'gxtv') > -1) return '<span class="s-nmtv">广西卫视</span>';
	else if (strpos($url, 'btgdt') > -1) return '<span class="s-btgdt">包头广电</span>';
	else if (strpos($url, 'myntv') > -1) return '<span class="s-myntv">绵阳广电</span>';
	else if (strpos($url, 'luzhoutv') > -1) return '<span class="s-luzhoutv">泸州广电</span>';
	else if (strpos($url, 'kylintv') > -1) return '<span class="s-kylintv">麒麟电视</span>';
	else if (strpos($url, 'sobey') > -1) return '<span class="s-sobey">索贝视频</span>';
	else if (strpos($url, 'btzx') > -1) return '<span class="s-btzx">兵团在线</span>';
	else if (strpos($url, 'sun0769') > -1) return '<span class="s-sun0769">东莞阳光</span>';
	else if (strpos($url, 'sytv') > -1) return '<span class="s-sytv">邵阳传媒</span>';
	else if (strpos($url, 'appwuhan') > -1) return '<span class="s-appwuhan">掌上武汉</span>';
	else if (strpos($url, 'hbtv') > -1) return '<span class="s-hbtv">湖北广电</span>';
	else if (strpos($url, 'ncnews') > -1) return '<span class="s-hbtv">天圆网</span>';
	else if (strpos($url, 'fjtv') > -1) return '<span class="s-fjtv">福建广电</span>';
	else if (strpos($url, 'ahtv') > -1) return '<span class="s-ahtv">安徽卫视</span>';
	else if (strpos($url, 'hnntv') > -1) return '<span class="s-hnntv">海南广电</span>';
	else if (strpos($url, 'gdtv') > -1) return '<span class="s-gdtv">荔枝网</span>';
	else if (strpos($url, 'jmtv') > -1) return '<span class="s-jmtv">荆门广电</span>';
	else if (strpos($url, 'jxtvcn') > -1) return '<span class="s-jxtvcn">江西广电</span>';
	else if (strpos($url, 'cbg') > -1) return '<span class="s-cbg">重庆视界</span>';
	else if (strpos($url, 'iqilu') > -1) return '<span class="s-iqilu">齐鲁网</span>';
	else if (strpos($url, 'ijntv') > -1) return '<span class="s-ijntv">济南广电</span>';
	else if (strpos($url, 'ilinyi') > -1) return '<span class="s-ilinyi">爱临沂网</span>';
	else if (strpos($url, 'hznet') > -1) return '<span class="s-hznet">菏泽广电</span>';
	else if (strpos($url, 'wfcmw') > -1) return '<span class="s-wfcmw">潍坊传媒</span>';
	else if (strpos($url, 'weihai') > -1) return '<span class="s-weihai">威海广电</span>';
	else if (strpos($url, 'hdbs') > -1) return '<span class="s-hdbs">邯郸广电</span>';
	else if (strpos($url, 'jcbctv') > -1) return '<span class="s-jcbctv">晋城广电</span>';
	else if (strpos($url, 'dltv') > -1) return '<span class="s-dltv">大连广电</span>';
	else if (strpos($url, 'dianjil') > -1) return '<span class="s-dianjil">智慧传媒</span>';
	else if (strpos($url, 'chinactv') > -1) return '<span class="s-chinactv">长电网</span>';
	else if (strpos($url, 'jlntv') > -1) return '<span class="s-jlntv">吉林广电</span>';
	else if (strpos($url, '53jl') > -1) return '<span class="s-53jl">融创天下</span>';
	else if (strpos($url, 'hljtv') > -1) return '<span class="s-hljtv">黑龙江卫视</span>';
	else if (strpos($url, '2500city') > -1) return '<span class="s-2500city">世纪飞越</span>';
	else if (strpos($url, 'hrbtv') > -1) return '<span class="s-hrbtv">蓝网</span>';
	else if (strpos($url, 'xwei') > -1) return '<span class="s-xwei">小微视频</span>';
	else if (strpos($url, 'yzntv') > -1) return '<span class="s-yzntv">名城扬州</span>';
	else if (strpos($url, 'ksntv') > -1) return '<span class="s-ksntv">昆山信息港</span>';
	else if (strpos($url, 'huaihai') > -1) return '<span class="s-huaihai">淮海网</span>';
	else if (strpos($url, 'thmz') > -1) return '<span class="s-thmz">太湖明珠</span>';
	else if (strpos($url, '0515yc') > -1) return '<span class="s-0515yc">盐城广电</span>';
	else if (strpos($url, 'zjgonline') > -1) return '<span class="s-zjgonline">张家港在线</span>';
	else if (strpos($url, 'ywcity') > -1) return '<span class="s-ywcity">义乌广电</span>';
	else if (strpos($url, 'haining') > -1) return '<span class="s-haining">海宁广电</span>';
	else if (strpos($url, 'ajbtv') > -1) return '<span class="s-ajbtv">安吉视窗</span>';
	else if (strpos($url, 'lxzc') > -1) return '<span class="s-lxzc">兰溪之窗</span>';
	else if (strpos($url, 'jinhuatv') > -1) return '<span class="s-jinhuatv">广众网</span>';
	else if (strpos($url, 'ahbbtv') > -1) return '<span class="s-ahbbtv">蚌埠广电</span>';
	else if (strpos($url, 'dzsm') > -1) return '<span class="s-dzsm">广元网络</span>';
	else if (strpos($url, 'yntv') > -1) return '<span class="s-yntv">云南广电</span>';
	else if (strpos($url, 'snrtv') > -1) return '<span class="s-snrtv">陕西广电</span>';
	else if (strpos($url, 'hebtv') > -1) return '<span class="s-hebtv">河北广电</span>';
	else if (strpos($url, '2300sjz') > -1) return '<span class="s-2300sjz">燕赵名城</span>';
	else if (strpos($url, 'cqtv') > -1) return '<span class="s-cqtv">重庆卫视</span>';
	else if (strpos($url, 'qtv') > -1) return '<span class="s-qtv">青岛广电</span>';
	else if (strpos($url, 'jnnews') > -1) return '<span class="s-jnnews">济宁新闻</span>';
	else if (strpos($url, 'readtv') > -1) return '<span class="s-readtv">阅视无限</span>';
	else if (strpos($url, 'lntv') > -1) return '<span class="s-lntv">辽宁卫视</span>';
	else if (strpos($url, 'sohu') > -1) return '<span class="s-sohu">搜狐视频</span>';
	else if (strpos($url, 'huijiayou') > -1) return '<span class="s-huijiayou">惠家有</span>';
	else if (strpos($url, 'brtn') > -1) return '<span class="s-brtn">北京卫视</span>';
	else if (strpos($url, 'cqcbc') > -1) return '<span class="s-cqcbc">重庆中广</span>';
	else if (strpos($url, 'tvesou') > -1) return '<span class="s-tvesou">TV拍拍</span>';
	else if (strpos($url, 'hntv') > -1) return '<span class="s-hntv">大象网</span>';
	else if (strpos($url, 'lytv') > -1) return '<span class="s-lytv">洛阳广电</span>';
	else if (strpos($url, 'yqrtv') > -1) return '<span class="s-yqrtv">阳泉广电</span>';
	else if (strpos($url, 'ntjoy') > -1) return '<span class="s-ntjoy">江海明珠</span>';
	else if (strpos($url, 'rdxmt') > -1) return '<span class="s-rdxmt">如东新媒体</span>';
	else if (strpos($url, 'lyg1') > -1) return '<span class="s-lyg1">连云港传媒</span>';
	else if (strpos($url, 'wifizs') > -1) return '<span class="s-wifizs">无限舟山</span>';
	else if (strpos($url, 'gd.cn') > -1) return '<span class="s-gdcn">掌智通</span>';
	else if (strpos($url, 'scjygd') > -1) return '<span class="s-scjygd">江油广电</span>';
	else if (strpos($url, 'ycgbtv') > -1) return '<span class="s-ycgbtv">银川广电</span>';
	else if (strpos($url, 'pptv') > -1) return '<span class="s-pplive">PPLive</span>';
	else if (strpos($url, 'pplive') > -1) return '<span class="s-pplive">PPLive</span>';
	else if (strpos($url, 'rtmp') > -1) return '<span class="s-rtmp">RTMP网络流</span>';
	else if (strpos($url, 'hls') > -1) return '<span class="s-rtmp">网络流</span>';
	else if (strpos($url, 'livestream') > -1) return '<span class="s-rtmp">网络流</span>';
	else if (strpos($url, 'streaming') > -1) return '<span class="s-rtmp">网络流</span>';
	else if (strpos($url, 'ctlcdn') > -1) return '<span class="s-other">电信CDN</span>';
	else return '<span class="s-other">未知</span>';
}

// Do process for remote resource.
$channel_json = httpReq($protocol.'://'.$apiServ.$apiPath, 0, $timeout);
$channel_json = strtr($channel_json, "\t", ' ');
$channel_obj = json_decode($channel_json);

// Initize Channel list update time.
$time_obj = $channel_obj->timestamp;
$timeYear = substr($time_obj, 0, 4);
$timeMonth = substr($time_obj, 4, 2);
$timeDay = substr($time_obj, 6, 2);
$timeHour = substr($time_obj, 8, 2);
$timeMin = substr($time_obj, 10, 2);
$timeSec = substr($time_obj, 12, 2);

// Initize Channel Type Object
$type_obj = $channel_obj->actions[0]->data;
$totalType = count($type_obj);

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>电视家节目单</title>
	<link href="https://cdn.bootcss.com/twitter-bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<style>
		body {background:#f5f5f5;}
		.header {min-width:1200px; text-align:center; background:#fff; height:120px; display:table; width:100%; box-shadow:0 0 12px #CACACA; margin-bottom:30px;}
		.footer {margin:30px auto;}
		h1 {font-family:"宋体" !important; margin-top:27px; text-shadow:1px 1px 1px #DADADA;}
		h5 {font-weight:normal; color:#C7C7C7;}
		img {width:50px; max-height:50px;}
		img[src=''] {display:none;}
		table {min-width:1200px; max-width:1500px !important; margin:0 auto; background:#fff; box-shadow:0 0 15px #DEDEDE;}
		thead {font-weight:bold;}
		td {height: 50px; vertical-align:middle !important; text-align:center;}
		td.mainType {background:#fff; font-size:32px; word-wrap:break-word; word-break:break-all; width:1px; padding:0 50px !important; line-height:300% !important; font-family:"宋体"; color:#757575; text-shadow:0 0 0px #000;}
		td.no-stream {color:#DEDEDE;}
		span.s-letv {color:#0BB90B; font-weight:bold;}
		span.s-wasu {color:blue; font-weight:bold;}
		span.s-52itv {color:#B63DFF; font-weight:bold;}
		span.s-cntv {color:#4ACCF7; font-weight:bold;}
		span.s-cmvideo {color:#21C196; font-weight:bold;}
		span.s-rtmp {color:red;}
		span.s-pplive {color:#FF007F;}
		span.s-other {color:#afafaf; text-decoration:line-through;}
		@media screen and (max-width: 1200px) {
			td.engName,td.stream4 {display:none}
			table,.header {min-width:935px;}
		}
		@media screen and (max-width: 950px) {
			td.engName,td.chId,td.stream4 {display:none}
			table,.header {min-width:768px;}
		}
		@media screen and (max-width: 780px) {
			td.typeTotal,td.mainType,td.engName,td.chId,td.stream4 {display:none}
			table,.header {min-width:640px;}
		}
		@media screen and (max-width: 680px) {
			td.typeTotal,td.mainType,td.engName,td.chId,td.stream3,td.stream4 {display:none}
			table,.header {min-width:420px;}
		}
		@media screen and (max-width: 480px) {
			td.typeTotal,td.mainType,td.engName,td.chId,td.stream3,td.stream4 {display:none}
			td.chNum {min-width:65px;}
			table,.header {min-width:320px;}
			* {font-size: 11px;}
		}
	</style>
</head>
<body>
	<div class="header">
		<h1>电视家节目单列表</h1>
		<h5>更新日期： <?php echo $timeYear.'年 '.$timeMonth.'月 '.$timeDay.'日 &nbsp;'.$timeHour.'时 '.$timeMin.'分 '.$timeSec.'秒 '; ?>
	</div>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<td class="typeTotal">总体分类</td>
			<td class="chIcon">节目台标</td>
			<td class="chName">节目名称</td>
			<td class="engName">其他名称</td>
			<td class="chNum">频道编号</td>
			<td class="chId">频道ID</td>
			<td class="stream1">节目源①</td>
			<td class="stream2">节目源②</td>
			<td class="stream3">节目源③</td>
			<td class="stream4">节目源④</td>
		</thead>
		<tbody>
		<?php 
			for($startType=0; $startType<$totalType; $startType++) { 
				// Count current Type have how many channel.
				$currentType_obj = $type_obj[$startType] -> channels;
				$currentType_count = count($currentType_obj);
				
				// Output each channel information.
				for($startSubType=0; $startSubType<$currentType_count; $startSubType++) {
					print '<tr>';
					
					// Output current Type's chinese name and rowspan.
					if($startSubType==0) {
						print '<td class="mainType" rowspan="'.$currentType_count.'">'.$type_obj[$startType] -> chineseName.'</td>';
					}
					
					// Output channel's base information
					print '<td class="chIcon"><img src="'.$currentType_obj[$startSubType] -> icon.'"/></td>';
					print '<td class="chName">'.$currentType_obj[$startSubType] -> name.'</td>';
					print '<td class="engName">'.$currentType_obj[$startSubType] -> englishName.'</td>';
					print '<td class="chNum">'.$currentType_obj[$startSubType] -> channelNum.'</td>';
					print '<td class="chId">'.$currentType_obj[$startSubType] -> id.'</td>';
					
					// Count this channel have how many streams
					$currentChannelStreams_obj = $currentType_obj[$startSubType] -> streams;
					$currentChannelStreams_count = count($currentChannelStreams_obj);
					// If more than 3 streams only output first 3rd streams
					$stream1_def = $currentType_obj[$startSubType] -> streams[0] -> definition;
					$stream2_def = $currentType_obj[$startSubType] -> streams[1] -> definition;
					$stream3_def = $currentType_obj[$startSubType] -> streams[2] -> definition;
					$stream4_def = $currentType_obj[$startSubType] -> streams[3] -> definition;
					$stream1_url = $currentType_obj[$startSubType] -> streams[0] -> url;
					$stream2_url = $currentType_obj[$startSubType] -> streams[1] -> url;
					$stream3_url = $currentType_obj[$startSubType] -> streams[2] -> url;
					$stream4_url = $currentType_obj[$startSubType] -> streams[3] -> url;
					if($currentChannelStreams_count >= 4) {
						print '<td class="stream1">'.trueFalse($stream1_def).'<br/><a href="'.$stream1_url.'">'.streamProvider($stream1_url).'</td>';
						print '<td class="stream2">'.trueFalse($stream2_def).'<br/><a href="'.$stream2_url.'">'.streamProvider($stream2_url).'</td>';
						print '<td class="stream3">'.trueFalse($stream3_def).'<br/><a href="'.$stream3_url.'">'.streamProvider($stream3_url).'</td>';
						print '<td class="stream4">'.trueFalse($stream4_def).'<br/><a href="'.$stream4_url.'">'.streamProvider($stream4_url).'</td>';
					} else {
						switch($currentChannelStreams_count) {
							case 3:
								print '<td class="stream1">'.trueFalse($stream1_def).'<br/><a href="'.$stream1_url.'">'.streamProvider($stream1_url).'</td>';
								print '<td class="stream2">'.trueFalse($stream2_def).'<br/><a href="'.$stream2_url.'">'.streamProvider($stream2_url).'</td>';
								print '<td class="stream3">'.trueFalse($stream3_def).'<br/><a href="'.$stream3_url.'">'.streamProvider($stream3_url).'</td>';
								print '<td class="stream4 no-stream">(无)</td>';
								break;
							case 2:
								print '<td class="stream1">'.trueFalse($stream1_def).'<br/><a href="'.$stream1_url.'">'.streamProvider($stream1_url).'</td>';
								print '<td class="stream2">'.trueFalse($stream2_def).'<br/><a href="'.$stream2_url.'">'.streamProvider($stream2_url).'</td>';
								print '<td class="stream3 no-stream">(无)</td>';
								print '<td class="stream4 no-stream">(无)</td>';
								break;
							case 1:
								print '<td class="stream1">'.trueFalse($stream1_def).'<br/><a href="'.$stream1_url.'">'.streamProvider($stream1_url).'</td>';
								print '<td class="stream2 no-stream">(无)</td>';
								print '<td class="stream3 no-stream">(无)</td>';
								print '<td class="stream4 no-stream">(无)</td>';
								break;
							default:
								print '<td class="stream1 no-stream">(无)</td>';
								print '<td class="stream2 no-stream">(无)</td>';
								print '<td class="stream3 no-stream">(无)</td>';
								print '<td class="stream4 no-stream">(无)</td>';
								break;
						}
					}
					
					print '</tr>';
				}
			} 
		?>
		</tbody>
	</table>
	<center class="footer">
		Copyright &copy; 2011-2016 <a href="http://dfc643.github.io">FC-System Computer Inc</a>.
	</center>
</body>
</html>
