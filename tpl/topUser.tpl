<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
    <td>姓名</td>
	<td>持久度 (時:分:秒)</td>&nbsp
</tr>
{foreach from=$user item=user}
    <tr>
       	<td>
			{$user.name} &nbsp &nbsp &nbsp
		</td>
	    <td>
	    	{assign var='hr' value=$user.score/3600|string_format:"%d"}
			{assign var='min' value=$user.score/60|string_format:"%d"}
			{assign var='sec' value=$user.score%60}
	    	{$hr} 小時 {$min} 分 {$sec} 秒
		</td>
    </tr>
{/foreach}
<table>
</div>
</body>
</html>
  