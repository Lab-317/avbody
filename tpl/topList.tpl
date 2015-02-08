<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type=text/javascript src="js/topList.js"></script>
{literal}
<style>
</style>
{/literal}
</head>
<body>

<div align="right" style="float:right">
	<a href="ListController.php?action=getAVList&page=1">首頁</a>
</div>

<div align="center" width="400">
<table>
<tr>
    <td>片名</td>
	<td>下載數</td>
	<td>評分</td>
	<td>雷數</td>
</tr>

{foreach from=$info item=top_Av} 
	<tr>	
       	<td>	
			<li id="name"><a href="ListController.php?action=getInfo&id={$top_Av.av_id}" onmouseover="showImage('{$top_Av.photo_path}');">{$top_Av.name}</a>&nbsp &nbsp</li>
		</td>
	    <td>{$top_Av.downloadtotal}</td>
		<td>{$top_Av.scoreavg}</td>
		<td>{$top_Av.minetotal}</td>
    </tr>
{/foreach}
<div id="imageDialog"></div>
<table>
</div>
</body>
</html>
