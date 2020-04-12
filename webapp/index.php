<!DOCTYPE html>
<!OWN FC-SYSTEM>
<html>
<body>
<meta charset="utf-8" />
<style>
    input {
        border: 0px;
        color: #00aafc;
    }
    #main {
        position: absolute;
        width: 500px; height: 300px;
        top: 50%; left: 50%;
        margin-top: -150px; margin-left: -250px;
        border: 1px solid #00aafc;
    }
    #title {
        width: 500px; height: 40px; line-height: 40px;
        background: #00aafc; color: #ffffff;
        text-align: center; font-weight: bold;
    }
    #content {
        width: 470px; height: 190px;
        padding: 15px;
        color: #00aafc;
        vertical-align: middle;
    }
    #content a {
        color: #66ccff;
        text-decoration: none;
    }
    #content a:hover {
        color: #00aafc;
        text-decoration: none;
    }
    #footer {
        width: 500px; height: 40px; line-height: 40px;
        text-align: center; 
        color: #00aafc;
        border-top: 1px solid #00aafc;
    }
</style>
<script type="text/javascript">
    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fa89299819f48e856af018d39c9b9cbf0' type='text/javascript'%3E%3C/script%3E"));
</script>
<div id="main">
    <div id="title">403 禁止访问</div>
    <div id="content">
        <script type="text/javascript">
            var timer1 = 5;
            var url = 'http://dfc643.github.io';
            document.write('啊咧，网站好像出现了一些小问题。您所访问的页面是系统禁止查看的页面，请先暂时看看其他的页面。若问题依然没有解决请<a href="http://wpa.qq.com/msgrd?v=3&uin=328729030&site=FC-SYSTEM&menu=no" target="_blank">联系网站管理员</a>。<br/><br/>');
            document.write('主机名称：<input type="text" value="' + location.hostname + '" style="width:380px;"/><br/>');
            document.write('访问路径：<input type="text" value="' + location.pathname + '" style="width:380px;"/><br/>');
            if(document.referrer=="") {
                document.write('来源地址：直接访问<br/>');
            } else {
                document.write('来源地址：<input type="text" value="' + document.referrer + '" style="width:380px;"/><br/>');
            }
            document.write('<p id="redirect">浏览器将在 5 秒钟后跳转到极光计算机主页。</p>');
            for(var i=timer1;i>=0;i--) {
                window.setTimeout("redirect_js("+i+");",(timer1-i)*1000);   
            }
            function redirect_js(num) {
                document.getElementById('redirect').innerHTML = '浏览器将在 '+ num +' 秒钟后跳转到极光计算机主页。'; 
                if(num==0) {
                    window.location.href='http://dfc643.github.io';
                }
            }
        </script>
    </div>
    <div id="footer">FC-System Computer Inc</div>
</div>
<?php
    header('http/1.1 403 Feel Sorry');
?>
</body>
</html>