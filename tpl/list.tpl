<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="development-bundle/themes/base/jquery.ui.all.css" rel="stylesheet" />
<link type="text/css" href="css/bluedream.css" rel="stylesheet"/>
<link type="text/css" href="css/list.css" rel="stylesheet"/>
<link href="js/jquery.rating.css" type="text/css" rel="stylesheet">
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>
<script src="js/list.js" type="text/javascript"></script>
<script src="js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/jquery.rating.js"></script>
<script type="text/javascript" src="js/jquery.rating.pack.js"></script>
<script type="text/javascript" src="js/jquery.MetaData.js"></script>
	
</head>
<title>AVBODY</title>
{if !$smarty.session.DVshowed}
<body onload="javascript:showDailyVideo();">
{else}
<body>
{/if}
<div id="DailyVideo"></div>

<div align="left" style="float:left"><a href="ListController.php?action=getAllAVTag">Tag Cloud</a> |
<a href="ListController.php?action=getTopAVDB">AVDB top20</a> | 
<a href="#" onclick="showDailyVideo();">好精氣!</a></div> 

<div align="right">
	<span id="durability">持久度{$smarty.session.score}秒</span>
	<div id="durDialog" title="持久度說明"><p style="color:blue">載片-1s,<br>評分+2s, 雷+2s, Tag+3s, 片名+3s<br></p><p style="color:red">少於一秒將無法下載。</p></div> | 
	載評比:{math equation="x/y" x=$reviewNum y=$downloadNum format="%.2f"}({$reviewNum}/{$downloadNum}) | 
	{$smarty.session.name} | <a href="UserController.php?action=downloadList">我的A片櫃</a> | 
<a href="UserController.php?action=logout">登出</a>
</div>
<table width="90%" class="mainTable">
<tr>
</tr>
<div id="imageDialog">
</div>
    <tr>
		{foreach from=$info item=av_info name=foo}
			{if $av_info.name eq ''}
				{assign var='name' value=$av_info.file_name}
			{else}
				{assign var='name' value=$av_info.name}
			{/if}
		<td width="33%">
		<table width="100%">
			<tr>
				<th class="avname">
					<div id="name" style="display:inline" onclick="showWindow('{$av_info.av_fileid}');">
						<a>{$name}</a>
					</div>
				</th>
			</tr>
			<tr>
				<td class="imgTd">
					{if $av_info.photo_path eq '' || $smarty.session.score <= 0}
						{assign var='image' value=css/images/error.jpg}
					{else}
						{assign var='image' value="/"|cat:$av_info.photo_path}
					{/if}
					<!--<div id="image" onclick="javascript:setState('{$smarty.session.score}');setPath('ftp://avbody:avbody@140.115.82.188/miroko/{$av_info.file_path}');setName('{$name}');showImage('{$image}');setAvId('{$av_info.av_fileid}')">-->
					<div id="image" onclick="showWindow('{$av_info.av_fileid}');">	
						<img src="{$image}" onLoad="setStar('{$av_info.scoreavg}','{$av_info.av_fileid}');"></img>
					</div>
				</td>
			</tr>
			<tr>
				<td><img src="bomb.png" style="width:20px;"/>{$av_info.minetotal|default:'0'}<img src="download.png" style="width:20px;"/>{$av_info.downloadtotal|default:'0'}
				<form id="starRate">
					<input id = "1{$av_info.av_fileid}" class="star{$av_info.av_fileid}" type="radio" name="rating" value="極差" >
					<input id = "2{$av_info.av_fileid}" class="star{$av_info.av_fileid}" type="radio" name="rating" value="差" >
					<input id = "3{$av_info.av_fileid}" class="star{$av_info.av_fileid}" type="radio" name="rating" value="普通" >
					<input id = "4{$av_info.av_fileid}" class="star{$av_info.av_fileid}" type="radio" name="rating" value="佳" >
					<input id = "5{$av_info.av_fileid}" class="star{$av_info.av_fileid}" type="radio" name="rating" value="極佳" >
				</form>	
				</td>
			</tr>
		</table>

<!--		
		{if $av_info.photo_path eq ''}
		<td id="imagePath{$av_info.av_fileid}" onclick="javascript:setPath('ftp://miroko:miroko@140.115.82.71/{$av_info.file_path}');setName('{$name}');showImage('error.jpg');">
			<a href="">看圖與下載</a>
		</td>
		{else}
		<td id="imagePath{$av_info.av_fileid}" onclick="javascript:setPath('ftp://miroko:miroko@140.115.82.71/{$av_info.file_path}');setName('{$name}');showImage('/{$av_info.photo_path}'); ">
			<a href="">看圖與下載</a>
		</td>
		{/if}
-->

	{if $smarty.foreach.foo.iteration % 3 == 0}
    </tr><tr>
	{/if}
{/foreach}

</table>
<center>
<table  class="pageTable">
<tr>
{if $smarty.get.page!=1}
	<td><a href="AvinfoController.php?action=getAVList&page={$smarty.get.page-1}"><img src="logoA.png" border=0 align=right><span style="display:block">上一頁</span></a></td>
{else}
	<td><img src="logoA.png" border=0 align=right><span style="display:block"></span></td>    
{/if}
{if $smarty.get.page>=10}
	{assign var='frontPageNum' value=$smarty.get.page-5}
	{if $smarty.get.page>=10 && $smarty.get.page<$maxPage}
		{assign var='endPageNum' value=$smarty.get.page+6}
	{else}
		{assign var='endPageNum' value=$maxPage+1}
	{/if}
{else}
	{assign var='frontPageNum' value=1}
	{assign var='endPageNum' value=11}
{/if}
{section name=bar start=$frontPageNum loop=$endPageNum step=1}
	{if $smarty.get.page eq $smarty.section.bar.index}
	<td><center><a href="ListController.php?action=getAVList&page={$smarty.section.bar.index}" class="nowPage"><img src="logoVi.png" border=0><span style="display:block">{$smarty.section.bar.index}</span></a></center></td>
	{else}
	<td><center><a href="ListController.php?action=getAVList&page={$smarty.section.bar.index}"><img src="logoV.png" border=0><span style="display:block">{$smarty.section.bar.index}</span></a></center></td>
	{/if}
{/section}
{if $smarty.get.page!=$maxPage}
<td><a href="ListController.php?action=getAVList&page={$smarty.get.page+1}"><img src="logoBody.png" border=0 align=left><span style="display:block">下一頁</span></a></td>
{/if}
</tr>
</center>
</table>



</form>
</body>
</html>
