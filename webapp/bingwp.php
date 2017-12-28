<?php
# Bing Wallpaper Redirecter
$bingServ='cn.bing.com';

function getDocument($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36');
	$r = curl_exec($ch);
	curl_close($ch);
	return $r;
}

function getBingBgAddr($doc) {
	preg_match_all("/(http:\\\\\/.*bing\..{10,100}\.jpg)/", $doc, $paperUrl);
	if($paperUrl[0][0] == "") {
		preg_match_all("/(http:\/\/.*bing\..{10,100}\.jpg)/", $doc, $paperUrl);
	}
	if($paperUrl[0][0] == "") {
                preg_match_all("/(\/\/.*msecnd\..{10,100}\.jpg)/", $doc, $paperUrl);
        }
	if($paperUrl[0][0] == "") {
                preg_match_all("/(\/az\/.{10,100}\_\d+x\d+\.jpg)\"/", $doc, $paperUrl);
		$paperUrl[0][0] = "http://s.cn.bing.net" . $paperUrl[1][0];
        }
	return str_replace("\/","/",$paperUrl[0][0]);
}

header('Location: '.getBingBgAddr(getDocument("http://".$bingServ."/")));
?>
