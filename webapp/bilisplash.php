<?php
# Bilibili splash Redirecter
$bilisplsrv='app.bilibili.com';
$bilisplpth='/x/splash';
$bilisplpa1='plat=0&width=1080&height=1920';
$bilisplpa2='build=412001&channel=master';

function getDocument($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	//curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36');
	$r = curl_exec($ch);
	curl_close($ch);
	return $r;
}

function getBiliSplAddr($doc) {
  preg_match_all("/(http:\/\/.{30,120}\.jpg)/", $doc, $paperUrl);
  return $paperUrl[0][1] ?: $paperUrl[0][0];
}

header('Location: '.getBiliSplAddr(getDocument("http://".$bilisplsrv.$bilisplpth.'?'.$bilisplpa1.'&'.$bilisplpa2)));
?>