var dl_Path=null;
var av_name=null;
var uid = null;
var avid= null;
var user_durability = null;

$(function() {
	
	var scWidth=screen.availWidth*0.8;
	var scHeight=screen.availHeight*0.7;
//	var imageWidth=screen.availWidth*0.7
//	var imageHeight=screen.availHeight*0.7
	var i=1;
	
	$('#durDialog').dialog({
		autoOpen: false,
		dragable: false,
		resizable: false
	});
	
	$('#DailyVideo').dialog({
		autoOpen: false,
		width:scWidth,
		height:scHeight,
		modal:true,
		closeOnEscape: true,
		buttons:{
			Detail:function(){
				showWindow(avid);
			}
		}
	});
	
//	$('#imageDialog').dialog({
//		autoOpen: false,
//		width:scWidth,
//		height:scHeight,
//		modal:true,
//		closeOnEscape: true,
//		buttons:{
//			Download:function(){
//				if(user_durability > 0){
//					window.location = getPath();
//					recordDownload(avid);
//				}else{
//					alert("都軟了還想載");
//				}
//			},
//			Detail:function(){
//				showWindow(avid);
//			}
//		}
//	});

//	$('#opener').mouseout(function() {
//		$('#dialog').dialog('close');
//		return false;
//	});
});

function showWindow(avid){
	window.open('AvinfoController.php?action=getInfo&id='+avid);
}

function showDailyVideo(){
	$.ajax({
		url:"ListController.php?action=getDailyVideo",
		type:"POST",
		dataType:"json",
		success:function(data){
			$('#DailyVideo').html("<img src=/" + data[0].avphotopath + "></img>");
			$('#DailyVideo').dialog('open');
			$('#DailyVideo').dialog({title:"每日精選──" + data[0].avname});
			setAvId(data[0].avid);
		}
	});
}

//durablity Tip dialog 
$(document).ready(function(){
	$('#durability').mouseover(function(e){
		showdurDialog(e.pageX,e.pageY);
	}),
	$('#durability').mouseout(function(e){
		hiddendurDialog();
	})
});

function showdurDialog(x,y){
	$('#durDialog').dialog({position:[x,y]});
	$('#durDialog').dialog('open');
	return false;
}

function hiddendurDialog(){
	$('#durDialog').dialog('close');
	return false;
}
//durablityEnd

//Not be Used
//imageDialog's functions

function showImage(path){
	$('#imageDialog').html("<img src='" + path + "'></img>");
	$('#imageDialog').dialog('open');
	$('#imageDialog').dialog({title:getName()});
	return false;
}

function setState(durability){
	user_durability = durability;
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

function recordDownload(avid){
	$.ajax({
		type:"POST",
		url: "UserController.php?action=downloadlog",
		data:({avid:avid}),
		success: function(msg){
			return msg;
		}
	});
}

//$(document).ready(function(score,avid){
//	var scoreavg = score;
//	$('.star2'+avid).rating('enable');
//	$("#"+scoreavg+avid).attr("checked", "checked");
//	$('.star2'+avid).rating();
//	$('.star2'+avid).rating('disable');
//});

function setStar(score,avid){
	var scoreavg = score;
	$("#"+scoreavg+avid).attr("checked", "checked");
	$('.star'+avid).rating();
	$('.star'+avid).rating('disable');
}

//$(document).ready(function() {
//	var scoreavg = $("para2").attr("value");
//	$("#"+scoreavg).attr("checked", "checked");
//	$('.star2').rating();
//	$('.star2').rating('disable');
//});