<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="development-bundle/themes/base/jquery.ui.all.css" rel="stylesheet" />
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>
<link type="text/css" href="css/avtop.css" rel="stylesheet"/>
{literal}
<style>
</style>
{/literal}
{literal}
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
</script>
{/literal}
</head>

<body>
<div class="AVTop">
<div id="tabs">
	<ul>
		<li><a href="ListController.php?action=getTopDownloadList">Top 下載</a></li>
		<li><a href="ListController.php?action=getTopScoreList">Top 評分</a></li>
		<li><a href="ListController.php?action=getTopMineList">Top 雷</a></li>
		<li><a href="ListController.php?action=getTopEnduranceList">Top 持久度</a></li>
	</ul>
</div>

</div><!-- End demo -->

{literal}
<script type="text/javascript"> 
	$(document).ready(function() {
		$('a').click(function(){
       	 	this.blur();
		});
	});
</script>
{/literal}

</body>
</html>
        