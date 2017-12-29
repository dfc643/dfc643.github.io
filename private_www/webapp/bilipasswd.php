<?php
// Get current time with Javascript style
function getTime() {  
    return number_format(microtime(true),3,'','');  
}  

// Http request process module
function httpReq($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36');
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}

// Get Login key and hash
function getLoginKey() {
    $r = httpReq('https://passport.bilibili.com/login?act=getkey&_='.getTime());
    return json_decode($r);
}

// Encrypt password via public rsa key
function encodePasswd($password) {
    $authHash = getLoginKey();
    openssl_public_encrypt($authHash->hash.$password, $encrypted, $authHash->key);
    return base64_encode($encrypted);
}

echo encodePasswd($_GET['pw']);
?>
