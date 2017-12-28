<?php
// Global Settings
$timeout = 15;
$uplinkDns = '119.29.29.29';
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
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36');
			$r = curl_exec($ch);
			curl_close($ch);
			return $r;
			
		case 1:
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_ENCODING , "gzip");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36');
			$r = curl_exec($ch);
			if (!curl_errno($ch)) {
                return curl_getinfo($ch);
            } else {
                return curl_error($ch);
            }
            curl_close($ch);
	}
}

// Get client IP address
function getIPAddr() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        if($ip != "") {
            $arr = explode(",",$ip);
            return $arr[0];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
	} else {
        return $_SERVER["REMOTE_ADDR"];
	}
}

// Local DNS lookup
function nslookup($domain) {
    if(($r = dns_get_record($domain, DNS_A)) == NULL) {
        print "DNS lookup query failed!\n";
        return false;
    }
    $c = count($r);
    $t=(object)$r[0];
    for($i=0; $i<$c; $i++) {
        $t=(object)$r[$i];
        if($t->ip != NULL) {
            print $t->ip."\n";
        }
    }
}

// HTTP DNS lookup
function rnslookup($uplinkDns, $domain, $ipaddr, $timeout) {
    if(($r = httpReq('http://'.$uplinkDns.'/d?dn='.$domain.'&ip='.$ipaddr, 0, $timeout)) == NULL) {
        return 'DNS lookup query failed!';
    } else {
        return str_replace(";","\n", $r);
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Website Accessibility Tester</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <link href="https://lib.fcsys.org/bootstrap/bootstrap.3.3.6.min.css" type="text/css" rel="stylesheet"/>
    <style>
    .title,.sub-title,.main-container,.copyright {margin:0 auto;max-width:750px; text-align:center;}
    .title              {font-size:48px; color:#888; margin-top:50px;}
    .sub-title          {color:#aaa; margin-bottom:50px;}
    .main-container     {background:#f5f5f5; border:1px solid #ccc; padding:20px 15px; margin-top:30px; border-radius:5px; color:#888; text-align:left;}
    form                {max-width:750px; margin:0 auto;}
    form .url           {max-width:663px; float:left;}
    .btn                {margin-left:5px;}
    .copyright          {margin-top:50px; color:#aaa;}
    pre                 {margin:0; padding:0; border:none;}
    pre > b             {font-size:15px;}
    @media screen and (max-width: 750px) {
        form            {text-align:center;}
        form .url       {max-width:75%;}
    }
    @media screen and (max-width: 480px) {
        .title          {font-size:24px;}
        .sub-title      {font-size:9px;}
        form            {text-align:center;}
        form .url       {max-width:75%;}
    }
    </style>
</head>
<body>
    <div class="title">Website Accessibility Tester</div>
    <div class="sub-title">RUNNING ON ALIYUN ECS SERVER @ QIANGDAO, CHINA.</div>
    
    <form method="post">
        <div class="input-group url">
            <div class="input-group-addon">URL</div>
            <input name="w" class="form-control" type="text" placeholder="Please enter website URL that you wanna test." value="<?php echo $_POST['w']; ?>"/>
        </div>
        <input type="submit" class="btn btn-primary" value="Check it!"/>
    </form>
    
    <div class="main-container">
        <?php 
        if((!isset($_POST['w'])) || ($_POST['w'] == NULL)) {
            echo '<center>Waiting for query.</center>';
        } else {
            print '<pre>';
            if(strpos($_POST['w'],"http://") > -1 || strpos($_POST['w'],"https://") > -1) {
                $url = $_POST['w'];
            } else {
                $url = "http://".$_POST['w'];
            }
            
            // Is URL or Domain?
            if(strpos($url, '/') > -1)
                $domain = parse_url($url)['host'];
            else
                $domain = $url;
            // If NOT valid IP address
            if(!filter_var($domain, FILTER_VALIDATE_IP)) {
                print "<b>Server DNS query result:</b>\n";
                nslookup($domain);
                
                print "\n<b>Cloud DNS query result:</b>\n";
                echo rnslookup($uplinkDns, $domain, getIPAddr(), $timeout);
                print "\n\n";
            }
    
            print "<b>Website accessible state:</b>\n";
            $httpCallback = (object)httpReq($url, 1, $timeout);
            if(isset($httpCallback->scalar)) {
                $rz = str_replace(": ","\nDetail: ", $httpCallback->scalar);
                print '<font color="red"><b>This website cannot be accessible!</b></font>'."\nReason: ".$rz;
            }
            else {
                switch($httpCallback->http_code) {
                    case 200: case 204: case 206: case 301: case 302: case 304:
                        print '<font color="green"><b>This website can be accessible!</b></font>';
                        break;
                    
                    case 400:
                        print '<font color="#FF6C00"><b>This website can be accessible but is bad request!</b></font>';
                        break;
                    
                    case 401:
                        print '<font color="#FF6C00"><b>This website can be accessible but unauthorized!</b></font>';
                        break;
                    
                    case 403:
                        print '<font color="#FF6C00"><b>This website can be accessible but permission denied!</b></font>';
                        break;
                    
                    case 404:
                        print '<font color="#FF6C00"><b>This website can be accessible but page not found!</b></font>';
                        break;
                    
                    case 405:
                        print '<font color="#FF6C00"><b>This website can be accessible but client failed!</b></font>';
                        break;
                    
                    case 500: case 501: case 502: case 503: case 504: case 505:
                        print '<font color="#FF6C00"><b>This website can be accessible but server failed!</b></font>';
                        break;
                    
                    default:
                        print '<font color="pink"><b>Please see HTTP Code for more detail.</b></font>';
                        break;
                }
                print "\n".'HTTP Code: HTTP 1.1/'.$httpCallback->http_code."";
                print "\n".'Content Type: '.$httpCallback->content_type;
            }
            print '</pre>';
        }
        ?>
    </div>
    <div class="copyright">Copyright &copy; 2011-2016 <a href="http://www.fcsys.org">FC-System Computer Inc</a>.</div>
</body>
</html>