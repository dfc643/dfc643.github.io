<?php
// Setting and Options
$apikey = "3c5edbe6fa584abcfce74a434640a72e";

// Http request process module
function httpReq($url, $apikey) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_HTTPHEADER, Array("apikey: $apikey")); 
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36');
	$r = curl_exec($ch);
	curl_close($ch);
	return $r;
}

if(isset($_GET['mac'])) {
    $mac = $_GET['mac'];
    $mac = str_replace("-", "%3A", $mac);
    $mac = str_replace(":", "%3A", $mac);
    $ret = httpReq("http://apis.baidu.com/lbs_repository/wifi/query?mac=$mac&coord=bd09", $apikey);
    $ret = json_decode($ret, true);
    
    if($ret['errcode'] == 0) {
        $M_status = true;
        $M_address = $ret['address'];
        $M_radius = $ret['radius'];
        $M_lat = $ret['lat'];
        $M_lon = $ret['lon'];
    } else {
        $M_status = false;
        $M_address = '';
        $M_radius = '';
        $M_lat = '39.929986';
        $M_lon = '116.395645';
    }
} else {
    $mac = '';
    $M_status = false;
    $M_address = '';
    $M_radius = '';
    $M_lat = '39.929986';
    $M_lon = '116.395645';
}

// Is from browser or cURL?
/*if(!isset($_GET['mode']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') > -1) {
    // From Browser
    $modeGeoEN = getIPGeo($modeIP, $uplinkGeoEN, 'EN');
} else {
    // From other ways or specified mode
    $help = '
=======================
  IP 信息查询系统
=======================
错误信息：您当前处于 API 模式当中，但您尚未指定正确的输出模式，请您先阅读以下内
容来帮助您选择所需要的模式。

模式说明
----------------
json        以 JSON 形式输出您当前 IP 或者所查询 IP 地址
            例如：{"ip":"1.1.1.1","geo":"澳大利亚 亚太互联网络信息中心"}

iponly      只输出您当前所查询的域名的 IP 地址或者您的当前 IP 地址
            例如：1.1.1.1

utf8        以 UTF-8 字符集输出您当前 IP 或者所查询 IP 地址
linux       例如：查询 IP: 1.1.1.1 来自: 澳大利亚 亚太互联网络信息中心
unix

gb2312      以 GB2312 字符集输出您当前 IP 或者所查询 IP 地址（适合Windows）
gbk         例如：查询 IP: 1.1.1.1 来自: 澳大利亚 亚太互联网络信息中心
windows

参数说明
----------------
ip          您希望查询的目标 IP 地址或者目标域名
            例如：ip=1.1.1.1

mode        您希望系统返回的 IP 查询信息格式（具体见上表），为了方便
            例如：mode=utf8


FC-System Computer Inc
    ';
    
    switch($_GET['mode']) {
        case 'json':
            die('{"ip":"'.$modeIP.'","geo":"'.$modeGeoCN.'"}');
            
        case 'iponly':
            die($modeIP);
            
        case 'utf8': case 'linux': case 'unix':
            die($modeText.' IP: '.$modeIP.' 来自: '.$modeGeoCN);
            
        case 'gb2312': case 'gbk': case 'windows':
            die(iconv("UTF-8", "GB2312//IGNORE", $modeText.' IP: '.$modeIP.' 来自: '.$modeGeoCN));
            
        default:
            //die($modeText.' IP: '.$modeIP.' 来自: '.$modeGeoCN);
            if(strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') > -1)
                echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><pre>';
            die($help);
    }
}*/

?>
<!doctype html>
<!own FC-System>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="http://lib.fcsys.org" rel="dns-prefetch" />
    <link href="http://fcsys.org" rel="dns-prefetch" />
    <title><?php if(isset($_GET['mac'])) echo $_GET['mac'].' - '; ?>MAC 信息查询</title>
    <meta name="robots" content="all" />
    <meta name="Keywords" content="ip,ip查询,手机ip,本机ip,外网ip,ip地址查询,手机号,归属地">
    <meta name="Description" content="专业本机 IP 地址查询、手机 IP 地址、地理位置查询、IP 数据库、手机号归属地查询、电话号码黄页查询，可查广告、骚扰、快递、银行、保险、房地产、中介电话。">
    
    <meta name="viewport" content="width=device-width, initial-scale=0.95, minimum-scale=0.95, maximum-scale=0.95">
    <meta name="format-detection" content="telephone=no">
    
    <meta name="apple-mobile-web-app-title" content="IP查询">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    
    <meta name="HandheldFriendly" content="true">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    
    <script src="http://lib.fcsys.org/dragscroll/dragscroll-0.0.4_micro.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
    <style>
    body                                    {background:#f5f5f5; font-family:"微软雅黑","Microsoft Yahei";}
    h5                                      {font-size:24px; color:#000; margin-top:15px; margin-bottom:0px; font-weight:normal;}
    #main                                   {width:370px; margin:0 auto;}
    .header                                 {margin-top:10px;}
    .header a                               {color:#ccc; text-decoration:none; font-size:20px;}
    .navbar .nav                            {padding:0; margin-top:10px; margin-bottom:20px; width:100%; overflow-x:scroll;  white-space:nowrap;}
    .navbar .nav::-webkit-scrollbar         {display:none;}
    .navbar .nav::-ms-scrollbar             {display:none;}
    .navbar .nav::-moz-scrollbar            {display:none;}
    .navbar .nav::-o-scrollbar              {display:none;}
    .navbar .nav li                         {display:inline; margin-right:15px;}
    .navbar .nav li a                       {font-size:38px; color:#dedede; text-decoration:none;}
    .navbar .nav li.active a                {color:#000;}
    .searchform                             {margin-bottom:15px;}
    .searchform .span3                      {background:#e8e8e8; height:35px; width:257px; border:0px; color:#000; font-size:16px; padding:0px 10px;}
    .searchform .span3:hover                {background:#f0f0f0; transition:background, .3s;}
    .searchform .btn                        {height:35px; width:85px; border:none; background:#00aafc; color:#fff; font-size:19px; vertical-align:bottom; margin-left:-5px;}
    .searchform .btn:hover                  {background:#51C4FB; transition:background, .3s;}
    #result,#recent,#db-info                {background:#ececec; width:342px; padding:10px; margin-top:10px; display:table;}
    #result p                               {margin:0px; line-height:175%; font-size:16px; color:#777;}
    #result p code                          {color:#009AE4; text-shadow:0px -1px 0px #fff;}
    #result p.geo-en                        {font-size:14px; margin-top:10px;}
    #recent .recent-item a                  {text-decoration:none; font-size:14px; color:#8e8e8e;}
    #recent .recent-item                    {width:33%; float:left;}
    #recent .recent-item:hover a            {color:#555; text-shadow:0px -1px 0px #fff;}
    #recent .recent-item:nth-last-child(1)  {display:none;}
    #db-info p                              {margin:0px; line-height:175%; font-size:14px; color:#777;}
    #db-info p a                            {text-decoration:none; text-shadow:0px -1px 0px #fff; color:#008FD4;}
    #db-info p a:hover                      {color:#00aafc; transition:color, .3s;}
    .footer                                 {width:100%; text-align:center;}
    </style>
</head>
<body onLoad="document.fs.mac.focus()">
<div id="main">
    <div class="header">
        <a href="."><b>FC-SYSTEM</b> COMPUTER INC</a>
    </div>

    <div class="navbar">
        <ul class="nav dragscroll">
            <li><a href="/ip.np">IP查询</a></li>
            <li class="active"><a href="/mac.np">MAC查询</a></li>
            <li><a href="http://ip.cn/dns.html">DNS</a></li>
            <li><a href="http://ip.cn/qr.html">二维码</a></li>
        </ul>
    </div>

    <div class="searchform">
        <form name="fs" method="GET" class="form-search">
            <input name="mac" type="text" placeholder="11:22:33:44:55:66 或 11-22-33-44-55-66" class="span3">
            <input id="s" type="submit" class="btn" value="查询">
        </form>
    </div>

    <?php if(!$M_status) { ?>
        <div id="result">未找到该热点的位置</div>
    <?php } else { ?>
        <div id="result"><p>热点：<code><?php echo $_GET['mac'];?></code>&nbsp;位于：<?php echo $M_address;?><small>（有效半径：<?php echo $M_radius;?>米）</small></p></div>
    <?php } ?>
    
    <h5>地图位置</h5>
    <div id="recent">
        <!--百度地图容器-->
        <div style="height:320px;" id="dituContent"></div>
    </div>
    
    <h5>数据来源</h5>
    <div id="db-info">
        <p>
        热点位置信息：<a href="http://apistore.baidu.com/apiworks/servicedetail/1350.html">LBS数据仓库</a>（百度地图）<br/>
        地图图形信息：<a href="http://lbsyun.baidu.com/index.php?title=%E9%A6%96%E9%A1%B5">百度地图开放平台</a><br/>
        </p>
    </div>
    
    <div class="footer">
        <p>Open Source Foundation</p>
    </div>
</div>
</body>
<script type="text/javascript">
    //创建和初始化地图函数：
    function initMap(){
        createMap();//创建地图
        setMapEvent();//设置地图事件
        addMapControl();//向地图添加控件
        addMarker();//向地图中添加marker
    }
    
    //创建地图函数：
    function createMap(){
        var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
        var point = new BMap.Point(<?php echo $M_lon; ?>,<?php echo $M_lat; ?>);//定义一个中心点坐标
        map.centerAndZoom(point,16);//设定地图的中心点和坐标并将地图显示在地图容器中
        window.map = map;//将map变量存储在全局
    }
    
    //地图事件设置函数：
    function setMapEvent(){
        map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
        map.enableScrollWheelZoom();//启用地图滚轮放大缩小
        map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
        map.enableKeyboard();//启用键盘上下左右键移动地图
    }
    
    //地图控件添加函数：
    function addMapControl(){
        //向地图中添加比例尺控件
        var ctrl_sca = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
        map.addControl(ctrl_sca);
    }
    
    //标注点数组
    var markerArr = [{title:"<?php if(isset($_GET['mac'])) echo $_GET['mac'];?>",content:"<?php if(isset($_GET['mac'])) echo $_GET['mac'];?>",point:"<?php echo $M_lon; ?>|<?php echo $M_lat; ?>",isOpen:0,icon:{w:21,h:21,l:0,t:0,x:6,lb:5}}
		 ];
    //创建marker
    function addMarker(){
        for(var i=0;i<markerArr.length;i++){
            var json = markerArr[i];
            var p0 = json.point.split("|")[0];
            var p1 = json.point.split("|")[1];
            var point = new BMap.Point(p0,p1);
			var iconImg = createIcon(json.icon);
            var marker = new BMap.Marker(point,{icon:iconImg});
			var iw = createInfoWindow(i);
			var label = new BMap.Label(json.title,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
			marker.setLabel(label);
            map.addOverlay(marker);
            label.setStyle({
                        borderColor:"#808080",
                        color:"#333",
                        cursor:"pointer"
            });
			
			(function(){
				var index = i;
				var _iw = createInfoWindow(i);
				var _marker = marker;
				_marker.addEventListener("click",function(){
				    this.openInfoWindow(_iw);
			    });
			    _iw.addEventListener("open",function(){
				    _marker.getLabel().hide();
			    })
			    _iw.addEventListener("close",function(){
				    _marker.getLabel().show();
			    })
				label.addEventListener("click",function(){
				    _marker.openInfoWindow(_iw);
			    })
				if(!!json.isOpen){
					label.hide();
					_marker.openInfoWindow(_iw);
				}
			})()
        }
    }
    //创建InfoWindow
    function createInfoWindow(i){
        var json = markerArr[i];
        var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
        return iw;
    }
    //创建一个Icon
    function createIcon(json){
        var icon = new BMap.Icon("http://api.map.baidu.com/lbsapi/creatmap/images/us_cursor.gif", new BMap.Size(json.w,json.h),{imageOffset: new BMap.Size(-json.l,-json.t),infoWindowOffset:new BMap.Size(json.lb+5,1),offset:new BMap.Size(json.x,json.h)})
        return icon;
    }

    initMap();//创建和初始化地图
</script>
</html>