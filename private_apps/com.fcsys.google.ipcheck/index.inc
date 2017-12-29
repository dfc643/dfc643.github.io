<!doctype html>
<!own FC-SYSTEM> <!-- Marked by FC-SYSTEM -->
<html lang="nr">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Google Available IP Datasheet - Powered by FC-SYSTEM</title>
	<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
	<!--<link href="css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" />-->
	<link href="css/style.css" type="text/css" rel="stylesheet" />
	<!--<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>-->
</head>
<body>
	<div id="main">
		<h1>Google Available IP Sharing Project</h1>
		<div class="tips">
			<p>Google Available IP Sharing Project is a project that collection and check Google is available everyday. All these IP can used in Google App Engine program. All most IP can access Google search directly.</p>
			<p><b>IP Database Latest Update Date: May 9th 2015</b></p>
			<font color="gray">The check result will be listed in this page, And provide IP list download link.</font>
		</div>
		<div class="tips running" <?php //GRunning(); ?>>
			<img width="32px" height="32px" src="img/time.png" style="margin-left:-10px;margin-right:2px;"/>
			<b>Unfortunately, this project has been stopped. (2015-12-08)</b>
		</div>
		<div class="tips info">
			<span><b>Total:</b> <?php echo $ip_tmpok_cnt+$ip_tmpno_cnt;?></span>
			<span><b>Unavailable:</b> <?php echo $ip_tmpno_cnt;?></span>
			<span><b>Available:</b> <?php echo $ip_tmpok_cnt;?></span>
			<span><b>Good:</b> <?php echo $ip_tmpgood_cnt;?></span>
		</div>
		<div class="table">
			<table class="table table-hover tablesorter table-striped">
				<thead>
					<td><b>ID</b></td>
					<td><b>IP Address</b></td>
					<td><b>Connect Time</b></td>
					<td><b>SSL</b></td>
				</thead>
				<tbody>
					<?php GTable();?>
				</tbody>
			</table>
		</div>
		<?php GPage(); ?>
		<div class="tips">
			<center><a class="btn btn-info" href="?d" target="_blank">Download IP List of Today</a></center>
		</div>
		<center><a href="//www.fcsys.org" target="_blank">FC-System Computer Inc</a></center>
	</div>
	<div style="display:none"><script src="http://s95.cnzz.com/stat.php?id=1254093889&web_id=1254093889" language="JavaScript"></script></div>
</body>
</html>
