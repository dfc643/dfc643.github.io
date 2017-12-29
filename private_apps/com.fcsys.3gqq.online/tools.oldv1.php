<?php
function openu($url)
{
$url = preg_replace('/^http\:\/\//', '', $url);
$temp = explode('/', $url);
$host = array_shift($temp);
$path = '/'.implode('/', $temp);
$temp = explode(':', $host);
$host = $temp[0];
$port = isset($temp[1]) ? $temp[1] : 80;

$fp = @fsockopen($host, $port, $errno, $errstr, 30);
if ($fp)
{
@fputs($fp, "GET $path HTTP/1.1\r\n");
@fputs($fp, "Host: $host\r\n");
@fputs($fp, "Accept: */*\r\n");
@fputs($fp, "Referer: http://$host/\r\n");
@fputs($fp, "User-Agent: MQQBrowser/1.5/Mozilla/5.0 (Linux; U; 2.3.3; zh-cn; Android Google Nexus S Build/MIUI.1.4.1;480*800) AppleWebkit/533.1 (KHTML, like Gecko) Safari/533.1\r\n");
@fputs($fp, "Connection: Close\r\n\r\n");
}

$Content = '';
while ($str = @fread($fp, 4096))
$Content .= $str;
@fclose($fp);

return $Content;
}
?>