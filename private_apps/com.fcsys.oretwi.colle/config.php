<?php
// Base Settings of OAuth
require_once 'oauth/twitteroauth/twitteroauth.php';
require_once 'core.php';
require_once 'token.php';

// Proxy Settings
$enable_proxy = true;					// Enable Proxy function If you need.
$proxy_server = 'dfc643:dfc220HAM_@127.0.0.1:643';      // The proxy server address and port.
$socks5_proxy = false;                                  // Is the proxy server workin Socks5?

// Key & Secrets settings
$consumer_key    = 'dl2HqEA8XR9EG1xdU8RQFcMYa';					// * Applications
$consumer_secret = 'QnMOXm7vNalxOpLmJJuUccBTpH9vz1O8gCMLQXmfP0Y9gnrGuT';

// Task Settings
$follower_count = 10;					// How many followers check per an hour.
$follower_lang = 'ja';					// Specifically followers language. ['all' for All]
$retweet_count  = 5;					// How many tweets will be retweet per an hour.
$favorite_count = 30;					// How many tweets will be favorite per an hour.
$search_keyword = '#abso_duo OR #koufukug OR #fafnir_a OR #boueibu OR #imascg_chihiro OR #yurikuma OR #C89コスプレ OR #C89COS OR #C89';
#backup: #コミケ OR #ore_twi OR 

// Site Settings
$site_name = '北極光のアニメ垢リツイートbot';
$callback  = 'https://apps.fcsys.org/com.fcsys.oretwi.colle/oauth/callback.php';
?>
