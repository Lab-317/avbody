<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="css/avinfo.css" rel="stylesheet" />
<link type="text/css" href="development-bundle/themes/base/jquery.ui.all.css" rel="stylesheet" />
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>
<script src="js/avinfo.js" type="text/javascript"></script>
<script src="js/starRating.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.rating.js"></script>
<script type="text/javascript" src="js/jquery.rating.pack.js"></script>
<script type="text/javascript" src="js/jquery.MetaData.js"></script>
<script type="text/javascript" src="js/ajaxfileupload.js"></script>		
<link href="js/jquery.rating.css" type="text/css" rel="stylesheet">
</head>
	{if $av_info.name eq ''}
		{assign var='name' value=$av_info.file_name}
	{else}		
		{assign var='name' value=$av_info.name}
	{/if}
<title>AVBODY-{$name}</title>
<body>
	<table align="center" border="0">
		<tr>
			<td rowspan="10" colspan="2" class="image">
				{if $av_info.photo_path eq ''}
				<input type="file" name="av_img" id="av_img"><input type="button" value="Upload" onclick="uploadImg('{$av_info.file_path}');">
				{else}
				<img src="/{$av_info.photo_path}"/>
				{/if}
			</td>
		</tr>
		<tr>
			<td class="content">檔案名稱:</td>
			<td>
			<div id="name{$av_info.av_fileid}" style="display:inline" onmouseover="showBackground('{$av_info.av_fileid}');" onmouseout="hiddenBackground('{$av_info.av_fileid}');" ondblClick="setDivId('{$av_info.av_fileid}');showChageField('{$av_info.av_fileid}');">{$name}</div>
			<div id="changeObj{$av_info.av_fileid}" style="display:none;">
        		<input id="changeField{$av_info.av_fileid}" type="text"></input>
          		<input type="submit" name="save_name" value="save" onClick="updateName('{$av_info.av_fileid}');"></input>
	  			<input type="button" name="cancel" value="cancel" onClick="hiddenChangeField('{$av_info.av_fileid}')"></input>
				<div id="loading{$av_info.av_fileid}" style="display:inline; visibility:hidden;"></div>
			</div>
			</td>
		</tr>
		<tr>
			<td class="content">影片編號:</td>
			<td>
			{$av_info.file_name}
			</td>
		</tr>
		<tr>
			<td class="content">上傳日期:</td>
			<td>
			{$av_info.upday}
			</td>
		</tr>
		<tr>
			<td class="content">檔案大小:</td>
			<td>
			{if $av_info.size / 1000000000 >= 1}
				{
				 math equation="x / y" 
				 x=$av_info.size 
				 y=1000000000  format="%.1f"
				}GB
			{elseif $av_info.size / 1000000 >= 1}
				{
				 math equation="x / y" 
				 x=$av_info.size 
				 y=1000000 format="%.1f"
				}MB
			{else}
				{
				 math equation="x / y" 
				 x=$av_info.size 
				 y=1000 format="%.1f"
				}KB
			{/if}
			</td>
		</tr>
		<tr>
			<td class="content">推薦指數</td>
			<td>
				<span id="test">{$av_info.scoreavg}</span>顆星
				共有 {$scoredPeopleNum}人評分
				<form id="star1">  
					<input id = "1" class="star2" type="radio" name="rating" value="極差" >
					<input id = "2" class="star2" type="radio" name="rating" value="差" >
					<input id = "3" class="star2" type="radio" name="rating" value="普通" >
					<input id = "4" class="star2" type="radio" name="rating" value="佳" >
					<input id = "5" class="star2" type="radio" name="rating" value="極佳" >
				</form>				 
				您對這個影片的評分
				<form id="star2">
					<para1 value="{$av_info.av_fileid}"></para1>
					<para2 value="{$av_info.scoreavg}"></para2>
					<para3 value="{$userReview.score}"></para3>
					<para4 value="{$scoredPeopleNum}"></para4>
										
					<input id = "self1" class="submit-star" type="radio" name="rating" value="極差" >
					<input id = "self2" class="submit-star" type="radio" name="rating" value="差" >
					<input id = "self3" class="submit-star" type="radio" name="rating" value="普通" >
					<input id = "self4" class="submit-star" type="radio" name="rating" value="佳" >
					<input id = "self5" class="submit-star" type="radio" name="rating" value="極佳" >
				</form>
			</td>
		</tr>
		<!--
		<tr>
			<td class="content">出演女優:
				
			</td>
		<tr>
		-->
			<td class="content">Tag
			<input id="showAddtabtn" type="button" value="新增" onclick="showAddtagtext();">
			</td>
			<td>
				<p id="tag">
				{foreach from=$avTag item=avTag}
				<span id="{$avTag.t_id}" class="tagElement">
					<a href="#" class="tagName">{$avTag.t_name}</a><a href="#" class="tagDelBtn" onclick="removeTag('{$avTag.t_id}','{$av_info.av_fileid}');">X</a>
				</span>
				{/foreach}
				</p>
				<p id="newtagrow" style="display:none;">
					<input type="text" name="newtag" id="newtag">
					<span>ex:巨乳,人妻</span>
					<input type="button" value="save" onclick="saveNewtag('{$av_info.av_fileid}');">
					<input type="reset" value="cancel" onclick="hiddenAddtagtext();">
				</p>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="content">
				<div id="mine">{$av_info.minetotal}</div>顆雷/{$av_info.downloadtotal}下載
				<input type="hidden" id="paraMineTotal" value="{$av_info.minetotal}">
				{if $userReview.mine == 0}
					{assign var='mine' value="評為雷"}
				{else}
					{assign var='mine' value="收回雷"}
				{/if}
				<input type="hidden" id="paraMine" value="{$userReview.mine}">
				<div id="mineFont" onClick="decideMineFunc('{$av_info.av_fileid}');setMinetotal('{$av_info.minetotal}');">{$mine}</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right" class="content">
				{if $smarty.session.score <=0}
				<a href="#" onclick="alert('都軟了還想載')">下載</a>
				{else}
				<a href="#" onclick="javascript:location.href='ftp://avbody:avbody@140.115.82.188/miroko/{$av_info.file_path}';recordDownload('{$av_info.av_fileid}');">下載</a>
				{/if}
			</td>
		</tr>
		<tr>
			<td colspan="3">	
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<hr size="5">
			</td>
		</tr>
			{foreach from=$comment item=comment}
			<tr>
				<td>{$comment.name}:</br>{$comment.commentTime}</td><td>{$comment.content}</td>
			</tr>
			{/foreach}
		<tr>
			<td colspan="2">
				留言:</br>
				<textarea id="content"></textarea>
				<input type="button" value="送出" onclick="saveComment('{$av_info.av_fileid}');">
			</td>
		</tr>
	</table>
</body>
</html>