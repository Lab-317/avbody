<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="development-bundle/themes/base/jquery.ui.all.css" rel="stylesheet" />
<link type="text/css" href="css/bluedream.css" rel="stylesheet"/>
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>
</head>
{literal}
<script type="text/javascript">
	//imageDialog's global var
	var dl_Path=null;
	var av_name=null;
	var uid = null;
	var avid= null;
	
	//imageDialog's functions
	$(function() {
		
		var scWidth=screen.availWidth*0.8;
		var scHeight=screen.availHeight*0.7;
//		var imageWidth=screen.availWidth*0.7
//		var imageHeight=screen.availHeight*0.7
		var i=1;
		
		$('#imageDialog').dialog({
			autoOpen: false,
			width:scWidth,
			height:scHeight,
			modal:true,
			closeOnEscape: false,
			buttons:{
				Download:function(){
					$.ajax({
						type: "POST",
						url: "UserController.php?action=downloadlog",
						data: ({uid : uid,avid:avid}),
						success: function(msg){
							window.location = getPath();
					    }
					});
					
				}
			}
		});
	
		while (i < 1000) {
			var imagePath=$('#imagePath'+i).val();
			$('#imagePath'+i).click(function(){
				return false;
			});
			i++;
		}
	
//		$('#opener').mouseout(function() {
//			$('#dialog').dialog('close');
//			return false;
//		});
	});
	
	function showImage(path){
		$('#imageDialog').html("<img src='" + path + "'></img>");
		$('#imageDialog').dialog('open');
		$('#imageDialog').dialog({title:getName()});
		return false;
	}
	
	function getText(){
		var text=document.getElementById('changeName').val();
		alert(text);
	}
	
	function setPath(path){
		dl_Path=path;
	}
	
	function getPath(){
		return dl_Path;
	}
	
	function setName(name){
		av_name=name;
	}
	function setUID(local_uid){
		uid = local_uid;
	}
	function setAvId(local_avid){
		avid = local_avid;
	}
	function getName(){
		return av_name;
	}
	//End imageDialog
//	<form name="listForm" action="av_infoUpdate.php" method="POST" id="photoupload" enctype="multipart/form-data">
</script>
{/literal}
<body>
<div align="left" style="float:left"><img height="15px" src="img/home.png"><a href="ListController.php?action=getAVList&page=1">Back Home</a></div>
<div align="right" >{$smarty.session.name} | <a href="UserController?action=downloadList">我的A片櫃</a> | <a href="UserController?action=logout">登出</a> </div>
<br/>
<a href="UserController.php?action=downloadList&type=2"><img height="18px" src="img/unRated.png">未評分</a><img height="16px" src="img/rated.png"/><a href="UserController.php?action=downloadList&type=1">已評分</a>
<table cellspacing="7" class="maintable">
<tr>
	<td>檔案名稱</td>
	<td>圖片</td>
	<td>下載日期</td>
	<td>評分</td>
</tr>

<div id="imageDialog">
</div>
{foreach from=$info item=av_info}
    <tr>
		<td>
			{if $av_info.name eq ''}
				{assign var='name' value=$av_info.file_name}
			{else}
				
				{assign var='name' value=$av_info.name}
			{/if}
			<div id="name{$av_info.av_fileid}" style="display:inline">
				<a target="_blank" href="AvinfoController.php?action=getInfo&id={$av_info.av_fileid}">{$name}</a>
			</div>
		</td>	
		{if $av_info.photo_path eq ''}
		<td id="imagePath{$av_info.av_fileid}" onclick="javascript:setPath('ftp://miroko:miroko@140.115.82.188/{$av_info.file_path}');setUID('{$smarty.session.uid}');setAvId({$av_info.av_fileid});setName('{$name}');showImage('error.jpg');">
			<a href="">圖片</a>
		</td>
		{else}
		<td id="imagePath{$av_info.av_fileid}" onclick="javascript:setPath('ftp://miroko:miroko@140.115.82.188/{$av_info.file_path}');setUID('{$smarty.session.uid}');setAvId({$av_info.av_fileid});setName('{$name}');showImage('/{$av_info.photo_path}'); ">
			<a href="">圖片</a>
		</td>
		{/if}
		<td>
			{$av_info.downloadTime}
		</td>
		<td>
			{$av_info.score}
		</td>
		<!--
		<td>
			<a href="index.php?action=addPage&avid={$av_info.av_fileid}&name={$av_info.file_name}">ק</a>
		</td>
		-->
    </tr>
{/foreach}
</table>
</form>
</body>
</html>
  